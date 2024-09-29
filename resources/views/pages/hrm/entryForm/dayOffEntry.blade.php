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

    /* Switch starts here */
    .rocker {
    display: inline-block;
    position: relative;
    
    font-size: 2em;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
    color: #888;
    width: 7em;
    height: 4em;
    overflow: hidden;
    border-bottom: 0.5em solid #eee;
    }

    .rocker-small {
    font-size: 0.75em; /* Sizes the switch */
    }

    .rocker::before {
    content: "";
    position: absolute;
    top: 0.5em;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #999;
    border: 0.5em solid #eee;
    border-bottom: 0;
    }

    .rocker input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    .switch-left,
    .switch-right {
    cursor: pointer;
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 2.5em;
    width: 3em;
    transition: 0.2s;
    }

    .switch-left {
    height: 2.4em;
    width: 2.75em;
    left: 0.85em;
    bottom: 0.4em;
    background-color: #ddd;
    transform: rotate(15deg) skewX(15deg);
    }

    .switch-right {
    right: 0.5em;
    bottom: 0;
    background-color: #bd5757;
    color: #fff;
    }

    .switch-left::before,
    .switch-right::before {
    content: "";
    position: absolute;
    width: 0.4em;
    height: 2.45em;
    bottom: -0.45em;
    background-color: #ccc;
    transform: skewY(-65deg);
    }

    .switch-left::before {
    left: -0.4em;
    }

    .switch-right::before {
    right: -0.375em;
    background-color: transparent;
    transform: skewY(65deg);
    }

    input:checked + .switch-left {
    background-color: #0084d0;
    color: #fff;
    bottom: 0px;
    left: 0.5em;
    height: 2.5em;
    width: 3em;
    transform: rotate(0deg) skewX(0deg);
    }

    input:checked + .switch-left::before {
    background-color: transparent;
    width: 3.0833em;
    }

    input:checked + .switch-left + .switch-right {
    background-color: #ddd;
    color: #888;
    bottom: 0.4em;
    right: 0.8em;
    height: 2.4em;
    width: 2.75em;
    transform: rotate(-15deg) skewX(-15deg);
    }

    input:checked + .switch-left + .switch-right::before {
    background-color: #ccc;
    }

    /* Keyboard Users */
    input:focus + .switch-left {
    color: #333;
    }

    input:checked:focus + .switch-left {
    color: #fff;
    }

    input:focus + .switch-left + .switch-right {
    color: #fff;
    }

    input:checked:focus + .switch-left + .switch-right {
    color: #333;
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
                <h5 class="mb-0" style="color: white;">Special Day OFF</h5>
            </div>
        </div>

        <form action="{{route('approveleave.show')}}" method="post" enctype="multipart/form-data">
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

                <div class="col-sm-3 form-group">
                    <label for="office" class="fw-medium">Office</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="office" name="office">
                            <option value="-1">Select a Office</option>
                            @foreach ($offices as $office)
                                <option {{ $selectedOffice==$office->id ? 'selected' : '' }} value="{{ $office->id }}">{{ $office->name }}</option>
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
                            <th>Pin </th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th scope="col" class="text-center">DAY OFF/DAY ON</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($day_off_entries as $day_off_entry)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $day_off_entry->emp_name }}</td>
                            <td>{{ $day_off_entry->emp_no }}</td>
                            <td>{{ date('d M Y, l', strtotime($from_date)) }}</td>                    
                            <td>{{ $day_off_entry->department }}</td>
                            <td>{{ $day_off_entry->designation }}</td>
                            <td>
                                @if ($day_off_entry->id != '')
                                    {{'Holyday'}}
                                @else
                                    {{'Working Day'}}
                                @endif
                            </td>
                            <td class="text-end text-nowrap" width='10%'>
                                <label class="rocker rocker-small">
                                    <input type="checkbox" value="1" 
                                        @if($day_off_entry->id != '') checked @php $val = 'yes'; @endphp 
                                        @else @php $val = 'no'; @endphp 
                                        @endif
                                        onChange="saveOffDay({{ $day_off_entry->id }}, '{{ $val }}', '{{ $from_date }}')"
                                    >
                                    <span class="switch-left">OFF</span>
                                    <span class="switch-right">ON</span>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $day_off_entries->links() !!}
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