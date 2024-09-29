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
    <div class="container-fluid p-0 pb-3 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Leave Register Report</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#leave_register_report"><i class="fa-solid fa-plus me-1"></i>Add New</a>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="leave_register_report" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('leaveregister.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Add Employee Leave Resister</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="employee_id" class="fw-medium">Employee</label>
                                    <select class="form-select form-select-sm selectmodal form-control" style="width: 100% !important;" id="employee_id" name="employee_id">
                                        <option value="-1">Select an Employee</option>
                                        @foreach ($employees_modal as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="leave_type" class="fw-medium">Leave Type</label>
                                    <select class="form-select form-select-sm form-control" id="leave_type" name="leave_type">
                                        <option value="-1">Select a Leave Type</option>
                                        @foreach ($leave_types as $leave_type)
                                            <option value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="year" class="fw-medium">Year</label>
                                    <select class="form-select form-select-sm form-control" id="year" name="year" >
                                        <option>{{ now()->year }}</option>
                                        @foreach (range(now()->year, now()->year + 1) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="total" class="fw-medium">Allow Leave days</label>
                                    <input type="text" class="form-control form-control-sm" value="" name="total" id="total">
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

        <form action="{{route('leaveregister.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="year" class="fw-medium">Year</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            <option>{{ now()->year }}</option>
                            <option value="-1">Select a Year</option>
                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                <option {{ $selectedYear==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="department" class="fw-medium">Department</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="department" name="department">
                            <option value="-1">Select a Department</option>
                            @foreach ($departments as $department)
                                <option {{ $selectedDepartment==$department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="employee" class="fw-medium">Employee</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                        <select class="select2 form-select form-select-sm" id="employee" name="employee">
                            <option value="-1">Select an Employee</option>
                            @foreach ($employees_modal as $employee)
                                <option {{ $selectedEmployee==$employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="col-sm-2 d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Show</button>
                </div>
            </div>
        </form>

        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th>Type</th>
                            <th>Allowed</th>
                            <th>Taken</th>
                            <th>Total</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            <td colspan="6"><strong>Employee {{ $employee->emp_name }}</strong></td>
                        </tr>
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $employee->name }}</td>                    
                            <td>{{ $employee->total }}</td>
                            <td>{{ $employee->consumed }}</td>
                            <td>{{ $employee->allowed - $employee->consumed }}</td>
                            <td class="text-center text-nowrap" width='10%'>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_leave_register_report-{{$employee->id}}">Edit</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit_leave_register_report-{{$employee->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('leaveregister.update', ['leaveregister'=>$employee->id] )}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit Employee Leave Resister</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="employee_id" class="fw-medium">Employee</label>
                                                    <select class="form-select form-select-sm selectmodal form-control" style="width: 100% !important;" id="employee_id" name="employee_id">
                                                        <option value="-1">Select an Employee</option>
                                                        @foreach ($employees_modal as $emp_modal)
                                                            <option {{$employee->emp_id==$emp_modal->id ? 'selected' : ''}} value="{{ $emp_modal->id }}">{{ $emp_modal->emp_name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="leave_type" class="fw-medium">Leave Type</label>
                                                    <select class="form-select form-select-sm form-control" id="leave_type" name="leave_type">
                                                        <option value="-1">Select a Leave Type</option>
                                                        @foreach ($leave_types as $leave_type)
                                                            <option {{$employee->leave_type==$leave_type->id ? 'selected' : ''}} value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="year" class="fw-medium">Year</label>
                                                    <select class="form-select form-select-sm form-control" id="year" name="year" >
                                                        <option>{{ now()->year }}</option>
                                                        @foreach (range(now()->year, now()->year + 1) as $year)
                                                            <option {{$employee->year==$year ? 'selected' : ''}} value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="total" class="fw-medium">Allow Leave days</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{$employee->total}}" name="total" id="total">
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
                        @endforeach
                    </tbody>
                </table>
                {!! $employees->links() !!}
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