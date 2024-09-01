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
                    <h5 class="mb-0 text-white text-center">Client List</h5>
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
                                <option value="-1">Select a Category</option>
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
                    <h5 class="mb-0 text-center">Millennium Computers And Networking</h5>
					<h5 class="mb-0 text-center">Client List</h5>
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
                @endphp


    	<thead>
        	<tr>
            	<td  align="left"  valign="middle" style="font-weight:bold;  width: 50%;"><h1> INVOICE</h1></td>
                <?php 
					$home_url = 'http://' . $_SERVER['HTTP_HOST'] ;
				?>
                <td  align="right" style="text-align:right; width: 50%;"><img src="<?php echo $home_url;?>/mcnbd/upload/mililogo.png" alt="" class="img-responsive pull-right" ></td>
            </tr>
        </thead>
		 <tbody>
		    @foreach ($client_list as $client)
		 <tr>
            	<td colspan="2" style="width: 50%;">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="2" style="width: 50%;">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="2" style="width: 50%;">&nbsp;</td>
            </tr>
        	<tr>
            	<td style="width: 50%;"><span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Bill To:</span><br>
                   	<span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Customer ID:</span>	{{ $client->billing_year }}<br>
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Company / Client Name:</span>	{{ $client->billing_year }}<br>
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Address:</span>	{{ $client->billing_year }}<br>                     <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Mobile:</span>	{{ $client->billing_year }}<br>   
                    
                    </td>
                <td style="width: 50%;"><span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Billing Statement</span><br>		
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Invoice #:</span> APCL/{{ $client->billing_year }}<br>		
                   	<span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Invoice Date:</span> {{ $client->billing_year }}<br>		
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Invoice Period:</span> {{ $client->billing_year }} <br>		
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">Payment Due Date:</span>	{{ $client->billing_year }}<br>
                    <span style="font-weight:bold; font-size:14px; color:rgba(71,71,71,1.00)">VAT Reg No:</span>{{ $client->billing_year }}	<br>		
                </td>
            </tr>
           
           
            <tr>
            	<td colspan="2" style=" width: 100%;">&nbsp;</td>
            </tr>
            
            
           
            
            <tr> <!--payment start-->
            	<td colspan="2" style="width: 100%;">
                	<table cellspacing="2" cellpadding="0" border="0" width="100%"  >
                    	
                    	<tr bgcolor="#DAEEF3">
                        	<th style="padding:3px; width: 20%;">User Id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        	<th style="padding:3px; width: 20%;">Month&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th style="padding:3px; width: 20%;">Invoice Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>          		
                        	<th style="padding:3px; width: 20%;">Invoice For&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>                        	
                            <th align="right" style="padding:3px; text-align:right;  width: 20%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amount(BDT)</th>
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