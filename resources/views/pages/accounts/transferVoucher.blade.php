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
                    <h5 class="mb-0 text-white text-center">Transfer Voucher</h5>
                </div>
            </div>
			
				
          
		    <form action="{{ route('transfervoucher.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
				
            <div class="QA_table p-3 pb-0 table-responsive">
			<div class="row">
					<div class="col-sm-4 form-group">
                        <label class="fw-medium" for="start_date" class="form-label">Voucher Date</label>
                        <input class="form-control input_form datepicker-here digits" name="start_date" id="start_date" data-date-Format="yyyy-mm-dd" value="{{ $start_date }}" placeholder="Start date">
                    </div>
					<div class="col-sm-4 form-group">
					<label class="fw-medium" for="start_date" class="form-label">Voucher No </label>
                     <input type='text' name='journalno' value='{{$maslatestjournalnumbers }}' readonly class='input_e' class='made'>
                    </div>
					<input type='hidden' name='txtJournalType' Value='TR' >
			</div>
					 
			<div class="container-fluid p-0 sm_padding_15px">
					<div class="">
						<div class="px-4 py-1 theme_bg_1">
							<h5 class="mb-0 text-white text-center">From</h5>
						</div>
					</div>
		
						
                            <div class="col-sm-12 ">
                                <div class="form-group col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            
                                                <div class="col-md-4">
                                                    <label for="rdopayto" style="margin-top: 10px">Pay By </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox pull-left">
                                                    <label>
                                                      <input  type='radio' name='rdopayto'  id="cash" value='C' class='input_e' onClick="toggleChequeFields()" checked> Cash
                                                    </label>
                                                    <label>
                                                      <input type='radio' name='rdopayto' id="cheque" value='Q' class='input_e' class='input_e' onClick="toggleChequeFields()" > Cheque
                                                    </label>
                                                  </div>
                                                </div>  
                                           <div class="col-md-4">
                                              <div class="form-group">
                                                    <label class="col-md-3">Cost Center</label>
                                                        <div class="col-md-9">
							<select class="select2 form-select form-select-sm" id="txtcost_code_from" name="txtcost_code_from">
                                <option value="-1" selected>Select a Cost Center</option>
                                @foreach ($costcenters as $costcenter)
                                    <option value="{{ $costcenter->id }}">{{ $costcenter->description }} </option>
                                @endforeach                   
                            </select>
                                                        </div>
                                              </div>
                                           </div>
                                           
                                           
                                        </div>
                                    </div>
								<div class="row">       
                                    <div class="col-md-6 form-group">   
                                        <label for="cboBank"  class="col-sm-4 control-label">Bank</label>
                                        <div class="input-group col-sm-8">
                                           <select class="form-control input-sm"  name='cboBank' id='cboBank' disabled>
									<option value="-1" selected>Select a Bank</option>
										@foreach ($masbanks as $masbank)
                                    <option value="{{ $masbank->id }}">{{ $masbank->bank_name }} </option>
										@endforeach      
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">   
                                        <label for="cboAccountNo" class="col-sm-4 control-label">Account No</label>
                                        <div class="input-group col-sm-8">
                                            <select class="form-control input-sm" name='cboAccountNo' id='cboAccountNo' disabled>
									<option value="-1" selected>Select an Account</option>
										@foreach ($trnbanks as $trnbank)
                                    <option value="{{ $trnbank->id }}">{{ $trnbank->account_no }} </option>
										@endforeach      
                                            </select>

                                            </select>
                                        </div>
                                    </div>
								</div>
									<div  class="row">
										<div class="col-md-6 form-group">   
											<label for="cqno" class="col-sm-4 control-label">Cheque No</label>
											<div class="input-group col-sm-8">
												
												<input type="text" class="form-control input-sm" name="cqno" id="cqno" value="" placeholder="Cheque No" disabled>
											</div>
										</div>
										<div class="col-md-6 form-group">
											<label for="txtChequeDate" class="col-sm-4 control-label">Cheque Date</label>
											<div class="input-group">
												
							<input class="form-control input_form datepicker-here digits" name="txtChequeDate" id="txtChequeDate" data-date-Format="yyyy-mm-dd" value="" placeholder="Cheque Date" disabled>
											</div>
										</div>
									</div>
									<div  class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="mremarks" class="col-sm-4 control-label">Particulars</label>
                                        <div class="input-group">
                                          
                                            <textarea type="text" class="form-control" rows="1" name="mremarks"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">   
                                        <label for="txtAmount" class="col-sm-4 control-label">Amount</label>
                                        <div class="input-group">
                                         
                                            <input type="text" class="form-control input-sm" name="txtAmount" id="txtAmount" value="" placeholder="">
                                        </div>
                                    </div>
								</div>	
                                </div>
                            </div>
               </div>
				
			<div class="container-fluid p-0 sm_padding_15px">
					<div class="">
						<div class="px-4 py-1 theme_bg_1">
							<h5 class="mb-0 text-white text-center">To</h5>
						</div>
					</div>
                        <div class="blog-body">
                            <div class="col-sm-12 ">
                                <div class="form-group col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-md-6 form-group">
                                                
                                                <label for="rdoTopayto" style="margin-top: 10px" class="col-sm-4 control-label">Pay By </label>
                                               
                                                <div class="col-md-8">
                                                    <div class="checkbox">
                                                    <label>
                                                      <input  type='radio' name='rdoTopayto' id="cashTo" value='C' class='input_e' onClick="toggleChequeFieldsTo()" checked> Cash
                                                    </label>
                                                
                                                 
                                                    <label>
                                                      <input type='radio' name='rdoTopayto' id="chequeTo"  value='Q' class='input_e' class='input_e' onClick="toggleChequeFieldsTo()" > Bank
                                                    </label>
                                                  </div>
                                                </div>  
                                            </div>
                                            <div class="col-md-4">
                                                  <div class="form-group">
                                                        <label class="col-sm-3 control-label pl0 pr0">Cost Center</label>
                                                            <div class="col-sm-9">
                               <select class="select2 form-select form-select-sm" id="txtcost_code_to" name="txtcost_code_to">
                                <option value="-1" selected>Select a Cost Center</option>
                                @foreach ($costcenters as $costcenter)
                                    <option value="{{ $costcenter->id }}">{{ $costcenter->description }} </option>
                                @endforeach                   
                            </select>                    
                                                            </div>
                                                  </div>
                                               </div>
                                        </div>
                                    </div>
                                <div class="row">     
                                    <div class="col-md-6 form-group">   
                                        <label for="cboToBank" class="col-sm-4 control-label">Bank</label>
                                        <div class="input-group">
                                        <select class="form-control input-sm"  name='cboToBank' id='cboToBank' disabled>
											 <option value="-1" selected>Select a Bank</option>
											@foreach ($masbanks as $masbank)
											<option value="{{ $masbank->id }}">{{ $masbank->bank_name }} </option>
											@endforeach      
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">   
                                        <label for="cboToAccountNo " class="col-sm-4 control-label">Account No</label>
                                        <div class="input-group">
										<select class="form-control input-sm" name='cboToAccountNo' id='cboToAccountNo' disabled>
									<option value="-1" selected>Select an Account</option>
										@foreach ($trnbanks as $trnbank)
                                    <option value="{{ $trnbank->id }}">{{ $trnbank->account_no }} </option>
										@endforeach      
                                            </select>
           
		   
                                            </select>
                                        </div>
                                    </div>
								</div>
                                </div>
                            </div>

                </div>
			</div>
				
							
				<div class="col-sm-12 form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                 </div>
	
            </div>
	</form>	
        </div>
 
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });
		
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.checkbox-to-select');

        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                }
            });
        });
    });
	
	 function toggleChequeFields() {
	
	
			var cashRadioFrom = document.getElementById('cash');
            var chequecboBank = document.getElementById('cboBank');
            var chequecboAccountNo = document.getElementById('cboAccountNo');
            var chequecqno = document.getElementById('cqno');
            var chequetxtChequeDate = document.getElementById('txtChequeDate');

            if (cashRadioFrom.checked) {
				chequecboBank.disabled = true;
                chequecboAccountNo.disabled = true;
                chequecqno.disabled = true;
                chequetxtChequeDate.disabled = true;

            }
            else {
				chequecboBank.disabled = false;
                chequecboAccountNo.disabled = false;
                chequecqno.disabled = false;
                chequetxtChequeDate.disabled = false;	
 
            }
        }
		
		function toggleChequeFieldsTo() {
		 
			var cashRadioTo = document.getElementById('cashTo');
            var chequecboBankTo = document.getElementById('cboToBank');
			var chequecboAccountNoTo = document.getElementById('cboToAccountNo');

            if (cashRadioTo.checked) {
               chequecboBankTo.disabled = true;
			    chequecboAccountNoTo.disabled = true;
            }
            else {
                chequecboBankTo.disabled = false;
				chequecboAccountNoTo.disabled = false;				
            }
        }
		
		
		
		
    </script>
@endsection