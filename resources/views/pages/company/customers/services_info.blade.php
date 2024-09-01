@extends("layouts.main")

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
    <div class="container-fluid p-0">
      <div class="row justify-content-center">
        <div class="">
          <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
              <h5 class="mb-0 text-white text-center">Services</h5>
              <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add</a>
          </div>
        </div>

        {{-- add modal --}}
        <div class="modal fade" id="addServiceModal" tabindex="-1"
          aria-labelledby="addServiceModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                <h1 class="modal-title fs-5 text-white" id="addServiceModalLabel">Add New Service</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close" style="filter: invert(100%);"></button>
              </div>
              <form method="POST" action="{{ route('services.store') }}">
                @csrf
                <div class="modal-body">
                  {{-- service information --}}
                  <fieldset class="border rounded-3 p-3 theme-border mb-5">
                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Information</legend>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="customer_id" class="form-label fw-bold">Customers Name</label>
                          <select class="select2 form-select form-select-sm" style="width: 100% !important;" id="customer_id" name="customer_id">
                            <option selected>Select a Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="srv_type_id" class="form-label fw-bold">Service Type</label>
                          <select onchange="addServices(this)" name="srv_type_id" id="srv_type_id" class="form-control form-select-sm">
                            <option value="">Select a Service</option>
                            @foreach ($service_types as $srv)
                                <option {{ ($srv->id == 2) ? "selected" : "" }} value="{{ $srv->id }}">{{ $srv->srv_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  {{-- Data Service/Other Service --}}
                  <fieldset class="border rounded-3 p-3 theme-border" id="add_data">
                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Data Service/Other Service</legend>
                    {{-- Service Info --}}
                    <fieldset class="border rounded-3 p-3 theme-border mb-5">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="link_from" class="form-label fw-bold">Link From</label>
                            <input type="text" class="form-control" id="link_from" name="link_from">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="link_to" class="form-label fw-bold">Link To</label>
                            <input type="text" class="form-control" id="link_to" name="link_to">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="bandwidth" class="form-label fw-bold">Bandwidth Capacity(K)</label>
                            <input type="text" class="form-control" id="bandwidth" name="bandwidth">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="unit_id" class="form-label fw-bold">Unit</label>
                            <select name="unit_id" id="unit_id" class="form-control">
                              <option value="">Select an Unit</option>
                              @foreach ($units as $unit)
                                  <option value="{{ $unit->id }}">{{ $unit->unit_display }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="unit_qty" class="form-label fw-bold">Quantity</label>
                            <input type="number" class="form-control" id="unit_qty" name="unit_qty">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="vat_rate" class="form-label fw-bold">VAT(%)</label>
                            <input type="number" class="form-control" id="vat_rate" name="vat_rate">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="rate_amnt" class="form-label fw-bold">Contact Amount</label>
                            <input type="number" class="form-control" id="rate_amnt" name="rate_amnt">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="vat_amnt" class="form-label fw-bold">VAT Amount</label>
                            <input type="number" class="form-control" id="vat_amnt" name="vat_amnt">
                          </div>
                        </div>
                      </div>
                    </fieldset>

                    {{-- Billing Info --}}
                    <fieldset class="border rounded-3 p-3 theme-border">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Billing Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="monthly_bill_data" class="form-label fw-bold">Monthly Bill </label>
                            <input type="text" class="form-control" id="monthly_bill_data" name="monthly_bill_data">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="include_vat_data" value="0">
                            <input type="checkbox" class="form-check-input" id="include_vat_data" name="include_vat_data" value="1" checked>
                            <label for="include_vat_data" class="form-label fw-bold ms-1">Include VAT </label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="bill_start_date_data" class="form-label fw-bold">Bill Start Date</label>
                            <input type="text" class="form-control datepicker-here digits" id="bill_start_date_data" data-date-Format="yyyy-mm-dd" name="bill_start_date_data">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_bill_type_id_data" class="form-label fw-bold">Bill Type</label>
                            <select name="tbl_bill_type_id_data" id="tbl_bill_type_id_data" class="form-control">
                              <option value="">Select a Bill Type</option>
                              @foreach ($bill_types as $bill_type)
                                  <option value="{{ $bill_type->id }}">{{ $bill_type->bill_type_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_status_type_id_data" class="form-label fw-bold">Service Status </label>
                            <select name="tbl_status_type_id_data" id="tbl_status_type_id_data" class="form-control">
                              <option value="">Select a Service Status</option>
                              @foreach ($status_types as $status_type)
                                  <option value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="remarks_data" class="form-label fw-bold">Remarks / Special Note </label>
                            <textarea class="form-control" id="remarks_data" name="remarks_data" rows="1"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="greeting_sms_sent_data" value="0">
                            <input type="checkbox" class="form-check-input" id="greeting_sms_sent_data" name="greeting_sms_sent_data" value="1">
                            <label for="greeting_sms_sent_data" class="form-label fw-bold ms-1">Send Greeting SMS? </label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </fieldset>

                  {{-- Broadband --}}
                  {{-- <fieldset class="border rounded-3 p-3 theme-border" id="add_broadband"> --}}
                    {{-- <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Broadband</legend> --}}
                    {{-- Service Info --}}
                    {{-- <fieldset class="border rounded-3 p-3 theme-border mb-5">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="user_id" class="form-label fw-bold">Customer ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="password" class="form-label fw-bold">Password </label>
                            <input type="password" class="form-control" id="password" name="password">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="bandwidth_plan_id" class="form-label fw-bold">Connection Type </label>
                            <select name="bandwidth_plan_id" id="bandwidth_plan_id" class="form-control">
                              <option value="">Select a Connection Type</option>
                              @foreach ($bandwidth_plans as $bandwidth_plan)
                                  <option value="{{ $bandwidth_plan->id }}">{{ $bandwidth_plan->bandwidth_plan }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="installation_date" class="form-label fw-bold">Installation Date </label>
                            <input type="text" class="form-control datepicker-here digits" id="installation_date" name="installation_date" data-date-Format="yyyy-mm-dd">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="remarks_broadband" class="form-label fw-bold">Remarks / Special Note </label>
                            <textarea class="form-control" id="remarks_broadband" name="remarks_broadband" rows="1"></textarea>
                          </div>
                        </div>
                      </div>
                    </fieldset> --}}
                  
                    {{-- Connection Info --}}
                    {{-- <fieldset class="border rounded-3 p-3 theme-border mb-5">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Connection Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="type_of_connectivity" class="form-label fw-bold">Type of Connectivity</label>
                            <select name="type_of_connectivity" id="type_of_connectivity" class="form-control">
                              <option value="">Select a Connectivity</option>
                              @foreach ($cable_types as $cable_type)
                                  <option value="{{ $cable_type->id }}">{{ $cable_type->cable_type }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="router_id" class="form-label fw-bold">Router</label>
                            <select name="router_id" id="router_id" class="form-control">
                              <option value="">Select a Router</option>
                              @foreach ($routers as $router)
                                  <option value="{{ $router->id }}">{{ $router->router_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="device" class="form-label fw-bold">Device </label>
                            <input type="text" class="form-control" id="device" name="device">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="mac_address" class="form-label fw-bold">Device MAC </label>
                            <input type="text" class="form-control" id="mac_address" name="mac_address">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="ip_number" class="form-label fw-bold">IP Number</label>
                            <input type="text" class="form-control" id="ip_number" name="ip_number">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="box_id" class="form-label fw-bold">Box </label>
                            <select name="box_id" id="box_id" class="form-control">
                              <option value="">Select a Box</option>
                              @foreach ($boxes as $box)
                                  <option value="{{ $box->id }}">{{ $box->box_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="cable_req" class="form-label fw-bold">Cable req </label>
                            <input type="text" class="form-control" id="cable_req" name="cable_req">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="no_of_core" class="form-label fw-bold">No. of Core </label>
                            <input type="text" class="form-control" id="no_of_core" name="no_of_core">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="core_color" class="form-label fw-bold">Core Color</label>
                            <input type="text" class="form-control" id="core_color" name="core_color">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="fiber_code" class="form-label fw-bold">Fiber Code </label>
                            <input type="text" class="form-control" id="fiber_code" name="fiber_code">
                          </div>
                        </div>
                      </div>
                    </fieldset> --}}

                    {{-- Billing Info --}}
                    {{-- <fieldset class="border rounded-3 p-3 theme-border">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Billing Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_bill_type_id_broadband" class="form-label fw-bold">Bill Type</label>
                            <select name="tbl_bill_type_id_broadband" id="tbl_bill_type_id_broadband" class="form-control">
                              <option value="">Select a Bill Type</option>
                              @foreach ($bill_types as $bill_type)
                                  <option value="{{ $bill_type->id }}">{{ $bill_type->bill_type_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="invoice_type_id" class="form-label fw-bold">Invoice Type </label>
                            <select name="invoice_type_id" id="invoice_type_id" class="form-control" disabled>
                              <option value="">Select an Invoice Type</option>
                              @foreach ($invoice_types as $invoice_type)
                                  <option {{ ($invoice_type->id == "1") ? "selected" : "" }} value="{{ $invoice_type->id }}">{{ $invoice_type->invoice_type_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="bill_start_date_broadband" class="form-label fw-bold">Bill Start Date</label>
                            <input type="text" class="form-control datepicker-here digits" id="bill_start_date_broadband" name="bill_start_date_broadband" data-date-Format="yyyy-mm-dd">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_client_type_id" class="form-label fw-bold">Package</label>
                            <select name="tbl_client_type_id" id="tbl_client_type_id" class="form-control">
                              <option value="">Select a Package</option>
                              @foreach ($client_types as $client_type)
                                  <option value="{{ $client_type->id }}">{{ $client_type->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="monthly_bill_broadband" class="form-label fw-bold">Monthly Bill </label>
                            <input type="text" class="form-control" id="monthly_bill_broadband" name="monthly_bill_broadband">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="billing_status_id" class="form-label fw-bold">Billing Status </label>
                            <select name="billing_status_id" id="billing_status_id" class="form-control">
                              <option value="">Select Billing Status</option>
                              @foreach ($billing_statuses as $billing_status)
                                  <option value="{{ $billing_status->id }}">{{ $billing_status->billing_status_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_status_type_id_broadband" class="form-label fw-bold">Service Status </label>
                            <select name="tbl_status_type_id_broadband" id="tbl_status_type_id_broadband" class="form-control">
                              <option value="">Select a Service Status</option>
                              @foreach ($status_types as $status_type)
                                  <option value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="include_vat_broadband" value="0">
                            <input type="checkbox" class="form-check-input" id="include_vat_broadband" name="include_vat_broadband" value="1" checked>
                            <label for="include_vat_broadband" class="form-label fw-bold ms-1">Include VAT </label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="greeting_sms_sent_broadband" value="0">
                            <input type="checkbox" class="form-check-input" id="greeting_sms_sent_broadband" name="greeting_sms_sent_broadband" value="1">
                            <label for="greeting_sms_sent_broadband" class="form-label fw-bold ms-1">Send Greeting SMS? </label>
                          </div>
                        </div>
                      </div>
                    </fieldset> --}}
                  {{-- </fieldset> --}}
                  
                  {{-- Cable TV --}}
                  <fieldset class="border rounded-3 p-3 theme-border d-none" id="add_cable_tv">
                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Cable TV</legend>
                    {{-- Service Info --}}
                    <fieldset class="border rounded-3 p-3 theme-border mb-5">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="number_of_tv" class="form-label fw-bold">Number of TV</label>
                            <input type="text" class="form-control" id="number_of_tv" name="number_of_tv">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="number_of_channel" class="form-label fw-bold">Number of Channel</label>
                            <input type="text" class="form-control" id="number_of_channel" name="number_of_channel">
                          </div>
                        </div>
                      </div>
                    </fieldset>

                    {{-- Billing Info --}}
                    <fieldset class="border rounded-3 p-3 theme-border">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Billing Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="monthly_bill_cable" class="form-label fw-bold">Monthly Bill </label>
                            <input type="text" class="form-control" id="monthly_bill_cable" name="monthly_bill_cable">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="include_vat_cable" value="0">
                            <input type="checkbox" class="form-check-input" id="include_vat_cable" name="include_vat_cable" value="1" checked>
                            <label for="include_vat_cable" class="form-label fw-bold ms-1">Include VAT </label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="bill_start_date_cable" class="form-label fw-bold">Bill Start Date</label>
                            <input type="text" class="form-control datepicker-here digits" id="bill_start_date_cable" name="bill_start_date_cable" data-date-Format="yyyy-mm-dd">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_bill_type_id_cable" class="form-label fw-bold">Bill Type</label>
                            <select name="tbl_bill_type_id_cable" id="tbl_bill_type_id_cable" class="form-control">
                              <option value="">Select a Bill Type</option>
                              @foreach ($bill_types as $bill_type)
                                  <option value="{{ $bill_type->id }}">{{ $bill_type->bill_type_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_status_type_id_cable" class="form-label fw-bold">Service Status </label>
                            <select name="tbl_status_type_id_cable" id="tbl_status_type_id_cable" class="form-control">
                              <option value="">Select a Service Status</option>
                              @foreach ($status_types as $status_type)
                                  <option value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="remarks_cable" class="form-label fw-bold">Remarks / Special Note </label>
                            <textarea class="form-control" id="remarks_cable" name="remarks_cable" rows="1"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="greeting_sms_sent_cable" value="0">
                            <input type="checkbox" class="form-check-input" id="greeting_sms_sent_cable" name="greeting_sms_sent_cable" value="1">
                            <label for="greeting_sms_sent_cable" class="form-label fw-bold ms-1">Send Greeting SMS? </label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </fieldset>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                  <button class="btn btn-sm btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-sm-12">
          <div class="p-3">
            <div class="row">
              <div class="col-sm-4 form-group">
                <label for="customer" class="fw-bold">Customer</label>
                <select class="select2 form-select form-select-sm id="customer" name="customer">
                  <option selected>Select a Customer</option>
                  @foreach ($customers as $customer)
                      <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-sm-4 form-group">
                <label for="tbl_status_type_id" class="fw-bold">Customer Status</label>
                <select class="select2 form-select form-select-sm" id="tbl_status_type_id" name="tbl_status_type_id">
                  <option selected>Select a Customer Status</option>
                  @foreach ($status_types as $status_type)
                      <option value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-sm-2 d-flex d-sm-inline justify-content-end">
                <br class="d-none d-sm-block">
                <button class="btn btn-sm btn-success">Search</button>    
              </div>
            </div>

            <div class="QA_table pb-0">
              <table class="table datatable compact">
                <thead>
                  <tr>
                    <th scope="col">Sl</th>
                    <th scope="col">Client Name</th>
                    <th scope="col">Service Type</th>
                    <th scope="col">Link From</th>
                    <th scope="col">Link To</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Status</th>
                    <th scope="col">Bill Type</th>
                    <th scope="col">Bill Start Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>

                <tbody>
                  @php $slNumber = 1 @endphp
                  @foreach ($client_services as $service)
                    <tr>
                      <td style="color: black; font-size: small;">{{ $slNumber++ }}</td>
                      <td style="color: black; font-size: small;">{{ $service->customer_name }}</td>
                      <td style="color: black; font-size: small;">{{ $service->srv_name }}</td>
                      <td style="color: black; font-size: small;">{{ $service->link_from }}</td>
                      <td style="color: black; font-size: small;">{{ $service->link_to }}</td>
                      <td style="color: black; font-size: small;">{{ $service->unit_display }}</td>
                      <td style="color: black; font-size: small;">{{ $service->unit_qty }}</td>
                      <td style="color: black; font-size: small;">{{ $service->inv_name }}</td>
                      <td style="color: black; font-size: small;">{{ $service->bill_type_name }}</td>
                      <td style="color: black; font-size: small;">{{ $service->bill_start_date }}</td>
                      <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">Edit</a>
                              <a class="dropdown-item" href="#" onclick="window.print()">Print</a>
                            </div>
                          </div>
                      </td>
                    </tr>

                    {{-- edit modal --}}
                    <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1"
                      aria-labelledby="editServiceModalLabel{{ $service->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="editServiceModalLabel{{ $service->id }}">Edit Service</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                              aria-label="Close" style="filter: invert(100%);"></button>
                          </div>
                          <form method="POST" action="{{ route('services.update', ['service' => $service->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                              {{-- service information --}}
                              <fieldset class="border rounded-3 p-3 theme-border mb-5">
                                <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Information</legend>
                                <div class="row">
                                  <div class="col-sm-4">
                                    <div class="mb-2">
                                      <label for="customer_id" class="form-label fw-bold">Customers Name</label>
                                      <input type="text" class="form-control form-select-sm" id="customer_id" name="customer_id" value="{{ $service->customer_name }}" readonly>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="mb-2">
                                      <label for="srv_type_id" class="form-label fw-bold">Service Type</label>
                                      <input type="text" class="form-control form-select-sm" id="srv_type_id{{ $service->srv_type_id }}" name="srv_type_id" value="{{ $service->srv_name }}" readonly>
                                      <input type="hidden" name="srv_type_id" value="{{ $service->srv_type_id }}">
                                    </div>
                                  </div>
                                </div>
                              </fieldset>

                              @if ($service->srv_type_id === 1)
                                {{-- Broadband --}}
                                <fieldset class="border rounded-3 p-3 theme-border" id="edit_broadband{{ $service->srv_type_id }}">
                                  <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Broadband</legend>
                                  {{-- Service Info --}}
                                  <fieldset class="border rounded-3 p-3 theme-border mb-5">
                                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Info</legend>
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="user_id" class="form-label fw-bold">Customer ID <span class="text-danger">*</span></label>
                                          <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $service->user_id }}" required>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                          <input type="password" class="form-control" id="password" name="password" value="{{ $service->password }}" required>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="bandwidth_plan_id" class="form-label fw-bold">Connection Type </label>
                                          <select name="bandwidth_plan_id" id="bandwidth_plan_id" class="form-control">
                                            @foreach ($bandwidth_plans as $bandwidth_plan)
                                                <option {{ ($service->bandwidth_plan_id == $bandwidth_plan->id) ? "selected" : "" }} value="{{ $bandwidth_plan->id }}">{{ $bandwidth_plan->bandwidth_plan }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="installation_date" class="form-label fw-bold">Installation Date </label>
                                          <input type="text" class="form-control datepicker-here digits" id="installation_date" name="installation_date" data-date-Format="yyyy-mm-dd" value="{{ $service->installation_date }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="remarks_broadband" class="form-label fw-bold">Remarks / Special Note </label>
                                          <textarea class="form-control" id="remarks_broadband" name="remarks_broadband" rows="1">{{ $service->remarks }}</textarea>
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>
                                
                                  {{-- Connection Info --}}
                                  <fieldset class="border rounded-3 p-3 theme-border mb-5">
                                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Connection Info</legend>
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="type_of_connectivity" class="form-label fw-bold">Type of Connectivity</label>
                                          <select name="type_of_connectivity" id="type_of_connectivity" class="form-control">
                                            @foreach ($cable_types as $cable_type)
                                                <option {{ ($service->type_of_connectivity == $cable_type->id) ? "selected" : "" }} value="{{ $cable_type->id }}">{{ $cable_type->cable_type }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="router_id" class="form-label fw-bold">Router</label>
                                          <select name="router_id" id="router_id" class="form-control">
                                            @foreach ($routers as $router)
                                                <option {{ ($service->router_id == $router->id) ? "selected" : "" }} value="{{ $router->id }}">{{ $router->router_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="device" class="form-label fw-bold">Device </label>
                                          <input type="text" class="form-control" id="device" name="device" value="{{ $service->device }}">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="mac_address" class="form-label fw-bold">Device MAC </label>
                                          <input type="text" class="form-control" id="mac_address" name="mac_address" value="{{ $service->mac_address }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="ip_number" class="form-label fw-bold">IP Number</label>
                                          <input type="text" class="form-control" id="ip_number" name="ip_number" value="{{ $service->ip_number }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="box_id" class="form-label fw-bold">Box </label>
                                          <select name="box_id" id="box_id" class="form-control">
                                            @foreach ($boxes as $box)
                                                <option {{ ($service->box_id == $box->id) ? "selected" : "" }} value="{{ $box->id }}">{{ $box->box_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="cable_req" class="form-label fw-bold">Cable req </label>
                                          <input type="text" class="form-control" id="cable_req" name="cable_req" value="{{ $service->cable_req }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="no_of_core" class="form-label fw-bold">No. of Core </label>
                                          <input type="text" class="form-control" id="no_of_core" name="no_of_core" value="{{ $service->no_of_core }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="core_color" class="form-label fw-bold">Core Color </label>
                                          <input type="text" class="form-control" id="core_color" name="core_color" value="{{ $service->core_color }}">
                                        </div>
                                      </div>
                                    </div>
                                        
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="fiber_code" class="form-label fw-bold">Fiber Code </label>
                                          <input type="text" class="form-control" id="fiber_code" name="fiber_code" value="{{ $service->fiber_code }}">
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>

                                  {{-- Billing Info --}}
                                  <fieldset class="border rounded-3 p-3 theme-border">
                                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Billing Info</legend>
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="tbl_bill_type_id_broadband" class="form-label fw-bold">Bill Type</label>
                                          <select name="tbl_bill_type_id_broadband" id="tbl_bill_type_id_broadband" class="form-control">
                                            @foreach ($bill_types as $bill_type)
                                                <option {{ ($service->tbl_bill_type_id == $bill_type->id) ? "selected" : "" }} value="{{ $bill_type->id }}">{{ $bill_type->bill_type_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="invoice_type_id" class="form-label fw-bold">Invoice Type </label>
                                          <select name="invoice_type_id" id="invoice_type_id" class="form-control" disabled>
                                            <option value="">Select an Invoice Type</option>
                                            @foreach ($invoice_types as $invoice_type)
                                                <option {{ ($service->invoice_type_id == $invoice_type->id) ? "selected" : "" }} value="{{ $invoice_type->id }}">{{ $invoice_type->invoice_type_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="bill_start_date_broadband" class="form-label fw-bold">Bill Start Date</label>
                                          <input type="text" class="form-control datepicker-here digits" id="bill_start_date_broadband" name="bill_start_date_broadband" data-date-Format="yyyy-mm-dd" value="{{ $service->bill_start_date }}">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="tbl_client_type_id" class="form-label fw-bold">Package </label>
                                          <select name="tbl_client_type_id" id="tbl_client_type_id" class="form-control">
                                            @foreach ($client_types as $client_type)
                                                <option {{ ($service->tbl_client_type_id == $client_type->id) ? "selected" : "" }} value="{{ $client_type->id }}">{{ $client_type->name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="monthly_bill_broadband" class="form-label fw-bold">Monthly Bill </label>
                                          <input type="text" class="form-control" id="monthly_bill_broadband" name="monthly_bill_broadband" value="{{ $service->monthly_bill }}">
                                        </div>
                                      </div>
                                      
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="billing_status_id" class="form-label fw-bold">Billing Status </label>
                                          <select name="billing_status_id" id="billing_status_id" class="form-control">
                                            @foreach ($billing_statuses as $billing_status)
                                                <option {{ ($service->billing_status_id == $billing_status->id) ? "selected" : "" }} value="{{ $billing_status->id }}">{{ $billing_status->billing_status_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="tbl_status_type_id_broadband" class="form-label fw-bold">Service Status </label>
                                          <select name="tbl_status_type_id_broadband" id="tbl_status_type_id_broadband" class="form-control">
                                            @foreach ($status_types as $status_type)
                                                <option {{ ($service->tbl_status_type_id == $status_type->id) ? "selected" : "" }} value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <br>
                                        <div class="mt-3">
                                          <input type="hidden" name="include_vat_broadband" value="0">
                                          <input type="checkbox" class="form-check-input" id="include_vat_broadband" name="include_vat_broadband" {{$service->include_vat == 1?'checked':''}} value="1">
                                          <label for="include_vat_broadband" class="form-label fw-bold ms-1">Include VAT </label>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <br>
                                        <div class="mt-3">
                                          <input type="hidden" name="greeting_sms_sent_broadband" value="0">
                                          <input type="checkbox" class="form-check-input" id="greeting_sms_sent_broadband" name="greeting_sms_sent_broadband" {{$service->greeting_sms_sent == 1?'checked':''}} value="1">
                                          <label for="greeting_sms_sent_broadband" class="form-label fw-bold ms-1">Send Greeting SMS? </label>
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>
                                </fieldset>
                              @elseif ($service->srv_type_id === 2)
                                {{-- Data Service/Other Service --}}
                                <fieldset class="border rounded-3 p-3 theme-border" id="edit_data{{ $service->srv_type_id }}">
                                  <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Data Service/Other Service</legend>
                                  {{-- Service Info --}}
                                  <fieldset class="border rounded-3 p-3 theme-border mb-5">
                                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Info</legend>
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="link_from" class="form-label fw-bold">Link From</label>
                                          <input type="text" class="form-control" id="link_from" name="link_from" value="{{ $service->link_from }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="link_to" class="form-label fw-bold">Link To</label>
                                          <input type="text" class="form-control" id="link_to" name="link_to" value="{{ $service->link_to }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="bandwidth" class="form-label fw-bold">Bandwidth Capacity(K)</label>
                                          <input type="text" class="form-control" id="bandwidth" name="bandwidth" value="{{ $service->bandwidth }}">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="unit_id" class="form-label fw-bold">Unit</label>
                                          <select name="unit_id" id="unit_id" class="form-control">
                                            <option value="">Select a Unit</option>
                                            @foreach ($units as $unit)
                                                <option {{ ($service->unit_id == $unit->id) ? "selected" : "" }} value="{{ $unit->id }}">{{ $unit->unit_display }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="unit_qty" class="form-label fw-bold">Quantity</label>
                                          <input type="number" class="form-control" id="unit_qty" name="unit_qty" value="{{ $service->unit_qty }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="vat_rate" class="form-label fw-bold">VAT(%)</label>
                                          <input type="number" class="form-control" id="vat_rate" name="vat_rate" value="{{ $service->vat_rate }}">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="rate_amnt" class="form-label fw-bold">Contact Amount</label>
                                          <input type="number" class="form-control" id="rate_amnt" name="rate_amnt" value="{{ $service->rate_amnt }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="vat_amnt" class="form-label fw-bold">VAT Amount</label>
                                          <input type="number" class="form-control" id="vat_amnt" name="vat_amnt" value="{{ $service->vat_amnt }}">
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>

                                  {{-- Billing Info --}}
                                  <fieldset class="border rounded-3 p-3 theme-border">
                                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Billing Info</legend>
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="monthly_bill_data" class="form-label fw-bold">Monthly Bill </label>
                                          <input type="text" class="form-control" id="monthly_bill_data" name="monthly_bill_data" value="{{ $service->monthly_bill }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <br>
                                        <div class="mt-3">
                                          <input type="hidden" name="include_vat_data" value="0">
                                          <input type="checkbox" class="form-check-input" id="include_vat_data" name="include_vat_data" {{$service->include_vat == 1?'checked':''}} value="1">
                                          <label for="include_vat_data" class="form-label fw-bold ms-1">Include VAT </label>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="bill_start_date_data" class="form-label fw-bold">Bill Start Date</label>
                                          <input type="text" class="form-control datepicker-here digits" id="bill_start_date_data" name="bill_start_date_data" data-date-Format="yyyy-mm-dd" value="{{ $service->bill_start_date }}">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="tbl_bill_type_id_data" class="form-label fw-bold">Bill Type</label>
                                          <select name="tbl_bill_type_id_data" id="tbl_bill_type_id_data" class="form-control">
                                            <option value="">Select a Bill Type</option>
                                            @foreach ($bill_types as $bill_type)
                                                <option {{ ($service->tbl_bill_type_id == $bill_type->id) ? "selected" : "" }} value="{{ $bill_type->id }}">{{ $bill_type->bill_type_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="tbl_status_type_id_data" class="form-label fw-bold">Service Status </label>
                                          <select name="tbl_status_type_id_data" id="tbl_status_type_id_data" class="form-control">
                                            <option value="">Select a Service Status</option>
                                            @foreach ($status_types as $status_type)
                                                <option {{ ($service->tbl_status_type_id == $status_type->id) ? "selected" : "" }} value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="remarks_data" class="form-label fw-bold">Remarks / Special Note </label>
                                          <textarea class="form-control" id="remarks_data" name="remarks_data" rows="1">{{ $service->remarks }}</textarea>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <br>
                                        <div class="mt-3">
                                          <input type="hidden" name="greeting_sms_sent_data" value="0">
                                          <input type="checkbox" class="form-check-input" id="greeting_sms_sent_data" name="greeting_sms_sent_data" {{$service->greeting_sms_sent == 1?'checked':''}} value="1">
                                          <label for="greeting_sms_sent_data" class="form-label fw-bold ms-1">Send Greeting SMS? </label>
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>
                                </fieldset>
                              @else
                                {{-- Cable TV --}}
                                <fieldset class="border rounded-3 p-3 theme-border" id="edit_cable_tv{{ $service->srv_type_id }}">
                                  <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Cable TV</legend>
                                  {{-- Service Info --}}
                                  <fieldset class="border rounded-3 p-3 theme-border mb-5">
                                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Info</legend>
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="number_of_tv" class="form-label fw-bold">Number of TV</label>
                                          <input type="text" class="form-control" id="number_of_tv" name="number_of_tv" value="{{ $service->number_of_tv }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="number_of_channel" class="form-label fw-bold">Number of Channel</label>
                                          <input type="text" class="form-control" id="number_of_channel" name="number_of_channel" value="{{ $service->number_of_channel }}">
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>

                                  {{-- Billing Info --}}
                                  <fieldset class="border rounded-3 p-3 theme-border">
                                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Billing Info</legend>
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="monthly_bill_cable" class="form-label fw-bold">Monthly Bill </label>
                                          <input type="text" class="form-control" id="monthly_bill_cable" name="monthly_bill_cable" value="{{ $service->monthly_bill }}">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <br>
                                        <div class="mt-3">
                                          <input type="hidden" name="include_vat_cable" value="0">
                                          <input type="checkbox" class="form-check-input" id="include_vat_cable" name="include_vat_cable" value="1" {{$service->include_vat == 1?'checked':''}}>
                                          <label for="include_vat_cable" class="form-label fw-bold ms-1">Include VAT </label>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="bill_start_date_cable" class="form-label fw-bold">Bill Start Date</label>
                                          <input type="text" class="form-control datepicker-here digits" id="bill_start_date_cable" name="bill_start_date_cable" data-date-Format="yyyy-mm-dd" value="{{ $service->bill_start_date }}">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="tbl_bill_type_id_cable" class="form-label fw-bold">Bill Type</label>
                                          <select name="tbl_bill_type_id_cable" id="tbl_bill_type_id_cable" class="form-control">
                                            <option value="">Select a Bill Type</option>
                                            @foreach ($bill_types as $bill_type)
                                                <option {{ ($service->tbl_bill_type_id == $bill_type->id) ? "selected" : "" }} value="{{ $bill_type->id }}">{{ $bill_type->bill_type_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="tbl_status_type_id_cable" class="form-label fw-bold">Service Status </label>
                                          <select name="tbl_status_type_id_cable" id="tbl_status_type_id_cable" class="form-control">
                                            <option value="">Select a Service Status</option>
                                            @foreach ($status_types as $status_type)
                                                <option {{ ($service->tbl_status_type_id == $status_type->id) ? "selected" : "" }} value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="mb-2">
                                          <label for="remarks_cable" class="form-label fw-bold">Remarks / Special Note </label>
                                          <textarea class="form-control" id="remarks_cable" name="remarks_cable" rows="1">{{ $service->remarks }}</textarea>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-4">
                                        <br>
                                        <div class="mt-3">
                                          <input type="hidden" name="greeting_sms_sent_cable" value="0">
                                          <input type="checkbox" class="form-check-input" id="greeting_sms_sent_cable" name="greeting_sms_sent_cable" {{$service->greeting_sms_sent == 1?'checked':''}} value="1">
                                          <label for="greeting_sms_sent_cable" class="form-label fw-bold ms-1">Send Greeting SMS? </label>
                                        </div>
                                      </div>
                                    </div>
                                  </fieldset>
                                </fieldset>
                              @endif
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                              <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('select2')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });

        function addServices(select){
          let dataSection = document.getElementById('add_data');
          // let broadbandSection = document.getElementById('add_broadband');
          let cableTvSection = document.getElementById('add_cable_tv');

          // if(select.value==1){
          //   broadbandSection.classList.remove("d-none");
          //   dataSection.classList.add("d-none");
          //   cableTvSection.classList.add("d-none");
          // } else if (select.value==2){
          //   broadbandSection.classList.add("d-none");
          //   dataSection.classList.remove("d-none");
          //   cableTvSection.classList.add("d-none");
          // } else if (select.value==3){
          //   cableTvSection.classList.remove("d-none");
          //   dataSection.classList.add("d-none");
          //   broadbandSection.classList.add("d-none");
          // }
          if(select.value==2){
            dataSection.classList.remove("d-none");
            cableTvSection.classList.add("d-none");
          } else if (select.value==3){
            cableTvSection.classList.remove("d-none");
            dataSection.classList.add("d-none");
          }
        }

        // function changeServices(serviceId){
        //   let serviceTypeId = document.getElementById('srv_type_id' + serviceId ).value;
        //   let dataSection = document.getElementById('edit_data'+ serviceId);
        //   let broadbandSection = document.getElementById('edit_broadband' + serviceId);
        //   let cableTvSection = document.getElementById('edit_cable_tv' + serviceId);

        //   if(serviceTypeId==1){
        //     dataSection.classList.remove("d-none");
        //     broadbandSection.classList.add("d-none");
        //     cableTvSection.classList.add("d-none");
        //   } else if (serviceTypeId==2){
        //     broadbandSection.classList.remove("d-none");
        //     dataSection.classList.add("d-none");
        //     cableTvSection.classList.add("d-none");
        //   } else if (serviceTypeId==3){
        //     cableTvSection.classList.remove("d-none");
        //     dataSection.classList.add("d-none");
        //     broadbandSection.classList.add("d-none");
        //   }
        // }
    </script>
  @endpush

@endsection