@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Student Schedule</h3>
                    <div class="card-tools">
                        <a href="javascript:window.print()" class="btn btn-default">
                            <i class="fas fa-print"></i> Print
                        </a>
                        <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-info">
                            <i class="fas fa-arrow-left"></i> Back to Student
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Student Information</h3>
                                </div>
                                <div class="card-body">
                                    <strong>Student ID:</strong> {{ $student->student_id }}<br>
                                    <strong>Name:</strong> {{ $student->full_name }}<br>
                                    <strong>Grade Level:</strong>
                                    {{ $student->year_level == '11' ? 'Grade 11' : 'Grade 12' }}<br>
                                    <strong>Strand:</strong>
                                    {{ $student->strand ? $student->strand->name : 'Not Assigned' }}<br>
                                    <strong>Section:</strong>
                                    {{ $student->section ? $student->section->name : 'Not Assigned' }}<br>
                                    <strong>Status:</strong>
                                    <span
                                        class="badge badge-{{ $student->status == 'PASSED' ? 'success' : ($student->status == 'ENROLLED' ? 'primary' : 'danger') }}">
                                        {{ $student->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Academic Information</h3>
                                </div>
                                <div class="card-body">
                                    <strong>Academic Year:</strong> {{ date('Y') }}-{{ date('Y')+1 }}<br>
                                    <strong>Enrollment Date:</strong>
                                    {{ $student->EnrollmentDate ? date('F d, Y', strtotime($student->EnrollmentDate)) : 'Not available' }}<br>
                                    <strong>Total Subjects:</strong> {{ count($schedules) }}<br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-success mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Weekly Schedule</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-light">
                                            <th width="15%">Day</th>
                                            <th width="15%">Time</th>
                                            <th width="20%">Subject</th>
                                            <th width="20%">Teacher</th>
                                            <th width="15%">Room</th>
                                            <th width="15%">Section</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($schedules) > 0)
                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as
                                        $day)
                                        @if(isset($schedules[$day]) && count($schedules[$day]) > 0)
                                        @foreach($schedules[$day] as $schedule)
                                        <tr>
                                            <td>{{ $day }}</td>
                                            <td>
                                                {{ date('h:i A', strtotime($schedule['start_time'])) }} -
                                                {{ date('h:i A', strtotime($schedule['end_time'])) }}
                                            </td>
                                            <td>
                                                <strong>{{ $schedule['subject']->code }}</strong><br>
                                                {{ $schedule['subject']->title }}
                                            </td>
                                            <td>
                                                {{ $schedule['faculty']->full_name ?? $schedule['faculty']->name }}
                                            </td>
                                            <td>{{ $schedule['room'] }}</td>
                                            <td>{{ $schedule['section']->name }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="text-center">No schedule available for this student.
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // For printable version
        window.addEventListener('beforeprint', function () {
            $('.card-tools').hide();
            $('.main-header').hide();
            $('.main-sidebar').hide();
            $('.main-footer').hide();
            $('body').removeClass('sidebar-mini').addClass('print-mode');
            $('.content-wrapper').css('margin-left', '0');
        });

        window.addEventListener('afterprint', function () {
            $('.card-tools').show();
            $('.main-header').show();
            $('.main-sidebar').show();
            $('.main-footer').show();
            $('body').addClass('sidebar-mini').removeClass('print-mode');
            $('.content-wrapper').css('margin-left', '');
        });
    });
</script>
@endsection

@section('styles')
<style>
    @media print {
        body {
            background-color: white !important;
        }

        .content-wrapper {
            margin-left: 0 !important;
            background-color: white !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>
@endsection