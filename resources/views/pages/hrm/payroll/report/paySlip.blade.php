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
                <h5 class="mb-0 text-white text-center">Pay Slip</h5>
            </div>
{{-- action="{{ route('salaryreporttemp.show') }}"  --}}
            <form method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row p-3">
                    <div class="col-sm-4 form-group">
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
    
                    <div class="col-sm-4 form-group">
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

                    <div class="col-sm-4 form-group">
                        <label for="dept" class="fw-medium">Employee</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <select class="form-select form-select-sm form-control" id="dept" name="dept">
                                <option value="">Select an Employee</option>
                                @foreach($employees as $employee)
                                    <option {{ $selectedEmployee==$employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row p-3">
                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-sm btn-primary">Show Report</button>
                        <button type="button" class="btn btn-sm btn-warning">Print</button>
                    </div>
                </div>
            </form>

            <div class="QA_table table-responsive p-3 pb-0">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Employee Name</th>
                            <td></td>
                            <th>Salary Month</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Employee ID</th>
                            <td></td>
                            <th>Date</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">Earnings</th>
                            <th colspan="2">Deductions</th>
                        </tr>
                        <tr>
                            <th>Gross Salary</th>
                            <td></td>
                            <th>Provident Fund</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Incentive</th>
                            <td></td>
                            <th>Revenue Stamp</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Net Earnings</th>
                            <td></td>
                            <th>Total Deduction</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="3">Current NET Salary</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td colspan="4"><br><br><br></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">Employee Signature</td>
                            <td colspan="2" class="text-center">Director Signature</td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            </div>

        </div>
    </div>

@endsection