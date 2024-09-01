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
                    <h5 class="mb-0" style="color: white;">Modify Invoice</h5>
                </div>
            </div>
            <form action="{{route('masinvoice.editinvoiceshow')}}">
                <div class="row p-3">
                    <div class="col-sm-3 form-group">
                        <label for="month" class="fw-medium">Month</label>
                        <select class="form-select form-select-sm form-control" id="month" name="month" readonly>
                            @foreach(range(1,12) as $month)
                                    <option value="{{$month}}">
                                            {{date("M", strtotime('2016-'.$month))}}
                                    </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="year" class="fw-medium">Year</label>
                        <select class="form-select form-select-sm form-control" id="year" name="year" readonly >
                            <option>Please Choose A Year</option>
                            @foreach (range(now()->year - 10, now()->year + 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">Client</label>
                        <select class="select2 form-select form-select-sm" id="client" name="client" disabled>
                            <option selected>Select a Client</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->customer_name }}">{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
                            @endforeach                   
                        </select>
                    </div>

                    <!-- <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <input type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div> -->
                </div>
            </form>


            <div class="QA_table p-3 pb-0">
                @php
                    $count  = 1;
                @endphp
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Invoice No.</th>
                                <th scope="col">Invoice Date</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Total Bill</th>
                                <th scope="col">Collection Amnt.</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($mas_invoices as $mas_invoice)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $mas_invoice->invoice_number }}</td>
                                <td>{{ $mas_invoice->invoice_date }}</td>
                                <td>{{ $mas_invoice->Customer->customer_name }}</td>
                                <td>{{ $mas_invoice->total_bill }}</td>
                                <td>{{ $mas_invoice->collection_amnt }}</td>
                                <td>{{ $mas_invoice->status ==1 ? 'Active': 'Inactive'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_mas_invoice-{{$mas_invoice->id}}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_mas_invoice-{{ $mas_invoice->id }}">Delete</button>
                                </td>
                            </tr>
    
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_mas_invoice-{{$mas_invoice->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{route('masinvoice.update', ['masinvoice' => $mas_invoice])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit Invoice</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-2">
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="invoice_number">Invoice No.</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-receipt"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->invoice_number}}" name="invoice_number" id="invoice_number" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="bill_number">Bill No.</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->bill_number}}" name="bill_number" id="bill_number" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="customer_name">Client Name</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->Customer->customer_name }} | {{ $mas_invoice->Customer->id }}" name="customer_name" id="customer_name" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="invoice_date">Invoice Date</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->invoice_date}}" name="invoice_date" id="invoice_date" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="bill_amount">Bill Amount</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->bill_amount }}" name="bill_amount" id="bill_amount" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="vat">Vat</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->vat }}" name="vat" id="vat" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="total_bill">Total Bill</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->total_bill}}" name="total_bill" id="total_bill" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <label for="collection_amnt">Collection Amount</label>
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bills"></i></span>
                                                                <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->collection_amnt }}" name="collection_amnt" id="collection_amnt" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div>
                                                            <label for="total_bill">Amount</label>
                                                            <input type="text" class="form-control form-control-sm" value="" name="total_bill" id="total_bill">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div>
                                                            <label for="vat">Vat</label>
                                                            <input type="text" class="form-control form-control-sm" value="" name="vat" id="vat">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div>
                                                            <label for="discount_amnt">Discount</label>
                                                            <input type="text" class="form-control form-control-sm" value="" name="discount_amnt" id="discount_amnt">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div>
                                                            <label for="comments">Comments</label>
                                                            <textarea class="form-control form-control-sm" id="comments" name="comments" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-sm btn-success" value="Update" onclick="this.disabled=true;this.form.submit();">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete_mas_invoice-{{$mas_invoice->id}}" tabindex="-1" aria-labelledby="deleteMasInvoiceModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('masinvoice.destroy', ['masinvoice' => $mas_invoice])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteMasInvoiceModalLabel{{ $mas_invoice->id }}">Delete {{ $mas_invoice->Customer->customer_name }}?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-2">
                                                    <div>
                                                        <label for="invoice_number">Invoice No.</label>
                                                        <div class="input-group input-group-sm flex-nowrap">
                                                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-receipt"></i></span>
                                                            <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->invoice_number}}" name="invoice_number" id="invoice_number" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div>
                                                        <label for="bill_number">Bill No.</label>
                                                        <div class="input-group input-group-sm flex-nowrap">
                                                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-money-bill"></i></span>
                                                            <input type="text" class="form-control form-control-sm" value="{{ $mas_invoice->bill_number}}" name="bill_number" id="bill_number" disabled>
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
</script>

@endpush
@endsection