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
            <div class="">
                <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                    <h5 class="mb-0 text-white text-center">Invoice Information</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addOtherInvModal">Add</a>
                </div>
            </div>

            <div class="p-4 row">
                <div class="col-sm-3">
                    <label for="" class="">Customer</label>
                    <select name="" id="" class="form-control form-control-sm select2" style="width: 145%;">
                        <option selected>Select a Customer</option>
                        @foreach ($customers as $customer)
                            <option {{--value="{{ $customer->customer_name }}"--}}>{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
                        @endforeach 
                    </select>
                </div>
                <div class="col-sm-5">
                    <br/>
                    <center><button type="submit" class="btn btn-sm btn-info">Search</button></center>
                </div>
            </div>

            <div class="QA_table px-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Invoice No.</th>
                            <th scope="col" class="text-center">Invoice Date</th>
                            <th scope="col" class="text-center">Customer Name</th>
                            <th scope="col" class="text-center">Vat</th>
                            <th scope="col" class="text-center">Bill Amount</th>
                            <th scope="col" class="text-center">Total Bill</th>
                            <th scope="col" class="text-center">Collection Amount</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $slNumber = 1 @endphp
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td class="text-center">{{ $slNumber++ }}</td>
                                <td class="text-center">{{ $invoice->invoice_date }}</td>
                                <td class="text-center">Customer Name</td>
                                <td class="text-center">{{ $invoice->vat }}</td>
                                <td class="text-center">{{ $invoice->bill_amount }}</td>
                                <td class="text-center">{{ $invoice->total_bill }}</td>
                                <td class="text-center">{{ $invoice->collection_amnt }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success py-0" data-bs-toggle="modal" data-bs-target="#editOtherInvModal{{ $invoice->id }}">Edit</button>
                                    <button class="btn btn-sm btn-info py-0" data-bs-toggle="modal" data-bs-target="#viewOtherInvModal{{ $invoice->id }}">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach ($invoices as $invoice)
                
                {{-- edit modal --}}
                <div class="modal fade" id="editOtherInvModal{{ $invoice->id }}" tabindex="-1"
                    aria-labelledby="editOtherInvModalLabel{{ $invoice->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                                <h1 class="modal-title fs-5 text-white" id="editOtherInvModalLabel{{ $invoice->id }}">Edit Invoice</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            {{-- action="{{ route('area.store') }}" --}}
                            <form class="" method="POST" >
                                @csrf
                                <div class="modal-body">
                                    <div class="QA_table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 35%;">Customer Name</th>
                                                    <th scope="col" style="width: 20%;">Invoice Date</th>
                                                    <th scope="col" style="width: 25%;">Work Order Ref.</th>
                                                    <th scope="col" style="width: 20%;">Next Invoice Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="client_id" id="client_id" class="form-select form-select-sm select2" style="width: 100%">
                                                            @foreach ($customers as $customer)
                                                                @if ($customer->id == $invoice->client_id)
                                                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
                                                                @endif
                                                            @endforeach 
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="" id="" class="form-control form-control-sm datepicker-here" value="{{ $invoice->invoice_date }}" data-date-Format="yyyy-mm-dd"></td>
                                                    <td><input type="text" class="form-control form-control-sm" value="{{ $invoice->work_order }}"></td>
                                                    <td><input type="text" name="" id="" class="form-control form-control-sm datepicker-here" value="{{ $invoice->next_inv_date }}" data-date-Format="yyyy-mm-dd"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Category: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div class="mb-2">
                                                <label for="" class="form-label">Description: </label>
                                                <textarea class="form-control form-control-sm" id="" name="" rows="1"></textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label for="" class="form-label">Quantity: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Product: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div class="mb-2">
                                                <label for="" class="form-label">Billing Period: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div class="mb-2">
                                                <label for="" class="form-label">Unit: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Quantity Remaining: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="" disabled>
                                            </div>
                                            <div class="mb-2">
                                                <label for="" class="form-label">Price/Rate (BDT): </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div class="mb-2">
                                                <label for="" class="form-label">Amount (BDT): </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div>
                                                <label for="">Sub Total:</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div>
                                                <label for="">Discount:</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="" value="0">
                                            </div>
                                            <div>
                                                <label for="">Vat:</label>
                                                <div class="d-flex gap-3">
                                                    <input type="number" class="form-control form-control-sm" id="" name="" placeholder="vat %">
                                                    <input type="number" class="form-control form-control-sm" id="" name="">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="">Total Bill:</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div>
                                                <label for="">Advance Received:</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- view modal --}}
                <div class="modal fade" id="viewOtherInvModal{{ $invoice->id }}" tabindex="-1"
                    aria-labelledby="viewOtherInvModalLabel{{ $invoice->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                                <h1 class="modal-title fs-5 text-white" id="viewOtherInvModalLabel{{ $invoice->id }}">View Invoice</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            {{-- action="{{ route('area.store') }}" --}}
                            <form class="" method="POST" >
                                @csrf
                                <div class="modal-body">
                                    <div class="QA_table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Customer Name</th>
                                                    <th scope="col" class="text-center">Invoice Date</th>
                                                    <th scope="col" class="text-center">Work Order Ref.</th>
                                                    <th scope="col" class="text-center">Next Invoice Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($customers as $customer)
                                                        @if ($customer->id == $invoice->client_id)
                                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td class="text-center">{{ $invoice->invoice_date }}</td>
                                                    <td class="text-center">{{ $invoice->work_order }}</td>
                                                    <td class="text-center">{{ $invoice->next_inv_date }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="QA_table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Category</th>
                                                    <th scope="col" class="text-center">Product</th>
                                                    <th scope="col" class="text-center">Description</th>
                                                    <th scope="col" class="text-center">Billing Period</th>
                                                    <th scope="col" class="text-center">Price/Rate (BDT)</th>
                                                    <th scope="col" class="text-center">Quantity</th>
                                                    <th scope="col" class="text-center">Unit</th>
                                                    <th scope="col" class="text-center">Amount (BDT)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">sdaf123</td>
                                                    <td class="text-center">sdaf123</td>
                                                    <td class="text-center">sdaf123</td>
                                                    <td class="text-center">123</td>
                                                    <td class="text-center">123</td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">123</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-end">Sub Total: </td>
                                                    <td class="text-center">123</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-end">Discount: </td>
                                                    <td class="text-center">12</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-end">VAT: 0 %</td>
                                                    <td class="text-center">0</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-end">Total Bill: </td>
                                                    <td class="text-center">111</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-end">Advance Received: </td>
                                                    <td class="text-center">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
                

            {{-- add modal --}}
            <div class="modal fade" id="addOtherInvModal" tabindex="-1"
                aria-labelledby="addOtherInvModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="addOtherInvModalLabel">Add Invoice</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        {{-- action="{{ route('area.store') }}" --}}
                        <form class="" method="POST" >
                            @csrf
                            <div class="modal-body">
                                <div class="QA_table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 35%;">Customer Name</th>
                                                <th scope="col" style="width: 20%;">Invoice Date</th>
                                                <th scope="col" style="width: 25%;">Work Order Ref.</th>
                                                <th scope="col" style="width: 20%;">Next Invoice Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="client_id" id="client_id" class="form-select form-select-sm select2" style="width: 100%">
                                                        <option selected>Select a Customer</option>
                                                        @foreach ($customers as $customer)
                                                            <option value="{{ $customer->id }}">{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
                                                        @endforeach 
                                                    </select>
                                                </td>
                                                <td><input type="text" name="" id="" class="form-control form-control-sm datepicker-here" data-date-Format="yyyy-mm-dd"></td>
                                                <td><input type="text" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="" id="" class="form-control form-control-sm datepicker-here" data-date-Format="yyyy-mm-dd"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Category: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Description: </label>
                                            <textarea class="form-control form-control-sm" id="" name="" rows="1"></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Quantity: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Product: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Billing Period: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Unit: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Quantity Remaining: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="" disabled>
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Price/Rate (BDT): </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Amount (BDT): </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div>
                                            <label for="">Sub Total:</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div>
                                            <label for="">Discount:</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="0">
                                        </div>
                                        <div>
                                            <label for="">Vat:</label>
                                            <div class="d-flex gap-3">
                                                <input type="number" class="form-control form-control-sm" id="" name="" placeholder="vat %">
                                                <input type="number" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="">Total Bill:</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div>
                                            <label for="">Advance Received:</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn-custom-1 py-1" type="submit" onclick="this.disabled=true;this.form.submit();">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });
    </script>
@endsection