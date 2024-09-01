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
    
    <div class="main_content_iner mt-0">
        
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white text-center">Client Ledger</h5>
                </div>
            </div>

            <form action="{{ route('clientledger.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					 <div class="col-sm-2 form-group">
                    
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
						<option>Month</option>                           
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
                            <option>Year</option>
                            @foreach (range(now()->year - 10, now()->year + 5) as $year)
                                <option {{ $invoiceYear==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
				 <div class="col-sm-2 form-group">
                    
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="tmonth" name="tmonth">
						<option>Month</option>                           
						   @foreach(range(1,12) as $month)
                                <option {{ $invoiceTmonth==$month? 'selected' : '' }} value="{{ $month }}">
                                    {{ date("M", mktime(0, 0, 0, $month, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="col-sm-2 form-group">
                 
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="tyear" name="tyear" >
                            <option>Year</option>
                            @foreach (range(now()->year - 10, now()->year + 5) as $year)
                                <option {{ $invoiceTyear==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
								
                            @endforeach
                        </select>
                    </div>
                </div>

                        <div class="col-sm-4">
                            <select name="customer" id="customer" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Client</option>
                                @foreach ($customers as $customer)
                                    <option {{ $selectedCustomer==$customer->id? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
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
					<h5 class="mb-0 text-center">Client Ledger</h5>
					<h5 class="mb-0 text-center">From  {{ $invoiceMonth}} - {{ $invoiceYear}} To {{ $invoiceTmonth}} - {{ $invoiceTyear}}  </h5>
                </div>
				

            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
                @endphp

                <table class="table table-responsive">
                    <thead>
                        <tr>
						
					<th style="width: 82px;">Date</th>
                    <th>Inv Number</th>
                    <th>Money Rec No</th>
					<th>Inv. type</th>					
					<th width="150">Billing Period</th>
                    <th style="width:200px;">Products</th>                    
                    <th style="width: 242px;">Col.Remarks</th>
                    <th>Package</th>
					<td align="right"><strong>Invoice Amnt.</strong></td>
					<td align="right"><strong>Collected Amnt.</strong></td>
					<td align="right"><strong>Vat Adj.</strong></td>
                    <td align="right"><strong>AIT Adj.</strong></td>
					<td align="right"><strong>Discount</strong></td>
                    <td align="right"><strong>D.T Adj.</strong></td>
					<td align="right"><strong>Balance</strong></td>
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cust_invoices as $cust_invoice)
                        <tr>
                            <td>{{ $cust_invoice->orderdate }}</td>
                            <td>{{ $cust_invoice->invoice_number }}</td>
							 <td>{{ $cust_invoice->money_receipt }}</td>
                            <td>{{ $cust_invoice->invtype }}</td>
                            <td>{{ $cust_invoice->month.' - '.$cust_invoice->year}}</td>
                            <td>	Bandwidth Bill</td>
							<td>{{ $cust_invoice->collection_remarks }}</td>
                            <td>{{ $cust_invoice->package }}</td>
                            <td>{{ $cust_invoice->total }}</td>
                            <td>{{ $cust_invoice->ctotal }}</td>
							 <td>{{ $cust_invoice->vat_adjust_ment }}</td>
                            <td>{{ $cust_invoice->ait_adjustment }}</td>
                            <td>{{ $cust_invoice->discoun_amnt }}</td>
							<td>{{ $cust_invoice->downtimeadjust }}</td> 
							<td>{{ $cust_invoice->total }}</td>
                        </tr>
                        @endforeach               
                    </tbody>
                </table>
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