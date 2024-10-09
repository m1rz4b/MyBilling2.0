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
    	  <div>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible my-1" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible my-1" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            @foreach($errors->all() as $error)
            <strong>Error !</strong> {{ $error }}
            @endforeach
        </div>
    @endif
  </div>
  
  
    <div class="main_content_iner mt-0">
        
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white text-center">Journal</h5>
                </div>
            </div>

            <form action="{{ route('journal.show') }}" method="get">
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
				     <label class="fw-medium" for="start_date" class="form-label">Journal Type</label>
				    <div class="input-group input-group-sm flex-nowrap">
                            <select name="gl_types" id="gl_types" class="select2 form-select form-select-sm form-control">
                               <option value=''>Select Type</option>
										<option value='REC'>REC</option>
										<option value='PAY'>PAY</option>
										<option value='JV'>JV</option>
										<option value='TR'>TR</option>
                            </select>
                     </div>
                   </div>
				   
				   
                  <div class="col-sm-3">
				     <label class="fw-medium" for="start_date" class="form-label">Account Head</label>
				    <div class="input-group input-group-sm flex-nowrap">
                            <select name="gl_codes" id="gl_codes" class="select2 form-select form-select-sm form-control">
                                <option value="-1">Select an Account Head</option>
                                @foreach ($glcodes as $glcode)
                                    <option value="{{ $glcode->gl_code }}">{{ $glcode->description }} </option>
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
					<h5 class="mb-0 text-center">Journal For {{ $glcodeName }}</h5>
					<h5 class="mb-0 text-center">From  {{ $start_date}} To {{ $end_date}}</h5>
					
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$opencashdr = 0;
					$opencashcr = 0;
					$openbankdr= 0;
					$openbankcr= 0;
		           @endphp


                <table class="table table-responsive">
                    <thead>
                     <tr>
					<th rowspan='2'>Entry No</th>
					<th rowspan='2'>Type</th>
                    <th rowspan='2'>Date</th>
					<th rowspan='2' align='center'>Description</th>
					<th rowspan='2' align='center'>JV For</th>
					<th colspan='2'>Period Transaction</th>
                     </tr>
					 <tr>
					<th align='right'>Debit</th>
					<th align='right'>Credit</th>
				     </tr>
 
 
                    </thead>
                    <tbody>		
						
			@php
			$Total_dr=0;
			$Total_cr=0;

			$BlDrAmount=0;
			$BlCrAmount=0;
			$MasterBalance=0;

			@endphp

                @foreach ($masjournals as $masjournal)
				
			@php
					$DrAmount = $masjournal->DrAmount;
					$CrAmount = $masjournal->CrAmount;
					$ttype = $masjournal->ttype;
					$CrAmount = $masjournal->CrAmount;
			
			
				$Total_dr=$Total_dr+$DrAmount;
				  $Total_cr=$Total_cr+$CrAmount;

				  if(strcmp($ttype,"Dr")==0)
				  {
						$MasterBalance=$MasterBalance+$masjournal->amount;
				  }
				  else
				  {
						$MasterBalance=$MasterBalance-$masjournal->amount;
				  }


				  //////////////////////////////////////////
				  if($MasterBalance>0)
				  {
						$BlDrAmount=$MasterBalance;
						$BlCrAmount=0;
				  }
				  else if($MasterBalance<0)
				  {
						$BlCrAmount=$MasterBalance*-1;
						$BlDrAmount=0;
				  }
				  else
				  {
						$BlDrAmount=0;
						$BlCrAmount=0;
				  }
		@endphp
							<tr>
                            <td>{{ $masjournal->journalno }}</td>
							 <td>{{ $masjournal->journaltype }}</td>
                            <td>{{ $masjournal->journaldate }}</td>
							<td > {{ $masjournal->description  }}</td>
                            <td align='right'>{{ $masjournal->customer_name  }} {{ $masjournal->employee  }} {{ $masjournal->supplier  }}</td>
                            <td align='right'>{{ $DrAmount  }}</td>
                            <td align='right'>{{ $CrAmount  }} </td>
                        </tr>		
				@endforeach 
		
		
				
				
				
			<TR bgcolor=\"#a7e4ff\">
			  <td align='right' colspan='5'><font color='#000000' face='Verdana' size='1' > <b>Total</font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $Total_dr; ?> </font></td>
			   <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $Total_cr; ?> </font></td>

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