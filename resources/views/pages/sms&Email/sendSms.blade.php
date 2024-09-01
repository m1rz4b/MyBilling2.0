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

    .sms-body-container {
        width: 50%;
    }

    @media screen and (max-width: 576px) {
        .sms-body-container {
            width: 100%;
        }
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
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">Client List</h5>
                </div>
            </div>

            <div class="row p-3">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-sm-3 form-group">
                        <label for="package" class="fw-medium">Package</label>
                        <select class="form-select form-select-sm form-control" id="package" name="package">
                            <option selected>Select a Package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach                      
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="status" class="fw-medium">Status</label>
                        <select class="form-select form-select-sm form-control" id="status" name="status">
                            <option selected>Select a Client Status</option>
                            @foreach ($status_types as $status)
                                <option value="{{ $status->id }}">{{ $status->inv_name }}</option>
                            @endforeach                      
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="zone" class="fw-medium">Zone</label>
                        <select class="form-select form-select-sm form-control" id="zone" name="zone">
                            <option selected>Select a Zone</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                            @endforeach                      
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="client" class="fw-medium">Client Type</label>
                        <select class="form-select form-select-sm form-control" id="client" name="client">
                            <option selected>Select a Client Type</option>
                            @foreach ($client_categories as $categories)
                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                            @endforeach                   
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="billing_cycle" class="fw-medium">Billing Cycle</label>
                        <select class="form-select form-select-sm form-control" id="billing_cycle" name="billing_cycle">
                            <option selected>Select a Billing Cycle</option>
                            @foreach ($bill_cycles as $bill)
                                <option value="{{ $bill->id }}">{{ $bill->day }}</option>
                            @endforeach                   
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="exp_date" class="fw-medium">Exp Date</label>
                        <input type="text" class="form-control form-control-sm datepicker-here digits" value="" name="exp_date" id="exp_date" data-date-Format="yyyy-mm-dd">
                    </div>

                    <div class="col-sm-3 form-group">
                        <br class="d-none d-sm-block">
                        <input type="checkbox" class="form-check-input" id="due_client">
                        <label class="form-check-label" for="due_client">Due Client</label>
                    </div>

                    <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Show Report</button>
                    </div>
                </form>
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="p-3 pt-0">
                    <div class="sms-body-container">
                        <fieldset class="border rounded-3 p-3 pt-0 mb-3 theme-border">
                            <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">SMS Body</legend>
                            <div class="mb-2 form-group">
                                <label for="sms_template" class="fw-medium">SMS Template</label>
                                <select class="form-select form-select-sm form-control" id="sms_template" name="sms_template">
                                    <option selected>Select a SMS Template</option>
                                    @foreach ($sms_templates as $sms)
                                        <option value="{{ $sms->id }}">{{ $sms->command }}</option>
                                    @endforeach                   
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="sms_body" class="fw-medium">SMS Body</label>
                                <textarea class="form-control" id="sms_body" rows="2"></textarea>
                            </div>
                        </fieldset>
                    </div>

                    <div class="QA_table">
                        @php
                            $count  = 1;
                        @endphp
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sl</th>
                                        <th scope="col">Account No</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Client Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Bill Start Date</th>
                                        <th scope="col">Package Type</th>
                                        <th scope="col">Bill Cycle</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Total Dues</th>
                                        <th scope="col">Exp Date</th>
                                        <th scope="col">Client Status</th>
                                        <th scope="col"><input type="checkbox" class="form-check-input me-1" id="select_all_client">Select All</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <th scope="col"></th>
                                        <td scope="col">{{ $customer->id }}</td>
                                        <td scope="col">{{ $customer->customer_name }}</td>
                                        <td scope="col">{{ $customer->mobile1 }}</td>
                                        <td scope="col">{{ $customer->present_address }}</td>
                                        <td scope="col">{{ $customer->joining_date }}</td>
                                        <td scope="col">{{ $customer->TblClientType->name }}</td>
                                        <td scope="col">{{ $customer->TblBillCycle->day }}</td>
                                        <td scope="col">{{ $customer->rate_amnt }}</td>
                                        <td scope="col">{{ $total_dues }}</td>
                                        <td scope="col">{{ $customer->block_date }}</td>
                                        <td scope="col">{{ $customer->TblStatusType->inv_name }}</td>
                                        <td scope="col" class="text-center"><input type="checkbox" class="form-check-input checkbox" value="{{ $customer->id }}"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-sm btn-primary" value="Submit" onclick="this.disabled=true;this.form.submit();">
                    </div>
                </div>
            </form>
        </div>
    </form>
</div>

<script>
    var $loading = $('#load').hide();
    var select_all = document.getElementById("select_all_client"); //select all checkbox
    var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

    //select all checkboxes
    select_all.addEventListener("change", function(e){
        for (i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = select_all.checked;
        }
    });

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(this.checked == false){
                select_all.checked = false;
            }
            //check "select all" if all checkbox items are checked
            if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
                select_all.checked = true;
            }
        });
    }
</script>

@endsection