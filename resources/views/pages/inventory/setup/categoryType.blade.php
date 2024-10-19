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
                <h5 class="mb-0 text-white text-center">Type Information</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addCategoryTypeModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addCategoryTypeModal" tabindex="-1" aria-labelledby="addCategoryTypeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addCategoryTypeModalLabel">Add Type</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        {{-- action="{{ route('brand.store') }}"  --}}
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="brand_display" class="form-label">Category: </label>
                                    <input type="text" class="form-control" id="brand_display" name="brand_display">
                                </div>
                                <div class="mb-2">
                                    <label for="identefire_code_brand" class="form-label">Type Name: </label>
                                    <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                </div>
                                <div class="mb-2">
                                    <label for="identefire_code_brand" class="form-label">Short Code: </label>
                                    <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                </div>
                                <div class="mb-2">
                                    <label for="brand_detail" class="form-label">Description: </label>
                                    <textarea rows="2" class="form-control" id="brand_detail" name="brand_detail"></textarea>
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
                            <th scope="col">Category</th>
                            <th scope="col">Type Name</th>
                            <th scope="col">Short Code</th>
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
                                <td width='10%'>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editCategoryTypeModal">Edit</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editCategoryTypeModal" tabindex="-1" aria-labelledby="editCategoryTypeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editCategoryTypeModalLabel">Edit Type</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        {{-- action="{{ route('brand.update', ['brand' => $tblbrand]) }}"  --}}
                                        <form method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="brand_display" class="form-label">Category Name: </label>
                                                    <input type="text" class="form-control" id="brand_display" name="brand_display" value="">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="identefire_code_brand" class="form-label">Type Name: </label>
                                                    <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand" value="">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="identefire_code_brand" class="form-label">Short Code: </label>
                                                    <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand" value="">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="brand_detail" class="form-label">Description: </label>
                                                    <textarea rows="2" class="form-control" id="brand_detail" name="brand_detail"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
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