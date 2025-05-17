@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Old Students (Transferee) Management</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.old_students.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Old Student
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabs for Grade 11/12 -->
                    <ul class="nav nav-tabs" id="gradeTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="grade11-tab" data-toggle="tab" href="#grade11" role="tab"
                                aria-controls="grade11" aria-selected="true">Grade 11</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="grade12-tab" data-toggle="tab" href="#grade12" role="tab"
                                aria-controls="grade12" aria-selected="false">Grade 12</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3" id="gradeTabsContent">
                        <!-- Grade 11 Tab -->
                        <div class="tab-pane fade show active" id="grade11" role="tabpanel"
                            aria-labelledby="grade11-tab">
                            <form id="markPassedForm11" action="{{ route('admin.old_students.mark_passed') }}"
                                method="POST" class="mb-3">
                                @csrf
                                <button type="submit" class="btn btn-success mb-3" id="markPassedBtn11">
                                    <i class="fas fa-check"></i> Mark Selected as PASSED
                                </button>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll11"></th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Strand</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transferees as $transferee)
                                            @if($transferee->grade_level == '11')
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="student_ids[]"
                                                        value="{{ $transferee->id }}" class="student-checkbox">
                                                </td>
                                                <td>{{ $transferee->id }}</td>
                                                <td>{{ $transferee->first_name }} {{ $transferee->middle_name }}
                                                    {{ $transferee->last_name }}</td>
                                                <td>{{ $transferee->email }}</td>
                                                <td>{{ $transferee->contact_number }}</td>
                                                <td>{{ $transferee->strand ? $transferee->strand->name : 'N/A' }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $transferee->status == 'PASSED' ? 'success' : ($transferee->status == 'ENROLLED' ? 'primary' : 'warning') }}">
                                                        {{ $transferee->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.old_students.show', $transferee->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.old_students.edit', $transferee->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if($transferee->status == 'PENDING')
                                                        <form
                                                            action="{{ route('admin.old_students.approve', $transferee->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                        <form
                                                            action="{{ route('admin.old_students.destroy', $transferee->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>

                            <form id="promoteForm" action="{{ route('admin.old_students.promote') }}" method="POST"
                                class="mt-4">
                                @csrf
                                <div class="alert alert-info">
                                    <h5><i class="icon fas fa-info"></i> Promotion to Grade 12</h5>
                                    Select students marked as "PASSED" to promote them to Grade 12.
                                </div>

                                <button type="submit" class="btn btn-warning" id="promoteBtn">
                                    <i class="fas fa-arrow-up"></i> Promote Selected to Grade 12
                                </button>

                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAllPromote"></th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Strand</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transferees as $transferee)
                                            @if($transferee->grade_level == '11' && $transferee->status == 'PASSED')
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="student_ids[]"
                                                        value="{{ $transferee->id }}" class="promote-checkbox">
                                                </td>
                                                <td>{{ $transferee->id }}</td>
                                                <td>{{ $transferee->first_name }} {{ $transferee->middle_name }}
                                                    {{ $transferee->last_name }}</td>
                                                <td>{{ $transferee->strand ? $transferee->strand->name : 'N/A' }}</td>
                                                <td>
                                                    <span class="badge badge-success">PASSED</span>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                        <!-- Grade 12 Tab -->
                        <div class="tab-pane fade" id="grade12" role="tabpanel" aria-labelledby="grade12-tab">
                            <form id="markPassedForm12" action="{{ route('admin.old_students.mark_passed') }}"
                                method="POST" class="mb-3">
                                @csrf
                                <button type="submit" class="btn btn-success mb-3" id="markPassedBtn12">
                                    <i class="fas fa-check"></i> Mark Selected as PASSED
                                </button>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll12"></th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Strand</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transferees as $transferee)
                                            @if($transferee->grade_level == '12')
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="student_ids[]"
                                                        value="{{ $transferee->id }}" class="student-checkbox">
                                                </td>
                                                <td>{{ $transferee->id }}</td>
                                                <td>{{ $transferee->first_name }} {{ $transferee->middle_name }}
                                                    {{ $transferee->last_name }}</td>
                                                <td>{{ $transferee->email }}</td>
                                                <td>{{ $transferee->contact_number }}</td>
                                                <td>{{ $transferee->strand ? $transferee->strand->name : 'N/A' }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $transferee->status == 'PASSED' ? 'success' : ($transferee->status == 'ENROLLED' ? 'primary' : 'warning') }}">
                                                        {{ $transferee->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.old_students.show', $transferee->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.old_students.edit', $transferee->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if($transferee->status == 'PENDING')
                                                        <form
                                                            action="{{ route('admin.old_students.approve', $transferee->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                        <form
                                                            action="{{ route('admin.old_students.destroy', $transferee->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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
        // Grade 11 select all
        $('#selectAll11').click(function () {
            $('#grade11 .student-checkbox').prop('checked', this.checked);
        });

        // Grade 12 select all
        $('#selectAll12').click(function () {
            $('#grade12 .student-checkbox').prop('checked', this.checked);
        });

        // Promotion select all
        $('#selectAllPromote').click(function () {
            $('.promote-checkbox').prop('checked', this.checked);
        });

        // Mark as passed buttons
        $('#markPassedBtn11, #markPassedBtn12').click(function (e) {
            var form = $(this).closest('form');
            var checkedBoxes = form.find('.student-checkbox:checked');

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one student to mark as passed.');
            }
        });

        // Promote button
        $('#promoteBtn').click(function (e) {
            var checkedBoxes = $('.promote-checkbox:checked');

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one student to promote.');
            }
        });
    });
</script>
@endsection