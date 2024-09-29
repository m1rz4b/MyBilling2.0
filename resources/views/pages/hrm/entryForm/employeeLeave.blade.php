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
                <h5 class="mb-0" style="color: white;">Manage Employee Leave</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#add_employee_leave"><i class="fa-solid fa-plus me-1"></i>Add New</a>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="add_employee_leave" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('employeeleave.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Add Employee Leave</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div id="load_alldata">
                                
                                </div>

                                <div class="form-group">
                                    <label for="employee_id" class="fw-medium">Employee</label>
                                    <select class="select2 form-select form-select-sm selectmodal form-control" style="width: 100% !important;" id="employee_id" name="employee_id">
                                        <option value="-1">Select an Employee</option>
                                        @foreach ($employees_modal as $employees)
                                            <option value="{{ $employees->emp_id }}">{{ $employees->employee_details }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="day_type" class="fw-medium">Day Type</label>
                                    <select class="form-select form-select-sm form-control" id="day_type" name="day_type">
                                        <option value="-1">Select a Leave Type</option>
                                        @foreach ($leave_day_types as $leave_day_type)
                                            <option value="{{ $leave_day_type->id }}">{{ $leave_day_type->name }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="from_date" class="fw-medium">From Date</label>
                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="from_date" data-date-Format="yyyy-mm-dd" id="from_date">
                                </div>

                                <div class="form-group hideclass">
                                    <label for="to_date" class="fw-medium">To Date</label>
                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="to_date" data-date-Format="yyyy-mm-dd" id="to_date">
                                </div>

                                <div class="form-group">
                                    <label for="days" class="fw-medium">Days</label>
                                    <input type="text" class="form-control form-control-sm" value="" name="days" id="days">
                                </div>
                                    
                                <div class="form-group">
                                    <label for="leavetype_id" class="fw-medium">Leave Type</label>
                                    <select class="form-select form-select-sm form-control" id="leavetype_id" name="leavetype_id">
                                        <option value="-1">Select a Leave Type</option>
                                        @foreach ($leave_types as $leave_type)
                                            <option value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="remarks" class="fw-medium">Remarks</label>
                                    <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="2"></textarea>
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

        <form action="{{route('employeeleave.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="txtfromopen_date" class="fw-medium">From Date</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$selectedFromDate}}" name="txtfromopen_date" data-date-Format="yyyy-mm-dd" id="txtfromopen_date">
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="txttoopen_date" class="fw-medium">To Date</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$selectedToDate}}" name="txttoopen_date" data-date-Format="yyyy-mm-dd" id="txttoopen_date">
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="employee" class="fw-medium">Employee</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                        <select class="select2 form-select form-select-sm" id="employee" name="employee">
                            <option value="-1">Select an Employee</option>
                            @foreach ($mas_employees as $mas_employee)
                                <option {{ $selectedEmployee==$mas_employee->id ? 'selected' : '' }} value="{{ $mas_employee->id }}">{{ $mas_employee->emp_name }}</option>
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
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Date Range</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tbl_leaves as $tbl_leave)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $tbl_leave->emp_name }}</td>
                            <td>{{ $tbl_leave->leavetype_name }}</td>
                            <td>{{ $tbl_leave->from_date }} - {{ $tbl_leave->to_date }}</td>                    
                            <td>{{ $tbl_leave->days }}</td>
                            <td>{{ $tbl_leave->leave_status }}</td>
                            <td class="text-end text-nowrap" width='10%'>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_employee_leave-{{$tbl_leave->id}}">Edit</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit_employee_leave-{{$tbl_leave->id}}" tabindex="-1" aria-labelledby="attendance_summery_title" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('employeeleave.update', ['employeeleave' => $tbl_leave])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="attendance_summery_title">Edit Employee Leave</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div id="load_alldata">
                                                
                                                </div>

                                                <div class="form-group">
                                                    <label for="employee_id" class="fw-medium">Employee</label>
                                                    <select class="select2 form-select form-select-sm selectmodal form-control" style="width: 100% !important;" id="employee_id" name="employee_id">
                                                        <option value="-1">Select an Employee</option>
                                                        @foreach ($employees_modal as $employees)
                                                            <option {{ $tbl_leave->employee_id == $employees->emp_id ? 'selected':'' }} value="{{ $employees->emp_id }}">{{ $employees->employee_details }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="day_type" class="fw-medium">Day Type</label>
                                                    <select class="form-select form-select-sm form-control" id="day_type" name="day_type">
                                                        <option value="-1">Select a Leave Type</option>
                                                        @foreach ($leave_day_types as $leave_day_type)
                                                            <option {{ $tbl_leave->day_type == $leave_day_type->id ? 'selected':'' }} value="{{ $leave_day_type->id }}">{{ $leave_day_type->name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="from_date" class="fw-medium">From Date</label>
                                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ $tbl_leave->from_date}}" name="from_date" data-date-Format="yyyy-mm-dd" id="from_date">
                                                </div>

                                                <div class="form-group hideclass">
                                                    <label for="to_date" class="fw-medium">To Date</label>
                                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ $tbl_leave->to_date}}" name="to_date" data-date-Format="yyyy-mm-dd" id="to_date">
                                                </div>

                                                <div class="form-group">
                                                    <label for="days" class="fw-medium">Days</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $tbl_leave->days}}" name="days" id="days" readonly>
                                                </div>
                                                    
                                                <div class="form-group">
                                                    <label for="leavetype_id" class="fw-medium">Leave Type</label>
                                                    <select class="form-select form-select-sm form-control" id="leavetype_id" name="leavetype_id">
                                                        <option value="-1">Select a Leave Type</option>
                                                        @foreach ($leave_types as $leave_type)
                                                            <option {{ $tbl_leave->leavetype_id == $leave_type->id ? 'selected':'' }} value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="remarks" class="fw-medium">Remarks</label>
                                                    <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="2">{{ $tbl_leave->remarks}}</textarea>
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
                {!! $tbl_leaves->links() !!}
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

    // $('.selectmodal').select2({dropdownParent: $('#add_employee_leave')});
    // $.fn.modal.Constructor.prototype.enforceFocus = function () {};

    // $("#from_date").change(function() {
    // //alert();
    // var start = parseDate($('#from_date').val());
    // var end = parseDate($('#to_date').val());
    // if ($('#from_date').val() != "" && $('#to_date').val() != "") {
    //     datecalculate(start, end);
    // }
    // });

    // $("#to_date").change(function() {
    // //alert();
    // var start = parseDate($('#from_date').val());
    // var end = parseDate($('#to_date').val());
    // if ($('#from_date').val() != "" && $('#to_date').val() != "") {
    //     datecalculate(start, end);
    // }
    // });

    // function datecalculate(start, end){
    // // end - start returns difference in milliseconds 
    // var diff = new Date(end - start);
    // // get days
    // var days = diff / 1000 / 60 / 60 / 24;
    // //alert(days);
    // //$('#days').val("");
    // var days = days + 1;
    // $('#days').val(days);
    // }

    // function parseDate(str) {
    // var mdy = str.split('/');
    // return new Date(mdy[2], mdy[1] - 1, mdy[0]);
    // }

    // $("#day_type").change(function() {
    // //alert();
    // var daytype = $('#day_type').val();
    // if(daytype!=3){
    //     $(".hideclass").hide();
    //     $("#days").val('.5')
    //     }else{
    //     $(".hideclass").show();	
    //     $("#days").val('')
    //         }
    // });

    // $("#employee_id,#from_date").change(function() {
    // var id = $('#employee_id').val();
    // var start = parseDate($('#from_date').val());
    // var year = (new Date(start)).getFullYear();
    // //alert(year);
    // $.ajax({
    //     type: "POST",
    //     url: "get_leavedays.php",
    //     data: {
    //         id: id,
    //         year:year
    //     },
    //     success: function(response) {
    //         $('#load_alldata').html(response);
    //     }
    // });
    // });
</script>

@endpush
@endsection