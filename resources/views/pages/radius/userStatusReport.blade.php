@extends('layouts.main')

@section('main-container')
    <style>
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
    
    <div class="main_content_iner mt-0">
        
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">User Status Report</h5>
                </div>
            </div>

            <form action="{{ route('userstatusreport.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <select name="zone" id="zone" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Zone</option>
                                @foreach ($zones as $zone)
                                    <option {{ $selectedZone==$zone->id? 'selected' : '' }} value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select name="package" id="package" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Package</option>
                                @foreach ($client_types as $package)
                                    <option {{ $selectedPackage==$package->id? 'selected' : '' }} value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select name="customer_status" id="customer_status" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Customer Status</option>
                                @foreach ($status_types as $status)
                                    <option {{ $selectedCustomerStatus==$status->id? 'selected' : '' }} value="{{ $status->id }}">{{ $status->inv_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <select name="current_status" id="current_status" class="form-select form-select-sm form-control">
                                <option value="-1" selected>Select a Status</option>
                                <option {{ $selectedCurrentStatus=="active"? 'selected' : '' }} value="active">Active</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select name="customer" id="customer" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Customer</option>
                                @foreach ($customers as $customer)
                                    <option {{ $selectedCustomer==$customer->id? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-sm-4">
                            <select name="data_limit" id="data_limit" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Data Limit</option>
                                <option value="20">20</option>
                                <option value="100" selected>100</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                                <option value="18446744073709551615">All</option>
                            </select>
                        </div> --}}
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-sm btn-primary me-2"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                            <a class="btn btn-warning btn-sm text-white me-2" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Print</a>
                            <a class="btn btn-success btn-sm"><i class="fa-regular fa-file-excel me-1"></i>Excel</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="QA_table p-3 pb-0">
                @php
                    $count  = 1;
                @endphp

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Cust ID</th>
                            <th scope="col">Login ID</th>
                            <th scope="col">Package</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Mac Address</th>
                            <th scope="col">IP Address</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Registered Date</th>
                            <th scope="col">EXP Date</th>
                            <th scope="col">Password</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="10">Total User</th>
                            <th colspan="3" style="text-align: right;">{{ $countRow }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="bg-primary" style="color: whitesmoke;">Online</th>
                            <th colspan="3" class="bg-primary" style="text-align: right; color: whitesmoke;">{{ $online }}</th>
                            <th colspan="3" class="bg-primary" style="color: whitesmoke;">Offline</th>
                            <th colspan="3" class="bg-primary" style="text-align: right; color: whitesmoke;">{{ $offline }}</th>
                        </tr>
                        @foreach ($services as $service)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $service->account_no }}</td>
                            <td>{{ $service->user_id }}</td>
                            <td>{{ $service->package }}</td>
                            <td>{{ $service->customer_name }}</td>
                            <td>{{ $service->present_address }}</td>
                            <td>{{ $service->callingstationid }}</td>
                            <td>{{ $service->framedipaddress }}</td>
                            <td>{{ $service->mobile1 }}</td>
                            <td>{{ $service->bill_start_date }}</td>
                            <td>{{ $service->block_date }}</td>
                            <td>{{ $service->password }}</td>
                            <td class="text-end">
                                @if($service->acctstarttime)
                                    <img src="{{URL::asset('/img/gif/light-green-flash.gif')}}" alt="" width="20px">
                                @else
                                    <img src="{{URL::asset('/img/gif/light-red-flash.gif')}}" alt="" width="20px">
                                @endif
                            </td>
                        </tr>
                        @endforeach               
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });
    </script>
@endsection