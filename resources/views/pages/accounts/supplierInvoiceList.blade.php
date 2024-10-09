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
                    <h5 class="mb-0 text-white text-center">Supplier Invoice List</h5>
                </div>
            </div>

            <form action="{{ route('supplierinvoicelist.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					 <div class="col-sm-3 form-group">
                        <label class="fw-medium" for="start_date" class="form-label">From</label>
                        <input class="form-control input_form datepicker-here digits" name="start_date" id="start_date" data-date-Format="yyyy-mm-dd" value="{{ $start_date }}" placeholder="Start date">
                    </div>
                    <div class="col-sm-3 form-group">
                        <label class="fw-medium" for="end_date" class="form-label">To</label>
                        <input class="form-control input_form datepicker-here digits" name="end_date" id="end_date" data-date-Format="yyyy-mm-dd" value="{{ $end_date }}" placeholder="End date">
                    </div>

                  <div class="col-sm-3">
				     <label class="fw-medium" for="start_date" class="form-label">Supplier</label>
				    <div class="input-group input-group-sm flex-nowrap">
                            <select name="supplier" id="supplier" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ $selectedSupplier==$supplier->id? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->clients_name }}</option>
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
					<h5 class="mb-0 text-center">Supplier Invoice List</h5>
					<h5 class="mb-0 text-center">From  {{ $start_date}} To {{ $end_date}}</h5>
					
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$tbill_amount=0;
					$tvat=0;
					$ttotal_amount=0;
		           @endphp




                <table class="table table-responsive">
                    <thead>
                        <tr>
						
					<th>SL.</th>
					<th>Client Name</th>
                    <th>Date</th>
					<th>Invoice No</th>
					<th>Product</th>
					<th align='right'>Bill Price</th>
					<th align='right'>VAT</th>
					<th align='right'>Total</th>  
                        </tr>
                    </thead>
                    <tbody>
							
                        @foreach ($supplierinvoices as $supplierinvoice)
					@php
							$tbill_amount=$supplierinvoice->bill_amount+$tbill_amount;
							$tvat=$supplierinvoice->vat+$tvat;							
							$ttotal_amount=$supplierinvoice->total_bill+$ttotal_amount;
						
					@endphp
			   
							<tr>
                            <td>{{ $count++ }}</td>
							<td>{{ $supplierinvoice->clients_name }}</td>
                            <td>{{ $supplierinvoice->invoice_date }}</td>
							<td>{{ $supplierinvoice->invoice_number }}</td>
                            <td align='right'>{{ $supplierinvoice->invoice_number }}</td>
                            <td align='right'>{{ $supplierinvoice->bill_amount }}</td>
                            <td align='right'>{{ $supplierinvoice->vat }} </td>
							 <td align='right'>{{ $supplierinvoice->total_bill }} </td>
                        </tr>	
							
		
				
				
				@endforeach  
				
			<TR bgcolor=\"#a7e4ff\">
			  <td align='right' colspan='5'><font color='#000000' face='Verdana' size='1' > <b>Total</font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $tbill_amount; ?> </font></td>
			   <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $tvat; ?> </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $ttotal_amount; ?>  </font></td>
			</TR>
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