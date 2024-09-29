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
                <h5 class="mb-0" style="color: white;">Approve Leave</h5>
            </div>
        </div>

        <form action="{{route('approveleave.show')}}" method="post" enctype="multipart/form-data">
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
                            <th>From</th>
                            <th>To</th>
                            <th>Leave Type</th>
                            <th>Days</th>
                            <th>Last Approve</th>
                            <th>Approve Date</th>
                            <th>Approve Remark</th>
                            <th>Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tbl_leaves as $tbl_leave)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $tbl_leave->emp_name }}</td>
                            <td>{{ $tbl_leave->from_date }}</td>
                            <td>{{ $tbl_leave->to_date }}</td>                    
                            <td>{{ $tbl_leave->leavetype_name }}</td>
                            <td>{{ $tbl_leave->days }}</td>
                            <td>{{ $user_id }}</td>
                            <td>{{ $tbl_leave->approved_time }}</td>
                            <td>{{ $tbl_leave->approve_remarks }}</td>
                            <td>{{ $tbl_leave->leave_status }}</td>
                            <td class="text-end text-nowrap" width='10%'>
                                <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#view_approve_leave-{{$tbl_leave->id}}">View</button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancel_approve_leave-{{ $tbl_leave->id }}">Delete</button>
                            </td>
                        </tr>

                        <!-- View Modal -->
                        <div class="modal fade" id="view_approve_leave-{{$tbl_leave->id}}" tabindex="-1" aria-labelledby="approve_leave_title" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('employeeleave.update', ['employeeleave' => $tbl_leave])}}" id="modal_form" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="approve_leave_title">Approve Leave</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="employee_id" class="fw-medium">Employee</label>
                                                    <select class="select2 form-select form-select-sm" style="width: 100% !important;" id="employee_id" name="employee_id" disabled>
                                                        <option value="-1">Select an Employee</option>
                                                        @foreach ($mas_employees as $employees)
                                                            <option {{ $tbl_leave->emp_name == $employees->emp_name ? 'selected':'' }} value="{{ $employees->id }}">{{ $employees->emp_name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="day_type" class="fw-medium">Day Type</label>
                                                    <select class="form-select form-select-sm" id="day_type" name="day_type" disabled>
                                                        <option value="-1">Select a Leave Type</option>
                                                        @foreach ($leave_day_types as $leave_day_type)
                                                            <option {{ $tbl_leave->day_type == $leave_day_type->id ? 'selected':'' }} value="{{ $leave_day_type->id }}">{{ $leave_day_type->name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="from_date" class="fw-medium">From Date</label>
                                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ $tbl_leave->from_date}}" name="from_date" data-date-Format="yyyy-mm-dd" id="from_date" disabled>
                                                </div>

                                                <div class="form-group hideclass">
                                                    <label for="to_date" class="fw-medium">To Date</label>
                                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ $tbl_leave->to_date}}" name="to_date" data-date-Format="yyyy-mm-dd" id="to_date" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="days" class="fw-medium">Days</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $tbl_leave->days}}" name="days" id="days" disabled>
                                                </div>
                                                    
                                                <div class="form-group">
                                                    <label for="leavetype_id" class="fw-medium">Leave Type</label>
                                                    <select class="form-select form-select-sm" id="leavetype_id" name="leavetype_id" disabled>
                                                        <option value="-1">Select a Leave Type</option>
                                                        @foreach ($leave_types as $leave_type)
                                                            <option {{ $tbl_leave->leavetype_id == $leave_type->id ? 'selected':'' }} value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="remarks" class="fw-medium">Remarks</label>
                                                    <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="2" disabled>{{ $tbl_leave->remarks}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="approve_remarks" class="fw-medium">Remarks</label>
                                                    <textarea class="form-control form-control-sm" name="approve_remarks" id="approve_remarks" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" id="close">Close</button>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="save(1)">Approve</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="save(2)">Reject</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Cancel Modal -->
                        <div class="modal fade" id="cancel_approve_leave-{{$tbl_leave->id}}" tabindex="-1" aria-labelledby="approve_leave_title" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('employeeleave.update', ['employeeleave' => $tbl_leave])}}" id="modal_form" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="approve_leave_title">Approve Leave</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="employee_id" class="fw-medium">Employee</label>
                                                    <select class="select2 form-select form-select-sm" style="width: 100% !important;" id="employee_id" name="employee_id" disabled>
                                                        <option value="-1">Select an Employee</option>
                                                        @foreach ($mas_employees as $employees)
                                                            <option {{ $tbl_leave->emp_name == $employees->emp_name ? 'selected':'' }} value="{{ $employees->id }}">{{ $employees->emp_name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="day_type" class="fw-medium">Day Type</label>
                                                    <select class="form-select form-select-sm" id="day_type" name="day_type" disabled>
                                                        <option value="-1">Select a Leave Type</option>
                                                        @foreach ($leave_day_types as $leave_day_type)
                                                            <option {{ $tbl_leave->day_type == $leave_day_type->id ? 'selected':'' }} value="{{ $leave_day_type->id }}">{{ $leave_day_type->name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="from_date" class="fw-medium">From Date</label>
                                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ $tbl_leave->from_date}}" name="from_date" data-date-Format="yyyy-mm-dd" id="from_date" disabled>
                                                </div>

                                                <div class="form-group hideclass">
                                                    <label for="to_date" class="fw-medium">To Date</label>
                                                    <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{ $tbl_leave->to_date}}" name="to_date" data-date-Format="yyyy-mm-dd" id="to_date" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="days" class="fw-medium">Days</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $tbl_leave->days}}" name="days" id="days" disabled>
                                                </div>
                                                    
                                                <div class="form-group">
                                                    <label for="leavetype_id" class="fw-medium">Leave Type</label>
                                                    <select class="form-select form-select-sm" id="leavetype_id" name="leavetype_id" disabled>
                                                        <option value="-1">Select a Leave Type</option>
                                                        @foreach ($leave_types as $leave_type)
                                                            <option {{ $tbl_leave->leavetype_id == $leave_type->id ? 'selected':'' }} value="{{ $leave_type->id }}">{{ $leave_type->name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="remarks" class="fw-medium">Remarks</label>
                                                    <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="2" disabled>{{ $tbl_leave->remarks}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="approve_remarks" class="fw-medium">Remarks</label>
                                                    <textarea class="form-control form-control-sm" name="approve_remarks" id="approve_remarks" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" id="close">Close</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="save(2)">Reject</button>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="save(1)">Approve</button>
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

    function save(value) {
        const approveRemarks = document.getElementById("approve_remarks").value;
        console.log(approveRemarks);
        
        
        const jsonData = { approveRemarks: approveRemarks, value: value };
        console.log(jsonData);
        
        
        fetch('approveleave.update', {
            method: 'POST',
            body: JSON.stringify(jsonData),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Parse response as text (can be JSON or other depending on the response format)
        })
        .then(msg => {
            // alert(msg);
            // viewdata();
            document.getElementById("close").click();
        })
        .catch(error => {
            alert("Error: " + error.message);
        });
    }


        // $.ajax({
        // type: "POST",
        // url: "saveaproveLeave.php",
        // data: $('#modal_form').serialize()+ "&ifaprove=" + value,

        // }).done(function(msg) {
        //     alert(msg);
        //     viewdata();
            
        //     document.getElementById("close").click();
        //     $loading.hide();
        // }).fail(function() {
        //     alert("error");
        //     $loading.hide();
        // });


    // // Set up options for the fetch request
    // const options = {
    // method: 'POST',
    // headers: {
    //     'Content-Type': 'application/json',
    //     'X-CSRF-TOKEN': '{{ csrf_token() }}'
    // },
    // body: JSON.stringify(jsonData) // Convert JSON data to a string and set it as the request body
    // };

    //     fetch(`{{ url('getCustomerByBranch') }}`, options)
    // .then(response => {
    //     // Check if the request was successful
    //     if (!response.ok) {
    //     throw new Error('Network response was not ok');
    //     }
    //     // Parse the response as JSON
    //     return response.json();
    // })
    // .then(data => {
    //     // Handle the JSON data
    //     console.log(data);
    //     var select = document.getElementById("customer_id");
    //     select.innerHTML = "";
    //     var option = new Option(data.text, data.id, true, true);
    //     option.text = "Select a Customer";
    //     option.value = -1;
    //     select.append(option);
    //     for(prod of data.data)
    //     {
    //         var option = new Option(data.text, data.id, true, true);
    //         option.text = prod.customer_name;
    //         option.value = prod.id;
    //         var select = document.getElementById("customer_id");
    //         select.append(option);
    //     }
    //     $('#customer_id').val('-1'); 
            
    // })
    // .catch(error => {
    //     // Handle any errors that occurred during the fetch
    //     console.error('Fetch error:', error);
    // });
</script>

@endpush
@endsection