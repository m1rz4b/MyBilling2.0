@extends('layouts.main')

@section('main-container')
<style>
    .table th,
    .table td {
        padding: 0.25rem;
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
                <h5 class="mb-0" style="color: white;">Modify Invoice</h5>
            </div>
        </div>

        <form method="POST" action="{{ route('masinvoice.dailycollectionsheet.show') }}">
            @csrf
        <div class="row p-3">
            
                <div class="col-sm-4 form-group">
                    <label for="date" class="fw-medium">Select a Date</label>
                    <div class="d-flex justify-content-between gap-3">
                        <select name="day" id="day" class="form-select form-select-sm form-control">
                            <option value="">Day</option>
                            @foreach (range(1, 31) as $day )
                                <option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
                            @endforeach
                        </select>
                        <select name="month" id="month" class="form-select form-select-sm form-control">
                            <option value="">Month</option>
                            @foreach (range(1,12) as $month)
                                <option {{ $dates->month == $month?'selected':'' }} value="{{ date("m", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                            @endforeach
                        </select>
                        <select name="year" id="year" class="form-select form-select-sm form-control">
                            <option value="">Year</option>
                            @foreach (range(now()->year - 5, now()->year + 5) as $year)
                                <option {{ $dates->year == $year?'selected':'' }} value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  

                <div class="col-sm-4 form-group">
                    <label for="collector" class="fw-medium">Collector</label>
                    <select class="form-select form-select-sm form-control" id="collector" name="collector">
                        <option selected>Select a Collector</option>
                        @foreach ($nisl_mas_members as $nisl_mas_member)
                            <option value="{{ $nisl_mas_member->id }}">{{ $nisl_mas_member->username }}</option>
                        @endforeach                   
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="client_type" class="fw-medium">Client Type</label>
                    <select class="form-select form-select-sm form-control" id="client_type" name="client_type">
                        <option selected>Select a Client Type</option>
                        @foreach ($client_categories as $client_category)
                            <option value="{{ $client_category->id }}">{{ $client_category->name }}</option>
                        @endforeach                   
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="zone" class="fw-medium">Zone</label>
                    <select class="form-select form-select-sm form-control" id="zone" name="zone">
                        <option selected>Select a Zone</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                        @endforeach                   
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="branch" class="fw-medium">Branch</label>
                    <select class="form-select form-select-sm form-control" id="branch" name="branch">
                        <option selected>Select a Branch</option>
                        @foreach ($suboffices as $suboffice)
                            <option value="{{ $suboffice->id }}">{{ $suboffice->name }}</option>
                        @endforeach                   
                    </select>
                </div>

                <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">Show Report</button>
                </div>

            </form>

            <h5 class="text-center fs-5 text-dark mb-0">Daily Bill Collection Report</h5>

            <div class="QA_table p-3 pt-0 pb-0">
                @php
                    $count  = 1;
                @endphp
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Clients Name</th>
                                <th scope="col">Money Rec. No.</th>
                                <th scope="col">Bank Name</th>
                                <th scope="col">Cheque No.</th>
                                <th scope="col">Cash(BDT)</th>
                                <th scope="col">Cheque(BDT)</th>
                                <th scope="col">Deposit(BDT)</th>
                                <th scope="col">Total(BDT)</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        @foreach ($result as $r)
                            <tr>
                                <td scope="col">{{ $count++ }}</td>
                                <td scope="col">{{ $r->created_by }}</td>
                                <td scope="col">{{ $r->customer_name }}</td>
                                <td scope="col">{{ $r->money_receipt }}</td>
                                <td scope="col">{{ $r->qcollamnt }}</td>
                                <td scope="col">{{ $r->dcollamnt }}</td>
                                <td scope="col">{{ $r->collamnt }}</td>
                                <td scope="col">{{ $r->created_by }}</td>
                                <td scope="col">{{ $r->created_by }}</td>
                                <td scope="col">{{ $r->created_by }}</td>
                                <td scope="col">{{ $r->remarks }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection