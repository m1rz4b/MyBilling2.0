@extends('layouts.main')

@section('main-container')

    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible my-1" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <strong>Success !</strong> {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="main_content_iner">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                <h5 class="mb-0 text-white text-center">Approve Salary</h5>
            </div>
            {{-- action="{{ route('generate-salary.show') }}"  --}}
            <form method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row p-3">
                    <div class="col-sm-3 form-group">
                        <label for="year" class="fw-medium">Year</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                            <select class="form-select form-select-sm form-control" id="year" name="year" >
                                <option>{{ now()->year }}</option>
                                @foreach (range(now()->year - 15, now()->year + 5) as $year)
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
                        <label for="dept" class="fw-medium">Department</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <select class="form-select form-select-sm form-control" id="dept" name="dept">
                                <option value="">Select a Department</option>
                                @foreach($departments as $department)
                                    <option {{ $selectedDepartment==$department ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-3 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Show</button>
                    </div>
                </div>
                
            </form>

            <div class="QA_table table-responsive p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#Sl</th>
                            <th scope="col" class="text-center">Employee</th>
                            <th scope="col" class="text-center">Basic</th>
                            <th scope="col" class="text-center">House Rent</th>
                            <th scope="col" class="text-center">Medical</th>
                            <th scope="col" class="text-center">Food</th>
                            <th scope="col" class="text-center">Conveyance</th>
                            <th scope="col" class="text-center">Gross Salary</th>
                            <th scope="col" class="text-center">Advanced Salary</th>
                            <th scope="col" class="text-center">Absent</th>
                            <th scope="col" class="text-center">Late (days/3)</th>
                            <th scope="col" class="text-center">Total Absent Deduct</th>
                            <th scope="col" class="text-center">Addition</th>
                            <th scope="col" class="text-center">Deduction</th>
                            <th scope="col" class="text-center">PF Office</th>
                            <th scope="col" class="text-center">PF Employee</th>
                            <th scope="col" class="text-center">Revenue Stamp</th>
                            <th scope="col" class="text-center">Welfare Fund</th>
                            <th scope="col" class="text-center">Net Salary</th>
                            <th scope="col" class="text-center">Final Salary <input type="checkbox"> </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection