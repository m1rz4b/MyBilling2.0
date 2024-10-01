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
                <h5 class="mb-0" style="color: white;">Employee</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#add_attendance_summery"><i class="fa-solid fa-plus me-1"></i>Add New Employee</a>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="add_attendance_summery" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('employeeinformation.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Add Timesheet</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <input type="file" class="dropify" name="image" />
                                </div>

                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label for="suboffice_id" class="fw-medium">Sub-Office</label>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                                                <select class="form-select form-select-sm form-control" id="suboffice_id" name="suboffice_id">
                                                    <option value="-1" selected><i class="fa-solid fa-building me-1"></i>Select a Sub-Office</option>
                                                    @foreach ($suboffices as $suboffice)
                                                        <option value="{{ $suboffice->id }}">{{ $suboffice->name }}</option>
                                                    @endforeach                      
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label for="emp_name" class="fw-medium">Employee Name</label>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                                <input type="text" class="form-control form-control-sm" value="" name="emp_name" id="emp_name" placeholder="Name">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label for="emp_pin" class="fw-medium">Employee Pin</label>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                                <input type="text" class="form-control form-control-sm" value="" name="emp_pin" id="emp_pin" placeholder="Name">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label for="date_of_joining" class="fw-medium">Date of Joining</label>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-calendar-days"></i></span>
                                                <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="date_of_joining" data-date-Format="yyyy-mm-dd" id="date_of_joining">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label for="mobile" class="fw-medium">Mobile</label>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-mobile"></i></span>
                                                <input type="text" class="form-control form-control-sm" value="" name="mobile" data-date-Format="yyyy-mm-dd" id="mobile">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label for="email" class="fw-medium">Email</label>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-envelope"></i></span>
                                                <input type="text" class="form-control form-control-sm" value="" name="email" data-date-Format="yyyy-mm-dd" id="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="department" class="fw-medium">Department</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                                        <select value="-1" class="form-select form-select-sm form-control" id="department" name="department">
                                            <option selected>Select a Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                                            @endforeach                      
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="designation" class="fw-medium">Designation</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-brands fa-black-tie"></i></span>
                                        <select class="form-select form-select-sm form-control" id="designation" name="designation">
                                            <option value="-1" selected>Select a Designation</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                            @endforeach                      
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="status" class="fw-medium">Employee Status</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-chart-simple"></i></span>
                                        <select class="form-select form-select-sm form-control" id="status" name="status">
                                            <option value="-1" selected>Select a Status</option>
                                            @foreach ($employee_statuses as $emp_status)
                                                <option value="{{ $emp_status->id }}">{{ $emp_status->name }}</option>
                                            @endforeach                      
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="reporting_manager" class="fw-medium">Reporting Manager</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                        <select class="form-select form-select-sm form-control" id="reporting_manager" name="reporting_manager">
                                            <option value="-1" selected>Select a Reporting Manager</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                            @endforeach                      
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="reporting_manager_des" class="fw-medium">Reporting Manager Designation</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-brands fa-black-tie"></i></span>
                                        <select class="form-select form-select-sm form-control" id="reporting_manager_des" name="reporting_manager_des">
                                            <option value="-1" selected>Select a Designation</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                            @endforeach                       
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="salary_status" class="fw-medium">Salary Status</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-chart-simple"></i></span>
                                        <select class="form-select form-select-sm form-control" id="salary_status" name="salary_status">
                                            <option value="-1" selected>Select a Status</option>
                                            @foreach ($salary_status as $status)
                                                <option value="{{ $status->id }}">{{ $status->description }}</option>
                                            @endforeach                       
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="address" class="fw-medium">Address</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-house-chimney"></i></span>
                                        <textarea type="text" rows="1" class="form-control form-control-sm" name="address" id="address"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="payment_mode" class="fw-medium">Payment Mode</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill-transfer"></i></span>
                                        <select class="form-select form-select-sm form-control" id="payment_mode" name="payment_mode">
                                            <option value="-1" selected>Select a Payment Mode</option>
                                            @foreach ($payment_modes as $payment_mode)
                                                <option value="{{ $payment_mode->id }}">{{ $payment_mode->name }}</option>
                                            @endforeach                       
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="bank_id" class="fw-medium">Bank</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building-columns"></i></span>
                                        <select class="form-select form-select-sm form-control" id="bank_id" name="bank_id">
                                            <option value="-1" selected>Select a Bank</option>
                                            @foreach ($mas_banks as $mas_bank)
                                                <option value="{{ $mas_bank->id }}">{{ $mas_bank->bank_name }}</option>
                                            @endforeach                       
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="acc_no" class="fw-medium">Account No.</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-id-card"></i></span>
                                        <input type="text" class="form-control form-control-sm" value="" name="acc_no" id="acc_no" placeholder="Account No.">
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="shift_id" class="fw-medium">Shift</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-clock"></i></span>
                                        <select class="form-select form-select-sm form-control" id="shift_id" name="shift_id">
                                            <option value="-1" selected>Select a Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option {{$shift->id == '1' ? 'Selected' : ''}} value="{{ $shift->id }}">{{ $shift->sch_name }}</option>
                                            @endforeach                       
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="user_group_id" class="fw-medium">User Access Group</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user-group"></i></span>
                                        <select class="form-select form-select-sm form-control" id="user_group_id" name="user_group_id">
                                            <option value="-1" selected>Select a User Access Group</option>
                                            @foreach ($user_types as $user_type)
                                                <option value="{{ $user_type->id }}">{{ $user_type->type_name }}</option>
                                            @endforeach                       
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="e_tin" class="fw-medium">E-Tin</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" class="form-control form-control-sm" value="" name="e_tin" id="e_tin" placeholder="E-Tin">
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="last_increment_date" class="fw-medium">Last Increment</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-calendar-days"></i></span>
                                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="last_increment_date" data-position="top left" data-date-Format="yyyy-mm-dd" id="last_increment_date">
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label for="last_promotion_date" class="fw-medium">Last Promotion</label>
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-calendar-days"></i></span>
                                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="last_promotion_date" data-position="top left" data-date-Format="yyyy-mm-dd" id="last_promotion_date">
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

        <div class="row p-3">
            <div class="col-sm-4 form-group">
                <label for="suboffice" class="fw-medium">Sub-Office</label>
                <select class="form-select form-select-sm form-control" id="suboffice" name="suboffice">
                    <option selected>Select a Sub-Office</option>
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

            <div class="col-sm-4 form-group">
                <label for="designation" class="fw-medium">Designation</label>
                <select class="form-select form-select-sm form-control" id="designation" name="designation">
                    <option selected>Select a Designation</option>
                    @foreach ($designations as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                    @endforeach                      
                </select>
            </div>

            <div class="col-sm-4 form-group">
                <label for="name" class="fw-medium">Name/Mobile/Address</label>
                <input type="text" class="form-control form-control-sm" value="" name="name" id="name">
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
                            <th scope="col"><small class="text-nowrap">Sl</small></th>
                            <th scope="col"><small class="text-nowrap">Employee Name</small></th>
                            <th scope="col"><small class="text-nowrap">Date of Joining</small></th>
                            <th scope="col"><small class="text-nowrap">Department</small></th>
                            <th scope="col"><small class="text-nowrap">Designation</small></th>
                            <th scope="col"><small class="text-nowrap">Mobile</small></th>
                            <th scope="col"><small class="text-nowrap">Email</small></th>
                            <th scope="col"><small class="text-nowrap">Status</small></th>
                            <th scope="col" class="text-center"><small class="text-nowrap">Action</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($mas_employees as $mas_employee)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $mas_employee->emp_name }}</td>
                            <td>{{ $mas_employee->date_of_joining }}</td>
                            <td>{{ $mas_employee->department }}</td>
                            <td>{{ $mas_employee->designation }}</td>
                            <td>{{ $mas_employee->mobile }}</td>
                            <td>{{ $mas_employee->email }}</td>
                            <td>{{ $mas_employee->statusname }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-success px-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                    <ul class="dropdown-menu rounded-sm py-2">
                                        <li><button class="dropdown-item bg-primary text-white" type="button" data-bs-toggle="modal" data-bs-target="#edit_employee_information_modal-{{$mas_employee->id}}"><i class="fa-solid fa-pencil me-1"></i>Edit</button></li>
                                        <li><button class="dropdown-item bg-success text-white" type="button" data-bs-toggle="modal" data-bs-target="#package-modal-{{$mas_employee->id}}"><i class="fa-solid fa-camera me-1"></i>View</button></li>
                                        <li><button class="dropdown-item bg-info text-white" type="button" data-bs-toggle="modal" data-bs-target="#pass-modal-{{$mas_employee->id}}"><i class="fa-solid fa-dollar-sign me-1"></i>Salary</button></li>
                                        <li><button class="dropdown-item bg-danger text-white" type="button" data-bs-toggle="modal" data-bs-target="#pass-modal-{{$mas_employee->id}}"><i class="fa-solid fa-chart-simple me-1"></i>Status Change</button></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @foreach ($edit_mas_employees as $edit_mas_employee)
                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit_employee_information_modal-{{$edit_mas_employee->id}}" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{route('employeeinformation.update', ['employeeinformation' => $edit_mas_employee])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Edit Timesheet</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <input type="file" class="dropify" name="image" />
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label for="suboffice_id" class="fw-medium">Sub-Office</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                                                                <select class="form-select form-select-sm form-control" id="suboffice_id" name="suboffice_id">
                                                                    <option value="-1" selected><i class="fa-solid fa-building me-1"></i>Select a Sub-Office</option>
                                                                    @foreach ($suboffices as $suboffice)
                                                                        <option {{$edit_mas_employee->suboffice_id==$suboffice->id?'selected':''}} value="{{ $suboffice->id }}">{{ $suboffice->name }}</option>
                                                                    @endforeach                      
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 form-group">
                                                            <label for="emp_name" class="fw-medium">Employee Name</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $edit_mas_employee->emp_name }}" name="emp_name" id="emp_name" placeholder="Name">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 form-group">
                                                            <label for="emp_pin" class="fw-medium">Employee Pin</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $edit_mas_employee->emp_pin }}" name="emp_pin" id="emp_pin" placeholder="Name">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 form-group">
                                                            <label for="date_of_joining" class="fw-medium">Date of Joining</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-calendar-days"></i></span>
                                                                <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ $edit_mas_employee->date_of_joining }}" name="date_of_joining" data-date-Format="yyyy-mm-dd" id="date_of_joining">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 form-group">
                                                            <label for="mobile" class="fw-medium">Mobile</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-mobile"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $edit_mas_employee->mobile }}" name="mobile" data-date-Format="yyyy-mm-dd" id="mobile">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 form-group">
                                                            <label for="email" class="fw-medium">Email</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-envelope"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $edit_mas_employee->email }}" name="email" data-date-Format="yyyy-mm-dd" id="email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label for="department" class="fw-medium">Department</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                                                        <select value="-1" class="form-select form-select-sm form-control" id="department" name="department">
                                                            <option selected>Select a Department</option>
                                                            @foreach ($departments as $department)
                                                                <option {{$edit_mas_employee->department==$department->id?'selected':''}} value="{{ $department->id }}">{{ $department->department }}</option>
                                                            @endforeach                      
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="designation" class="fw-medium">Designation</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-brands fa-black-tie"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="designation" name="designation">
                                                            <option value="-1" selected>Select a Designation</option>
                                                            @foreach ($designations as $designation)
                                                                <option {{$edit_mas_employee->designation==$designation->id?'selected':''}} value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                                            @endforeach                      
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="status" class="fw-medium">Employee Status</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-chart-simple"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="status" name="status">
                                                            <option value="-1" selected>Select a Status</option>
                                                            @foreach ($employee_statuses as $emp_status)
                                                                <option {{$edit_mas_employee->status==$emp_status->id?'selected':''}} value="{{ $emp_status->id }}">{{ $emp_status->name }}</option>
                                                            @endforeach                      
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label for="reporting_manager" class="fw-medium">Reporting Manager</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="reporting_manager" name="reporting_manager">
                                                            <option value="-1" selected>Select a Reporting Manager</option>
                                                            @foreach ($employees as $employee)
                                                                <option {{$edit_mas_employee->reporting_manager==$employee->id?'selected':''}} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                                            @endforeach                      
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="reporting_manager_des" class="fw-medium">Reporting Manager Designation</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-brands fa-black-tie"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="reporting_manager_des" name="reporting_manager_des">
                                                            <option value="-1" selected>Select a Designation</option>
                                                            @foreach ($designations as $designation)
                                                                <option {{$edit_mas_employee->reporting_manager_des==$designation->id?'selected':''}} value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                                            @endforeach                       
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="salary_status" class="fw-medium">Salary Status</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-chart-simple"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="salary_status" name="salary_status">
                                                            <option value="-1" selected>Select a Status</option>
                                                            @foreach ($salary_status as $status)
                                                                <option {{$edit_mas_employee->salary_status==$status->id?'selected':''}} value="{{ $status->id }}">{{ $status->description }}</option>
                                                            @endforeach                       
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label for="address" class="fw-medium">Address</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-house-chimney"></i></span>
                                                        <textarea type="text" rows="1" class="form-control form-control-sm" name="address" id="address">{{ $edit_mas_employee->address }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="payment_mode" class="fw-medium">Payment Mode</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill-transfer"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="payment_mode" name="payment_mode">
                                                            <option value="-1" selected>Select a Payment Mode</option>
                                                            @foreach ($payment_modes as $payment_mode)
                                                                <option {{$edit_mas_employee->payment_mode==$payment_mode->id?'selected':''}} value="{{ $payment_mode->id }}">{{ $payment_mode->name }}</option>
                                                            @endforeach                       
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="bank_id" class="fw-medium">Bank</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building-columns"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="bank_id" name="bank_id">
                                                            <option value="-1" selected>Select a Bank</option>
                                                            @foreach ($mas_banks as $mas_bank)
                                                                <option {{$edit_mas_employee->bank_id==$mas_bank->id?'selected':''}} value="{{ $mas_bank->id }}">{{ $mas_bank->bank_name }}</option>
                                                            @endforeach                       
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label for="acc_no" class="fw-medium">Account No.</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-id-card"></i></span>
                                                        <input type="text" class="form-control form-control-sm" value="{{$edit_mas_employee->acc_no}}" name="acc_no" id="acc_no" placeholder="Account No.">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="shift_id" class="fw-medium">Shift</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-clock"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="shift_id" name="shift_id">
                                                            <option value="-1" selected>Select a Shift</option>
                                                            @foreach ($shifts as $shift)
                                                                <option {{$edit_mas_employee->shift_id==$shift->id?'selected':''}} value="{{ $shift->id }}">{{ $shift->sch_name }}</option>
                                                            @endforeach                       
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="user_group_id" class="fw-medium">User Access Group</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user-group"></i></span>
                                                        <select class="form-select form-select-sm form-control" id="user_group_id" name="user_group_id">
                                                            <option value="-1" selected>Select a User Access Group</option>
                                                            @foreach ($user_types as $user_type)
                                                                <option {{$edit_mas_employee->user_group_id==$user_type->id?'selected':''}} value="{{ $user_type->id }}">{{ $user_type->type_name }}</option>
                                                            @endforeach                       
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label for="e_tin" class="fw-medium">E-Tin</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                                        <input type="text" class="form-control form-control-sm" value="{{$edit_mas_employee->e_tin}}" name="e_tin" id="e_tin" placeholder="E-Tin">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="last_increment_date" class="fw-medium">Last Increment</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-calendar-days"></i></span>
                                                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$edit_mas_employee->last_increment_date}}" name="last_increment_date" data-position="top left" data-date-Format="yyyy-mm-dd" id="last_increment_date">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label for="last_promotion_date" class="fw-medium">Last Promotion</label>
                                                    <div class="input-group input-group-sm flex-nowrap">
                                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-calendar-days"></i></span>
                                                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$edit_mas_employee->last_promotion_date}}" name="last_promotion_date" data-position="top left" data-date-Format="yyyy-mm-dd" id="last_promotion_date">
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

    $('.dropify').dropify();

    jQuery('.datetimepicker').datetimepicker();
</script>

@endpush
@endsection