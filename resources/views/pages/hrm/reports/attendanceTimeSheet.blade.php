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
    <div class="coattendance-time-sheet.showntainer-fluid p-0 pb-3 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Attendance Time-Sheet Report</h5>
            </div>
        </div>

        <form action="{{route('attendance-time-sheet.show')}}" method="post" enctype="multipart/form-data">
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
        <p class="text-center text-dark fw-bold">Promotion Report</p>
        <p class="text-center text-dark fw-medium">For the period of <span id="time_period">{{$selectedMonth}}</span>, {{$selectedYear}}</p>
        <div class="QA_table px-3">
            <div>
                @php
                    $i  = 1;
                @endphp
                
                <table class="table table-bordered table-condenced" cellpadding='0' cellspacing='0' width='90%' align='center' id="tableheadfixer">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            @for ($x = 1; $x <= $d; $x++)
                                <th width="28">{{ $x }}</th>
                            @endfor
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($masEmployees as $employees) {
                            @php
                                $r_month = getMonth($employees->month);

                                $array = [];
                                $maxtm = [];
                                $mintm = [];
                                $emp_id =  $employees->id;
                                $emp_no =  $employees->emp_no;

                                if($emp_no != ''){
                                    $empid = $employees->id;
                                }else{
                                    $empid=0;
                                }

                                $mtext='';

                                $attendances = HrmAttendanceSummary::select([
                                    'id',
                                    'employee_id',
                                    'shift_id',
                                    DB::raw('DAY(date) AS date'),
                                    'start_date',
                                    'end_date',
                                    'total_time',
                                    'over_time',
                                    'late_mark',
                                    'early_mark',
                                    'leave_mark',
                                    'leave_type',
                                    'gov_holiday',
                                    'weekly_holiday',
                                    'absent',
                                    'administrative',
                                    'entry_by',
                                    'entry_date',
                                    'update_by',
                                    'update_date',
                                ])
                                ->where('employee_id', $emp_id)
                                ->whereMonth('date', $selectedMonth)
                                ->whereYear('date', $selectedYear)
                                ->orderBy('employee_id')
                                ->orderBy('date', 'ASC')
                                ->get();

                                $p_date_array = [];
                                $p_type_array = [];
                                $late_mark_array = [];
                                $early_mark_array = [];
                                $leave_mark_array = [];
                                $leave_type_array = [];
                                $gov_holiday_array = [];
                                $weekly_holiday_array = [];
                                $absent_array = [];
                                $a = 1;

                                foreach ($attendances as $attendance) {
                                    $array[$a] = $attendance->day;

                                    $max = date('H:i', strtotime(explode(" ", $attendance->end_date)[1]));
                                    $min = date('H:i', strtotime(explode(" ", $attendance->start_date)[1]));
                                    
                                    $maxtm[$attendance->date] = $max;
                                    $mintm[$attendance->date] = $min;

                                    $p_date[$attendance->date] = $attendance->date;
                                    $late_mark_array[$attendance->date] = $attendance->late_mark;
                                    $early_mark_array[$attendance->date] = $attendance->early_mark;
                                    $leave_mark_array[$attendance->date] = $attendance->leave_mark;
                                    $leave_type_array[$attendance->date] = $attendance->leave_type;
                                    $gov_holiday_array[$attendance->date] = $attendance->gov_holiday;
                                    $weekly_holiday_array[$attendance->date] = $attendance->weekly_holiday;
                                    $absent_array[$attendance->date] = $attendance->absent;
                                    $start_time[$attendance->date] = strtotime($attendance->start_date);

                                    $a++;
                                }

                                $t = 1;
                                $u = 1;
                                $l = '';
                                $e = '';

                                for ($j=1; $j <=$d ; $j++) {
                                    if ($p_date[$t] == $j) {
                                        $mtext='';
                                        $bgcolor='';
                                        $clr='';
                                        $l='';
                                        $ls='';
                                        if ($start_time[$t] > 0) {
                                            $ls = ($late_mark_array[$t] == 1) ? 'color:red' : 'color:green';
                                            $e = ($early_mark_array[$t] == 1) ? 'color:red' : 'color:green';

                                            if ($mintm[$t] == $maxtm[$t]) {
                                                $maxtm[$t] = '-';
                                            }

                                            $bgcolor = 'style="background:#fff;"';

                                            $mtext = "<span style='" . $ls . "'>" . $mintm[$t] . "</span> <br> <span style='" . $e . "'>" . $maxtm[$t] . "</span>";
                                        }
                                        
                                        if($weekly_holiday_array[$t]==1){
                                            $mtext .='W';
                                            $clr = "white";
                                            $bgcolor='style="background:#FF0000;"';
                                            $wh++;
                                        }
                                        if($gov_holiday_array[$t]==1){
                                            $mtext .='H';
                                            $clr = "white";
                                            $bgcolor='style="background:#FF0000;"';
                                            $gh++;
                                        }	
                                        if($absent_array[$t]==1 && $mtext==''){
                                            $mtext="<span style='color:red;'>A</span>";
                                            $ta++;
                                        }
                                        echo "<td ".$bgcolor."> <span style='color:".$clr."'>".$mtext.$l."</span></td>";	
                                        $t++;
                                    }	
                                }
                                $i++;
                            @endphp
                        }
                        @endforeach
                    </tbody>
                </table>
                <p style="color:red; font-size:11px"> <span>P : Present</span>, <span>A : Absent</span>,<span>L: Leave</span>, <span>H : Holyday</span>,<span>W : Weekend</span>, <span>LD : Late Days</span> <span>(L) : Late</span></p>
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