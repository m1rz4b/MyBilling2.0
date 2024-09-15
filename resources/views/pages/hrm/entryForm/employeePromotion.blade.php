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
                <h5 class="mb-0" style="color: white;">Employee Promotion</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#add_attendance_summery"><i class="fa-solid fa-plus me-1"></i>Add New</a>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="add_attendance_summery" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('employeepromotion.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Add Promotion</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label for="emp_id" class="fw-medium">Employee</label>
                                    <select class="select2 form-select form-select-sm form-control" style="width: 100% !important;" id="emp_id" name="emp_id">
                                        <option value="-1" selected>Select an Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label for="designation" class="fw-medium">Promotion Designation</label>
                                    <select class="select2 form-select form-select-sm form-control" style="width: 100% !important;" id="designation" name="designation">
                                        <option value="-1" selected>Select a Promotion Designation</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label for="pro_date" class="fw-medium">Promotion Date</label>
                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="pro_date" data-date-Format="yyyy-mm-dd" id="pro_date">
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

        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><small class="text-nowrap">Sl</small></th>
                            <th scope="col"><small class="text-nowrap">Employee Name</small></th>
                            <th scope="col"><small class="text-nowrap">Promotion Date</small></th>
                            <th scope="col"><small class="text-nowrap">Promotion Designation</small></th>
                            <th scope="col"><small class="text-nowrap">Previous Promotion Date</small></th>
                            <th scope="col"><small class="text-nowrap">Previous Designation</small></th>
                            <th scope="col" class="text-center"><small class="text-nowrap">Action</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($emp_job_histories as $emp_job_history)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $emp_job_history->emp_name }}</td>
                            <td>{{ $emp_job_history->pro_date }}</td>
                            <td>{{ $emp_job_history->prodes }}</td>
                            <td>{{ $emp_job_history->pre_pro_date }}</td>
                            <td>{{ $emp_job_history->predes }}</td>
                            <td class="text-center text-nowrap" width='10%'>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_emp_job_histories_modal-{{$emp_job_history->id}}">Edit</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit_emp_job_histories_modal-{{$emp_job_history->id}}" tabindex="-1" aria-labelledby="emp_job_histories_title" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('employeepromotion.update', ['employeepromotion' => $emp_job_history])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="emp_job_histories_title">Edit Timesheet</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-sm-12 form-group">
                                                        <label for="emp_id" class="fw-medium">Employee</label>
                                                        <select class="select2 form-select form-select-sm form-control" style="width: 100% !important;" id="emp_id" name="emp_id">
                                                            <option value="-1" selected>Select an Employee</option>
                                                            @foreach ($employees as $employee)
                                                                <option {{$emp_job_history->emp_name == $employee->emp_name ? "selected" : ""}} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                                            @endforeach                      
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 form-group">
                                                        <label for="designation" class="fw-medium">Promotion Designation</label>
                                                        <select class="select2 form-select form-select-sm form-control" style="width: 100% !important;" id="designation" name="designation">
                                                            <option value="-1" selected>Select a Promotion Designation</option>
                                                            @foreach ($designations as $designation)
                                                                <option {{$emp_job_history->designation == $designation->id ? "selected" : ""}} value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                                            @endforeach                      
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 form-group">
                                                        <label for="pro_date" class="fw-medium">Promotion Date</label>
                                                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$emp_job_history->pro_date}}" name="pro_date" data-date-Format="yyyy-mm-dd" id="pro_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="reset" class="btn btn-sm btn-warning text-white" value="Reset">
                                            <input type="submit" class="btn btn-sm btn-primary" value="Submit" onclick="this.disabled=true;this.form.submit();">
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
</script>

@endpush
@endsection