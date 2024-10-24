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
                <h5 class="mb-0 text-white text-center">Requisition Information</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addRequisitionModal">Add</a>
            </div>

            {{-- action="{{ route('generate-salary.show') }}"  --}}
            <form method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row p-3">
                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">Employee</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <select class="form-select form-select-sm form-control" id="client" name="client" >
                                <option>Select an Employee Name</option>
                                {{-- @foreach () --}}
                                    <option value=""></option>
                                {{-- @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">Client</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <select class="form-select form-select-sm form-control" id="client" name="client" >
                                <option>Select a Client</option>
                                {{-- @foreach () --}}
                                    <option value=""></option>
                                {{-- @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                    </div>
                </div>
            </form>

            {{-- Add Modal --}}
            <div class="modal fade" id="addRequisitionModal" tabindex="-1" aria-labelledby="addRequisitionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addRequisitionModalLabel">Add Requisition</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="w-50">
                                    <div class="mb-2">
                                        <h5 class="form-check-label">Requsiition Type: </h5>
                                        <div class="text-center">
                                            <div class="form-check form-check-inline mx-4">
                                                <label for="client" class="form-check-label">Client: </label>
                                                <input type="radio" class="form-check-input" id="client" name="client">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label for="personal" class="form-check-label">Personal: </label>
                                                <input type="radio" class="form-check-input" id="personal" name="personal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="brand_detail" class="form-label">Client: </label>
                                        <select name="brand_detail" id="brand_detail" class="form-select">
                                            <option>Select a Client</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="identefire_code_brand" class="form-label">Request Date: </label>
                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                    </div>
                                    <div class="mb-2">
                                        <label for="status" class="form-label">Remarks: </label>
                                        <input type="text" class="form-control" id="status" name="status">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="categoryID" class="form-label">Category</label>
                                            <select name="categoryID" id="categoryID" class="form-select form-select-sm select2">
                                                <option value="-1">Select a Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value={{ $cat->id }}>{{ $cat->cat_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="prodID" class="form-label">Product</label><br>
                                            <select name="prodID" id="prodID" class="form-select form-select-sm select2">
                                                <option value="-1">Select Product</option>
												
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Description</label>
                                            <textarea class="form-control form-control-sm" id="" name="" rows="1"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-1">
                                            <label for="" class="form-label">Quantity</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>
							    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn btn-sm btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Employee/Client</th>
                            <th scope="col">Requisition Type</th>
                            <th scope="col">Requisition Date</th>
                            <th scope="col">Product</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        {{-- @foreach ($tblbrands as $tblbrand) --}}
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editRequisitionModal">Edit</button>
                                </td>
                            </tr>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editRequisitionModal" tabindex="-1" aria-labelledby="editRequisitionModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editRequisitionModalLabel">Edit Requisition</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="w-50">
                                                    <div class="mb-2">
                                                        <h5 class="form-check-label">Requsiition Type: </h5>
                                                        <div class="text-center">
                                                            <div class="form-check form-check-inline mx-4">
                                                                <label for="client" class="form-check-label">Client: </label>
                                                                <input type="radio" class="form-check-input" id="client" name="client">
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label for="personal" class="form-check-label">Personal: </label>
                                                                <input type="radio" class="form-check-input" id="personal" name="personal">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="brand_detail" class="form-label">Client: </label>
                                                        <select name="brand_detail" id="brand_detail" class="form-select">
                                                            <option>Select a Client</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="identefire_code_brand" class="form-label">Request Date: </label>
                                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="status" class="form-label">Remarks: </label>
                                                        <input type="text" class="form-control" id="status" name="status">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label for="categoryID" class="form-label">Category</label>
                                                            <select name="categoryID" id="categoryID" class="form-select form-select-sm select2">
                                                                <option value="-1">Select a Category</option>
                                                                @foreach ($categories as $cat)
                                                                    <option value={{ $cat->id }}>{{ $cat->cat_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label for="prodID" class="form-label">Product</label><br>
                                                            <select name="prodID" id="prodID" class="form-select form-select-sm select2">
                                                                <option value="-1">Select Product</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label for="" class="form-label">Description</label>
                                                            <textarea class="form-control form-control-sm" id="" name="" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-1">
                                                            <label for="" class="form-label">Quantity</label>
                                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                <button class="btn btn-sm btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection