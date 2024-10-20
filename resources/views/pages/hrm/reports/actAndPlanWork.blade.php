@extends('layouts.main')
@inject('carbon', 'Carbon\Carbon')

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
                <h5 class="mb-0" style="color: white;">Actual And Planned Work Times</h5>
            </div>
        </div>

        <form action="{{route('act-and-plan-work-report.show')}}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="from_date" class="fw-medium">From Date <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$selectedFromDate}}" name="from_date" data-date-Format="yyyy-mm-dd" id="from_date" required>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="to_date" class="fw-medium">To Date <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$selectedToDate}}" name="to_date" data-date-Format="yyyy-mm-dd" id="to_date" required>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="employee" class="fw-medium">Employee <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                        <select class="select2 form-select form-select-sm" id="employee" name="employee" required>
                            <option value="-1">Select an Employee</option>
                            @foreach ($employees as $employee)
                                <option {{ $selectedEmployee==$employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div> 

                <div class="col-sm-3 d-flex d-sm-inline justify-content-start">
                    <br class="d-none d-sm-block">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-sm btn-primary me-4" name="action" value="show"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                        <button type="submit" class="btn btn-sm btn-danger text-white" name="action" value="pdf"><i class="fa-solid fa-file-pdf me-1"></i>Pdf</button>
                    </div>
                </div>
            </div>
        </form>

        @if ($attendanceData)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        @if ($selectedFromDate && $selectedToDate)
            <p class="text-center fw-bold text-dark">Actual And Planned Work Times ({{$selectedFromDate}} to {{$selectedToDate}})</p>
        @endif
        @if ($employeeName)
            <p class="text-center fw-bold text-dark">Employee: {{$employeeName->emp_name}}</p>
        @endif
        <div class="QA_table px-3">
            <div>
                @php
                    $count = ($attendanceData->currentPage() - 1) * $attendanceData->perPage() + 1;
                    $tw = 0;
                    $td = 0;
                    $tt = 0;
                    $work = 0;
                    $do = 0;
                    $total = 0;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Planned In</th>
                            <th>Actual In</th>
                            <th>Planned Out</th>
                            <th>Actual Out</th>
                            <th>Planned Work</th>
                            <th>Actual Work</th>
                            <th>Difference</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($attendanceData as $attendance)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $attendance->empdate }}</td>
                            <td>{{ date('g:i a', strtotime($plannedin)) }}</td>
                            <td>{{ $min ?? '' }}</td>
                            <td>{{ date('g:i a', strtotime($plannedout)) }}</td>
                            <td>{{ $max ?? '' }}</td>
                            <td>
                                @php
                                    $work=(strtotime($plannedout)-strtotime($plannedin));  
                                    $tw=$tw+$work;	
                                    $hours2 = floor($work / 60 / 60);
                                    $minutes2 = round(($work - ($hours2 * 60 * 60)) / 60);
                                    echo $hours2.' H, '.$minutes2 .' M';
                                @endphp
                            </td>
                            <td>
                                @php
                                    $do=(strtotime($attendance->max_checktime)-strtotime($attendance->min_checktime)); 
                                    $td=$td+$do;
                                    $hours = floor($do / 60 / 60);
                                    $minutes = round(($do - ($hours * 60 * 60)) / 60);
                                    echo $hours.' H, '.$minutes .' M';
                                @endphp
                            </td>
                            <td>
                                @php
                                    $total=$work-$do;
                                    $tt=$tt+$total;
                                    if($total < 0){
                                        $a_total = -$total;
                                        $hours1 = floor($a_total / 60 / 60);
                                        $minutes1 = round(($a_total - ($hours1 * 60 * 60)) / 60); 
                                        echo $hours1.' H, '.$minutes1 .' M (Over time)';
                                    }
                                    else{
                                        $a_total=$total;
                                        $hours1      = floor($a_total / 60 / 60);
                                        $minutes1    = round(($a_total - ($hours1 * 60 * 60)) / 60); 
                                        echo $hours1.' H, '.$minutes1 .' M (Less Work)';		 
                                    }
                                @endphp
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $attendanceData->links() !!}
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
    });
</script>

@endpush
@endsection