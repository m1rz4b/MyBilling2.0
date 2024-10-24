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
                <h5 class="mb-0 text-white text-center">Invoice Information</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addInvoiceInfoModal">Add</a>
            </div>

            {{-- action="{{ route('generate-salary.show') }}"  --}}
            <form method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row p-3">
                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">Client</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
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
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </div>
            </form>

            {{-- add modal --}}
            <div class="modal fade" id="addInvoiceInfoModal" tabindex="-1" aria-labelledby="addInvoiceInfoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="addInvoiceInfoModalLabel">Add Invoice</h1>
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
                                                <th scope="col" style="width: 40%;">Client Name</th>
                                                <th scope="col" style="width: 20%;">Invoice Date</th>
                                                <th scope="col" style="width: 20%;">Work Order Ref.</th>
                                                <th scope="col" style="width: 20%;">Next Invoice Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="customer_id" id="customer_id" class="form-select form-select-sm" style="width: 100%">
                                                        <option selected>Select a Client</option>
                                                        
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
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="categoryID" class="form-label">Category</label>
                                            <select name="categoryID" id="categoryID" class="form-control form-control-sm select2">
                                                <option value="-1">Select a Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value={{ $cat->id }}>{{ $cat->cat_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="prodID" class="form-label">Product</label><br>
                                            <select name="prodID" id="prodID" class="form-control form-control-sm select2">
                                                <option value="-1">Select Product</option>
												
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-1">
                                            <label for="" class="form-label">Quantity</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Description</label>
                                            <textarea class="form-control form-control-sm" id="" name="" rows="1"></textarea>
                                        </div>
                                    </div>
							        <!--
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Billing Period: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>
							        -->
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Rate</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Remain</label>
                                            <input type="text" class="form-control form-control-sm" id="r_qty" name="r_qty" disabled>
                                        </div>
                                    </div>
									
						            <!--
                                   <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Unit: </label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>
							        -->
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Amount</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                    </div>
							    </div>
                                
							    <div class="row">
                                    <div class="col-md-10">
                                
                                    </div>
                                    <div class="col-md-2">

                                        <div>
                                            <label for="">Sub Total</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div>
                                            <label for="">Discount</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="" value="0">
                                        </div>
                                        <div>
                                            <label for="">Vat</label>
                                            <div class="d-flex gap-3">
                                                <input type="number" class="form-control form-control-sm" id="" name="" placeholder="vat %">
                                                <input type="number" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="">Total Bill</label>
                                            <input type="text" class="form-control form-control-sm" id="" name="">
                                        </div>
                                        <div>
                                            <label for="">Advance Received</label>
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

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Invoice No.</th>
                            <th scope="col">Invoice Date</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Vat</th>
                            <th scope="col">Bill amount</th>
                            <th scope="col">Total Bill</th>
                            <th scope="col">Collection Amount</th>
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
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editInvoiceInfoModal">Edit</button>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewInvoiceInfoModal">View</button>
                                </td>
                            </tr>

                        {{-- @endforeach --}}
                    </tbody>
                </table>
                
                {{-- Edit Modal --}}
                <div class="modal fade" id="editInvoiceInfoModal" tabindex="-1" aria-labelledby="editInvoiceInfoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                                <h1 class="modal-title fs-5 text-white" id="editInvoiceInfoModalLabel">Edit Invoice</h1>
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
                                                    <th scope="col" style="width: 40%;">Client Name</th>
                                                    <th scope="col" style="width: 20%;">Invoice Date</th>
                                                    <th scope="col" style="width: 20%;">Work Order Ref.</th>
                                                    <th scope="col" style="width: 20%;">Next Invoice Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="customer_id" id="customer_id" class="form-select form-select-sm" style="width: 100%">
                                                            <option selected>Select a Client</option>
                                                            
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
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="categoryID" class="form-label">Category</label>
                                                <select name="categoryID" id="categoryID" class="form-control form-control-sm select2">
                                                    <option value="-1">Select a Category</option>
                                                    @foreach ($categories as $cat)
                                                        <option value={{ $cat->id }}>{{ $cat->cat_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="prodID" class="form-label">Product</label><br>
                                                <select name="prodID" id="prodID" class="form-control form-control-sm select2">
                                                    <option value="-1">Select Product</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-1">
                                                <label for="" class="form-label">Quantity</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Description</label>
                                                <textarea class="form-control form-control-sm" id="" name="" rows="1"></textarea>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Billing Period: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>
                                        -->
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Rate</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Remain</label>
                                                <input type="text" class="form-control form-control-sm" id="r_qty" name="r_qty" disabled>
                                            </div>
                                        </div>
                                        
                                        <!--
                                       <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Unit: </label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>
                                        -->
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="" class="form-label">Amount</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                    
                                        </div>
                                        <div class="col-md-2">
    
                                            <div>
                                                <label for="">Sub Total</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div>
                                                <label for="">Discount</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="" value="0">
                                            </div>
                                            <div>
                                                <label for="">Vat</label>
                                                <div class="d-flex gap-3">
                                                    <input type="number" class="form-control form-control-sm" id="" name="" placeholder="vat %">
                                                    <input type="number" class="form-control form-control-sm" id="" name="">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="">Total Bill</label>
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </div>
                                            <div>
                                                <label for="">Advance Received</label>
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
                <div class="modal fade" id="viewInvoiceInfoModal" tabindex="-1" aria-labelledby="viewInvoiceInfoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                                <h1 class="modal-title fs-5 text-white" id="viewInvoiceInfoModalLabel">View Invoice</h1>
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
                                                    {{-- @foreach ($customers as $customer)
                                                        @if ($customer->id == $invoice->client_id)
                                                            <td class="text-center">{{ $customer->customer_name }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td class="text-center">{{ $invoice->invoice_date }}</td>
                                                    <td class="text-center">{{ $invoice->work_order }}</td>
                                                    <td class="text-center">{{ $invoice->next_inv_date }}</td> --}}
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
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
            $("#categoryID").select2({
              dropdownParent: $("#addInvoiceInfoModal")
            });
            $("#prodID").select2({
              dropdownParent: $("#addInvoiceInfoModal")
            });
            $('#categoryID').on('select2:select', function (e) {
                var data = e.params.data;
                console.log(data);

                const catID = data.id;


                // Your JSON data
                const jsonData = { catID: catID };

                // Set up options for the fetch request
                const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(jsonData) // Convert JSON data to a string and set it as the request body
                };

                // Make the fetch request with the provided options
                fetch(`{{ url('otherInv/prodByCategory') }}`, options)
                .then(response => {
                    // Check if the request was successful
                    if (!response.ok) {
                    throw new Error('Network response was not ok');
                    }
                    // Parse the response as JSON
                    return response.json();
                })
                .then(data => {
                    // Handle the JSON data
                    console.log(data);

                    var option = new Option(data.text, data.id, true, true);
                    option.text = "Select Product";
                    option.value = -1;
                    var select = document.getElementById("prodID");
                    select.innerHTML = "";
                    select.append(option);
                    for(prod of data.data)
                    {
                        var option = new Option(data.text, data.id, true, true);
                        option.text = prod.pd_name;
                        option.value = prod.id;
                        var select = document.getElementById("prodID");
                        select.append(option);
                    }
                    $('#prodID').val('-1');
                        
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Fetch error:', error);
                });

            });
            $('#prodID').on('select2:select', function (e) {
                var data = e.params.data;
                console.log(data);

                const prodID = data.id;


                // Your JSON data
                const jsonData = { prodID: prodID };

                // Set up options for the fetch request
                const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(jsonData) // Convert JSON data to a string and set it as the request body
                };

                // Make the fetch request with the provided options
                fetch(`{{ url('otherInv/prodDetail') }}`, options)
                .then(response => {
                    // Check if the request was successful
                    if (!response.ok) {
                    throw new Error('Network response was not ok');
                    }
                    // Parse the response as JSON
                    return response.json();
                })
                .then(data => {
                    // Handle the JSON data
                    console.log(data);
                    var r_qty = document.getElementById("r_qty");
                    r_qty.value = data.data.pd_qty;
                        
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Fetch error:', error);
                });

            });

        });
    </script>
@endsection