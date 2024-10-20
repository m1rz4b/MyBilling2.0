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
                <h5 class="mb-0 text-white text-center">Vendor Entry</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addVendorInfoModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addVendorInfoModal" tabindex="-1" aria-labelledby="addVendorInfoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addVendorInfoModalLabel">Add Vendor</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        {{-- action="{{ route('brand.store') }}"  --}}
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="clients_name" class="form-label">Supplier Name: </label>
                                            <input type="text" class="form-control" id="clients_name" name="clients_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="mobile1" class="form-label">Mobile: </label>
                                            <input rows="2" class="form-control" id="mobile1" name="mobile1">
                                        </div>
                                        <div class="mb-2">
                                            <label for="email" class="form-label">Email: </label>
                                            <input type="text" class="form-control" id="email" name="email">
                                        </div>
                                        <div class="mb-2">
                                            <label for="address" class="form-label">Address: </label>
                                            <input type="text" class="form-control" id="address" name="address">
                                        </div>
                                        <div class="mb-2">
                                            <label for="cstatus" class="form-label">Status </label>
                                            <select name="cstatus" id="cstatus" class="form-select">
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="contract_person" class="form-label">Contact Person: </label>
                                            <input type="text" class="form-control" id="contract_person" name="contract_person">
                                        </div>
                                        <div class="mb-2">
                                            <label for="phone" class="form-label">Phone: </label>
                                            <input rows="2" class="form-control" id="phone" name="phone">
                                        </div>
                                        <div class="mb-2">
                                            <label for="web_address" class="form-label">Web: </label>
                                            <input type="text" class="form-control" id="web_address" name="web_address">
                                        </div>
                                        <div class="mb-2">
                                            <label for="client_type" class="form-label">Supplier Type: </label>
                                            <select name="client_type" id="client_type" class="form-select">
                                                <option value="1">Dell</option>
                                                <option value="2">HP</option>
                                            </select>
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
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Contact Person</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($mas_suppliers as $mas_supplier)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $mas_supplier->clients_name }}</td>
                                <td>{{ $mas_supplier->contract_person }}</td>
                                <td>{{ $mas_supplier->phone }}</td>
                                <td>{{ $mas_supplier->mobile1 }}</td>
                                <td>{{ ($mas_supplier->status == "1") ? "Active" : "Inactive" }}</td>
                                <td width='10%'>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editVendorInfoModal{{ $mas_supplier->id }}">Edit</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editVendorInfoModal{{ $mas_supplier->id }}" tabindex="-1" aria-labelledby="editVendorInfoModalLabel{{ $mas_supplier->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editVendorInfoModalLabel{{ $mas_supplier->id }}">Edit Vendor</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        {{-- action="{{ route('brand.update', ['brand' => $mas_supplier]) }}"  --}}
                                        <form method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="clients_name" class="form-label">Supplier Name: </label>
                                                            <input type="text" class="form-control" id="clients_name" name="clients_name">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="mobile1" class="form-label">Mobile: </label>
                                                            <label rows="2" class="form-control" id="mobile1" name="mobile1">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="email" class="form-label">Email: </label>
                                                            <input type="text" class="form-control" id="email" name="email">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="address" class="form-label">Address: </label>
                                                            <input type="text" class="form-control" id="address" name="address">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="cstatus" class="form-label">Status </label>
                                                            <select name="cstatus" id="cstatus" class="form-select">
                                                                <option value="1">Active</option>
                                                                <option value="2">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="contract_person" class="form-label">Contact Person: </label>
                                                            <input type="text" class="form-control" id="contract_person" name="contract_person">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="phone" class="form-label">Phone: </label>
                                                            <label rows="2" class="form-control" id="phone" name="phone">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="web_address" class="form-label">Web: </label>
                                                            <input type="text" class="form-control" id="web_address" name="web_address">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="client_type" class="form-label">Supplier Type: </label>
                                                            <select name="client_type" id="client_type" class="form-select">
                                                                <option value="1">Dell</option>
                                                                <option value="2">HP</option>
                                                            </select>
                                                        </div>
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

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection