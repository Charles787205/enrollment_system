<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Transferee;
use App\Models\Strand;
use App\Models\Application;
use Carbon\Carbon;
use App\Models\Faculty; // <-- Import the Faculty model


class DashboardController extends Controller
{
   
    public function index()
{
    // Fetching data
    $oldStudentsCount = Student::count(); // Assuming 'status' field for old students
    $transfereesCount = Transferee::count();
    $totalStudentsCount = $oldStudentsCount + $transfereesCount;

    $stats = [
        'total_students' => $totalStudentsCount,
        'old_students' => $oldStudentsCount,
        'transferees' => $transfereesCount,
        'total_strands' => Strand::count(),
        'faculty_members' => Faculty::count(), // Correctly counting faculty members
    ];

    // Get monthly registrations including transferees
    $monthlyRegistrations = Student::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->pluck('count', 'month');

    // Correct query for monthly transferee registrations
    $monthlyTransferees = Transferee::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at', now()->year) // Correct filter by 'created_at'
        ->groupBy('month')
        ->pluck('count', 'month');

    // Combine both data
    $chartData = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartData[] = ($monthlyRegistrations[$i] ?? 0) + ($monthlyTransferees[$i] ?? 0);
    }

    return view('admin.dashboard', compact('stats', 'chartData'));
}
}