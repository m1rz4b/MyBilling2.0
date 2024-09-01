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

            <form action="{{ route('rptclientlist.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					
                        <div class="col-sm-3">
                            <select name="client_category" id="client_category" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select a Client Category</option>
                                @foreach ($client_category as $category)
								<option {{ $selectedcategory==$category->id? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }} </option>
								</option>
                                @endforeach
                            </select>
                        </div>
                  <div class="col-sm-3">
				    <div class="input-group input-group-sm flex-nowrap">
                            <select name="zone" id="zone" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Zone</option>
                                @foreach ($zones as $zone)
                                    <option {{ $selectedZone==$zone->id? 'selected' : '' }} value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                @endforeach
                            </select>
                     </div>
                   </div>

                    <div class="col-sm-3">
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="branch" name="branch">
                                <option value="-1" selected>Select a Branch</option>
                                @foreach ($branches as $branch)
                                    <option {{ $selectedBranch==$branch->id? 'selected' : '' }} value="{{ $branch->id }}">{{ $branch->name }} </option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>
					<div class="col-sm-3">
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="package" name="package">
                                <option value="-1" selected>Select a Package</option>
                                @foreach ($clienttypes as $clienttype)
                                    <option {{ $selectedBranch==$clienttype->id? 'selected' : '' }} value="{{ $clienttype->id }}">{{ $clienttype->name }} </option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>
				<div class="col-sm-3">
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="customer_status" name="customer_status">
                                <option value="-1" selected>Select a Status</option>
                                @foreach ($status_types as $status_type)
                                    <option {{ $selectedCustomerStatus==$status_type->id? 'selected' : '' }} value="{{ $status_type->id }}">{{ $status_type->inv_name }} </option>
                                @endforeach                   
                            </select>
                        </div>
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


                <table class="table table-responsive">
                    <thead>
                        <tr>
						
		<th>Sl</th>
        <th>Account No</th>        
        <th>Client Name</th>
        <th>IP Address</th>
        <th>Address</th>
        <!--th>Email</th-->
        <th>Bill Start Date</th>        
        <th>Pakage Type</th>
        <th>Rate</th>        
        <th>Total Bill</th>
        <th>Total Collection</th>
        <th>Total Dues</th>
        <th>Client Status</th>
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client_list as $client)
                        <tr>
                            <td>{{ $count++ }}</td>
                           <td>{{ $client->account_no }}</td>
                            <td>{{ $client->customer_name }}</td>
                            <td>{{ $client->ip_number }}</td>
                            <td>{{ $client->present_address }}</td>
                            <td>{{ $client->start_date }}</td>
                            <td>{{ $client->clienttype }} </td>
                            <td>{{ $client->rate_amnt }}</td>
							 <td>{{ $client->cur_total }}</td>
							  <td>{{ $client->cur_collection }}</td> 
							  <td>{{ $client->cur_total - $client->cur_collection}}</td>
							   <td>{{ $client->inv_name }}</td>
                          
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