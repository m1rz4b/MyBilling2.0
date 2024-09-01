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
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white text-center">Renew</h5>
                </div>
            </div>

            <div class="p-4 row">
                <div class="col-sm-3">
                    <label for="" class="">Customer</label>
                    <select name="" id="" class="form-control form-control-sm select2" style="width: 145%;">
                        <option selected>Select a Customer</option>
                        @foreach ($customers as $customer)
                            <option {{--value="{{ $customer->customer_name }}"--}}>{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
                        @endforeach 
                    </select>
                </div>
                <div class="col-sm-5">
                    <br/>
                    <center><button type="submit" class="btn btn-sm btn-info">Search</button></center>
                </div>
            </div>

            <div class="">
                <div class="text-center"><span><strong>Account No :</strong> 0, <strong>User name :</strong> Mr. A</span></div>
                <div class="QA_table m-3 border border-bottom-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sl.</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Package</th>
                                <th scope="col">Exp Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Days</th>
                                <th scope="col">Bill</th>
                                <th scope="col">Total</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Vat</th>
                                <th scope="col">AIT</th>
                                <th scope="col">Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>flsohag</td>
                                <td>Mr. A</td>
                                <td>Expired</td>
                                <td>MCN Student</td>
                                <td>03 Feb 2024</td>
                                <td>700</td>
                                <td><input type="text" value="30" disabled class="form-control form-control-sm"></td>
                                <td><input type="text" value="0" disabled class="form-control form-control-sm"></td>
                                <td><input type="text" value="0" disabled class="form-control form-control-sm"></td>
                                <td><input type="text" value="0" class="form-control form-control-sm"></td>
                                <td><input type="number" value="0" class="form-control form-control-sm"></td>
                                <td><input type="number" value="0" class="form-control form-control-sm"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-end">Total Amount</th>
                                <td></td>
                                <td><input type="text" disabled value="0" class="form-control"></td>
                                <td><input type="text" disabled value="0" class="form-control"></td>
                                <td><input type="text" disabled value="0" class="form-control"></td>
                                <td><input type="text" disabled value="0" class="form-control"></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="QA_table m-3 mt-5 border border-bottom-0">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <td scope="col" colspan="4">Received Detail</td>
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
                                        <select name="day" id="day" class="form-select form-select-sm">
                                            <option value="">Day</option>
                                            @foreach (range(1, 31) as $day )
                                                <option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
                                            @endforeach
                                        </select>
                                        <select name="month" id="month" class="form-select form-select-sm">
                                            <option value="">Month</option>
                                            @foreach (range(1,12) as $month)
                                                <option {{ $dates->month == $month?'selected':'' }} value="{{ date("M", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                        <select name="year" id="year" class="form-select form-select-sm">
                                            <option value="">Year</option>
                                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                                <option {{ $dates->year == $year?'selected':'' }} value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <th>Bank</th>
                                <td>
                                    <select name="" id="" class="form-select form-select-sm">
                                        <option value="">Select a Bank</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Cheque No</th>
                                <td><input type="text" class="form-control form-control-sm" id="chequeNo" disabled></td>
                                <th>Cheque Date</th>
                                <td>
                                    <div class="d-flex justify-content-between gap-3">
                                        <select name="day" id="cday" class="form-select form-select-sm form-control" disabled>
                                            <option value="">Day</option>
                                            @foreach (range(1, 31) as $day )
                                                <option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
                                            @endforeach
                                        </select>
                                        <select name="month" id="cmonth" class="form-select form-select-sm form-control" disabled>
                                            <option value="">Month</option>
                                            @foreach (range(1,12) as $month)
                                                <option {{ $dates->month == $month?'selected':'' }} value="{{ date("M", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                        <select name="year" id="cyear" class="form-select form-select-sm form-control" disabled>
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
                                <td colspan="3"><textarea name="" id="" rows="3" class="form-control"></textarea></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3" class="py-3"><input type="checkbox">SMS Notification</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    <button class="btn btn-sm btn-info m-2 mb-3">Submit</button>
                    <button class="btn btn-sm btn-info m-2 mb-3">Submit & Print</button>
                </div>
            </div>
        </div>
        
    </div>

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
    </script>
@endsection