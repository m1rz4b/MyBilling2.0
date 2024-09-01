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
    <form action="{{ route('bulkrouterchange.show') }}" method="get" enctype="multipart/form-data" id="frm">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">Bulk Router Change</h5>
                </div>
            </div>

            <div class="row p-3">
                <div class="col-sm-4 form-group">
                    <label for="router" class="fw-medium">Router</label>
                    <select class="select2 form-select form-select-sm form-control" aria-label="Small select example" id="router" name="router">
                        <option value="-1" selected>Select a Router</option>
                        @foreach($routers as $router)
                            <option value="{{ $router->id }}">{{ $router->router_name }} -> {{ $router->router_ip }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="package" class="fw-medium">Package</label>
                    <select class="select2 form-select form-select-sm form-control" id="package" name="package">
                        <option value="-1" selected>Select a Package</option>
                        @foreach ($client_types as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                        @endforeach                      
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="zone" class="fw-medium">Zone</label>
                    <select class="select2 form-select form-select-sm form-control" id="zone" name="zone">
                        <option value="-1" selected>Select a Zone</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                        @endforeach                      
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="client_type" class="fw-medium">Client Type</label>
                    <select class="form-select form-select-sm form-control" id="client_type" name="client_type">
                        <option value="-1" selected>Select a Client Type</option>
                        @foreach ($client_categories as $client_category)
                            <option value="{{ $client_category->id }}">{{ $client_category->name }}</option>
                        @endforeach                      
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="status" class="fw-medium">Status</label>
                    <select class="form-select form-select-sm form-control" id="status" name="status">
                        <option value="-1" selected>Select a Status</option>
                        @foreach ($status_types as $status)
                            <option value="{{ $status->id }}">{{ $status->inv_name }}</option>
                        @endforeach                      
                    </select>
                </div>

                <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <button type="button" id="submitBtn" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        })
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