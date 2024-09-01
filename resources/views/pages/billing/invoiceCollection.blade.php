@extends('layouts.main')

@section('main-container')
<style>
    .table th,
    .table td {
        padding: 0.25rem;
    }

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

<div class="main_content_iner">
	<div class="container-fluid p-0 sm_padding_15px">
		<div class="px-4 py-1 theme_bg_1">
			<div class="d-flex justify-content-between align-items-center">
				<h5 class="mb-0" style="color: white;">Invoice Collection</h5>
			</div>
		</div>

		<div class="row p-3">
			<div class="col-sm-4 form-group">
				<label for="client" class="fw-medium">Client</label>
				<select class="select2 form-select form-select-sm" id="client" name="client">
					<option selected>Select a Client</option>
					@foreach ($customers as $customer)
						<option value="{{ $customer->customer_name }}">{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
					@endforeach                   
				</select>
			</div>

			<div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
				<br class="d-none d-sm-block">
				<button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();">Show Data</button>
			</div>
		</div>

		<div class="QA_table p-3 pb-0">
			@php
				$count  = 1;
			@endphp
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr style="border-bottom: 1px solid black;">
							<th colspan="11" class="text-center">Invoice List</th>
						</tr>
						<tr>
							<th scope="col">Invoice No.</th>
							<th scope="col">Type & Service</th>
							<th scope="col">Date</th>
							<th scope="col">Net Bill</th>
							<th scope="col">Received Amnt.</th>
							<th scope="col">Accept</th>
							<th scope="col">Amount</th>
							<th scope="col">Discount</th>
							<th scope="col">Vat</th>
							<th scope="col">AIT</th>
							<th scope="col">Down Time</th>
						</tr>
					</thead>

					<tbody>
						@php
							$totalReceivedAmount = 0;
						@endphp

						@foreach ($mas_invoices as $mas_invoice)
						@php
							$ReceivedAmount = ($mas_invoice->collection_amnt) + ($mas_invoice->discount_amnt) + ($mas_invoice->ait_adjustment) + ($mas_invoice->vat_adjust_ment) + ($mas_invoice->otheradjustment) + ($mas_invoice->downtimeadjust); 
							$totalReceivedAmount += $ReceivedAmount;
						@endphp
						<tr>
							<td>{{ $mas_invoice->invoice_number }}</td>
							<td>{{ $mas_invoice->invoice_cat }} {{ $mas_invoice->TblSrvType->srv_name }}</td>
							<td>{{ $mas_invoice->invoice_date }}</td>
							<td><input type="text" class="form-control form-control-sm" value="{{number_format( $mas_invoice->total_bill, 2, '.', ',') }}" name="" disabled></td>
							<td><input type="text" class="form-control form-control-sm" id="received_amount" value="{{ number_format($totalReceivedAmount, 2, '.', ',') }}" name="" disabled></td>
							<td class="text-center"><input type='checkbox' class="form-check-input" id="accept" value='on' name='chkAccept[$i]' onclick="getAmount($i)"></td>
							<td><input type='number' class='form-control form-control-sm' id="amount" onchange='calculateTotalAmount()' value='0'></td>
							<td><input type='number' class='form-control form-control-sm' onchange='calculateTotalAmount1()' value='0'></td>
							<td><input type='number' class='form-control form-control-sm' onchange='calculateTotalAmount2()' value='0'></td>
							<td><input type='number' class='form-control form-control-sm' onchange='calculateTotalAmount3()' value='0'></td>
							<td><input type='number' class='form-control form-control-sm' onchange='calculateTotalAmount4()' value='0'></td>
						</tr>
						@endforeach
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td colspan="3" class="text-end">Total Amount</td>
							<td><input type="text" class="form-control form-control-sm" value="0" name='txtTotalAmount' disabled></td>
							<td><input type="text" class="form-control form-control-sm" value="0" name='txtTotalDiscount' disabled></td>
							<td><input type="text" class="form-control form-control-sm" value="0" name='txtTotalVat' disabled></td>
							<td><input type="text" class="form-control form-control-sm" value="0" name='txtTotalAit' disabled></td>
							<td><input type="text" class="form-control form-control-sm" value="0" name='txtTotalDownTime' disabled></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="QA_table p-3 pb-0">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="text-center">
							<th scope="col" colspan="4">Received Detail</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="col">Receive Type</th>
							<td>
								<div class="">
									<div class="form-check form-check-inline">
										<label class="form-check-label" for="cash">Cash</label>
										<input class="form-check-input" type="radio" name="send_options" id="cash" value="option1" onchange="toggleChequeFields()">
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label" for="cheque">Cheque</label>
										<input class="form-check-input" type="radio" name="send_options" id="cheque" value="option2" onchange="toggleChequeFields()">
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label" for="directdiposit">Direct Diposit</label>
										<input class="form-check-input" type="radio" name="send_options" id="directdiposit" value="option3" onchange="toggleChequeFields()">
									</div>
								</div>
							</td>
							<th scope="col">Money Receipt No</th>
							<td><input type="text" class="form-control form-control-sm"></td>
						</tr>
						<tr>
							<th>Collection Date</th>
							<td>
								<div class="d-flex justify-content-between gap-3">
									<select name="day" id="day" class="form-select form-select-sm form-control">
										<option value="">Day</option>
										@foreach (range(1, 31) as $day )
											<option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
										@endforeach
									</select>
									<select name="month" id="month" class="form-select form-select-sm form-control">
										<option value="">Month</option>
										@foreach (range(1,12) as $month)
											<option {{ $dates->month == $month?'selected':'' }} value="{{ date("M", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
										@endforeach
									</select>
									<select name="year" id="year" class="form-select form-select-sm form-control">
										<option value="">Year</option>
										@foreach (range(now()->year - 15, now()->year + 5) as $year)
											<option {{ $dates->year == $year?'selected':'' }} value="{{ $year }}">{{ $year }}</option>
										@endforeach
									</select>
								</div>
							</td>
							<th>Bank</th>
							<td>
								<select class="form-select form-select-sm form-control" id="bank" name="bank">
									<option selected>Select a Bank</option>
									@foreach ($banks as $bank)
										<option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
									@endforeach                   
								</select>
							</td>
						</tr>
						<tr>
							<th>Cheque No</th>
							<td><input type="text" class="form-control form-control-sm" id="chequeNo" disabled></td>
							<th>Cheque Date</th>
							<td>
								<div class="d-flex justify-content-between gap-3">
									<select name="day" id="day" class="form-select form-select-sm form-control">
										<option value="">Day</option>
										@foreach (range(1, 31) as $day )
											<option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
										@endforeach
									</select>
									<select name="month" id="month" class="form-select form-select-sm form-control">
										<option value="">Month</option>
										@foreach (range(1,12) as $month)
											<option {{ $dates->month == $month?'selected':'' }} value="{{ date("M", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
										@endforeach
									</select>
									<select name="year" id="year" class="form-select form-select-sm form-control">
										<option value="">Year</option>
										@foreach (range(now()->year - 15, now()->year + 5) as $year)
											<option {{ $dates->year == $year?'selected':'' }} value="{{ $year }}">{{ $year }}</option>
										@endforeach
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<th>Remarks</th>
							<td colspan="3"><textarea name="remarks" id="remarks" rows="2" class="form-control"></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="3" class="py-3"><input type="checkbox" class="form-check-input me-1">SMS Notification</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="text-center">
			<button class="btn btn-sm btn-primary m-2 mb-3" onclick="this.disabled=true;this.form.submit();">Submit</button>
			<button class="btn btn-sm btn-primary m-2 mb-3" onclick="this.disabled=true;this.form.submit();">Submit & Print</button>
		</div>
	</div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });

	function toggleChequeFields() {
		var chequeRadio = document.getElementById('cheque');
		var chequeNoInput = document.getElementById('chequeNo');
		var chequeDateDay = document.getElementById('cday');
		var chequeDateMonth = document.getElementById('cmonth');
		var chequeDateYear = document.getElementById('cyear');

		if (chequeRadio.checked) {
			chequeNoInput.disabled = false;
			chequeDateDay.disabled = false;
			chequeDateMonth.disabled = false;
			chequeDateYear.disabled = false;
		}
		else {
			chequeNoInput.disabled = true;
			chequeDateDay.disabled = true;
			chequeDateMonth.disabled = true;
			chequeDateYear.disabled = true;
		}
	}



	const receivedAmount = document.getElementById('received_amount').value;
	let amount = document.getElementById('amount').value;
	const acceptAmount = document.getElementById('accept');

	acceptAmount.addEventListener('change', function(){
		if (acceptAmount.checked){
			const checkboxValue = acceptAmount.value;
        	console.log("Checkbox value:", checkboxValue);
		}
	});

	console.log(amount);
</script>

@endpush
@endsection