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
        <div class="">
            <div class="px-4 py-1 theme_bg_1">
                <h5 class="mb-0" style="color: white;">Client Access Control</h5>
            </div>
        </div>

        <form action="{{ route('clientcontrol.search') }}" method="POST" >
            @csrf
        
            <div class="row p-3">
                <div class="col-sm-4 form-group">
                    <label for="zone" class="fw-medium">Zone</label>
                    <select class="select2 form-select form-select-sm" id="zone" name="zone">
                        <option value="-1" selected>Select a Zone</option>
                        @foreach ($zones as $z)
                            <option {{ $zone==$z->id? 'selected' : '' }}  value="{{ $z->id }}">{{ $z->zone_name }}</option>
                        @endforeach                      
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="package" class="fw-medium">Package</label>
                    <select class="select2 form-select form-select-sm" id="package" name="package">
                        <option value="-1" selected>Select a Package</option>
                        @foreach ($client_types as $pack)
                            <option {{ $package==$pack->id? 'selected' : '' }} value="{{ $pack->id }}">{{ $pack->name }}</option>
                        @endforeach                      
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="status" class="fw-medium">Status</label>
                    <select class="form-select form-select-sm form-control" id="status" name="status">
                        <option value="-1" selected>Select a Status</option>
                        @foreach ($status_types as $stat)
                            <option {{ $status==$stat->id? 'selected' : '' }} value="{{ $stat->id }}">{{ $stat->inv_name }}</option>
                        @endforeach                      
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="customer" class="fw-medium">Customer</label>
                    <select class="select2 form-select form-select-sm" id="customer" name="customer">
                        <option value="-1" selected>Select a Customer</option>
                        @foreach ($customer_dropdown as $cust)
                            <option {{ $customer==$cust->id? 'selected' : '' }} value="{{ $cust->id }}">{{ $cust->customer_name }}</option>
                        @endforeach                   
                    </select>
                </div>

                <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <button id="submitBtn" type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                </div>
            </div>
        </form>

        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><small class="text-nowrap">Sl</small></th>
                            <th scope="col"><small class="text-nowrap">Acc. No</small></th>
                            <th scope="col"><small class="text-nowrap">Login Id</small></th>
                            <th scope="col"><small class="text-nowrap">Client Name</small></th>
                            <th scope="col"><small class="text-nowrap">Mac Address</small></th>
                            <th scope="col"><small class="text-nowrap">Ip Address</small></th>
                            <th scope="col"><small class="text-nowrap">Mobile</small></th>
                            <th scope="col"><small class="text-nowrap">Package</small></th>
                            <th scope="col"><small class="text-nowrap">Client Status</small></th>
                            <th scope="col"><small class="text-nowrap">Login Type</small></th>
                            <th scope="col"><small class="text-nowrap">Client Type</small></th>
                            <th scope="col"><small class="text-nowrap">Router Ip</small></th>
                            <th scope="col"><small class="text-nowrap">Exp Date</small></th>
                            <th scope="col" class="text-center"><small class="text-nowrap">Action</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $customer->account_no }}</td>
                            <td>{{ $customer->user_id }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->mac_address }}</td>
                            <td>{{ $customer->ip_number }}</td>
                            <td>{{ $customer->mobile1 }}</td>
                            <td>{{ $customer->package }}</td>
                            <td>{{ $customer->inv_name }}</td>
                            <td>{{ $customer->bandwidth_plan }}</td>
                            <td>{{ $customer->client_type_name }}</td>
                            <td>{{ $customer->router_ip }}</td>
                            <td>{{ $customer->block_date }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-success px-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                    <ul class="dropdown-menu rounded-sm py-2">
                                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#block-modal-{{$customer->srv_id}}"><i class="fa-solid fa-ban me-1"></i>Block/Active</button></li>
                                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#package-modal-{{$customer->srv_id}}"><i class="fa-solid fa-suitcase me-1"></i>Change Package</button></li>
                                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#pass-modal-{{$customer->srv_id}}"><i class="fa-solid fa-key me-1"></i>Change Pass/IP/Mac</button></li>
                                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#pppoe-modal-{{$customer->srv_id}}"><i class="fa-solid fa-wifi me-1"></i>PPPOE To Hotspot</button></li>
                                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#hotspot-modal-{{$customer->srv_id}}"><i class="fa-solid fa-wifi me-1"></i>Hotspot To PPPOE</button></li>
                                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#userid-modal-{{$customer->srv_id}}"><i class="fa-regular fa-address-card me-1"></i>Change Userid</button></li>
                                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#router-modal-{{$customer->srv_id}}"><i class="fa-solid fa-server me-1"></i>Change Router</button></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Block/Active Modal -->
        @foreach ($customers as $customer)
        <div class="modal fade" id="block-modal-{{$customer->srv_id}}" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="position: relative !important; z-index: 1 !important;">
                    <form action="{{route('clientcontrol.block', ['uniqueclientcontrol' => $customer->srv_id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="blockModalLabel">Client Status Change for: {{ $customer->customer_name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="user_id" class="fw-medium">Client ID</label>
                                        <input type="text" class="form-control" value="{{ $customer->user_id }}" name="user_id" id="user_id" readonly>
                                    </div>
                                    <div>
                                        <label for="exp_date" class="fw-medium">Exp Date</label>
                                        <input type="text" class="form-control datepicker-here digits" value="{{ $customer->block_date }}" name="exp_date" data-date-Format="yyyy-mm-dd" id="exp_date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="reason" class="fw-medium">Reason</label>
                                        <select class="form-select form-control" id="reason" name="reason">
                                            <option>Select a Reason</option>
                                            @foreach ($blockreasons as $blockreason)
                                                <option {{$customer->block_reason_id==$blockreason->id?'selected':''}} value="{{ $blockreason->id }}">{{ $blockreason->block_reason_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="client_status" class="fw-medium">Client Status</label>
                                        <select class="form-select form-control" id="client_status" name="client_status">
                                            <option>Select a Status</option>
                                            @foreach ($status_types as $status_type)
                                                <option {{ ($customer->tbl_status_type_id==$status_type->id) ?'selected':''}} value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Client Status Change History</h5>
                            <div class="QA_table">
                                @php
                                    $count  = 1;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">SL</th>
                                                <th scope="col">Change Reason</th>
                                                <th scope="col">Exp. Date</th>
                                                <th scope="col">Previous Status</th>
                                                <th scope="col">Current Status</th>
                                                <th scope="col">Updated By</th>
                                                <th scope="col">Block/Active Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($client_status_logs as $client_status_log)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td scope="col">{{ $client_status_log->block_reason_name }}</td>
                                                <td scope="col">{{ $client_status_log->exp_date }}</td>
                                                <td scope="col">{{ $client_status_log->previous_status }}</td>
                                                <td scope="col">{{ $client_status_log->current_status }}</td>
                                                <td scope="col">{{ $client_status_log->name }}</td>
                                                <td scope="col">{{ $client_status_log->updated_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-success" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Change Package Modal -->
        @foreach ($customers as $customer)
        <div class="modal fade" id="package-modal-{{$customer->srv_id}}" tabindex="-1" aria-labelledby="changePackageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('clientcontrol.changepackage', ['uniqueclientcontrol' => $customer->srv_id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="changePackageModalLabel">Package Change For: {{ $customer->customer_name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="current_package" class="fw-medium">Current Package:</label>
                                        <input type="text" class="form-control" value="{{ $customer->package }}" name="current_package" id="current_package" readonly>
                                    </div>
                                    <div>
                                        <label for="package" class="fw-medium">Package</label>
                                        <select class="form-select form-control" aria-label="Small select example" id="package_change" name="package_change" onchange="packageChanged(this)">
                                            <option value="-1" data-rate='0'>Select a Package</option>
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}" data-rate="{{ $package->price }}" >{{ $package->package_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="current_package_rate" class="fw-medium">Package Rate:</label>
                                        <input type="text" class="form-control" value="{{ $customer->price }}" name="current_package_rate" id="current_package_rate" disabled>
                                    </div>
                                    <div>
                                        <label for="package_rate" class="fw-medium">Rate Amount</label>
                                        <input type="text" class="form-control" value="" name="package_rate" id="package_rate" readonly>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-0 text-dark fw-medium">Package History</h5>
                            <div class="QA_table">
                                @php
                                    $count  = 1;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Previous Package</th>
                                                <th scope="col">Previous Rate</th>
                                                <th scope="col">Rate Changed Date</th>
                                                <th scope="col">Current Package</th>
                                                <th scope="col">Current rate</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($trn_rate_changes as $trn_rate_change)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td scope="col">{{ $trn_rate_change->customer_name }} -> {{$trn_rate_change->ip_number}}</td>
                                                <td scope="col">{{ $trn_rate_change->pclienttype }}</td>
                                                <td scope="col">{{ $trn_rate_change->prate + $trn_rate_change->pvat }}</td>
                                                <td scope="col">{{ $trn_rate_change->rate_change_date }}</td>
                                                <td scope="col">{{ $trn_rate_change->cclienttype }}</td>
                                                <td scope="col">{{ $trn_rate_change->crate + $trn_rate_change->cvat }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-success" value="Change">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Change Pass/IP/Mac Modal -->
        @foreach ($customers as $customer)
        <div class="modal fade" id="pass-modal-{{$customer->srv_id}}" tabindex="-1" aria-labelledby="changePassModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('clientcontrol.changeip', ['uniqueclientcontrol' => $customer->srv_id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="changePassModalLabel">Change Pass/IP/Mac for: {{ $customer->customer_name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="client_id" class="fw-medium">Client ID</label>
                                        <input type="text" class="form-control" value="{{$customer->user_id}}" name="client_id" id="client_id" readonly>
                                    </div>
                                    <div>
                                        <label for="ip_number" class="fw-medium">IP Number</label>
                                        <input type="text" class="form-control" value="{{$customer->ip_number}}" name="ip_number" id="ip_number">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="password" class="fw-medium">Password<span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" value="{{$customer->password}}" name="password" id="password" required>
                                    </div>
                                    <div>
                                        <label for="mac_address" class="fw-medium">Mac Address</label>
                                        <input type="text" class="form-control" value="{{$customer->mac_address}}" name="mac_address" id="mac_address">
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Pass/IP/Mac changes History</h5>
                            <div class="QA_table">
                                @php
                                    $count  = 1;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl</th>
                                                <th scope="col">Previous Pass</th>
                                                <th scope="col">Current Pass</th>
                                                <th scope="col">Previous IP</th>
                                                <th scope="col">Current IP</th>
                                                <th scope="col">Previous Mac</th>
                                                <th scope="col">Current Mac</th>
                                                <th scope="col">Updated By</th>
                                                <th scope="col">Changed Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($pass_ip_mac_logs as $pass_ip_mac_log)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->previous_pass }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->current_pass }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->previous_ip }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->current_ip }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->previous_mac }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->current_mac }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->name }}</td>
                                                <td scope="col">{{ $pass_ip_mac_log->updated_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-success" value="Active">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- PPPOE To Hotspot Modal -->
        @foreach ($customers as $customer)
        <div class="modal fade" id="pppoe-modal-{{$customer->srv_id}}" tabindex="-1" aria-labelledby="pppoeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('clientcontrol.pppoetohotspot', ['uniqueclientcontrol' => $customer->srv_id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="pppoeModalLabel">PPPOE To Hotspot for: {{$customer->customer_name}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="client_id" class="fw-medium">Client ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{$customer->user_id}}" name="client_id" id="client_id" disabled>
                                    </div>
                                    <div>
                                        
                                        <label for="static_ip" class="fw-medium">Static IP <span class="text-danger">*</span></label>
                                        <select class="form-select" aria-label="Small select example" id="static_ip" name="static_ip">
                                            <option selected>Select a Static IP</option>
                                            @foreach($staticip as $ip)
                                                <option value="{{ $ip->id }}">{{ $ip->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div>
                                        <label for="ip_number" class="fw-medium">IP Number</label>
                                        <input type="text" class="form-control" value="{{$customer->ip_number}}" name="ip_number" id="ip_number">
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">PPPOE to Hotspot History</h5>
                            <div class="QA_table">
                                @php
                                    $count  = 1;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl</th>
                                                <th scope="col">Previous IP</th>
                                                <th scope="col">Current IP</th>
                                                <th scope="col">Static IP</th>
                                                <th scope="col">Updated By</th>
                                                <th scope="col">PPPOE to Hotspot Changed Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($pppoe_to_hotspot_logs as $pppoe_to_hotspot_log)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td scope="col">{{ $pppoe_to_hotspot_log->previous_ip }}</td>
                                                <td scope="col">{{ $pppoe_to_hotspot_log->current_ip }}</td>
                                                <td scope="col">{{ $pppoe_to_hotspot_log->static_ip }}</td>
                                                <td scope="col">{{ $pppoe_to_hotspot_log->username }}</td>
                                                <td scope="col">{{ $pppoe_to_hotspot_log->updated_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-success" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Hotspot To PPPOE Modal -->
        @foreach ($customers as $customer)
        <div class="modal fade" id="hotspot-modal-{{$customer->srv_id}}" tabindex="-1" aria-labelledby="hotspotModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('clientcontrol.hotspottopppoe', ['uniqueclientcontrol' => $customer->srv_id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="hotspotModalLabel">Change Hotspot To PPPOE for: {{$customer->customer_name}}?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <h5 class="mb-0 text-dark fw-bold">Hotspot To PPPOE History</h5>
                            <div class="QA_table">
                                @php
                                    $count  = 1;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl</th>
                                                <th scope="col">Previous IP</th>
                                                <th scope="col">Current IP</th>
                                                <th scope="col">Static IP</th>
                                                <th scope="col">Updated By</th>
                                                <th scope="col">Hotspot To PPPOE Changed Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($hotspot_to_pppoe_logs as $hotspot_to_pppoe_log)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td scope="col">{{ $hotspot_to_pppoe_log->previous_ip }}</td>
                                                <td scope="col">{{ $hotspot_to_pppoe_log->current_ip }}</td>
                                                <td scope="col">{{ $hotspot_to_pppoe_log->static_ip }}</td>
                                                <td scope="col">{{ $hotspot_to_pppoe_log->username }}</td>
                                                <td scope="col">{{ $hotspot_to_pppoe_log->updated_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-success" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Change Userid Modal -->
        @foreach ($customers as $customer)
        <div class="modal fade" id="userid-modal-{{$customer->srv_id}}" tabindex="-1" aria-labelledby="changeUseridModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('clientcontrol.updateuserid', ['uniqueclientcontrol' => $customer->srv_id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="changeUseridModalLabel">User ID change for: {{ $customer->customer_name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    {{-- <div class="mb-2">
                                        <label for="client_name" class="fw-medium">Clients Name</label>
                                        <input type="text" class="form-control" value="{{$customer->customer_name}}" name="client_name" id="client_name" disabled>
                                    </div> --}}
                                    <div>
                                        <label for="client_id" class="fw-medium">Client ID<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{$customer->user_id}}" name="client_id" id="client_id">
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">UserId History</h5>
                            <div class="QA_table">
                                @php
                                    $count  = 1;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl</th>
                                                <th scope="col">Previous ID</th>
                                                <th scope="col">Current ID</th>
                                                <th scope="col">Updated By</th>
                                                <th scope="col">User ID Changed Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($userid_logs as $userid_log)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td scope="col">{{$userid_log->previous_id}}</td>
                                                <td scope="col">{{$userid_log->current_id}}</td>
                                                <td scope="col">{{$userid_log->name}}</td>
                                                <td scope="col">{{$userid_log->created_at}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-success" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Change Router Modal -->
        @foreach ($customers as $customer)
        <div class="modal fade" id="router-modal-{{$customer->srv_id}}" tabindex="-1" aria-labelledby="changeRouterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{route('clientcontrol.updaterouter', ['uniqueclientcontrol' => $customer->srv_id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="changeRouterModalLabel">Edit Client Router</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="client_name" class="fw-medium">Clients Name</label>
                                        <input type="text" class="form-control" value="{{$customer->customer_name}}" name="client_name" id="client_name" disabled>
                                    </div>
                                    <div>
                                        <label for="current_router" class="fw-medium">Current Router</label>
                                        <input type="text" class="form-control" value="{{$customer->router_name}}->{{$customer->router_ip}}" name="current_router" id="current_router" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label for="client_id" class="fw-medium">Client ID</label>
                                        <input type="text" class="form-control" value="{{$customer->user_id}}" name="client_id" id="client_id" disabled>
                                    </div>
                                    <div>
                                        <label for="new_router" class="fw-medium">New Router</label>
                                        <select class="form-select" aria-label="Small select example" id="new_router" name="new_router">
                                            <option>Select a New Router</option>
                                            @foreach($routers as $router)
                                                <option value="{{ $router->id }}">{{ $router->router_name }} -> {{ $router->router_ip }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Router History</h5>
                            <div class="QA_table">
                                @php
                                    $count  = 1;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl</th>
                                                <th scope="col">Previous Router</th>
                                                <th scope="col">Current Router</th>
                                                <th scope="col">Updated By</th>
                                                <th scope="col">Router Changed Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($router_logs as $router_log)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td scope="col">{{$router_log->previous}}</td>
                                                <td scope="col">{{$router_log->current}}</td>
                                                <td scope="col">{{$router_log->user_name}}</td>
                                                <td scope="col">{{$router_log->created_at}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-success" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
        
    
    });

    document.getElementById('submitBtn').addEventListener('click', function (e) {
        let router = document.getElementById('router').value;
        
         let submitBtn = document.getElementById('submitBtn');
        
        
        if(router=="-1")
        {
            
            alert("Select a router first!");
            e.preventDefault();
        } 
        else
        {
            submitBtn.disabled=true;
            document.getElementById("frm").submit();
        }
    });

    const selectClientStatus = document.getElementById('client_status');
    const selectExpDate = document.getElementById('exp_date');
    
    selectClientStatus.addEventListener("change", (event) => {
        if (event.target.value == 2){
            selectExpDate.setAttribute('readonly', '');
        } else {
            selectExpDate.removeAttribute('readonly');
        }
    });


    function packageChanged(package) {
        
        let option = $('option:selected', package).attr('data-rate');
        let new_rate = document.getElementById('package_rate');
        new_rate.value = option;
        // let animalType = animal.getAttribute("data-animal-type");
        console.log(option);
    }

    



        
   
</script>

@endpush
@endsection