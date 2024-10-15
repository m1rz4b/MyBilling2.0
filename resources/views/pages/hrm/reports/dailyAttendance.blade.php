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
                <h5 class="mb-0" style="color: white;">Daily Attendance Report</h5>
            </div>
        </div>

        <form action="{{route('daily-attendance-report.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class=" col-sm-3 form-group">
                    <label for="date" class="fw-medium">Date <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" name="date" id="date" value="{{$selectedDate}}" data-date-Format="yyyy-mm-dd" required/>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="suboffice_id" class="fw-medium">Office <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="form-select form-select-sm form-control" id="suboffice_id" name="suboffice_id" required>
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

                <div class="col-sm-3 d-flex d-sm-inline justify-content-start">
                    <br class="d-none d-sm-block">
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-primary me-4"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                        <button type="button" class="btn btn-sm btn-danger text-white"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-file-pdf me-1"></i>Pdf</button>
                    </div>
                </div>
            </div>
        </form>

        @if ($hrmAttendances)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center fw-bold text-dark">Daily Attendance Report</p>
        <p class="text-center fw-medium text-dark">For the period of: {{$selectedDate}}</p>
        <p class="text-center fw-medium text-dark">Department: {{$selectedDepartment}}, Office: {{$selectedSuboffice}}</p>
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>     
                            <th>Employee Name</th>     			
                            <th>Check-In Time</th>
                            <th>Check-Out Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hrmAttendances as $hrmAttendance)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $hrmAttendance->emp_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($hrmAttendance->start_date)->format('g:i a') }}</td>
                            <td>{{ \Carbon\Carbon::parse($hrmAttendance->end_date)->format('g:i a') }}</td>
                            {{-- <td>
                                @if($carbon::parse($hrmAttendance->end_date)->greaterThan($hrmAttendance->start_date))
                                    @php
                                        $start = $carbon::parse($hrmAttendance->start_date);
                                        $end = $carbon::parse($hrmAttendance->end_date);
                                        $diffInSeconds = $end->diffInSeconds($start);
                                        $hours = floor($diffInSeconds / 3600);
                                        $minutes = round(($diffInSeconds % 3600) / 60);
                                    @endphp
                                    {{ $hours }} H, {{ $minutes }} M
                                @endif
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $hrmAttendances->links() !!}
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