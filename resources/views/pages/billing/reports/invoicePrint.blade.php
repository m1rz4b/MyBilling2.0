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
                    <h5 class="mb-0 text-white text-center">Invoice Print</h5>
                </div>
            </div>

            <form action="{{ route('invoiceprint.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					 <div class="col-sm-3 form-group">
                    
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


                <div class="col-sm-3 form-group">
                 
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
                            <select name="invoice_cat" id="invoice_cat" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Invoice Type</option>
                                @foreach ($invoicecategorys as $invoicecategory)
                   <option {{ $selectedInvoiceCat==$invoicecategory->id? 'selected' : '' }} value="{{ $invoicecategory->id }}">{{ $invoicecategory->invoice_type_name }}</option>
                                @endforeach
                            </select>
							
                        </div>
                  <div class="col-sm-3">
                            <select name="customer" id="customer" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Client</option>
                                @foreach ($customers as $customer)
                                    <option {{ $selectedCustomer==$customer->id? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
							
                        </div>
						



                        <div class="col-sm-3">
                            <button type="button" class="btn btn-sm btn-primary me-2"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                            <a class="btn btn-warning btn-sm text-white me-2" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Print</a>
                            <a class="btn btn-success btn-sm"><i class="fa-regular fa-file-excel me-1"></i>Excel</a>
                        </div>
                    </div>
                </div>
            </form>
					<div class="px-4 py-1">
                    <h3 class="mb-0 text-center">Millennium Computers And Networking</h3>
					<h5 class="mb-0 text-center">11/1,Rambabu Road, Alimun Plaza( 1st Floor),</h5>
					<h5 class="mb-0 text-center">Mymensingh-2200,Bangladesh.t</h5>
					<h5 class="mb-0 text-center">Phone +8809666747474, Tel: + 88091-64234,Mob:+8801881010100</h5>
					<h5 class="mb-0 text-center">www.mcnbd.com</h5>
               </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
                @endphp

		    @foreach ($client_list as $client)
				@foreach ($invoice_header as $inv_header)
				
		<table cellpadding="0" border="0" width="100%"  >
    	<thead>
        	<tr>
            	<td colspan="1" valign="middle" style="font-weight:bold; text-align:center;  width: 100%;"><h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INVOICE</h2></td> <br><br>
            </tr>
			  <tr>
                 <?php 
					$home_url = 'http://' . $_SERVER['HTTP_HOST'] ;
				?>
                <td  colspan="1" align="right" style="text-align:right; width: 50%;"><img src="<?php echo $home_url;?>/mcnbd/upload/mililogo.png" alt="" class="img-responsive pull-right" ></td>
            </tr>
        </thead>
		</table>
		<table cellpadding="0" border="0" width="100%"  >
		 <tbody>
        	<tr>
					<td style="width: 70%;"><span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Bill To:</span><br>
                   	<span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Customer ID:</span>	{{ $inv_header->user_id }}<br>
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Company / Client Name:</span>	{{ $inv_header->customer_name }}<br>
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Address:</span>	{{ $inv_header->present_address }}<br> 
					<span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Mobile:</span>	{{ $inv_header->mobile1 }}<br>   
                    </td>
                <td style="width: 30%;"><span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Billing Statement</span><br>		
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Invoice #:</span> {{ $client->inv_number }}<br>		
              <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Invoice Date:</span> {{ date('d F Y',strtotime($client->invoice_date)) }}<br>		
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Invoice Period:</span> {{ date('d F Y',strtotime($client->invoice_date)) }} <br>		
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Payment Due Date:</span>	{{ date('15 F Y',strtotime($client->invoice_date)) }}<br>
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">VAT Reg No:</span>{{ $inv_header->status_name }}	<br>		
                </td>
            </tr>
            <tr>
            	<td colspan="2" style=" width: 100%;">&nbsp;</td>
            </tr>
           </table>
		<table cellpadding="0" border="0" width="100%"  >
		 <tbody> 
                    	<tr bgcolor="#DAEEF3">
                        	<th style="padding:3px; width: 25%;">Invoice Date </th>
                        	<th style="padding:3px; width: 25%;">Invoice Type</th>
                            <th style="padding:3px; width: 25%;">Invoice For</th>          		
                        	<th style="padding:3px; width: 20%;">Amount(BDT)</th>
                        </tr>
						<tr>
                        	<td style="padding:3px; width: 25%;">{{ $client->invoice_date }}	 </td>
                        	<td style="padding:3px; width: 25%;">{{ $client->invoice_type_name }}	</td>
                            <td style="padding:3px; width: 25%;">{{ $client->billing_year }}	</td>          		
                        	<td style="padding:3px; width: 20%;">{{ $client->total_bill }}	</td>
                        </tr>
					</tbody>
        
				</table>	
				<br><br><br><br><br><br>
							<div class="py-1">
							<h5 class="mb-0 text-left">Millennium Computers And Networking</h5>
							<h5 class="mb-0 text-left">Signature- Billing Department	</h5>
							<h5 class="mb-0 text-left">Millennium Computers and Network</h5>
							<h5 class="mb-0 text-left">Phone:- 09666-747474</h5>
							<h5 class="mb-0 text-left">Address:- Ram Babu Rd, Mymensingh</h5>
   
							</div>
	 @endforeach  
 @endforeach  	 
	
	
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