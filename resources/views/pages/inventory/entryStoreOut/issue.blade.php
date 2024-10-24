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
            <div class="px-4 py-1 theme_bg_1 d-flex">
                <h5 class="mb-0 text-white text-center">Issue Information</h5>
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

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Employee/Client</th>
                            <th scope="col">Requisition Type</th>
                            <th scope="col">Requisition Date</th>
                            <th scope="col">Product</th>
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
                                <td>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#editIssueModal">Issue</button>
                                </td>
                            </tr>

                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editIssueModal" tabindex="-1" aria-labelledby="editIssueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="editIssueModalLabel">Requisition Issue</h1>
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
                                <div class="QA_table p-3 pb-0">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Category</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Inv. Qty</th>
                                                <th scope="col">Req. Qty</th>
                                                <th scope="col">Issued Qty</th>
                                                <th scope="col">Issue Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
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

        </div>
    </div>
@endsection