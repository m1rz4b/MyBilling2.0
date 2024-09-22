@extends('layouts.main')

@section('main-container')
<style>
    .table th,
    .table td {
        padding: 0.25rem;
    }

    .select2-container .select2-selection--single {
        height: auto !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-top: .25rem !important;
        padding-bottom: .25rem !important;
        font-size: .875rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 3px !important;
        right: 3px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
    }
</style>

<div>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible my-1" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible my-1" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            @foreach($errors->all() as $error)
            <strong>Error !</strong> {{ $error }}
            @endforeach
        </div>
    @endif
</div>

<div class="main_content_iner">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Administrative</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#add_attendance_summery"><i class="fa-solid fa-plus me-1"></i>Add New</a>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="add_attendance_summery" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('attendancesummary.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Add Timesheet</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="employee_id" class="fw-medium">Employee</label>
                                    <select class="select2 form-select form-select-sm" style="width: 100% !important;" id="employee_id" name="employee_id">
                                        <option selected>Select an Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                        @endforeach                      
                                    </select>
                                </div>
                                    
                                <div class="col-sm-4 form-group">
                                    <label for="date" class="fw-medium">Date</label>
                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="date" data-date-Format="yyyy-mm-dd" id="date">
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="start_date" class="fw-medium">Start Time</label>
                                    <input type="text" class="form-control form-control-sm datetimepicker" value="" name="start_date" data-date-Format="dd-mm-yyyy" id="start_date">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="end_date" class="fw-medium">End Time</label>
                                    <input type="text" class="form-control form-control-sm datetimepicker" value="" name="end_date" data-date-Format="dd-mm-yyyy" id="end_date">
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="total_time" class="fw-medium">Working Hour</label>
                                    <input type="text" class="form-control form-control-sm" value="" name="total_time" id="total_time">
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="over_time" class="fw-medium">Over Time</label>
                                    <input type="text" class="form-control form-control-sm" value="" name="over_time" id="over_time">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <input type="hidden" name="late_mark" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" name="late_mark" id="late_mark" value="1" >
                                    <p class="ms-2 text-dark">Late In</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="hidden" name="early_mark" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" name="early_mark" id="early_mark" value="1">
                                    <p class="ms-2 text-dark">Early Out</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="hidden" name="leave_mark" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" name="leave_mark" id="leave_mark" value="1">
                                    <p class="ms-2 text-dark">On Leave</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="hidden" name="gov_holiday" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" name="gov_holiday" id="gov_holiday" value="1">
                                    <p class="ms-2 text-dark">Government Holiday</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="hidden" name="weekly_holiday" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" name="weekly_holiday" id="weekly_holiday" value="1">
                                    <p class="ms-2 text-dark">Weekly Holiday</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="hidden" name="absent" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" name="absent" id="absent" value="1">
                                    <p class="ms-2 text-dark">Absent</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-primary" value="Submit" onclick="this.disabled=true;this.form.submit();">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row p-3">
            <div class="col-sm-4 form-group">
                <label for="from_date" class="fw-medium">From Date</label>
                <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="from_date" data-date-Format="yyyy-mm-dd" id="from_date">
            </div>

            <div class="col-sm-4 form-group">
                <label for="employee" class="fw-medium">Employee</label>
                <select class="select2 form-select form-select-sm" id="employee" name="employee">
                    <option selected>Select an Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                    @endforeach                      
                </select>
            </div>

            <div class="col-sm-4 form-group">
                <label for="suboffice" class="fw-medium">Office</label>
                <select class="form-select form-select-sm form-control" id="suboffice" name="suboffice">
                    <option selected>Select an Office</option>
                    @foreach ($suboffices as $suboffice)
                        <option value="{{ $suboffice->id }}">{{ $suboffice->name }}</option>
                    @endforeach                      
                </select>
            </div>

            <div class="col-sm-4 form-group">
                <label for="department" class="fw-medium">Department</label>
                <select class="form-select form-select-sm form-control" id="department" name="department">
                    <option selected>Select a Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->department }}</option>
                    @endforeach                      
                </select>
            </div>

            <div class="col-sm-2 d-flex d-sm-inline justify-content-end">
                <br class="d-none d-sm-block">
                <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
            </div>
        </div>



        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Date</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Total Time</th>
                            <th scope="col">Over Time</th>
                            <th scope="col">Ad.Entry</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($attendanceSummeries as $attendanceSummery)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $attendanceSummery->emp_name }}</td>
                            <td>{{ $attendanceSummery->designation }}</td>
                            <td>{{ $attendanceSummery->name }}</td>
                            <td>{{ date('d M Y, l', strtotime($attendanceSummery->date)) }}</td>
                            <td>{{ $attendanceSummery->start_date !='0000-00-00 00:00:00' ? date('H:i A', strtotime($attendanceSummery->start_date)) : $attendanceSummery->start_date }}</td>
                            <td>{{ $attendanceSummery->end_date !='0000-00-00 00:00:00' && $attendanceSummery->start_date != $attendanceSummery->end_date ? date('H:i A', strtotime($attendanceSummery->end_date)) : $attendanceSummery->end_date }}</td>                            
                            <td>{{ $attendanceSummery->total_time }}</td>
                            <td>{{ $attendanceSummery->ot_time }}</td>
                            <td>{{ $attendanceSummery->administrative == 1 ? 'Yes':'No' }}</td>
                            <td class="text-end text-nowrap" width='10%'>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_attendance_summery-{{$attendanceSummery->id}}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_attendance_summery-{{ $attendanceSummery->id }}">Delete</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit_attendance_summery-{{$attendanceSummery->id}}" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{route('attendancesummary.update', ['attendancesummary' => $attendanceSummery])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Edit Timesheet</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label for="employee" class="fw-medium">Employee</label>
                                                    <select class="select2 form-select form-select-sm" style="width: 100% !important;" id="employee" name="employee" disabled>
                                                        <option selected>Select an Employee</option>
                                                        @foreach ($employees as $employee)
                                                            <option {{ $attendanceSummery->id == $employee->id ? 'selected':'' }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>
                                                    
                                                <div class="col-sm-4 form-group">
                                                    <label for="txtdate" class="fw-medium">Date</label>
                                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ date('Y/m/d', strtotime($attendanceSummery->date)) }}" name="txtdate" id="txtdate" disabled>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="start_date" class="fw-medium">Start Time</label>
                                                    <input type="text" class="form-control form-control-sm datetimepicker" value="{{ $attendanceSummery->start_date }}" name="start_date" data-date-Format="dd-mm-yyyy" id="start_date">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label for="end_date" class="fw-medium">End Time</label>
                                                    <input type="text" class="form-control form-control-sm datetimepicker" value="{{ $attendanceSummery->end_date }}" name="end_date" data-date-Format="dd-mm-yyyy" id="end_date">
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="total_time" class="fw-medium">Working Hour</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $attendanceSummery->total_time }}" name="total_time" id="total_time">
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="over_time" class="fw-medium">Over Time</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $attendanceSummery->over_time }}" name="over_time" id="over_time">
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="late_mark" value="0">
                                                    <input class="form-check-input mt-0" type="checkbox" name="late_mark" id="late_mark" {{$attendanceSummery->late_mark == 1?'checked':''}} value="1" >
                                                    <p class="ms-2 text-dark">Late In</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="early_mark" value="0">
                                                    <input class="form-check-input mt-0" type="checkbox" name="early_mark" id="early_mark" {{$attendanceSummery->early_mark == 1?'checked':''}} value="1" >
                                                    <p class="ms-2 text-dark">Early Out</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="leave_mark" value="0">
                                                    <input class="form-check-input mt-0" type="checkbox" name="leave_mark" id="leave_mark" {{$attendanceSummery->leave_mark == 1?'checked':''}} value="1" >
                                                    <p class="ms-2 text-dark">On Leave</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="gov_holiday" value="0">
                                                    <input class="form-check-input mt-0" type="checkbox" name="gov_holiday" id="gov_holiday" {{$attendanceSummery->gov_holiday == 1?'checked':''}} value="1" >
                                                    <p class="ms-2 text-dark">Government Holiday</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="weekly_holiday" value="0">
                                                    <input class="form-check-input mt-0" type="checkbox" name="weekly_holiday" id="weekly_holiday" {{$attendanceSummery->weekly_holiday == 1?'checked':''}} value="1" >
                                                    <p class="ms-2 text-dark">Weekly Holiday</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="absent" value="0">
                                                    <input class="form-check-input mt-0" type="checkbox" name="absent" id="absent" {{$attendanceSummery->absent == 1?'checked':''}} value="1" >
                                                    <p class="ms-2 text-dark">Absent</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-sm btn-success" value="Submit" onclick="this.disabled=true;this.form.submit();">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="delete_attendance_summery-{{$attendanceSummery->id}}" tabindex="-1" aria-labelledby="delete_attendance_summery_modal_label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('attendancesummary.destroy', ['attendancesummary' => $attendanceSummery])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="delete_attendance_summery_modal_label{{ $attendanceSummery->id }}">Delete Timesheet for {{ $attendanceSummery->emp_name }}?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-2">
                                                        <label for="emp_name">Employee Name</label>
                                                        <input type="text" class="form-control" value="{{ $attendanceSummery->emp_name }}" name="emp_name" id="emp_name" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-sm btn-danger" value="Delete" onclick="this.disabled=true;this.form.submit();">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });

    jQuery('.datetimepicker').datetimepicker();
</script>

@endpush
@endsection