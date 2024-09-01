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
                    <h5 class="mb-0 text-white text-center">Monthly Invoice</h5>
                </div>
            </div>

            <form action="{{ route('collectionsummery.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					 <div class="col-sm-4 form-group">
                    
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


                <div class="col-sm-4 form-group">
                 
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
					<h5 class="mb-0 text-center">Monthly Invoice</h5>
					<h5 class="mb-0 text-center">For The Month of {{ $invoiceMonth}} - {{ $invoiceYear}}</h5>
                </div>

            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
                @endphp

                <table class="table table-responsive">
                    <thead>
                        <tr>
						
					<th>SL.</th>
					<th>Collection Date</th>
                    <td align="right"><strong>Arrier(BDT)</strong></td>
					<td align="right"><strong>Current(BDT</strong>)</td>
					<td align="right"><strong>Advanced Rec(BDT)</strong></td>
					<td align="right"><strong>Total(BDT)</strong></td>
		
		
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cust_invoices as $cust_invoice)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $cust_invoice->collection_date }}</td>
                            <td align="right">{{ $cust_invoice->tcc }}</td>
                            <td align="right">{{ $cust_invoice->tcq }}</td>
                            <td align="right">{{ $cust_invoice->tcd }}</td>
                            <td align="right">{{ $cust_invoice->tcc + $cust_invoice->tcq + $cust_invoice->tcd }}</td>
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