@extends('layouts.main')

@section('main-container')
    <style>
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
  
    <div class="main_content_iner mt-0">
        
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white text-center">Client Invoice Posting</h5>
                </div>
            </div>

            <form action="{{ route('clientinvoiceposting.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					
				<div class="col-sm-2 form-group">
                    
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
						<option>Select A Month</option>                           
						   @foreach(range(1,12) as $month)
                                <option {{ $invoiceMonth==$month? 'selected' : '' }} value="{{ $month }}">
                                    {{ date("M", mktime(0, 0, 0, $month, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
				
                <div class="col-sm-2 form-group">
                 
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            <option>Select A Year</option>
                            @foreach (range(now()->year - 10, now()->year + 5) as $year)
                                <option {{ $invoiceYear==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="col-sm-3">
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="branch_id" name="branch_id">
                                <option value="-1" selected>Select a Branch</option>
                                @foreach ($branches as $branch)
                                    <option {{ $selectedBranch==$branch->id? 'selected' : '' }} value="{{ $branch->id }}">{{ $branch->name }} </option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>
					<div class="col-md-3">
                    <select name="customer_id" id="customer_id" class="form-select form-select-sm select2" style="width: 100%">
                    <option value="-1" selected>Select a Customer</option>
					 @php 
					 if($selectedCustomer) {
					@endphp
					 @foreach ($customers as $customer)
	<option {{ $selectedCustomer==$customer->customer_id ? 'selected' : '' }} value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
				@endforeach
			<!--		<option selected value="{{ $selectedCustomer }}">{{ $selectedCustomer }}</option> -->
					  @php
					 }
					  @endphp                               
                     </select>
                </div>
					
						<div class="col-sm-2">
                            <select name="invoice_cat" id="invoice_cat" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Invoice Type</option>
                                @foreach ($invoicecategorys as $invoicecategory)
                   <option {{ $selectedInvoiceCat==$invoicecategory->id? 'selected' : '' }} value="{{ $invoicecategory->id }}">{{ $invoicecategory->invoice_type_name }}</option>
                                @endforeach
                            </select>
							
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-sm btn-primary me-2"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                            <a class="btn btn-warning btn-sm text-white me-2" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Print</a>
                            <a class="btn btn-success btn-sm"><i class="fa-regular fa-file-excel me-1"></i>Excel</a>
                        </div>
                    </div>
                </div>
            </form>
					<div class="px-4 py-1">
                    <h5 class="mb-0 text-center">Millennium Computers And Networking</h5>
					<h5 class="mb-0 text-center">Client Invoice Posting</h5>
					<h5 class="mb-0 text-center">Month: {{ $invoiceMonth}} Year: {{ $invoiceYear}}</h5>
					
                </div>
				
		<form action="{{ route('clientinvoiceposting.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$ittotal_bill=0;
					$gttotal_bill=0;
					$icollection_amnt=0;
					$gcollection_amnt=0;
					$idiscount_amnt=0;
					$gdiscount_amnt=0;
					$idue_amnt=0;
					$gdue_amnt=0;
					$customers_id=0;
                @endphp


                <table class="table table-responsive">
                    <thead>
                        <tr>
						
												<th>SL</th>
                                                <th>Invoice No.</th>
                                                <!-- <th>Bill No.</th> -->
                                                <th>Invoice Date</th>
                                                <th width="25%">Client Name</th>
                                                <th>Vat</th>
                                                <th>Bill Amount</th>
                                                <th>Total Bill</th>
                                                <th>Collection Amount</th>
                                                <th>Invoice Cat</th>
														<th>
		                                            <input class="form-check-input pr-1" type="checkbox" value="" id="selectAll">
                                            <label class="form-check-label" for="selectAll">
		</th>
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice_postings as $invoice_posting)
                        <tr>
                            <td>{{ $count++ }}</td>
                           <td>{{ $invoice_posting->invoices_id}}</td>
                            <td>{{ $invoice_posting->invoice_date }}</td>
                            <td>{{ $invoice_posting->Company_Name }}</td>
                            <td>{{ $invoice_posting->vat }}</td>
                            <td>{{ $invoice_posting->bill_amount }}</td>
                            <td align='right'>{{ $invoice_posting->total_bill }} </td>
							 <td align='right'>{{ $invoice_posting->collection_amnt }} </td>
							  <td align='right'>{{ $invoice_posting->invoice_cat }} </td>
				 <td><input class="form-check-input checkbox-to-select" type="checkbox" name="collection_id[]" value="{{ $invoice_posting->invoices_id }}" id="flexCheckDefault[{{ $count }}]"></td>
                            </tr>	
							
						
						
				@php
							$ittotal_bill=$invoice_posting->total_bill+$ittotal_bill;
						
							
							$icollection_amnt=$invoice_posting->collection_amnt+$icollection_amnt;
						
							
							$idiscount_amnt=$invoice_posting->discount_amnt+$idiscount_amnt;
					
							
							$idue_amnt=$invoice_posting->due+$idue_amnt;
						
							
							$customers_id=$invoice_posting->customers_id;
                @endphp
				
				@endforeach  
				
		@php	echo "<TR bgcolor=\"#a7e4ff\">
			  <td align='right' colspan='6'><font color='#000000' face='Verdana' size='1' > <b>Sub Total</font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$ittotal_bill </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$icollection_amnt </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$idiscount_amnt </font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$idue_amnt </font></td>
			</TR>";
			 @endphp
                    </tbody>
                </table>
						<div class="col-sm-4">
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="costcenter_id" name="costcenter_id">
                                <option value="-1" selected>Select a Cost Center</option>
                                @foreach ($costcenters as $costcenter)
                                    <option {{ $selectedcostcenter==$costcenter->id? 'selected' : '' }} value="{{ $costcenter->id }}">{{ $costcenter->description }} </option>
                                @endforeach                   
                            </select>
                        </div>
        </div>
					
				<div class="col-sm-12 form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();">Submit</button>
                 </div>
	
            </div>
            </div>
		</form>
        </div>
 
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
			
					$('#branch_id').on('select2:select', function (e) {
                var data = e.params.data;
                console.log(data);

                const branchID = data.id;


                // Your JSON data
                const jsonData = { branchID: branchID };

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
                fetch(`{{ url('getCustomerByBranch') }}`, options)
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
                    var select = document.getElementById("customer_id");
                    select.innerHTML = "";
                    var option = new Option(data.text, data.id, true, true);
                    option.text = "Select a Customer";
                    option.value = -1;
                    select.append(option);
                    for(prod of data.data)
                    {
                        var option = new Option(data.text, data.id, true, true);
                        option.text = prod.customer_name;
                        option.value = prod.id;
                        var select = document.getElementById("customer_id");
                        select.append(option);
                    }
                    $('#customer_id').val('-1'); 
                        
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Fetch error:', error);
                });

            });	
			
			
        });
		
		   document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.checkbox-to-select');

        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                }
            });
        });
    });
    </script>
@endsection