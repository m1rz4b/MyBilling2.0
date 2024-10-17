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
                <h5 class="mb-0 text-white text-center">Salary Report</h5>
            </div>

            <form method="POST" action="{{ route('salaryreporttemp.show') }}" enctype="multipart/form-data">
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
                        <label for="dept" class="fw-medium">Department</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <select class="form-select form-select-sm form-control" id="dept" name="dept">
                                <option value="">Select a Department</option>
                                @foreach($departments as $department)
                                    <option {{ $selectedDepartment == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row p-3">
                    <div class="col-sm-4 form-group">
                        <label for="paymode" class="fw-medium">Payment Mode</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill"></i></span>
                            <select class="form-select form-select-sm form-control" id="paymode" name="paymode">
                                <option value="">Select a Payment Mode</option>
                                @foreach($paymentmodes as $paymentmode)
                                    <option {{ $selectedPaymentMode==$paymentmode->id ? 'selected' : '' }} value="{{ $paymentmode->id }}">{{ $paymentmode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                        <button type="submit" class="btn btn-sm btn-warning"><i class="fa-solid fa-magnifying-glass me-1"></i>Print</button>
                    </div>
                </div>
            </form>

            <div class="QA_table table-responsive p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#Sl</th>
                            <th scope="col" class="text-center">Employee</th>
                            <th scope="col" class="text-center">Year</th>
                            <th scope="col" class="text-center">Month</th>
                            <th scope="col" class="text-center">Basic</th>
                            <th scope="col" class="text-center">House Rent</th>
                            <th scope="col" class="text-center">Medical</th>
                            <th scope="col" class="text-center">Food</th>
                            <th scope="col" class="text-center">Conveyance</th>
                            <th scope="col" class="text-center">Gross Salary</th>
                            <th scope="col" class="text-center">Advanced Salary</th>
                            <th scope="col" class="text-center">AB</th>
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
                        </tr>
                    </thead>

                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        {{-- @foreach ($salarytemps as $salarytemp)
                            @php
                                $gross_salary = $salarytemp->basic + $salarytemp->h_rent + $salarytemp->med + $salarytemp->food + $salarytemp->conv;
                                $net_salary = ( $gross_salary + $salarytemp->tot_add ) - ( $salarytemp->tot_deduct + $salarytemp->salary_advanced + $salarytemp->leave_deduct );
                            @endphp
                            <tr>
                                <td class="text-center">{{ $slNumber++ }}</td>
                                <td class="text-center">{{ $salarytemp->emp_id }}</td>
                                <td class="text-center">{{ $salarytemp->year }}</td>
                                <td class="text-center">{{ $salarytemp->month }}</td>
                                <td class="text-center">{{ $salarytemp->basic }}</td>
                                <td class="text-center">{{ $salarytemp->h_rent }}</td>
                                <td class="text-center">{{ $salarytemp->med }}</td>
                                <td class="text-center">{{ $salarytemp->food }}</td>
                                <td class="text-center">{{ $salarytemp->conv }}</td>
                                <td class="text-center">{{ $gross_salary }}</td>
                                <td class="text-center">{{ $salarytemp->salary_advanced }}</td>
                                <td class="text-center">{{ $salarytemp-> }}</td>
                                <td class="text-center">{{ $salarytemp->abcent_days }}</td>
                                <td class="text-center">{{ $salarytemp->late_days }}</td>
                                <td class="text-center">{{ $salarytemp->leave_deduct }}</td>
                                <td class="text-center">{{ $salarytemp->additional_compensation }}</td>
                                <td class="text-center">{{ $salarytemp->deductions }}</td>
                                <td class="text-center">{{ $salarytemp->pf_office }}</td>
                                <td class="text-center">{{ $salarytemp->pf_employee }}</td>
                                <td class="text-center">{{ $salarytemp->revenue_stamp }}</td>
                                <td class="text-center">{{ $salarytemp->welfare_fund }}</td>
                                <td class="text-center text-nowrap">{{ $net_salary }}</td>
                            </tr>

                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection