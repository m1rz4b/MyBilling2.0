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
                <h5 class="mb-0" style="color: white;">Employee Increment Report</h5>
            </div>
        </div>

        <form action="{{route('employeeincrement.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="year" class="fw-medium">Year</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            <option>{{ now()->year }}</option>
                            @foreach (range(now()->year - 2, now()->year + 1) as $year)
                                <option {{ $selectedYear==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="month" class="fw-medium">Month</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
                            <option>{{ now()->format('M') }}</option>
                            @foreach(range(1,12) as $month)
                                <option {{ $selectedMonth==$month? 'selected' : '' }} value="{{ $month }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <br class="d-none d-sm-block">
                    <input type="checkbox" class="mt-2" id="ignore_month" name="ignore_month" value="{{$selectedIgnoreMonth}}" {{$selectedIgnoreMonth == 1 ? 'checked' : ''}} > Ignore Month
                </div>

                <div class="col-sm-3 form-group">
                    <label for="department" class="fw-medium">Department</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="department" name="department">
                            <option value="-1">Select a Department</option>
                            @foreach ($mas_departments as $department)
                                <option {{ $selectedDepartment==$department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="increment_type" class="fw-medium">Increment Type</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="increment_type" name="increment_type">
                            <option value="-1">Select a Increment Type</option>
                            @foreach ($hrm_increment_types as $increment_type)
                                <option {{ $selectedIncrementType==$increment_type->id ? 'selected' : '' }} value="{{ $increment_type->id }}">{{ $increment_type->name }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>                

                <div class="col-sm-3 d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-primary me-4"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                        <button type="button" class="btn btn-sm btn-warning text-white"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Print</button>
                    </div>
                </div>
            </div>
        </form>

        @if ($hrm_increments)
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
                            <th>Increment Type</th>
                            <th>Previous Gross</th>
                            <th>Percentage</th>
                            <th>Amount</th>
                            <th>Current Gross</th>
                            <th>Effective Month</th>
                            <th>Entry Date</th>
                            <th>Approve Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hrm_increments as $hrm_increment)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $hrm_increment->emp_name }}</td>
                            <td>{{ $hrm_increment->name }}</td>
                            <td>{{ number_format($hrm_increment->previous_gross, 2) }}</td>                    
                            <td>{{ $hrm_increment->increment_percent }}</td>
                            <td>{{ number_format($hrm_increment->increment_amount, 2) }}</td>
                            <td>{{ number_format($hrm_increment->current_gross, 2) }}</td>
                            <td class="month">{{ $hrm_increment->month }}, {{$hrm_increment->year }}</td>
                            <td>{{ date('d-m-Y', strtotime($hrm_increment->entry_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($hrm_increment->approve_date)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {!! $hrm_increments->links() !!} --}}
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


        const month = document.getElementsByClassName('month');

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

        for(mon of month){
            let res = mon.innerText;
            let result = res.split(',')[0];
            let monthName = getMonth(result);
            result = monthName.concat(',',res.split(',')[1]);
            mon.innerText = result;
        }
    });
</script>

@endpush
@endsection