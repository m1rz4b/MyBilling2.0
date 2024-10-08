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
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Employee List</h5>
            </div>
        </div>

        <form action="{{route('employee-list-report.show')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row p-3">
                <div class="col-sm-4 form-group">
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
                
                <div class="col-sm-4 form-group">
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

                <div class="col-sm-4 form-group">
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

                <div class="col-sm-4 form-group">
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
                
                <div class=" col-sm-4 form-group">
                    <label for="name" class="fw-medium">Name/Mobile/Address</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-address-card"></i></span>
                        <input class="form-control form-control-sm" name="name" id="name" value="{{$name}}"  placeholder="Name/Mobile/Address"/>
                    </div>
                </div>

                <div class="col-sm-4 d-flex d-sm-inline justify-content-start">
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
        <p class="text-center fw-bold text-dark">Employee List</p>
        <p class="text-center fw-medium text-dark">Office: {{$selectedOfficeName->name}}</p>
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Userid</th>
                            <th>Employee Name</th>
                            <th>Date of Birth</th>
                            <th>Date of Joining</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Working Duration</th>
                            <th>Status</th>
                            <th>Mobile</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($masEmployees as $masEmployee)
                        <tr>
                            <td>{{ $masEmployee->emp_id }}</td>
                            <td>{{ $masEmployee->emp_name }}</td>
                            <td>{{ $masEmployee->date_of_birth }}</td>
                            <td>{{ $masEmployee->date_of_joining }}</td>
                            <td>{{ $masEmployee->department }}</td>
                            <td>{{ $masEmployee->designation }}</td>
                            <td>
                                @if ($masEmployee->ndate > 0)
                                    {{\Carbon\Carbon::parse($masEmployee->ndate)->diffForHumans(['parts' => 2])}}
                                @endif
                            </td>
                            <td>{{ $masEmployee->name }}</td>
                            <td>{{ $masEmployee->mobile }}</td>
                            <td>{{ $masEmployee->email }}</td>
                        </tr>
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