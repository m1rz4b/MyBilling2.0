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
                    <h5 class="mb-0 text-white text-center">Vendor Master Client Informaiton</h5>
                </div>
            </div>

            <form action="{{ route('vendormasterclient.show') }}" method="get">
			
                @csrf
                <div class="m-3">
                    <div class="row mb-3">

                  <div class="col-sm-3">
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


					<div class="col-sm-3">
					<label class="fw-medium" for="end_date" class="form-label">Package</label>
                        <div class="input-group input-group-sm flex-nowrap">
                            <select class="select2 form-select form-select-sm" id="package" name="package">
                                <option value="-1" selected>Select a Package</option>
                                @foreach ($clienttypes as $clienttype)
                                    <option {{ $selectedPackage==$clienttype->id? 'selected' : '' }} value="{{ $clienttype->id }}">{{ $clienttype->name }} </option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>
				<div class="col-sm-3">
				<label class="fw-medium" for="end_date" class="form-label">Status</label>
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
					<h5 class="mb-0 text-center">Vendor Master Client Informaiton</h5>
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
        <th>User ID</th>        
        <th>Client Name</th>
        <th>Zone</th>
        <th>Mobile</th>
        <th>Address</th>
        <th>Bill Start Date</th>        
        <th>Client Status</th>
			  
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($block_list as $block)
                        <tr>
                            <td>{{ $count++ }}</td>
                           <td>{{ $block->account_no }}</td>
                            <td>{{ $block->user_id }}</td>
                            <td>{{ $block->customer_name }}</td>
                            <td>{{ $block->zone_name }}</td>
                            <td>{{ $block->mobile1 }}</td>
                            <td>{{ $block->present_address }} </td>
                            <td>{{ $block->start_date }}</td>
							<td>{{ $block->inv_name }}</td> 
                         
						 
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