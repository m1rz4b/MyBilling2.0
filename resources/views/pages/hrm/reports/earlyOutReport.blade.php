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
                <h5 class="mb-0" style="color: white;">Early Out Report</h5>
            </div>
        </div>

        <form action="{{route('early-out-report.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="date" class="fw-medium">Date</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="{{$selectedDate}}" name="date" data-date-Format="yyyy-mm-dd" id="date">
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

                <div class="col-sm-3 d-flex d-sm-inline justify-content-start">
                    <br class="d-none d-sm-block">
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-primary me-4"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                        <button type="button" class="btn btn-sm btn-warning text-white"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-print me-1"></i>Print</button>
                    </div>
                </div>
            </div>
        </form>

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-medium">For the period of: {{$selectedDate}}</p>
        <p class="text-center fw-medium text-dark">Office: {{$selectedOfficeName->name}}</p>
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
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