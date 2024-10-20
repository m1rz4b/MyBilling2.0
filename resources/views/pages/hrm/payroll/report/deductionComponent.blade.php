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
                <h5 class="mb-0 text-white text-center">Addition Component Report</h5>
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
                        <label for="dept" class="fw-medium">Deduction Component</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <select class="form-select form-select-sm form-control" id="dept" name="dept">
                                <option value="">Select a Deduction Component</option>
                                @foreach($deductcomps as $deductcomp)
                                    <option {{ $selectedDeductComp==$deductcomp->id ? 'selected' : '' }} value="{{ $deductcomp->id }}">{{ $deductcomp->deduct_comp_name }}</option>
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
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Year</th>
                            <th scope="col">Month</th>
                            <th scope="col">Deduction Component</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection