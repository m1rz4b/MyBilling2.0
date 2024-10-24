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
                <h5 class="mb-0 text-white text-center">Purchase Return Information</h5>
            </div>

            {{-- action="{{ route('generate-salary.show') }}"  --}}
            <form method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row px-3 pt-3">
                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">From</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <input type="text" class="form-control form-control-sm" id="client" name="client">
                        </div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">To</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <input type="text" class="form-control form-control-sm" id="client" name="client">
                        </div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">Supplier</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"></span>
                            <select class="form-select form-select-sm form-control" id="client" name="client" >
                                <option>Select a Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->clients_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row px-3">
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
                            <th scope="col">Return No.</th>
                            <th scope="col">From Supplier</th>
                            <th scope="col">Return Date</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($tblbrands as $tblbrand) --}}
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection