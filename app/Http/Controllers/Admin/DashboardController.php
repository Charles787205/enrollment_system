<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Strand;
use App\Models\Application;
use Carbon\Carbon;
use App\Models\Faculty;

class DashboardController extends Controller
{
    public function index()
    {
        // Get student counts based on type
        $oldStudentsCount = Student::where('type', 'old')->count();
        $transfereesCount = Student::where('type', 'transferee')->count();
        $totalStudentsCount = $oldStudentsCount + $transfereesCount;

        $stats = [
            'total_students' => $totalStudentsCount,
            'old_students' => $oldStudentsCount,
            'transferees' => $transfereesCount,
            'total_strands' => Strand::count(),
            'faculty_members' => Faculty::count(),
        ];

        // Get monthly registrations for all students
        $monthlyRegistrations = Student::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        // Create chart data array
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyRegistrations[$i] ?? 0;
        }

        return view('admin.dashboard', compact('stats', 'chartData'));
    }
}