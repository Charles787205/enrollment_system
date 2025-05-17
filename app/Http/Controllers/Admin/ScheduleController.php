<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacultySubject;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Strand;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     */
    public function index()
    {
        $schedules = FacultySubject::with(['faculty', 'subject', 'section'])->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $faculty = Faculty::all();
        $subjects = Subject::all();
        $sections = Section::all();
        return view('admin.schedules.create', compact('faculty', 'subjects', 'sections'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'faculty_id' => 'required|exists:faculties,id',
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for scheduling conflicts
        $conflictCheck = FacultySubject::where(function($query) use ($request) {
                $query->where('faculty_id', $request->faculty_id)
                      ->orWhere(function($q) use ($request) {
                          $q->where('section_id', $request->section_id)
                            ->where('subject_id', $request->subject_id);
                      });
            })
            ->where('day_of_week', $request->day_of_week)
            ->get();

        foreach ($conflictCheck as $existingSchedule) {
            $newStart = strtotime($request->start_time);
            $newEnd = strtotime($request->end_time);
            $existingStart = strtotime($existingSchedule->start_time);
            $existingEnd = strtotime($existingSchedule->end_time);

            if ($newStart < $existingEnd && $newEnd > $existingStart) {
                return redirect()->back()
                    ->withErrors(['conflict' => 'Schedule conflicts with an existing schedule.'])
                    ->withInput();
            }
        }

        // Create the schedule
        FacultySubject::create($request->all());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified schedule.
     */
    public function show($id)
    {
        $schedule = FacultySubject::with(['faculty', 'subject', 'section'])->findOrFail($id);
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit($id)
    {
        $schedule = FacultySubject::findOrFail($id);
        $faculty = Faculty::all();
        $subjects = Subject::all();
        $sections = Section::all();
        return view('admin.schedules.edit', compact('schedule', 'faculty', 'subjects', 'sections'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'faculty_id' => 'required|exists:faculties,id',
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for scheduling conflicts (excluding the current schedule)
        $conflictCheck = FacultySubject::where('id', '!=', $id)
            ->where(function($query) use ($request) {
                $query->where('faculty_id', $request->faculty_id)
                      ->orWhere(function($q) use ($request) {
                          $q->where('section_id', $request->section_id)
                            ->where('subject_id', $request->subject_id);
                      });
            })
            ->where('day_of_week', $request->day_of_week)
            ->get();

        foreach ($conflictCheck as $existingSchedule) {
            $newStart = strtotime($request->start_time);
            $newEnd = strtotime($request->end_time);
            $existingStart = strtotime($existingSchedule->start_time);
            $existingEnd = strtotime($existingSchedule->end_time);

            if ($newStart < $existingEnd && $newEnd > $existingStart) {
                return redirect()->back()
                    ->withErrors(['conflict' => 'Schedule conflicts with an existing schedule.'])
                    ->withInput();
            }
        }

        // Update the schedule
        $schedule = FacultySubject::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy($id)
    {
        $schedule = FacultySubject::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }

    /**
     * Display faculty schedule.
     */
    public function facultySchedule($facultyId)
    {
        $faculty = Faculty::findOrFail($facultyId);
        $schedules = FacultySubject::where('faculty_id', $facultyId)
            ->with(['subject', 'section'])
            ->get()
            ->groupBy('day_of_week');
        
        return view('admin.schedules.faculty', compact('faculty', 'schedules'));
    }

    /**
     * Display section schedule.
     */
    public function sectionSchedule($sectionId)
    {
        $section = Section::with('strand')->findOrFail($sectionId);
        $schedules = FacultySubject::where('section_id', $sectionId)
            ->with(['faculty', 'subject'])
            ->get()
            ->groupBy('day_of_week');
        
        return view('admin.schedules.section', compact('section', 'schedules'));
    }

    /**
     * Display student schedule.
     */
    public function studentSchedule($studentId)
    {
        $student = Student::with(['strand', 'section'])->findOrFail($studentId);
        
        // Get all enrollments for this student
        $enrollments = Enrollment::where('student_id', $studentId)
            ->whereHas('facultySubject')
            ->with(['subject', 'facultySubject.faculty', 'facultySubject.section'])
            ->get();
        
        // Group by day of week
        $schedules = $enrollments->map(function ($enrollment) {
            return [
                'day_of_week' => $enrollment->facultySubject->day_of_week,
                'start_time' => $enrollment->facultySubject->start_time,
                'end_time' => $enrollment->facultySubject->end_time,
                'subject' => $enrollment->subject,
                'faculty' => $enrollment->facultySubject->faculty,
                'section' => $enrollment->facultySubject->section,
                'room' => $enrollment->facultySubject->section->room_number
            ];
        })->groupBy('day_of_week');
        
        return view('admin.schedules.student', compact('student', 'schedules'));
    }

    /**
     * Generate section schedules for a specific strand and grade level.
     */
    public function generateSectionSchedules(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'strand_id' => 'required|exists:strands,id',
            'grade_level' => 'required|in:11,12',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $strand = Strand::findOrFail($request->strand_id);
        $gradeLevel = $request->grade_level;
        
        // Get all sections for this strand and grade level
        $sections = Section::where('strand_id', $strand->id)
            ->where('grade_level', $gradeLevel)
            ->get();
        
        // Get all subjects for this strand and grade level
        $subjects = Subject::where('strand_id', $strand->id)
            ->where('grade_level', $gradeLevel)
            ->get();
        
        // Get available faculty
        $faculty = Faculty::all();
        
        return view('admin.schedules.generate', compact('strand', 'gradeLevel', 'sections', 'subjects', 'faculty'));
    }
}
