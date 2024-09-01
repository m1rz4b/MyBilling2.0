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
                    <h5 class="mb-0 text-white">Bulk Router Change</h5>
                </div>
            </div>

            <form action="{{ route('bulkrouterchange.show') }}" method="get" enctype="multipart/form-data">
                @csrf
                <div class="row p-3">
                    <div class="col-sm-4 form-group">
                        <label for="router" class="fw-medium">Router</label>
                        <select class="select2 form-select form-select-sm form-control" aria-label="Small select example" id="router" name="router">
                            <option value="-1" selected>Select a Router</option>
                            @foreach($routers as $router)
                                <option {{ $selectedRouter==$router->id? 'selected' : '' }} value="{{ $router->id }}">{{ $router->router_name }} -> {{ $router->router_ip }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="package" class="fw-medium">Package</label>
                        <select class="select2 form-select form-select-sm form-control" id="package" name="package">
                            <option value="-1" selected>Select a Package</option>
                            @foreach ($client_types as $package)
                                <option {{ $selectedPackage==$package->id? 'selected' : '' }} value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach                      
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="zone" class="fw-medium">Zone</label>
                        <select class="select2 form-select form-select-sm form-control" id="zone" name="zone">
                            <option value="-1" selected>Select a Zone</option>
                            @foreach ($zones as $zone)
                                <option {{ $selectedZone==$zone->id? 'selected' : '' }} value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                            @endforeach                      
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="client_type" class="fw-medium">Client Type</label>
                        <select class="form-select form-select-sm form-control" id="client_type" name="client_type">
                            <option value="-1" selected>Select a Client Type</option>
                            @foreach ($client_categories as $client_category)
                                <option {{ $selectedClientType==$client_category->id? 'selected' : '' }} value="{{ $client_category->id }}">{{ $client_category->name }}</option>
                            @endforeach                      
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="status" class="fw-medium">Status</label>
                        <select class="form-select form-select-sm form-control" id="status" name="status">
                            <option value="-1" selected>Select a Status</option>
                            @foreach ($status_types as $status)
                                <option {{ $selectedStatus==$status->id? 'selected' : '' }} value="{{ $status->id }}">{{ $status->inv_name }}</option>
                            @endforeach                      
                        </select>
                    </div>

                    <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                    </div>
                </div>
            </form>

        
            <form action="{{ route('bulkrouterchange.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row px-3">
                    <h3 class="fs-3 text-black">Router Change</h3>
                    <div class="col-sm-4 form-group">
                        <select class="form-select form-select-sm form-control" id="router" name="router">
                            <option value="-1" selected>Select a Router</option>
                            @foreach ($routers as $router)
                                <option value="{{ $router->id }}">{{ $router->router_name }}</option>
                            @endforeach                      
                        </select>
                    </div>
                </div>

                <div class="QA_table px-3">
                    @php
                        $count  = 1;
                    @endphp
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><small class="text-nowrap">Sl</small></th>
                                <th scope="col"><small class="text-nowrap">Cl ID</small></th>
                                <th scope="col"><small class="text-nowrap">Login Id</small></th>
                                <th scope="col"><small class="text-nowrap">Client Name</small></th>
                                <th scope="col"><small class="text-nowrap">Mac Address</small></th>
                                <th scope="col"><small class="text-nowrap">IP Address</small></th>
                                <th scope="col"><small class="text-nowrap">Mobile</small></th>
                                <th scope="col"><small class="text-nowrap">Package</small></th>
                                <th scope="col"><small class="text-nowrap">Client Status</small></th>
                                <th scope="col"><small class="text-nowrap">Login Type</small></th>
                                <th scope="col"><small class="text-nowrap">Client Type</small></th>
                                <th scope="col"><small class="text-nowrap">Router IP</small></th>
                                <th scope="col"><small class="text-nowrap">Exp Date</small></th>
                                <th scope="col">
                                    <small class="text-nowrap">
                                        <div>
                                            <input class="form-check-input pr-1" type="checkbox" value="" id="selectAll">
                                            <label class="form-check-label" for="selectAll">
                                                Select All
                                            </label>
                                        </div>
                                    </small>
                                </th>
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
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-to-select" type="checkbox" value="{{ $customer->srv_id }}" id="flexCheckDefault[{{ $count }}]" name="service[]">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-sm-12 form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.checkbox-to-select');

        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                }
            });
        });
    });
</script>

@endsection