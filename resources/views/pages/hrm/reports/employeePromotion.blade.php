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
                <h5 class="mb-0" style="color: white;">Employee Promotion Report</h5>
            </div>
        </div>

        <form action="{{route('employee-promotion-report.show')}}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="year" class="fw-medium">Year</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            <option value="{{ now()->year }}">{{ now()->year }}</option>
                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                <option value="{{ $year }}" {{ ($selectedYear==$year? 'selected' : '') }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="month" class="fw-medium">Month</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
                            <option value="{{ now()->format('M') }}">{{ now()->format('M') }}</option>
                            @foreach(range(1,12) as $month)
                                <option value="{{ $month }}" {{ ($selectedMonth == $month ? 'selected' : '') }}>
                                    {{ date("M", mktime(0, 0, 0, $month, 1)) }}
                                </option>
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

                <div class="col-sm-3 d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-sm btn-primary me-4" name="action" value="show"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                        <button type="submit" class="btn btn-sm btn-danger text-white" name="action" value="pdf"><i class="fa-solid fa-file-pdf me-1"></i>Pdf</button>
                    </div>
                </div>
            </div>
        </form>

        @if ($hrmEmpJobHistory)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-bold">Promotion Report</p>
        @if ($selectedMonth && $selectedYear) 
            <p class="text-center text-dark fw-medium">For the period of <span id="time_period">{{$selectedMonth}}</span>, {{$selectedYear}}</p>
        @endif
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        <div class="QA_table px-3">
            <div>
                @php
                    $count = ($hrmEmpJobHistory->currentPage() - 1) * $hrmEmpJobHistory->perPage() + 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th>Employee Name</th>
                            <th>Promotion Date</th>
                            <th>New Designation</th>
                            <th>Previous Promotion Date</th>                                        
                            <th>Previous Designation</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hrmEmpJobHistory as $jobHistory)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $jobHistory->emp_name }}</td>
                            <td>{{ $jobHistory->pro_date }}</td>
                            <td>{{ $jobHistory->prodes }}</td>
                            <td>{{ $jobHistory->pre_pro_date }}</td>
                            <td>{{ $jobHistory->predes }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $hrmEmpJobHistory->links() !!}
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
        let monthNumber = timePeriod.innerText;
        let monthName = getMonth(monthNumber);
        timePeriod.innerText = monthName;
    });
</script>

@endpush
@endsection