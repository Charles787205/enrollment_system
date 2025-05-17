<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Program;
use App\Models\Strand;
use App\Models\Transferee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash; // Add this import
use Illuminate\Support\Facades\Validator; // Add this import


class AdminController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('admin.login');
    }

public function showRegistrationForm()
{
    return view('admin.register');
}
    // Handle login attempt
    public function login(Request $request)
    {
        // Validate credentials
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Attempt to log in
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        // If login fails
        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    // Dashboard
    public function dashboard()
{
    // Get statistics for the dashboard
    $old_students = Student::where('type', 'old')->count();
    $transferees = Transferee::count();
    $total_students = $old_students + $transferees;
    $new_applications = Student::where('status', 'Pending')->count();

    $stats = [
        'total_students' => $total_students,
        'old_students' => $old_students,
        'transferees' => $transferees,
        'new_applications' => $new_applications,
        'active_programs' => Program::where('status', 'active')->count(),
        'total_strands' => Strand::count(),
        'faculty_members' => 89 // You might want to dynamically fetch faculty members later
    ];

    // Get recent student applications (latest 5)
    $recent_applications = Student::latest()->take(5)->get();

    // Fetch old students and transferees, then merge them
    $oldStudents = Student::where('type', 'old')->get();
    $transferees = Transferee::all(); // Assuming `Transferee` is a model for transferee students
    $allStudents = $oldStudents->merge($transferees); // Combine both collections

    // Pass data to the dashboard view
    return view('admin.dashboard', compact('stats', 'recent_applications', 'allStudents'));
}

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $admin = Admin::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::guard('admin')->login($admin);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }

    // Show the first-time admin setup form
    public function showSetupForm()
    {
        // If admin already exists, redirect to login
        if (Admin::count() > 0) {
            return redirect()->route('admin.login');
        }
        
        return view('admin.setup');
    }

    // Handle first-time admin setup
    public function setupAdmin(Request $request)
    {
        // If admin already exists, redirect to login
        if (Admin::count() > 0) {
            return redirect()->route('admin.login');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $admin = Admin::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::guard('admin')->login($admin);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Admin account created successfully! Welcome to your dashboard.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}
