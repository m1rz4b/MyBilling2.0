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
                    <h5 class="mb-0 text-white text-center">Cash Book</h5>
                </div>
            </div>

            <form action="{{ route('cashbank.show') }}" method="get">
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
				     <label class="fw-medium" for="start_date" class="form-label">Cost Center</label>
				    <div class="input-group input-group-sm flex-nowrap">
                            <select name="cost_center" id="cost_center" class="form-select form-select-sm form-control">
                                <option value="-1">Select a Cost Center</option>
                                @foreach ($costcenters as $costcenter)
                                    <option {{ $selectedCostcenter==$costcenter->id? 'selected' : '' }} value="{{ $costcenter->id }}">{{ $costcenter->description }}</option>
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
					<h5 class="mb-0 text-center">Cash Book  {{ $CostcenterName }}</h5>
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
					<th rowspan='2'>Vouch. Date</th>
					<th rowspan='2'>Vr No.</th>
                    <th rowspan='2'>Type</th>
					<th rowspan='2' colspan='2' align='center'>Particulars</th>
					<th colspan='2' align='center'>Debit</th>
					<th colspan='2' align='center'>Credit</th>
					<th colspan='2'align='center'>Balance</th>
                     </tr>
					 <tr>
					<th align='right'>Cash</th>
					<th align='right'>Bank</th>
					<th align='right'>Cash</th>
                    <th align='right'>Bank</th>
					<th align='right'>Cash</th>
					<th align='right'>Bank</th>
				     </tr>
 
 
                    </thead>
                    <tbody>
					 @foreach ($queryopencash as $queryopencas)
				@php
							$opencashdr = $opencashdr + $queryopencas->DrCashAmount;
							$opencashcr = $opencashcr + $queryopencas->CrCashAmount;
							
				@endphp
					@endforeach  		
							
					@foreach ($queryopenbank as $queryopenban)
					@php
								$openbankdr = $openbankdr + $queryopenban->DrBankAmount;
								$openbankcr = $openbankcr + $queryopenban->CrBankAmount;
					@endphp
					@endforeach 		
						
			@php
							$opencdr=0;
							$openccr=0;
							$openbdr=0;
							$openbcr=0;
							$openbalancecash=0;
							$openbalancebank=0;
						$totalopencashdr = 0;
						$totalopencashcr = 0;
						$totalopenbankdr = 0;
						$totalopenbankcr = 0;
						$cashbalance = 0;
						$bankbalance = 0;
						$totalcashbalance = 0;
						$totalbankbalance = 0;

							if(($opencashdr-$opencashcr)>0)
							{
								  $opencdr=$opencashdr-$opencashcr;

							}
							else
								  $openccr=abs($opencashdr-$opencashcr);
							  
							if(($openbankdr-$openbankcr)>0)
							{
								  $openbdr=$openbankdr-$openbankcr;

							}
							else
								  $openbcr=abs($openbankdr-$openbankcr);


							$openbalancecash=$opencdr-$openccr;
							$openbalancebank=$openbdr-$openbcr;
							
						$totalopencashdr=$opencdr;
						$totalopencashcr=$openccr;
						$totalopenbankdr=$openbdr;
						$totalopenbankcr=$openbcr;
						$totalcashbalance=$openbalancecash;
						$totalbankbalance=$openbalancebank;
							echo "<tr>
                            <td>$start_date</td>
							<td colspan='4'>Opening Balance</td>
                            <td align='right'>$opencdr</td>
							<td align='right' >$openbdr</td>
							<td align='right'>$openccr</td>
							<td align='right'>$openbcr</td>
							<td align='right'>$openbalancecash</td>
							<td align='right'>$openbalancebank</td>
							</tr>"	
			@endphp

				   
                @foreach ($trnjournals as $trnjournal)
				
				@php
						$drcash=0.0;
						$drbank=0.0;
						$crcash=0.0;
						$crbank=0.0;
						$cashbalance=0.0;
						$bankbalance=0.0;

				
						$gl_code = $trnjournal->gl_code;
						$ttype = $trnjournal->ttype;
						$DrAmount = $trnjournal->DrAmount;
						$CrAmount = $trnjournal->CrAmount;
						
						$remarks = $trnjournal->remarks;
						$tremarks = $trnjournal->tremarks;
						$journaltype = $trnjournal->journaltype;
						if($journaltype=='Pay')
							{
									if($remarks==''){
									$particulars=$tremarks;
									}else{
									$particulars=$remarks;	
									}
							}else {
								$particulars=$remarks;	
							}
						
						
						if($gl_code=='10201' && $ttype=='Dr')
						{
						 $drcash=$DrAmount;
						}
						else if($gl_code=='10201' && $ttype=='Cr')
						{
						   $crcash=$CrAmount;
						}
						else if($gl_code=='10202' && $ttype=='Dr')
						{
						 $drbank=$DrAmount;
						}
						else if($gl_code=='10202' && $ttype=='Cr')
						{
						   $crbank=$CrAmount;
						}
						
				$totalopencashdr=$totalopencashdr+$drcash;
				$totalopencashcr=$totalopencashcr+$crcash;
				$totalopenbankdr=$totalopenbankdr+$drbank;
				$totalopenbankcr=$totalopenbankcr+$crbank;
				$cashbalance=$drcash-$crcash;
				$bankbalance=$drbank-$crbank;
				$totalcashbalance=$totalcashbalance+$cashbalance;
				$totalbankbalance=$totalbankbalance+$bankbalance;
				
				
		
		@endphp
							<tr>
                            <td>{{ $trnjournal->journaldate }}</td>
							<td <button href="#" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#deletetAreaModal{{ $trnjournal->id }}">{{ $trnjournal->journalno }}</button></td>
                            <td>{{ $trnjournal->journaltype }}</td>
							<td colspan='2'> {{ $particulars }}</td>
                            <td align='right'>{{ $drcash }}</td>
                            <td align='right'>{{ $drbank }}</td>
                            <td align='right'>{{ $crcash }} </td>
							 <td align='right'>{{ $crbank }} </td>
							  <td align='right'>{{ $totalcashbalance }} </td>
                            <td align='right'>{{ $totalbankbalance }}</td>
                        </tr>		
					<div class="modal fade" id="deletetAreaModal{{ $trnjournal->id }}" tabindex="-1" aria-labelledby="deletetAreaModalLabel{{ $trnjournal->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="deletetAreaModalLabel{{ $trnjournal->id }}">Voucher Detail</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>

                                            <div class="modal-body">
											<div class="mb-2">
                                                    <label for="journalno" class="form-label">Journal ID: </label>
                                            <input disabled type="text" class="form-control" id="journalno" name="journalno" value="{{ $trnjournal->journalno }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="amount" class="form-label">Journal Amount1: </label>
                                            <input disabled type="text" class="form-control" id="amount" name="amount" value="{{ $trnjournal->journalno }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-sm btn-danger" value="Delete" onclick="this.disabled=true;this.form.submit();">
                                            </div>
                                    </div>
                                </div>
                    </div>
				@endforeach 
				
				
				
			<TR bgcolor=\"#a7e4ff\">
			  <td align='right' colspan='5'><font color='#000000' face='Verdana' size='1' > <b>Sub Total</font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $totalopencashdr; ?> </font></td>
			   <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $totalopenbankdr; ?> </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $totalopencashcr; ?>  </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $totalopenbankcr; ?>  </font></td>
			  	  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $totalcashbalance; ?>  </font></td>	  
				  <td align='right'><font color='#000000' face='Verdana' size='1' ><b><?php echo $totalbankbalance; ?>  </font></td>
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