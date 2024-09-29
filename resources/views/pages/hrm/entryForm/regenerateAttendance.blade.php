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
                <h5 class="mb-0" style="color: white;">Regenerate Attendence</h5>
            </div>
        </div>

        <form action="{{route('approveleave.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="txtfromopen_date" class="fw-medium">From Date</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="txtfromopen_date" data-date-Format="yyyy-mm-dd" id="txtfromopen_date">
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="txttoopen_date" class="fw-medium">To Date</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="txttoopen_date" data-date-Format="yyyy-mm-dd" id="txttoopen_date">
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="suboffices" class="fw-medium">Offices</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="suboffices" name="suboffices">
                            <option value="-1">Select a Office</option>
                            @foreach ($suboffices as $office)
                                <option value="{{ $office->id }}">{{ $office->name }}</option>
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
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="designation" class="fw-medium">Designation</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="designation" name="designation">
                            <option value="-1">Select a Designation</option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
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
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
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

        {{-- <div class="QA_table px-3">
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
        </div> --}}
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