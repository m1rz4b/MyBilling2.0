@extends("layouts.main")
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

    <div class="main_content_iner mt-0">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white;">Invoice Type</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#add_invoice_type_modal">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="add_invoice_type_modal" tabindex="-1"
                aria-labelledby="add_invoice_type_modal_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="add_invoice_type_modal_label">Add New Invoice Type</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="filter: invert(100%);"></button>
                        </div>

                        <form class="" method="POST" action="{{ route('invoicetype.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="invoice_type_name" class="form-label">Invoice Type: </label>
                                    <input type="text" class="form-control" id="invoice_type_name" name="invoice_type_name">
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
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

            <div class="QA_table p-3 pb-0">
                @php
                    $count  = 1;
                @endphp
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 20%;">Sl</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoicetypes as $invoice_type)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $invoice_type->invoice_type_name }}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_invoice_type_modal-{{$invoice_type->id}}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_invoice_type_modal-{{ $invoice_type->id }}">Delete</button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_invoice_type_modal-{{$invoice_type->id}}" tabindex="-1"
                                aria-labelledby="edit_invoice_type_modal_label{{$invoice_type->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="edit_invoice_type_modal_label{{$invoice_type->id}}">Edit Invoice Type</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>

                                        <form class="" id="editForm" method="POST" action="{{ route('invoicetype.update', ['invoicetype' => $invoice_type]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="invoice_type_name" class="form-label">Invoice Type: </label>
                                                    <input type="text" class="form-control" id="invoice_type_name" name="invoice_type_name" value="{{ $invoice_type->invoice_type_name }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ ($invoice_type->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($invoice_type->status == "2") ? "selected" : "" }} value="2">Inactive</option>
                                                    </select>
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
                            <div class="modal fade" id="delete_invoice_type_modal-{{$invoice_type->id}}" tabindex="-1" aria-labelledby="delete_invoice_type_modal_label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('invoicetype.destroy', ['invoicetype' => $invoice_type])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="delete_invoice_type_modal_label{{ $invoice_type->id }}">Delete {{ $invoice_type->invoice_type_name }}?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="invoice_type_name">Invoice Type Name</label>
                                                            <input type="text" class="form-control" value="{{ $invoice_type->invoice_type_name}}" name="invoice_type_name" id="invoice_type_name" disabled>
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
@endsection