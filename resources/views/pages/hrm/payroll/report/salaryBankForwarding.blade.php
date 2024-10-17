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
                <h5 class="mb-0 text-white text-center">Generate Salary</h5>
            </div>
            {{-- action="{{ route('generate-salary.show') }}"  --}}
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

                    <div class="col-sm-4 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="submit" class="btn btn-sm btn-primary">Show Report</button>
                        <button type="button" class="btn btn-sm btn-warning">Print</button>
                        <button type="button" class="btn btn-sm btn-success">Excel</button>
                    </div>
                </div>
            </form>

            <div class="QA_table table-responsive p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Debit Account</th>
                            <th scope="col" class="text-center">Voucher/Email</th>
                            <th scope="col" class="text-center">BATCH</th>
                            <th scope="col" class="text-center">Benificiary Name</th>
                            <th scope="col" class="text-center">Credit Account/Card</th>
                            <th scope="col" class="text-center">Txn Type</th>
                            <th scope="col" class="text-center">Bank Name</th>
                            <th scope="col" class="text-center">Routing No</th>
                            <th scope="col" class="text-center">Pay Amount</th>
                            <th scope="col" class="text-center">Remarks/Narration</th>
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