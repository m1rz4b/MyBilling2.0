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
                    <h5 class="mb-0 text-white text-center">Discount In Collection</h5>
                </div>
            </div>

            <form action="{{ route('discountincollection.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					
                    <div class="col-sm-3 form-group">
                        <label class="fw-medium" for="start_date" class="form-label">From</label>
                        <input class="form-control input_form datepicker-here digits" name="start_date" id="start_date" data-date-Format="yyyy-mm-dd" value="{{ $nowdate }}" placeholder="Start date">
                    </div>
                    <div class="col-sm-3 form-group">
                        <label class="fw-medium" for="end_date" class="form-label">To</label>
                        <input class="form-control input_form datepicker-here digits" name="end_date" id="end_date" data-date-Format="yyyy-mm-dd" value="{{ $nowdate }}" placeholder="End date">
                    </div>

                  <div class="col-sm-2 form-group">
				  	<label class="fw-medium" for="start_date" class="form-label">Zone</label>
				    <div class="input-group input-group-sm flex-nowrap">
                          <select name="zone" id="zone" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Zone</option>
                                @foreach ($zones as $zone)
                                    <option {{ $selectedZone==$zone->id? 'selected' : '' }} value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                @endforeach
                            </select>
                     </div>
                   </div>

                    <div class="col-sm-2 form-group">
					<label class="fw-medium" for="start_date" class="form-label">Branch</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="branch" name="branch">
                                <option value="-1" selected>Select a Branch</option>
                                @foreach ($branches as $branch)
                                    <option {{ $selectedBranch==$branch->id? 'selected' : '' }} value="{{ $branch->id }}">{{ $branch->name }} </option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>
                        <div class="col-sm-2">
						  <label class="fw-medium" for="start_date" class="form-label">Category</label>
                            <select name="client_category" id="client_category" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Category</option>
                                @foreach ($client_category as $category)
								<option {{ $selectedcategory==$category->id? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }} </option>
								</option>
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
					<h5 class="mb-0 text-center">Discount In Collection</h5>
					<h5 class="mb-0 text-center">From {{$start_date}} To {{$end_date}}</h5>
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$ttotal= 0;
                @endphp


                <table class="table table-responsive">
                    <thead>
                        <tr>
			<th>Sl</th>
        <th>Client ID</th>
        <th>Client Name</th>
        <th>Date</th>
        <th>MR NO</th>
         <th align="right">Discount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cust_invoices as $cust_invoice)
                        <tr>
                            <td>{{ $count++ }}</td>
                           <td>{{ $cust_invoice->user_id }}</td>
                            <td>{{ $cust_invoice->customer_name }}</td>
                            <td>{{ $cust_invoice->advrec_date }}</td>
                            <td>{{ $cust_invoice->money_receipt }}</td>
							<td align="right">{{ $cust_invoice->discoun_amnt }}</td>
                            </tr>
							@php
							$ttotal=$cust_invoice->discoun_amnt+$ttotal;
							
							@endphp
				
                        @endforeach 
<tr>
	<td colspan="5" align="right"> <strong>Total</strong></td>
	<td align="right"> <strong><?php echo number_format($ttotal,2);?></strong></td>
</tr>
						
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