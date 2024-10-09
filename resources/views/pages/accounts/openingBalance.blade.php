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
       
		    

            <div class="QA_table p-3 pb-0 table-responsive">

					 
			<div class="container-fluid p-0 sm_padding_15px">
			
			<form action="{{ route('openingbalance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
					<div class="">
						<div class="px-4 py-1 theme_bg_1">
							<h5 class="mb-0 text-white text-center">Opening Balance</h5>
						</div>
					</div>
		
						
                            <div class="col-sm-12 ">
                                <div class="form-group col-xs-12">
								<div class="row">       
                                    <div class="col-md-3 form-group">   
                                        <label for="cboToBank"  class="col-sm-4 control-label">Bank</label>
                                        <div class="input-group col-sm-8">
                                           <select class="form-control input-sm"  name='cboToBank' id='cboToBank' >
									<option value="-1" selected>Select a Bank</option>
										@foreach ($masbanks as $masbank)
                                    <option value="{{ $masbank->id }}">{{ $masbank->bank_name }} </option>
										@endforeach      
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">   
                                        <label for="cboToAccountNo" class="col-sm-4 control-label">Account No</label>
                                        <div class="input-group col-sm-8">
                                            <select class="form-control input-sm" name='cboToAccountNo' id='cboToAccountNo' >
									<option value="-1" selected>Select an Account</option>
										@foreach ($trnbanks as $trnbank)
                                    <option value="{{ $trnbank->id }}">{{ $trnbank->account_no }} </option>
										@endforeach      
                                            </select>
                                        </div>
                                    </div>
				<div class="col-md-3">
				<label for="branch" class="form-label">Branch</label>	
				  <select name="branch_id" id="branch_id" class="form-select form-select-sm" style="width: 100%">
                        <option value="-1" selected>Select a Branch</option>
                                                        @foreach ($sub_offices as $branch)
                 <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            
														@endforeach 
											
                    </select>
				</div>
				
			<div class="col-md-3">
                    <label for="customer" class="form-label">Client</label>
                    <select name="customer_id" id="customer_id" class="form-select form-select-sm" style="width: 100%">
                    <option value="-1" selected>Select a Customer</option>
					 @foreach ($customers as $customer)
				<option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
						@endforeach                            
                     </select>
                </div>
								</div>
								
								<div  class="row">
										<div class="col-md-4 form-group">   
											<label for="txtsupplierid" class="col-sm-4 control-label">Vendor</label>
											<div class="input-group col-sm-8">
                                        <select class="form-control input-sm"  name='txtsupplierid' id='txtsupplierid'>
											 <option value="-1" selected>Select a Vendor</option>
											@foreach ($massuppliers as $massupplier)
											<option value="{{ $massupplier->id }}">{{ $massupplier->clients_name }} </option>
											@endforeach      
                                               
                                            </select>
											</div>
										</div>
										<div class="col-md-4 form-group">
											<label for="emp_id" class="col-sm-4 control-label">Employee</label>
								<select class="form-control input-sm" name='emp_id' id='emp_id' >
									<option value="-1" selected>Select an Employee</option>
										@foreach ($masemployees as $masemployee)
                                    <option value="{{ $masemployee->id }}">{{ $masemployee->emp_name }} </option>
										@endforeach      
                                            </select>
											</div>
									<div class="col-md-4 form-group">
											<label for="gl_code" class="col-sm-4 control-label">Inc / Exp</label>
										<select class="select2 form-control input-sm" name='gl_code' id='gl_code' >
									<option value="-1" selected>Select an Account</option>
										@foreach ($mas_gls as $mas_gl)
                                    <option value="{{ $mas_gl->gl_code }}">{{ $mas_gl->description }} </option>
										@endforeach      
                                            </select>
											</div>
										
										
								</div>
							<div  class="row">
                                    <div class="col-md-4 form-group">   
                                        <label for="txtAmount" class="col-sm-4 control-label">Amount</label>
                                        <div class="input-group">
                                         
                                            <input type="text" class="form-control input-sm" name="txtAmount" id="txtAmount" value="" placeholder="">
                                        </div>
                                    </div>
						
							<div class="col-md-4 form-group">
											<label for="txtjournaldate" class="col-sm-4 control-label">Date</label>
											<div class="input-group">
												
							<input class="form-control input_form datepicker-here digits" name="txtjournaldate" id="txtjournaldate" data-date-Format="yyyy-mm-dd" value="" placeholder="Date" >
											</div>
										</div>
						 <div class="col-md-4 form-group">
                                                 
                        <label class="col-sm-4 control-label pl0 pr0">Cost Center</label>
                            <div class="col-sm-8">
                               <select class="select2 form-select form-select-sm" id="txtcost_code" name="txtcost_code">
                                <option value="-1" selected>Select a Cost Center</option>
                                @foreach ($costcenters as $costcenter)
                                    <option value="{{ $costcenter->id }}">{{ $costcenter->description }} </option>
                                @endforeach                   
                            </select>                    
                      </div>
                                                  
                        </div>	

					</div>	
									<div class="col-md-4 form-group">
										<label for="cboToAccountNo " class="col-sm-4 control-label"></label>
                                        <div class="input-group">									
									<button type="submit" class="btn btn-sm btn-primary">Submit</button>
									
									
									</div>
								</div>					
                </div>
              </div>
				</form>					
          </div>
		</div>
		
			
	<div class="container-fluid p-0 sm_padding_15px">
					<div class="">
						<div class="px-4 py-1 theme_bg_1">
							<h5 class="mb-0 text-white text-center">Search</h5>
						</div>
					</div>
			
			<form action="{{ route('openingbalance.show') }}" method="get">
			 @csrf	
             <div class="blog-body">
                         <div class="col-sm-12 ">
                                <div class="form-group col-xs-12">
                                <div class="row">     
                                    <div class="col-md-4 form-group">   
                                        <label for="cboToBank" class="col-sm-4 control-label">Gl Code</label>
                                        <div class="input-group">
									<select class=" select2 form-control input-sm" name='gl_codes' id='gl_codes' >
									<option value="-1" selected>Select an Gl Code`</option>
										@foreach ($glcodes as $glcode)
                                    <option value="{{ $glcode->gl_code }}">{{ $glcode->description }} </option>
										@endforeach      
                                    </select>
                                               
                                        </div>
                                    </div>
									
									<div class="col-md-4 form-group">
											<label for="txtjournaldate" class="col-sm-4 control-label">Date</label>
											<div class="input-group">
												
							<input class="form-control input_form datepicker-here digits" name="txtjournaldate" id="txtjournaldate" data-date-Format="yyyy-mm-dd" value="" placeholder="Date" >
											</div>
										</div>
										
									<div class="col-md-4 form-group">
										<label for="cboToAccountNo " class="col-sm-4 control-label"></label>
                                        <div class="input-group">									
									<button type="submit" class="btn btn-sm btn-primary">Submit</button>
									
									
									</div>
								</div>
                                </div>
                            </div>

                </div>
		</div>
			</form>	
		
	</div>
	 <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$tcredit=0;
					$tdebit=0;
                @endphp


                <table class="table table-responsive">
                    <thead>
         <tr>
						
		<th align="center">Account</th>
        <th align="center">Client</th>
        <th align="center">Employee</th>
        <th align="center">Vendor</th>
        <th align="center">Chart Of Account</th>
        <th align="center">Cost Center</th>
        <th align="center">Debit</th>
        <th align="center">Credit</th>
        <th>Delete</th>
					  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masjournals as $masjournal)
			
							<tr>
                            <td>{{ $masjournal->accountno }}</td>
                            <td>{{ $masjournal->cname }}</td>
                            <td>{{ $masjournal->emp_name }}</td>
                            <td>{{ $masjournal->clients_name }}</td>
                            <td align='right'>{{ $masjournal->description }} </td>
							 <td align='right'>{{ $masjournal->costcenter_dec }} </td>
							  <td align='right'>{{ $masjournal->debit }} </td>
                            <td align='right'>{{ $masjournal->credit }}</td>
				<td align='right'><button href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletetAreaModal{{ $masjournal->id }}">Delete</button></td>
                            </tr>	
				@php


							$tdebit=$masjournal->debit+$tdebit;
							$tcredit=$masjournal->credit+$tcredit;
                @endphp
				
<div class="modal fade" id="deletetAreaModal{{ $masjournal->id }}" tabindex="-1" aria-labelledby="deletetAreaModalLabel{{ $masjournal->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="deletetAreaModalLabel{{ $masjournal->id }}">Are you sure ?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('openingbalance.destroy', ['openingbalance' => $masjournal]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
											<div class="mb-2">
                                                    <label for="journalno" class="form-label">Journal ID: </label>
                                            <input disabled type="text" class="form-control" id="journalno" name="journalno" value="{{ $masjournal->id }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="amount" class="form-label">Journal Amount: </label>
                                            <input disabled type="text" class="form-control" id="amount" name="amount" value="{{ $masjournal->amount }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-sm btn-danger" value="Delete" onclick="this.disabled=true;this.form.submit();">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>				
				
				@endforeach  
				
				
		@php			
				echo "<TR bgcolor=\"#ffe392\">
			  <td align='right' colspan='6'><font color='#000000' face='Verdana' size='1' > <b>Total</font></td>
			  
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$tdebit </font></td>
			  <td align='right'><font color='#000000' face='Verdana' size='1' ><b>$tcredit </font></td>
			  <td> </td>
			</TR>";
			 @endphp
                    </tbody>
			
                </table>
	</div>
	
	
   </div>		
   </div>
 
    

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
			$("#branch_id").select2({
     
			});
			$("#customer_id").select2({
   
			});	
			
					$('#branch_id').on('select2:select', function (e) {
                var data = e.params.data;
                console.log(data);

                const branchID = data.id;


                // Your JSON data
                const jsonData = { branchID: branchID };

                // Set up options for the fetch request
                const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(jsonData) // Convert JSON data to a string and set it as the request body
                };

                // Make the fetch request with the provided options
                fetch(`{{ url('getCustomerByBranch') }}`, options)
                .then(response => {
                    // Check if the request was successful
                    if (!response.ok) {
                    throw new Error('Network response was not ok');
                    }
                    // Parse the response as JSON
                    return response.json();
                })
                .then(data => {
                    // Handle the JSON data
                    console.log(data);
                    var select = document.getElementById("customer_id");
                    select.innerHTML = "";
                    var option = new Option(data.text, data.id, true, true);
                    option.text = "Select a Customer";
                    option.value = -1;
                    select.append(option);
                    for(prod of data.data)
                    {
                        var option = new Option(data.text, data.id, true, true);
                        option.text = prod.customer_name;
                        option.value = prod.id;
                        var select = document.getElementById("customer_id");
                        select.append(option);
                    }
                    $('#customer_id').val('-1'); 
                        
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Fetch error:', error);
                });

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