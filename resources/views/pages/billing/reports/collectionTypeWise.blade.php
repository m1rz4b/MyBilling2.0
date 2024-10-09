@extends('layouts.main')

@section('main-container')
    <style>gttotal_bill
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
                    <h5 class="mb-0 text-white text-center">Collection Type Wise</h5>
                </div>
            </div>

            <form action="{{ route('collectiontypewise.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					
					 <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="start_date" class="form-label">From</label>
                        <input class="form-control input_form datepicker-here digits" name="start_date" id="start_date" data-date-Format="yyyy-mm-dd" value="{{ $start_date }}" placeholder="Start date">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="end_date" class="form-label">To</label>
                        <input class="form-control input_form datepicker-here digits" name="end_date" id="end_date" data-date-Format="yyyy-mm-dd" value="{{ $end_date }}" placeholder="End date">
                    </div>


                  <div class="col-sm-4">
				  <label class="fw-medium" for="end_date" class="form-label">Zone</label>
				  
				    <div class="input-group input-group-sm flex-nowrap">
                            <select name="zone" id="zone" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Zone</option>
                                @foreach ($zones as $zone)
                                    <option {{ $selectedZone==$zone->id? 'selected' : '' }} value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                @endforeach
                            </select>
                     </div>
                   </div>

                    <div class="col-sm-4">
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="branch" name="branch">
                                <option value="-1" selected>Select a Branch</option>
                                @foreach ($branches as $branch)
                                    <option {{ $selectedBranch==$branch->id? 'selected' : '' }} value="{{ $branch->id }}">{{ $branch->name }} </option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>
                        <div class="col-sm-4">
                            <select name="client_category" id="client_category" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Client Category</option>
                                @foreach ($client_category as $category)
								<option {{ $selectedcategory==$category->id? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }} </option>
								</option>
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
					<h5 class="mb-0 text-center">Collection Type Wise</h5>
					<h5 class="mb-0 text-center">Date From {{ $start_date}} To {{ $end_date}}</h5>
					
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$gccollamnt=0;
					$gqcollamnt=0;
					$gdcollamnt=0;
					$gcollamnt=0;
					
					$customers_id=0;
                @endphp


                <table class="table table-responsive">
                    <thead>
                        <tr>
						
			<th > SL.</th>
		  <th >Client Id</th>
		  <th >Clients Name</th>		  
		  <th>Money Rec. No.</th>
		  <th> Bank Name</th>
		  <th> Cheque No.</th>		  
		  <th>Cash(BDT)</th>
		  <th>Cheque(BDT)</th>
		  <th>Deposit(BDT)</th>
          <th>Total(BDT)</th>
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection_lists as $collection_list)
				
			
							<tr>
                            <td>{{ $count++ }}</td>
                           <td>{{ $collection_list->user_id }}</td>
                            <td>{{ $collection_list->customer_name }}</td>
                            <td>{{ $collection_list->money_receipt }}</td>
                            <td>{{ $collection_list->bank_name }}</td>
                            <td>{{ $collection_list->cheque_no }}</td>
                            <td align='right'>{{ $collection_list->ccollamnt }} </td>
							 <td align='right'>{{ $collection_list->qcollamnt }} </td>
							  <td align='right'>{{ $collection_list->dcollamnt }} </td>
                            <td align='right'>{{ $collection_list->collamnt }}</td>
                            </tr>	
							
				@php

							$gccollamnt=$collection_list->ccollamnt+$gccollamnt;
							$gqcollamnt=$collection_list->qcollamnt+$gqcollamnt;
							$gdcollamnt=$collection_list->dcollamnt+$gdcollamnt;
							$gcollamnt=$collection_list->collamnt+$gcollamnt;
							
							$customers_id=$collection_list->customers_id;
                @endphp
				
				@endforeach  
				
		@php			
				echo "<TR bgcolor=\"#ffe392\">
			  <td align='right' colspan='6'><font color='#000000' face='Verdana' size='1' > <b>Grand Total</font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$gccollamnt </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$gqcollamnt </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$gdcollamnt </font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$gcollamnt </font></td>
			</TR>";
			 @endphp
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