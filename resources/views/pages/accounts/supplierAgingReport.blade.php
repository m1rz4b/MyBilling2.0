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
                    <h5 class="mb-0 text-white text-center">Aging Report</h5>
                </div>
            </div>

            <form action="{{ route('supplieragingreport.show') }}" method="get">
                @csrf
                <div class="m-3">
				
                    <div class="row mb-3">
					<div class="col-sm-4 form-group">
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
						<option>Select A Month</option>                           
						   @foreach(range(1,12) as $month)
                                <option {{ $cboMonth==$month? 'selected' : '' }} value="{{ $month }}">
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
                                <option {{ $cboYear==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
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
					<h5 class="mb-0 text-center">Supplier Aging Report</h5>
					<h5 class="mb-0 text-center">Upto  {{ $cboMonth}} - {{ $cboYear}}</h5>
					
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$tdues1=0;
					$tdues2=0;
					$tdues3=0;
					$tdues4=0;
					$trutern=0;
					$trdues=0;
					$rdues = 0;

		           @endphp




                <table class="table table-responsive">
                    <thead>
                        <tr>
						
					<th>SL.</th>
					<th>Name</th>
                    <th align='right'>Month {{ $cboMonth }}, {{ $cboYear }}</th>
					<th align='right'>30 days  </th>
					<th align='right'>60 days </th>
					<th align='right'>over 60 days</th>
					<th align='right'>Purchase Returns</th>
					<th align='right'>Total</th>
	  
                    </tr>
                    </thead>
                    <tbody>
					
							
                        @foreach ($due_lists as $due_list)
					@php
							$rdues=($due_list->dues1+$due_list->dues2+$due_list->dues3+$due_list->dues4)-$due_list->rutern;
							$tdues1=$due_list->dues1+$tdues1;
							$tdues2=$due_list->dues2+$tdues2;							
							$tdues3=$due_list->dues3+$tdues3;
							$tdues4=$due_list->dues4+$tdues4;
							$trutern=$due_list->rutern+$trutern;
							$trdues=$rdues+$trdues;
						
					@endphp
			   
							<tr>
                            <td>{{ $count++ }}</td>
							<td>{{ $due_list->clients_name }}</td>
                            <td align='right'>{{ $due_list->dues1 }}</td>
							<td align='right'>{{ $due_list->dues2 }}</td>
                            <td align='right'>{{ $due_list->dues3 }}</td>
                            <td align='right'>{{ $due_list->dues4 }}</td>
                            <td align='right'>{{ $due_list->rutern }} </td>
							 <td align='right'>{{ $rdues }} </td>
                        </tr>	
							
	
	
				
				@endforeach  
				
			<TR bgcolor=\"#a7e4ff\">
			  <td align='right' colspan='2'><font color='#000000' face='Verdana' size='1' > <b>Total</font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $tdues1; ?> </font></td>
			   <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $tdues2; ?> </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $tdues3; ?>  </font></td>
			    <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $tdues4; ?>  </font></td>
				  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $trutern; ?>  </font></td>
				    <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $trdues; ?>  </font></td>
			  
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