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
                <h5 class="mb-0" style="color: white;">Performance Report</h5>
            </div>
        </div>

        <form action="{{route('performance-report.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="year" class="fw-medium">Year</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                <option value="{{ $year }}" {{ (now()->year == $year) ? 'selected' : ($selectedYear==$year? 'selected' : '') }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="month" class="fw-medium">Month</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
                            @foreach(range(1,12) as $month)
                                <option value="{{ $month }}" {{ (now()->format('n') == $month) ? 'selected' : ($selectedMonth == $month ? 'selected' : '') }}>
                                    {{ date("M", mktime(0, 0, 0, $month, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="suboffice_id" class="fw-medium">Office</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="suboffice_id" name="suboffice_id">
                            <option value="-1">Select an Office</option>
                            @foreach ($suboffices as $suboffice)
                                <option {{ $selectedSuboffice==$suboffice->id ? 'selected' : '' }} value="{{ $suboffice->id }}">{{ $suboffice->name }}</option>
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
                            @foreach ($masDepartments as $department)
                                <option {{ $selectedDepartment==$department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-3 form-group">
                    <label for="status_id" class="fw-medium">Employee Status</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                        <select class="form-select form-select-sm form-control" id="status_id" name="status_id">
                            <option value="-1">Select an Employee Status</option>
                            @foreach ($employeeStatus as $status)
                                <option {{ $selectedEmployeeStatus==$status->id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="designation" class="fw-medium">Designation</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-brands fa-black-tie"></i></span>
                        <select class="form-select form-select-sm form-control" id="designation" name="designation">
                            <option value="-1">Select a Designation</option>
                            @foreach ($masDesignations as $designation)
                                <option {{ $selectedDesignation==$designation->id ? 'selected' : '' }} value="{{ $designation->id }}">{{ $designation->designation }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="salary_status" class="fw-medium">Salary Status</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-brands fa-black-tie"></i></span>
                        <select class="form-select form-select-sm form-control" id="salary_status" name="salary_status">
                            <option value="-1">Select a Salary Status</option>
                            @foreach ($hrmSalaryStatus as $salaryStatus)
                                <option {{ $selectedSalaryStatus==$salaryStatus->id ? 'selected' : '' }} value="{{ $salaryStatus->id }}">{{ $salaryStatus->description }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-primary me-4"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                        <button type="button" class="btn btn-sm btn-danger text-white"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-file-pdf me-1"></i>Pdf</button>
                    </div>
                </div>
            </div>
        </form>

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-bold">Performance Report</p>
        @if ($selectedMonth && $selectedYear)
            <p class="text-center text-dark fw-medium">For the period of <span id="time_period">{{$selectedMonth}}</span>, {{$selectedYear}}</p>
        @endif
        @if ($subofficeName)
            <p class="text-center text-dark fw-medium">Office: {{ $subofficeName->name }}</p>
        @endif
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        @if ($employeeStatusName)
            <p class="text-center text-dark fw-medium">Employee Status: {{ $employeeStatusName->name }}</p>
        @endif
        @if ($designationName)
            <p class="text-center text-dark fw-medium">Designation: {{ $designationName->designation }}</p>
        @endif
        @if ($salaryStatusName)
            <p class="text-center text-dark fw-medium">Salary Status: {{ $salaryStatusName->description }}</p>
        @endif
        <p class="text-right fw-bold">Total Working Day = {{ ($diffday - $govholy) + $chw }} </p>
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp

                <table class="table table-bordered table-condenced" cellpadding='0' cellspacing='0' width='90%' align='center' id="tableheadfixer">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            @for ($x = 1; $x <= $d; $x++)
                                <th width="28">{{ $x }}</th>
                            @endfor
                            <th>TP</th>
                            <th>TL</th>
                            <th>TA</th>
                            <th>LD</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($masEmployees as $employees)
                        <tr>
                            <td>{{ $employees->emp_name . ' (' . $employees->emp_no . ')' }}</td>
                            
                            <td class="fw-bold">{{  $tot_precent }}</td>
                            <td class="fw-bold">{{  $tot_leave }}</td>
                            <td class="fw-bold">{{  $ta }}</td>
                            <td class="text-danger fw-bold">{{  $tot_late }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p style="color:red; font-size:11px"><span>TP: Total Present</span>, <span>TL: Total Leave</span>, <span>TA : Total Absent</span>, <span>P : Present</span>, <span>A : Absent</span>,<span>PW: Present In weekend</span><span>PH: Present In Holyday</span>
                <span>L: Leave</span>, <span>H : Holyday</span>,<span>W : Weekend</span>, <span>LD : Late Days</span> <span>(L) : Late</span></p>
            </div>
        </div>
        @endif
    </div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });

        const timePeriod = document.getElementById('time_period');
        
        function getMonth(m){
            if(m==1){
                return "January";
            }else if(m==2){
                return "February";
            }else if(m==3){
                return "March";
            }else if(m==4){
                return "April";
            }else if(m==5){
                return "May";
            }else if(m==6){
                return "June";
            }else if(m==7){
                return "July";
            }else if(m==8){
                return "August";
            }else if(m==9){
                return "September";
            }else if(m==10){
                return "October";
            }else if(m==11){
                return "November";
            }else if(m==12){
                return "December";
            }
        }

        //Convert number into month name for table header
        let munthNumber = timePeriod.innerText;
        let monthName = getMonth(munthNumber);
        timePeriod.innerText = monthName;
    });
</script>

@endpush
@endsection