@extends('layouts.main')

@section('main-container')
    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible my-1" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <strong>Success !</strong> {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="main_content_iner">

        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                    <h5 class="mb-0 text-white text-center">Advance Information</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addAdvInfoModal">Add</a>
                </div>
            </div>
            <form action="{{ route('advanceinformation.advanceinformation') }}" method="get">
                @csrf		 
            <div class="d-flex justify-content-between mx-4 mb-3 mt-2">
			<div class="col-md-3">
				<label for="branch" class="form-label">Branch</label>	
				  <select name="branch_id" id="branch_id" class="form-select form-select-sm" style="width: 100%">
                        <option value="-1" selected>Select a Branch</option>
                                                        @foreach ($suboffices as $branch)
                                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                        @endforeach 
                    </select>
				</div>									
                <div class="col-md-3">
                    <label for="customer" class="form-label">Customer</label>
                                                    <select name="customer_id" id="customer_id" class="form-select form-select-sm" style="width: 100%">
                                                        <option value="-1" selected>Select a Customer</option>
                                                        
                                                    </select>
                </div>
               <div class="col-md-2">
                    <label for="fromDate" class="form-label">From Date</label>
                    <input type="text" class="form-control form-control-sm datepicker-here" name="fromDate" id="fromDate" data-date-Format="yyyy-mm-dd">
                </div>

                <div class="col-md-2">
                    <label for="toDate" class="form-label">To Date</label>
                    <input type="text" class="form-control form-control-sm datepicker-here" name="toDate" id="toDate" data-date-Format="yyyy-mm-dd">
                </div>
            </div>

            <div class="text-center mb-1">
                                         <button type="button" class="btn btn-sm btn-primary me-2"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
            </div>
		</form>
            <div class="QA_table m-3 border border-bottom-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 15%;">Customer</th>
                            <th scope="col">Collection Date</th>
                            <th scope="col" style="width: 20%">Money Receipt</th>
                            <th scope="col">For Month</th>
                            <th scope="col">Amount</th>
                            <th scope="col" style="width: 10%">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
					
					 @foreach ($advancebills as $advancebill)
                        <tr>
                            <td>{{ $advancebill->customer_name }}</td>
                            <td>{{ $advancebill->rec_date }}</td>
                            <td>{{ $advancebill->money_recipt }}</td>
                            <td>{{ $advancebill->bill_month }} - {{ $advancebill->bill_year }}</td>
                            <td>{{ $advancebill->amount }}</td>
							<td>{{ $advancebill->remarks }}</td>
							
                        </tr>
                    @endforeach  
                    </tbody>
                </table>
            </div>

            {{-- add modal --}}
            <div class="modal fade" id="addAdvInfoModal" tabindex="-1"
                aria-labelledby="addAdvInfoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="addAdvInfoModalLabel">Add Advanced Information</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        
                        <form class="" method="POST" action="{{ route('advanceinformation.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
							<div class="mb-2">
							<label for="branch" class="form-label fw-bold">Branch</label>	
							  <select name="branch_id1" id="branch_id1" class="form-select form-select-sm" style="width: 100%">
									<option selected>Select a Branch</option>
																		@foreach ($suboffices as $branch)
																			<option value="{{ $branch->id }}">{{ $branch->name }}</option>
																		@endforeach 
									</select>
								</div>		
								
						<div class="mb-2">
							
						</div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Month: </label>
                                         <select class="form-select form-select-sm form-control" id="month" name="month">
                                <option value="-1">Please Choose A Month</option>
                                @foreach(range(01,12) as $month)
                                    <option value="{{ $month }}">
                                        {{ date("M", mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                                        </div>
                                        <div class="mb-2">
										<label for="discount" class="form-label fw-bold">Discount: </label>
                                         <input type="text" class="form-control form-control-sm" id="discount" name="discount">
                                            
                                        </div>
                                        <div class="mb-2">
                                            <label for="send_options" class="form-label fw-bold">Payment Type: </label>
                                            <div class="">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="cash">Cash</label>
                                                    <input class="form-check-input" type="radio" name="pay_type" id="pay_type" value="C">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="cheque">Cheque</label>
                                                    <input class="form-check-input" type="radio" name="pay_type" id="pay_type" value="Q">
                                                </div>
												
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="directdiposit">Direct Diposit</label>
                                                    <input class="form-check-input" type="radio" name="pay_type" id="pay_type" value="D">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="remarks" class="form-label fw-bold">Remarks: </label>
                                            <textarea class="form-control form-control-sm" rows="2" id="remarks" name="remarks"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="customer" class="form-label fw-bold">Customer</label>
															<select name="customer_id1" id="customer_id1" class="form-select form-select-sm" style="width: 100%">
																<option value="-1" selected>Select a Customer</option>
																
							</select>
                                        </div>
                                        <div class="mb-2">
										<label for="zone_name" class="form-label fw-bold">Year: </label>
                                           <select class="form-select form-select-sm form-control" id="year" name="year" >
                                <option value="-1">Please Choose A Year</option>
                                @foreach (range(now()->year - 10, now()->year + 5) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
										
                                            
                                        </div>
                                        <div class="mb-2">
										<label for="" class="form-label fw-bold">Collection Date: </label>
                                            <input type="text" class="form-control form-control-sm datepicker-here" id="collection_date" name="collection_date" placeholder="yyyy-mm-dd" data-date-Format="yyyy-mm-dd">
                                            
                                        </div>
                                        <div class="mb-2">
                                            <label for="bank_id" class="form-label fw-bold">Bank: </label>
                                            <select name="bank_id" id="bank_id" class="form-select form-select-sm" style="width: 100%">
												<option value="-1" selected>Select a Bank</option>
																		@foreach ($banks as $bank)
																			<option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
																		@endforeach 
									</select>
                                        </div>
                                        <div class="mb-2 text-center mt-5">
                                            <input type="checkbox" class="" id="smsnotification" name="smsnotification">
                                            <label for="smsnotification" class="form-label fw-bold">SMS Notification </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
										<label for="service_id" class="form-label fw-bold">Service For: </label>
                                            <select name="service_id" id="service_id" class="form-select form-select-sm" style="width: 100%">
									<option value="-1" selected>Select a Service</option>
																		@foreach ($services as $service)
																			<option value="{{ $service->id }}">{{ $service->srv_name }}</option>
																		@endforeach 
									</select>
										</div>
                                        <div class="mb-2">
										<label for="amount" class="form-label fw-bold">Amount: </label>
                                            <input type="text" class="form-control form-control-sm" id="amount" name="amount">
										 
                                            
                                        </div>
                                        <div class="mb-2">
										<label for="money_recpt" class="form-label fw-bold">Money Receipt: </label>
                                            <input type="text" class="form-control form-control-sm" id="money_recpt" name="money_recpt">
										 
                                           
                                        </div>
										
                                        <div class="mb-2">
                                           <label for="" class="form-label fw-bold">Cheque Date: </label>
                                            <input type="text" class="form-control form-control-sm datepicker-here" id="cheque_date" name="cheque_date" placeholder="yyyy-mm-dd" data-date-Format="yyyy-mm-dd">
                                        </div>
                                        <div class="mb-2">
                                            <label for="cheque_no" class="form-label fw-bold">Cheque No: </label>
                                            <input type="text" class="form-control form-control-sm" id="cheque_no" name="cheque_no">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn-custom-1 py-1" type="submit" onclick="this.disabled=true;this.form.submit();">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
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
	 
  $("#branch_id1").select2({
      dropdownParent: $("#addAdvInfoModal")
     });
  $("#customer_id1").select2({
     dropdownParent: $("#addAdvInfoModal")
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
			
			 $('#branch_id1').on('select2:select', function (e) {
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
                    var select = document.getElementById("customer_id1");
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
                        var select = document.getElementById("customer_id1");
                        select.append(option);
                    }
                    $('#customer_id1').val('-1'); 
                        
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Fetch error:', error);
                });

            });
			
			

        });
    </script>
	
@endsection