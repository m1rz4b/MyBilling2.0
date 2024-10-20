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
                <h5 class="mb-0 text-white text-center">Item Information</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addItemModal">Add</a>
            </div>

            {{-- action="{{ route('generate-salary.show') }}"  --}}
            <form method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row p-3">
                    <div class="col-sm-4 form-group">
                        <label for="year" class="fw-medium">Category</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                            <select class="form-select form-select-sm form-control" id="year" name="year" >
                                <option>Select a Category</option>
                                {{-- @foreach () --}}
                                    <option value=""></option>
                                {{-- @endforeach --}}
                            </select>
                        </div>
                    </div>
    
                    <div class="col-sm-4 form-group">
                        <label for="brand" class="fw-medium">Brand</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                            <select class="form-select form-select-sm form-control" id="brand" name="brand">
                                <option>Select a Brand</option>
                                {{-- @foreach() --}}
                                    <option value=""></option>
                                {{-- @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="submit" class="btn btn-sm btn-primary"></i>Submit</button>
                    </div>
                </div>
            </form>

            <!-- Add Modal -->
            <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addItemModalLabel">Add Item</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        {{-- action="{{ route('brand.store') }}"  --}}
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="brand_display" class="form-label">Category: </label>
                                    <select class="form-select form-select-sm form-control" id="category" name="category" >
                                        <option>Select a Category</option>
                                        {{-- @foreach () --}}
                                            <option value=""></option>
                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="brand_display" class="form-label">Brand: </label>
                                    <select class="form-select form-select-sm form-control" id="category" name="category" >
                                        <option>Select a Brand</option>
                                        {{-- @foreach () --}}
                                            <option value=""></option>
                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                                <div class="d-flex gap-4 mb-2">
                                    <div class="w-50">
                                        <label for="identefire_code_brand" class="form-label">Model: </label>
                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                    </div>
                                    <div class="w-50">
                                        <label for="identefire_code_brand" class="form-label">Capacity: </label>
                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                    </div>
                                </div>
                                <div class="d-flex gap-4 mb-2">
                                    <div class="w-50">
                                        <label for="identefire_code_brand" class="form-label">Category Type: </label>
                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                    </div>
                                    <div class="w-50">
                                        <label for="identefire_code_brand" class="form-label">Unit: </label>
                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="identefire_code_brand" class="form-label">Product Name: </label>
                                    <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                </div>
                                <div class="mb-2">
                                    <label for="brand_detail" class="form-label">Description: </label>
                                    <textarea rows="2" class="form-control" id="brand_detail" name="brand_detail"></textarea>
                                </div>
                                <div class="d-flex gap-4 mb-2">
                                    <div class="w-50">
                                        <label for="identefire_code_brand" class="form-label">Reorder Level: </label>
                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                    </div>
                                    <div class="w-50">
                                        <label for="identefire_code_brand" class="form-label">Item Type: </label>
                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
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
                            <th scope="col">Category</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Unit</th>
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
                                <td width='10%'>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editItemModal">Edit</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editItemModalLabel">Edit Item</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        {{-- action="{{ route('brand.update', ['brand' => $tblbrand]) }}"  --}}
                                        <form method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="brand_display" class="form-label">Category: </label>
                                                    <select class="form-select form-select-sm form-control" id="category" name="category" >
                                                        <option>Select a Category</option>
                                                        {{-- @foreach () --}}
                                                            <option value=""></option>
                                                        {{-- @endforeach --}}
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="brand_display" class="form-label">Brand: </label>
                                                    <select class="form-select form-select-sm form-control" id="category" name="category" >
                                                        <option>Select a Brand</option>
                                                        {{-- @foreach () --}}
                                                            <option value=""></option>
                                                        {{-- @endforeach --}}
                                                    </select>
                                                </div>
                                                <div class="d-flex gap-4 mb-2">
                                                    <div class="w-50">
                                                        <label for="identefire_code_brand" class="form-label">Model: </label>
                                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                    </div>
                                                    <div class="w-50">
                                                        <label for="identefire_code_brand" class="form-label">Capacity: </label>
                                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-4 mb-2">
                                                    <div class="w-50">
                                                        <label for="identefire_code_brand" class="form-label">Category Type: </label>
                                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                    </div>
                                                    <div class="w-50">
                                                        <label for="identefire_code_brand" class="form-label">Unit: </label>
                                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="identefire_code_brand" class="form-label">Product Name: </label>
                                                    <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="brand_detail" class="form-label">Description: </label>
                                                    <textarea rows="2" class="form-control" id="brand_detail" name="brand_detail"></textarea>
                                                </div>
                                                <div class="d-flex gap-4 mb-2">
                                                    <div class="w-50">
                                                        <label for="identefire_code_brand" class="form-label">Reorder Level: </label>
                                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                    </div>
                                                    <div class="w-50">
                                                        <label for="identefire_code_brand" class="form-label">Item Type: </label>
                                                        <input type="text" class="form-control" id="identefire_code_brand" name="identefire_code_brand">
                                                    </div>
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