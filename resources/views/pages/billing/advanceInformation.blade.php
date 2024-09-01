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
                
            <div class="d-flex justify-content-between mx-4 mb-3 mt-2">
                <div class="w-25">
                    <label for="fromDate" class="form-label">From Date</label>
                    <input type="text" class="form-control form-control-sm datepicker-here" name="" id="fromDate" data-date-Format="yyyy-mm-dd">
                </div>
                <div class="w-25">
                    <label for="toDate" class="form-label">To Date</label>
                    <input type="text" class="form-control form-control-sm datepicker-here" name="" id="toDate" data-date-Format="yyyy-mm-dd">
                </div>
                <div class="w-25">
                    <label for="customer" class="form-label">Customer</label>
                    <select name="" id="customer" class="form-select" style="width: 100%">
                        <option value="">Select a Customer</option>
                        <option value="Customer 1">Customer 1</option>
                        <option value="Customer 2">Customer 2</option>
                        <option value="Customer 3">Customer 3</option>
                    </select>
                </div>
            </div>

            <div class="text-center mb-4">
                <a class="btn btn-sm btn-info">Search</a>
            </div>

            <div class="QA_table m-3 border border-bottom-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 15%;">Customer</th>
                            <th scope="col">Collection Date</th>
                            <th scope="col" style="width: 30%">Money Receipt</th>
                            <th scope="col">For Month</th>
                            <th scope="col">Amount</th>
                            <th scope="col" style="width: 15%">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Md Bulbul Ahmed (Zone_128)</td>
                            <td>30/3/2024</td>
                            <td>3124HUIU1HY3214J</td>
                            <td>March 2024</td>
                            <td>300</td>
                            <td>Prepaid Online Payment Area</td>
                        </tr>
                        <tr>
                            <td>Md Bulbul Ahmed (Zone_128)</td>
                            <td>30/3/2024</td>
                            <td>3124HUIU1HY3214J</td>
                            <td>March 2024</td>
                            <td>300</td>
                            <td>Prepaid Online Payment Area</td>
                        </tr>
                        <tr>
                            <td>Md Bulbul Ahmed (Zone_128)</td>
                            <td>30/3/2024</td>
                            <td>3124HUIU1HY3214J</td>
                            <td>March 2024</td>
                            <td>300</td>
                            <td>Prepaid Online Payment Area</td>
                        </tr>
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
                        
                        <form class="" method="POST" action="{{ route('advanceinformation.advanceinformation') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Client Name: </label>
                                            <select name="" id="" class="form-select form-select-sm"></select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label fw-bold">Collection Date: </label>
                                            <input type="text" class="form-control form-control-sm datepicker-here" id="" name="" data-date-Format="yyyy-mm-dd">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label fw-bold">Cheque Date: </label>
                                            <input type="text" class="form-control form-control-sm datepicker-here" id="" name="" placeholder="dd/mm/yyyy" data-date-Format="yyyy-mm-dd">
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Payment Type: </label>
                                            <div class="">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="cash">Cash</label>
                                                    <input class="form-check-input" type="radio" name="send_options" id="cash" value="option1">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="cheque">Cheque</label>
                                                    <input class="form-check-input" type="radio" name="send_options" id="cheque" value="option2">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="directdiposit">Direct Diposit</label>
                                                    <input class="form-check-input" type="radio" name="send_options" id="directdiposit" value="option3">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Remarks: </label>
                                            <textarea class="form-control form-control-sm" rows="2" id="zone_name" name="zone_name"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Service For: </label>
                                            <select name="" id="" class="form-select form-select-sm"></select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Money Receipt: </label>
                                            <input type="text" class="form-control form-control-sm" id="zone_name" name="zone_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Month: </label>
                                            <select name="" id="" class="form-select form-select-sm"></select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Bank: </label>
                                            <input type="text" class="form-control form-control-sm" id="zone_name" name="zone_name">
                                        </div>
                                        <div class="mb-2 text-center mt-5">
                                            <input type="checkbox" class="" id="smsnotification" name="">
                                            <label for="smsnotification" class="form-label fw-bold">SMS Notification </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Amount: </label>
                                            <input type="text" class="form-control form-control-sm" id="zone_name" name="zone_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Discount: </label>
                                            <input type="text" class="form-control form-control-sm" id="zone_name" name="zone_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Year: </label>
                                            <select name="" id="" class="form-select form-select-sm"></select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="zone_name" class="form-label fw-bold">Cheque No: </label>
                                            <input type="text" class="form-control form-control-sm" id="zone_name" name="zone_name">
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
@endsection