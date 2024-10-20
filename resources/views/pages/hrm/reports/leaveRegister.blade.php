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
    <div class="container-fluid p-0 pb-3 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Leave Register Report</h5>
            </div>
        </div>

        <form action="{{route('leave-register-report.show')}}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="year" class="fw-medium">Year</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            {{-- <option value="{{ now()->year }}">{{ now()->year }}</option> --}}
                            <option value="-1">Select a Year</option>
                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                <option value="{{ $year }}" {{ ($selectedYear==$year? 'selected' : '') }}>{{ $year }}</option>
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
                    <label for="employee" class="fw-medium">Employee</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-building"></i></span>
                        <select class="select2 form-select form-select-sm form-control" id="employee" name="employee">
                            <option value="-1">Select an Employee</option>
                            @foreach ($employees as $emp)
                                <option {{ $selectedEmployee==$emp->id ? 'selected' : '' }} value="{{ $emp->id }}">{{ $emp->emp_name }}</option>
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

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-semibold">Leave Register Report</p>
        @if ($selectedYear>-1)
            <p class="text-center text-dark fw-medium">For the year: {{$selectedYear}}</p>
        @endif
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        @if ($employeenName)
            <p class="text-center text-dark fw-medium">Employee: {{ $employeenName->emp_name }}</p>
        @endif
        <div class="QA_table px-3">
            <div>                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Allowed</th>
                            <th>Taken</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $nemp = null;
                        @endphp
                        @foreach ($masEmployees as $employees)
                            @if ($nemp != $employees->emp_name)
                                <tr>
                                    <td colspan="4"><strong>Employee: {{ $employees->emp_name }}</strong></td>
                                </tr>
                            @endif
                            <tr>
                                <td>{{ $employees->name }}</td>
                                <td>{{ $employees->total }}</td>
                                <td>{{ $employees->consumed }}</td>
                                <td>{{ $employees->allowed - $employees->consumed }}</td>
                            </tr>
                            
                            @php
                                $nemp = $employees->emp_name;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {!! $masEmployees->links() !!}
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