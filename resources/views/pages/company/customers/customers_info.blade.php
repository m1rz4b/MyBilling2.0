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
    <div class="container-fluid p-0 pb-3">
      <div class="row justify-content-center">
        {{-- Customers header --}}
        <div class="">
          <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
              <h5 class="mb-0 text-white text-center">Customers</h5>
              <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Add</a>
          </div>
        </div>

        {{-- add modal --}}
        <div class="modal fade" id="addCustomerModal" tabindex="-1"
          aria-labelledby="addCustomerModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                <h1 class="modal-title fs-5 text-white" id="addCustomerModalLabel">Add New Customer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close" style="filter: invert(100%);"></button>
              </div>
              <form class="" method="POST" action="{{ route('customers.store') }}">
                @csrf
                <div class="modal-body">

                  {{-- Customer Basic Information --}}
                  <fieldset class="border rounded-3 p-3 theme-border mb-5">
                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Customer Basic Information</legend>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="customer_name" class="form-label fw-bold">Customer Name <span class="text-danger">*</span> </label>
                          <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="father_or_husband_name" class="form-label fw-bold">Father/Husband Name </label>
                          <input type="text" class="form-control" id="father_or_husband_name" name="father_or_husband_name">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="mother_name" class="form-label fw-bold">Mother Name </label>
                          <input type="text" class="form-control" id="mother_name" name="mother_name">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="mobile1" class="form-label fw-bold">Mobile-1<span class="text-danger">*</span> </label>
                          <input type="text" class="form-control" id="mobile1" name="mobile1" required>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="mobile2" class="form-label fw-bold">Mobile-2</label>
                          <input type="text" class="form-control" id="mobile2" name="mobile2">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="phone" class="form-label fw-bold">Phone</label>
                          <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="gender" class="form-label fw-bold">Gender</label>
                          <select name="gender" id="gender" class="form-control">
                            <option value="">Select a Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Others</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="blood_group" class="form-label fw-bold">Blood Group </label>
                          <select name="blood_group" id="blood_group" class="form-control">
                            <option value="0">Select a Blood Group</option>
                            <option value="1">A + (Positive)</option>
                            <option value="2">A - (Negative)</option>
                            <option value="3">B + (Positive)</option>
                            <option value="4">B - (Negative)</option>
                            <option value="5">AB + (Positive)</option>
                            <option value="6">AB - (Negative)</option>
                            <option value="7">O + (Positive)</option>
                            <option value="8">O - (Negative)</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="date_of_birth" class="form-label fw-bold">Date Of Birth </label>
                          <input type="text" class="form-control datepicker-here digits" id="date_of_birth" name="date_of_birth" placeholder="dd/mm/yy" data-date-Format="yyyy-mm-dd">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="reg_form_no" class="form-label fw-bold">Registration form Number </label>
                          <input type="text" class="form-control" id="reg_form_no" name="reg_form_no">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="occupation" class="form-label fw-bold">Occupation </label>
                          <input type="text" class="form-control" id="occupation" name="occupation">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="contract_person" class="form-label fw-bold">Contract Person </label>
                          <input type="text" class="form-control" id="contract_person" name="contract_person">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="nid_number" class="form-label fw-bold">NID Number</label>
                          <input type="text" class="form-control" id="nid_number" name="nid_number">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="email" class="form-label fw-bold">Email</label>
                          <input type="text" class="form-control" id="email" name="email">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="fb_id" class="form-label fw-bold">Facebook ID</label>
                          <input type="text" class="form-control" id="fb_id" name="fb_id">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="road_no" class="form-label fw-bold">Road No</label>
                          <input type="text" class="form-control" id="road_no" name="road_no">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="house_flat_no" class="form-label fw-bold">House No</label>
                          <input type="text" class="form-control" id="house_flat_no" name="house_flat_no">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="area_id" class="form-label fw-bold">Area</label>
                          <select name="area_id" id="area_id" class="form-control">
                            <option value="">Select an Area</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="district_id" class="form-label fw-bold">District</label>
                          <select name="district_id" id="district_id" class="form-control">
                            <option value="">Select a District</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="upazila_id" class="form-label fw-bold">Upazila</label>
                          <select name="upazila_id" id="upazila_id" class="form-control">
                            <option value="">Select a Upazila</option>
                            @foreach ($upazilas as $upazila)
                                <option value="{{ $upazila->id }}">{{ $upazila->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="zone_id" class="form-label fw-bold">Zone </label>
                          <select name="zone_id" id="zone_id" class="form-control">
                            <option value="">Select a Zone</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="subzone_id" class="form-label fw-bold">Sub Zone </label>
                          <select name="subzone_id" id="subzone_id" class="form-control">
                            <option value="">Select a Sub Zone</option>
                            @foreach ($subzones as $subzone)
                                <option value="{{ $subzone->id }}">{{ $subzone->subzone_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="latitude" class="form-label fw-bold">Latitude </label>
                          <input type="text" class="form-control" id="latitude" name="latitude">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="longitude" class="form-label fw-bold">Longitude </label>
                          <input type="text" class="form-control" id="longitude" name="longitude">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="business_type_id" class="form-label fw-bold">Business Type </label>
                          <select name="business_type_id" id="business_type_id" class="form-control">
                            <option value="">Select a Business Type</option>
                            @foreach ($business_types as $business_type)
                                <option value="{{ $business_type->id }}">{{ $business_type->business_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="connection_employee_id" class="form-label fw-bold">Employee Connection </label>
                          <select name="connection_employee_id" id="connection_employee_id" class="form-control">
                            <option value="">Select an Employee</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="reference_by" class="form-label fw-bold">Reference By </label>
                          <input type="text" class="form-control" id="reference_by" name="reference_by">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="present_address" class="form-label fw-bold">Present Address</label>
                          <textarea class="form-control" id="present_address" name="present_address"></textarea>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="permanent_address" class="form-label fw-bold">Permanent Address </label>
                          <textarea class="form-control" id="permanent_address" name="permanent_address"></textarea>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="remarks" class="form-label fw-bold">Remarks / Special Note </label>
                          <textarea class="form-control" id="remarks" name="remarks"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="vat_status" class="form-label fw-bold">VAT Status </label>
                          <input type="text" class="form-control" id="vat_status" name="vat_status" value="Yes" readonly>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  {{-- Upload Picture --}}
                  <fieldset class="border rounded-3 p-3 theme-border mb-5">
                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Upload Picture</legend>
                    <div class="d-flex justify-content-between">
                      <div class="col-lg-3">
                        <div class="white_box">
                            <h5 class="">Profile Picture</h5>
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="profile_pic" name="profile_pic" accept=".png, .jpg, .jpeg" />
                                    <label for="profile_pic"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview"
                                        style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQioKINfcXK55EtAkOsFMG_CnHibqyNRI-tiPq_fGUVig&s);">
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="col-lg-3">
                        <div class="white_box h-100">
                            <h5 class="mb-0">NID / Birth Certificate Picture</h5>
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="nid_pic" name="nid_pic" accept=".png, .jpg, .jpeg" />
                                    <label for="nid_pic"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview"
                                        style="background-image: url(https://png.pngtree.com/png-vector/20221021/ourmid/pngtree-id-card-templateidentity-document-stock-icon-employee-sign-registered-vector-png-image_39834212.png);">
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="col-lg-3">
                        <div class="white_box h-100">
                            <h5 class="mb-0">Registration Form Picture</h5>
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="reg_form_pic" name="reg_form_pic" accept=".png, .jpg, .jpeg" />
                                    <label for="reg_form_pic"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview"
                                        style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfE5MgZNS1cCgi6bQLQdD7dgxK7aGqIa3yJQ&usqp=CAU);">
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  {{-- service information --}}
                  <fieldset class="border rounded-3 p-3 theme-border">
                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Information</legend>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="account_no" class="form-label fw-bold">A/C No.</label><br>
                          <span class="text-danger"><small>Customer ID automatically generated after save</small></span>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="tbl_client_category_id" class="form-label fw-bold">Client Category</label>
                          <select name="tbl_client_category_id" id="tbl_client_category_id" class="form-control">
                            <option value="">Select a Client Category</option>
                            @foreach ($client_categories as $client_category)
                                <option value="{{ $client_category->id }}">{{ $client_category->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="mb-2">
                          <label for="sub_office_id" class="form-label fw-bold">Branch</label>
                          <select name="sub_office_id" id="sub_office_id" class="form-control">
                            <option value="">Select a Branch</option>
                            @foreach ($sub_offices as $sub_office)
                                <option value="{{ $sub_office->id }}">{{ $sub_office->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <div class="d-flex justify-content-center mt-4 mb-3">
                    <div class="d-flex align-items-center">
                      <p class="me-2 text-dark fw-bold">Service Type: </p>
                      <input type="hidden" name="srv_type_id" value="1">
                      <input class="form-check-input mt-0" type="checkbox" name="srv_type_id" id="srv_type_id" value="1" checked disabled>
                      <p class="ms-2 text-dark fw-medium">Broadband</p>
                    </div>
                  </div>

                  {{-- Broadband --}}
                  <fieldset id="add_service_info" class="border rounded-3 p-3 theme-border">
                    <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Broadband</legend>
                    {{-- Service Info --}}
                    <fieldset class="border rounded-3 p-3 theme-border mb-5">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="user_id" class="form-label fw-bold">Customer ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
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
                            <label for="remarks" class="form-label fw-bold">Remarks / Special Note </label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="1"></textarea>
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
                            <label for="router_id" class="form-label fw-bold">Router <span class="text-danger">*</span></label>
                            <select name="router_id" id="router_id" class="form-control" required>
                              <option value="">Select a Router</option>
                              @foreach ($routers as $router)
                                  <option value="{{ $router->id }}">{{ $router->router_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="mac_address" class="form-label fw-bold">MAC Address</label>
                            <input type="text" class="form-control" id="mac_address" name="mac_address">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="ip_number" class="form-label fw-bold">IP Number</label>
                            <input type="text" class="form-control" id="ip_number" name="ip_number">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        {{-- <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="type_of_connectivity" class="form-label fw-bold">Type of Connectivity</label>
                            <select name="type_of_connectivity" id="type_of_connectivity" class="form-control">
                              <option value="">Select a Connectivity</option>
                              @foreach ($cable_types as $cable_type)
                                  <option value="{{ $cable_type->id }}">{{ $cable_type->cable_type }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> --}}
                        {{-- <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="device" class="form-label fw-bold">Device </label>
                            <input type="text" class="form-control" id="device" name="device">
                          </div>
                        </div> --}}
                        {{-- <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="box_id" class="form-label fw-bold">Box </label>
                            <select name="box_id" id="box_id" class="form-control">
                              <option value="">Select a Box</option>
                              @foreach ($boxes as $box)
                                  <option value="{{ $box->id }}">{{ $box->box_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> --}}
                      </div>

                      {{-- <div class="row">
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
                      </div> --}}

                      {{-- <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="fiber_code" class="form-label fw-bold">Fiber Code </label>
                            <input type="text" class="form-control" id="fiber_code" name="fiber_code">
                          </div>
                        </div>
                      </div> --}}
                    </fieldset>

                    {{-- Billing Info --}}
                    <fieldset class="border rounded-3 p-3 theme-border">
                      <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Billing Info</legend>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_bill_type_id" class="form-label fw-bold">Bill Type <span class="text-danger">*</span></label>
                            <select name="tbl_bill_type_id" id="tbl_bill_type_id" class="form-control" required>
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
                            <label for="bill_start_date" class="form-label fw-bold">Bill Start Date <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker-here digits" id="bill_start_date" name="bill_start_date" placeholder="dd/mm/yy" data-date-Format="yyyy-mm-dd" required>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_client_type_id" class="form-label fw-bold">Package <span class="text-danger">*</span></label>
                            <select name="tbl_client_type_id" id="tbl_client_type_id" class="form-control" required>
                              <option value="">Select a Package</option>
                              @foreach ($client_types as $client_type)
                                  <option value="{{ $client_type->id }}">{{ $client_type->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="monthly_bill" class="form-label fw-bold">Monthly Bill </label>
                            <input type="text" class="form-control" id="monthly_bill" name="monthly_bill">
                          </div>
                        </div>
                        {{-- <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="billing_status_id" class="form-label fw-bold">Billing Status </label>
                            <select name="billing_status_id" id="billing_status_id" class="form-control">
                              <option value="">Select Billing Status</option>
                              @foreach ($billing_statuses as $billing_status)
                                  <option value="{{ $billing_status->id }}">{{ $billing_status->billing_status_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> --}}
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="mb-2">
                            <label for="tbl_status_type_id" class="form-label fw-bold">Service Status <span class="text-danger">*</span></label>
                            <select name="tbl_status_type_id" id="tbl_status_type_id" class="form-control" required>
                              <option value="">Select a Service Status</option>
                              @foreach ($status_types as $status_type)
                                  <option {{$status_type->inv_name == 'Active' ? 'Selected' : '' }} value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="include_vat" value="0">
                            <input type="checkbox" class="form-check-input" id="include_vat" name="include_vat" value="1" checked>
                            <label for="include_vat" class="form-label fw-bold ms-1">Include VAT </label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <br>
                          <div class="mt-3">
                            <input type="hidden" name="greeting_sms_sent" value="0">
                            <input type="checkbox" class="form-check-input" id="greeting_sms_sent" name="greeting_sms_sent" value="1">
                            <label for="greeting_sms_sent" class="form-label fw-bold ms-1">Send Greeting SMS? </label>
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
          <form action="{{ route('customers.search') }}" method="POST" class="p-3">
            @csrf
            <div class="row">
              <div class="col-sm-4 mb-2">
                <label for="customer" class="form-label fw-bold">Customer</label>
                <select class="select2 form-select" id="customer" name="customer">
                  <option value="-1" selected>Select a Customer</option>
                  @foreach ($customers_dropdown as $cust)
                      <option {{ $selectedCustomer==$cust->customer_id ? 'selected' : '' }} value="{{ $cust->customer_id }}">{{ $cust->customer_name }}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-sm-4 mb-2">
                <label for="customer_category" class="form-label fw-bold">Customer Category</label>
                <select class="select2 form-select" id="customer_category" name="customer_category">
                  <option value="-1" selected>Select a Customer Category</option>
                  @foreach ($client_categories as $client_category)
                      <option {{ $selectedCustomerCategory==$client_category->id ? 'selected' : '' }} value="{{ $client_category->id }}">{{ $client_category->name }}</option>
                  @endforeach                      
                </select>
              </div>
              
              <div class="col-sm-4 mb-2">
                <label for="customer_status" class="form-label fw-bold">Customer Status</label>
                <select class="select2 form-select" id="customer_status" name="customer_status">
                  <option value="-1" selected>Select a Customer Status</option>
                  @foreach ($status_types as $status_type)
                      <option {{ $selectedCustomerStatus==$status_type->id ? 'selected' : '' }} value="{{ $status_type->id }}">{{ $status_type->inv_name }}</option>
                  @endforeach
                </select>
              </div>    
            </div>

            <div class="row">
              <div class="col-sm-4 mb-2">
                <label for="package" class="form-label fw-bold">Package</label>
                <select class="select2 form-select" id="package" name="package">
                  <option value="-1" selected>Select a Package</option>
                  @foreach ($client_types as $client_type)
                      <option {{ $selectedPackage==$client_type->id ? 'selected' : '' }} value="{{ $client_type->id }}">{{ $client_type->name }}</option>
                  @endforeach 
                </select>
              </div> 
              
              <div class="col-sm-4 mb-2">
                <label for="zone" class="form-label fw-bold">Zone</label>
                <select class="select2 form-select" id="zone" name="zone">
                  <option value="-1" selected>Select a Zone</option>
                  @foreach ($zones as $zone)
                      <option {{ $selectedZone==$zone->id ? 'selected' : '' }} value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-sm-4 mb-2">
                <label for="subzone" class="form-label fw-bold">Sub Zone</label>
                <select class="select2 form-select" id="subzone" name="subzone">
                  <option value="-1" selected>Select a Sub Zone</option>
                  @foreach ($subzones as $subzone)
                      <option {{ $selectedSubZone==$subzone->id ? 'selected' : '' }} value="{{ $subzone->id }}">{{ $subzone->subzone_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>    
            </div>
          </form>

          <div class="QA_table p-3 pb-0">
            <table class="table datatable compact">
              <thead>
                <tr>
                  <th scope="col">Sl</th>
                  <th scope="col">User ID</th>
                  <th scope="col">Customer Name</th>
                  <th scope="col">IP Address</th>
                  <th scope="col">Mobile</th>
                  <th scope="col">Package</th>
                  <th scope="col">Client Status</th>
                  <th scope="col">Bill Start Date</th>
                  <th scope="col">Client Cateory</th>
                  <th scope="col">Bill Type</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $slNumber = 1 @endphp
                @foreach ($customers as $cust)
                  <tr>
                    <td style="color: black; font-size: small;">{{ $slNumber++ }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->user_id }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->customer_name }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->ip_number }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->mobile1 }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->package }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->inv_name }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->bill_start_date }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->client_type_name }}</td>
                    <td style="color: black; font-size: small;">{{ $cust->bill_type_name }}</td>
                    <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $cust->customer_id }}">Edit</a>
                            <a class="dropdown-item" href="#" onclick="window.print()">Print</a>
                          </div>
                        </div>
                    </td>
                  </tr>

                  {{-- edit modal --}}
                  <div class="modal fade" id="editCustomerModal{{ $cust->customer_id }}" tabindex="-1"
                    aria-labelledby="editCustomerModalLabel{{ $cust->customer_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                          <h1 class="modal-title fs-5 text-white" id="editCustomerModalLabel{{ $cust->customer_id }}">Edit Customer</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        
                        <form class="" method="POST" action="{{ route('customers.update', ['customer' => $cust->customer_id]) }}">
                          @csrf
                          @method('PUT')
                          <div class="modal-body">

                            {{-- Customer Basic Information --}}
                            <fieldset class="border rounded-3 p-3 theme-border mb-5">
                              <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Customer Basic Information</legend>
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="customer_name" class="form-label fw-bold">Customer Name <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $cust->customer_name }}" required>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="father_or_husband_name" class="form-label fw-bold">Father Name/Husband Name</label>
                                    <input type="text" class="form-control" id="father_or_husband_name" name="father_or_husband_name" value="{{ $cust->father_or_husband_name }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="mother_name" class="form-label fw-bold">Mother Name </label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{ $cust->mother_name }}">
                                  </div>
                                </div>
                              </div>
                                                                  
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="mobile1" class="form-label fw-bold">Mobile-1<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="mobile1" name="mobile1" value="{{ $cust->mobile1 }}" required>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="mobile2" class="form-label fw-bold">Mobile-2</label>
                                    <input type="text" class="form-control" id="mobile2" name="mobile2" value="{{ $cust->mobile2 }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="phone" class="form-label fw-bold">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $cust->phone }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="gender" class="form-label fw-bold">Gender </label>
                                    <select name="gender" id="gender" class="form-control">
                                      <option {{ $cust->gender == "1" ? "selected" : "" }} value="1">Male</option>
                                      <option {{ $cust->gender == "2" ? "selected" : "" }} value="2">Female</option>
                                      <option {{ $cust->gender == "3" ? "selected" : "" }} value="3">Others</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="blood_group" class="form-label fw-bold">Blood Group </label>
                                    <select name="blood_group" id="blood_group" class="form-control">
                                      <option {{ $cust->blood_group == "1" ? "selected" : "" }} value="1">A + (Positive)</option>
                                      <option {{ $cust->blood_group == "2" ? "selected" : "" }} value="2">A - (Negative)</option>
                                      <option {{ $cust->blood_group == "3" ? "selected" : "" }} value="3">B + (Positive)</option>
                                      <option {{ $cust->blood_group == "4" ? "selected" : "" }} value="4">B - (Negative)</option>
                                      <option {{ $cust->blood_group == "5" ? "selected" : "" }} value="5">AB + (Positive)</option>
                                      <option {{ $cust->blood_group == "6" ? "selected" : "" }} value="6">AB - (Negative)</option>
                                      <option {{ $cust->blood_group == "7" ? "selected" : "" }} value="7">O + (Positive)</option>
                                      <option {{ $cust->blood_group == "8" ? "selected" : "" }} value="8">O - (Negative)</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="date_of_birth" class="form-label fw-bold">Date Of Birth </label>
                                    <input type="text" class="form-control datepicker-here digits" id="date_of_birth" name="date_of_birth" placeholder="dd/mm/yy" data-date-Format="yyyy-mm-dd" value="{{ $cust->date_of_birth }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="reg_form_no" class="form-label fw-bold">Registration form Number </label>
                                    <input type="text" class="form-control" id="reg_form_no" name="reg_form_no" value="{{ $cust->reg_form_no }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="occupation" class="form-label fw-bold">Occupation </label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $cust->occupation }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="contract_person" class="form-label fw-bold">Contract Person </label>
                                    <input class="form-control" id="contract_person" name="contract_person" value="{{ $cust->contract_person }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="nid_number" class="form-label fw-bold">NID Number</label>
                                    <input type="text" class="form-control" id="nid_number" name="nid_number" value="{{ $cust->nid_number }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ $cust->email }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="fb_id" class="form-label fw-bold">Facebook ID </label>
                                    <input type="text" class="form-control" id="fb_id" name="fb_id" value="{{ $cust->fb_id }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="road_no" class="form-label fw-bold">Road No</label>
                                    <input type="text" class="form-control" id="road_no" name="road_no" value="{{ $cust->road_no }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="house_flat_no" class="form-label fw-bold">House No</label>
                                    <input type="text" class="form-control" id="house_flat_no" name="house_flat_no" value="{{ $cust->house_flat_no }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="area_id" class="form-label fw-bold">Area</label>
                                    <select name="area_id" id="area_id" class="form-control">
                                      @foreach ($areas as $area)
                                          <option {{ ($cust->area_id == $area->id) ? "selected" : "" }} value="{{ $area->id }}">{{ $area->area_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                                  
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="district_id" class="form-label fw-bold">District</label>
                                    <select name="district_id" id="district_id" class="form-control">
                                      @foreach ($districts as $district)
                                          <option {{ ($cust->district_id == $district->id) ? "selected" : "" }} value="{{ $district->id }}">{{ $district->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="upazila_id" class="form-label fw-bold">Upazila</label>
                                    <select name="upazila_id" id="upazila_id" class="form-control">
                                      @foreach ($upazilas as $upazila)
                                          <option {{ ($cust->upazila_id == $upazila->id) ? "selected" : "" }} value="{{ $upazila->id }}">{{ $upazila->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="zone_id" class="form-label fw-bold">Zone</label>
                                    <select name="zone_id" id="zone_id" class="form-control">
                                      @foreach ($zones as $zone)
                                          <option {{ ($cust->tbl_zone_id == $zone->id) ? "selected" : "" }} value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                                  
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="subzone_id" class="form-label fw-bold">Sub Zone </label>
                                    <select name="subzone_id" id="subzone_id" class="form-control">
                                      @foreach ($subzones as $subzone)
                                          <option {{ ($cust->subzone_id == $subzone->id) ? "selected" : "" }} value="{{ $subzone->id }}">{{ $subzone->subzone_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="latitude" class="form-label fw-bold">Latitude </label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $cust->latitude }}">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="longitude" class="form-label fw-bold">Longitude </label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $cust->longitude }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="business_type_id" class="form-label fw-bold">Business Type </label>
                                    <select name="business_type_id" id="business_type_id" class="form-control">
                                      @foreach ($business_types as $business_type)
                                          <option {{ ($cust->business_type_id == $business_type->id) ? "selected" : "" }} value="{{ $business_type->id }}">{{ $business_type->business_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="connection_employee_id" class="form-label fw-bold">Employee Connection </label>
                                    <select name="connection_employee_id" id="connection_employee_id" class="form-control">
                                      @foreach ($employees as $employee)
                                          <option {{ ($cust->connection_employee_id == $employee->id) ? "selected" : "" }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="reference_by" class="form-label fw-bold">Reference By </label>
                                    <input type="text" class="form-control" id="reference_by" name="reference_by" value="{{ $cust->reference_by }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="present_address" class="form-label fw-bold">Present Address</label>
                                    <textarea class="form-control" id="present_address" name="present_address">{{ $cust->present_address }}</textarea>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="permanent_address" class="form-label fw-bold">Permanent Address </label>
                                    <textarea class="form-control" id="permanent_address" name="permanent_address">{{ $cust->permanent_address }}</textarea>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="remarks" class="form-label fw-bold">Remarks / Special Note </label>
                                    <textarea class="form-control" id="remarks" name="remarks">{{ $cust->remarks }}</textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="vat_status" class="form-label fw-bold">VAT Status </label>
                                    <select readonly name="vat_status" id="vat_status" class="form-control">
                                      <option selected value="Yes">Yes</option>
                                      <option value="No">No</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </fieldset>

                            {{-- Upload Picture --}}
                            <fieldset class="border rounded-3 p-3 theme-border mb-5">
                              <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Upload Picture</legend>
                              <div class="d-flex justify-content-between">
                                <div class="col-lg-3">
                                  <div class="white_box">
                                      <h5 class="">Profile Picture</h5>
                                      <div class="avatar-upload">
                                          <div class="avatar-edit">
                                              <input type='file' id="profile_pic" name="profile_pic" accept=".png, .jpg, .jpeg" />
                                              <label for="profile_pic"></label>
                                          </div>
                                          <div class="avatar-preview">
                                              <div id="imagePreview"
                                                  style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQioKINfcXK55EtAkOsFMG_CnHibqyNRI-tiPq_fGUVig&s);">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <div class="col-lg-3">
                                  <div class="white_box h-100">
                                      <h5 class="mb-0">NID / Birth Certificate Picture</h5>
                                      <div class="avatar-upload">
                                          <div class="avatar-edit">
                                              <input type='file' id="nid_pic" name="nid_pic" accept=".png, .jpg, .jpeg" />
                                              <label for="nid_pic"></label>
                                          </div>
                                          <div class="avatar-preview">
                                              <div id="imagePreview"
                                                  style="background-image: url(https://png.pngtree.com/png-vector/20221021/ourmid/pngtree-id-card-templateidentity-document-stock-icon-employee-sign-registered-vector-png-image_39834212.png);">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <div class="col-lg-3">
                                  <div class="white_box h-100">
                                      <h5 class="mb-0">Registration Form Picture</h5>
                                      <div class="avatar-upload">
                                          <div class="avatar-edit">
                                              <input type='file' id="reg_form_pic" name="reg_form_pic" accept=".png, .jpg, .jpeg" />
                                              <label for="reg_form_pic"></label>
                                          </div>
                                          <div class="avatar-preview">
                                              <div id="imagePreview"
                                                  style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfE5MgZNS1cCgi6bQLQdD7dgxK7aGqIa3yJQ&usqp=CAU);">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </fieldset>

                            {{-- Service information --}}
                            <fieldset class="border rounded-3 p-3 theme-border">
                              <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">Service Information</legend>
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="account_no" class="form-label fw-bold">A/C No.</label><br>
                                    <span class="text-danger"><small>Customer ID automatically generated after save</small></span>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="tbl_client_category_id" class="form-label fw-bold">Client Category </label>
                                    <select name="tbl_client_category_id" id="tbl_client_category_id" class="form-control">
                                      @foreach ($client_categories as $client_category)
                                          <option {{ ($cust->client_category == $client_category->id) ? "selected" : "" }} value="{{ $client_category->id }}">{{ $client_category->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-2">
                                    <label for="sub_office_id" class="form-label fw-bold">Branch</label>
                                    <select name="sub_office_id" id="sub_office_id" class="form-control">
                                      @foreach ($sub_offices as $sub_office)
                                          <option {{ ($cust->sub_office == $sub_office->id) ? "selected" : "" }} value="{{ $sub_office->id }}">{{ $sub_office->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </fieldset>
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
            {!! $customers->links() !!}
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

        const addBroadband = document.getElementById('srv_type_id');
        const addServiceInfo = document.getElementById('add_service_info');

        addBroadband.addEventListener('change', function() {
          if (this.checked) {
            addServiceInfo.classList.remove("d-none");
          } else {
            addServiceInfo.classList.add("d-none");
          }
        });

        const editBroadband = document.getElementById('edit_broadband');
        const editServiceInfo = document.getElementById('edit_service_info');

        editBroadband.addEventListener('change', function() {
          if (this.checked) {
            editServiceInfo.classList.remove("d-none");
          } else {
            editServiceInfo.classList.add("d-none");
          }
        });
    </script>
  @endpush

@endsection