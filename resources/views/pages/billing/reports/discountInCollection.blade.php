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
                    <h5 class="mb-0 text-white text-center">Daily Bill Collection</h5>
                </div>
            </div>

            <form action="{{ route('discountincollection.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					 <div class="col-sm-2 form-group">
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="day" name="day">
						<option>Select Day</option>                           
						   @foreach(range(1,31) as $day)
                                <option {{ $start_day==$day? 'selected' : '' }} value="{{ $day }}">
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
				<div class="col-sm-2 form-group">
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
						<option>Select Month</option>                           
						   @foreach(range(1,12) as $month)
                                <option {{ $start_month==$month? 'selected' : '' }} value="{{ $month }}">
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
                            <option>Select Year</option>
                            @foreach (range(now()->year - 10, now()->year + 5) as $year)
                                <option {{ $start_year==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                  <div class="col-sm-4">
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
					<h5 class="mb-0 text-center">Daily Bill Collection</h5>
					<h5 class="mb-0 text-center">For The Date of {{ $start_day}} - {{ $start_month}} - {{ $start_year}}</h5>
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
                @endphp


                <table class="table table-responsive">
                    <thead>
                        <tr>
						
			<th> SL.</th>
		  <th>Client Id </th>
		  <th>Clients Name </th>
		  <th> Money Rec. No.</th>
		  <th> Arrier(BDT)</th>
		  <th> Current(BDT)</th>
		  <th> Advanced Rec(BDT)</th>
		  <th> Total(BDT) </th>
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cust_invoices as $cust_invoice)
                        <tr>
                            <td>{{ $count++ }}</td>
                           <td>{{ $cust_invoice->user_id }}</td>
                            <td>{{ $cust_invoice->customer_name }}</td>
                            <td>{{ $cust_invoice->money_receipt }}</td>
                            <td>{{ $cust_invoice->ccollamnt }}</td>
                            <td>{{ $cust_invoice->qcollamnt }}</td>
                            <td>{{ $cust_invoice->ad + $cust_invoice->adnormal }} </td>
                            <td>{{ $cust_invoice->ccollamnt + $cust_invoice->qcollamnt + $cust_invoice->dcollamnt }}</td>
                          
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