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
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Package Plan</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#add_new_package_plan">Add</a>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="add_new_package_plan" tabindex="-1" aria-labelledby="package_plan_label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('packageplan.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="package_plan_label">Add Package Plan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-2">
                                <label for="name" class="fw-medium">Package Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name">
                                </div>

                                <div class="col-sm-6">
                                    <label class="fw-medium">
                                        <input type="hidden" name="hotspot" value="0">
                                        <input class="form-check-input" type="checkbox" name="hotspot" id="hotspot" value="1" >
                                        Hotspot
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="unit" class="fw-medium">Package Bandwidth (K)</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" id="unit" name="unit">
                                </div>

                                <div class="col-sm-6">
                                    <label class="fw-medium">
                                        <input type="hidden" name="pcq" value="0">
                                        <input class="form-check-input" type="checkbox" name="pcq" id="pcq" value="1" >
                                        Disable Rate Limit In Radius
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="days" class="fw-medium">Days(Only valid in Hotspot)</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control form-control-sm" id="days" name="days">
                                </div>

                                <div class="col-sm-6">
                                    <label class="fw-medium">
                                        <input type="hidden" name="view_portal" value="0">
                                        <input class="form-check-input" type="checkbox" name="view_portal" id="view_portal" value="1" >
                                        Show In Portal
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <label for="price" class="fw-medium">Package Price</label>
                                    <input type="text" class="form-control form-control-sm" id="price" name="price">
                                </div>

                                <div class="col-sm-6">
                                    <label for="share_rate" class="fw-medium">Provider Bill (Amount)</label>
                                    <input type="number" class="form-control form-control-sm" id="share_rate" name="share_rate">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="reseller_id" class="fw-medium">Reseller User</label>
                                    <select class="form-select form-select-sm form-control" id="reseller_id" name="reseller_id">
                                        <option selected>Select Reseller User</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                        @endforeach                      
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="status" class="fw-medium">Status: </label>
                                    <select class="form-select form-select-sm form-control" name="status" id="status">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-sm btn-primary" value="Submit" onclick="this.disabled=true;this.form.submit();">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- <div class="px-3 row pt-2">
            <div class="col-sm-6">
                <label for="reseller" class="fw-medium">Reseller </label>
                <select class="select2 form-select form-select-sm" id="reseller_user" name="reseller_user">
                    <option selected>Select Reseller</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                    @endforeach                      
                </select>
            </div>
            <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                <br class="d-none d-sm-block">
                <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
            </div>
        </div> --}}

        <div class="QA_table p-3 pb-0">
            @php
                $count  = 1;
            @endphp
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Package Name</th>
                            <th scope="col">Package Bandwidth (K)</th>
                            <th scope="col">Package Price</th>
                            <th scope="col">Provider Bill (Amount)</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($client_types as $client_type)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $client_type->name }}</td>
                            <td>{{ $client_type->unit }}</td>
                            <td>{{ $client_type->price }}</td>
                            <td>{{ $client_type->share_rate }}</td>
                            <td>{{ $client_type->status ==1 ? 'Active': 'Inactive'}}</td>
                            <td class="text-end text-nowrap" width='10%'>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_package_plan-{{$client_type->id}}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_package_plan-{{ $client_type->id }}">Delete</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit_package_plan-{{$client_type->id}}" tabindex="-1" aria-labelledby="edit_package_plan_label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('packageplan.update', ['packageplan' => $client_type])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="edit_package_plan_label">Edit Package Plan</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <label for="name" class="fw-medium">Package Name</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" value="{{ $client_type->name}}" id="name" name="name">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="fw-medium">
                                                        <input type="hidden" name="hotspot" value="0">
                                                        <input class="form-check-input" type="checkbox" name="hotspot" id="hotspot" {{$client_type->hotspot == 1?'checked':''}} value="1" >
                                                        Hotspot
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <label for="unit" class="fw-medium">Package Bandwidth (K)</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" value="{{ $client_type->unit}}" id="unit" name="unit">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="fw-medium">
                                                        <input type="hidden" name="pcq" value="0">
                                                        <input class="form-check-input" type="checkbox" name="pcq" id="pcq" {{$client_type->pcq == 1?'checked':''}} value="1" >
                                                        Disable Rate Limit In Radius
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <label for="days" class="fw-medium">Days(Only valid in Hotspot)</label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control form-control-sm" value="{{ $client_type->days}}" id="days" name="days">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="fw-medium">
                                                        <input type="hidden" name="view_portal" value="0">
                                                        <input class="form-check-input" type="checkbox" name="view_portal" id="view_portal" {{$client_type->view_portal == 1?'checked':''}} value="1" >
                                                        Show In Portal
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <label for="price" class="fw-medium">Package Price</label>
                                                    <input type="number" class="form-control form-control-sm" value="{{ $client_type->price}}" id="price" name="price">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="share_rate" class="fw-medium">Provider Bill (Amount)</label>
                                                    <input type="number" class="form-control form-control-sm" value="{{ $client_type->share_rate}}" id="share_rate" name="share_rate">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="reseller_id" class="fw-medium">Reseller User</label>
                                                    <select class="form-select form-select-sm form-control" id="reseller_id" name="reseller_id">
                                                        <option selected>Select Reseller User</option>
                                                        @foreach ($customers as $customer)
                                                            <option {{ $client_type->id == $customer->id ? 'selected':'' }} value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                                        @endforeach                      
                                                    </select>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="status" class="fw-medium">Status: </label>
                                                    <select class="form-select form-select-sm form-control" name="status" id="status">
                                                        <option {{$client_type->status == "1"?'selected':''}} value="1">Active</option>
                                                        <option {{$client_type->status == "2"?'selected':''}} value="2">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-sm btn-success" value="Submit" onclick="this.disabled=true;this.form.submit();">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="delete_package_plan-{{$client_type->id}}" tabindex="-1" aria-labelledby="delete_package_plan_label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('packageplan.destroy', ['packageplan' => $client_type])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="delete_package_plan_label{{ $client_type->id }}">Delete {{ $client_type->name }}?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-2">
                                                        <label for="name">Package Name</label>
                                                        <input type="text" class="form-control" value="{{ $client_type->name}}" name="name" id="name" disabled>
                                                    </div>
                                                    <div>
                                                        <label for="unit">Package Bandwidth</label>
                                                        <input type="text" class="form-control" value="{{ $client_type->unit}}" name="unit" id="unit" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-sm btn-danger" value="Delete" onclick="this.disabled=true;this.form.submit();">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });

    jQuery('.datetimepicker').datetimepicker();
</script>

@endpush

@endsection