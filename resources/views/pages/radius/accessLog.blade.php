@extends('layouts.main')

@section('main-container')
    <div class="main_content_iner mt-0">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">Radius Report</h5>
                </div>
            </div>

            <form action="{{route('accesslog.search')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row p-3">
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="start_date" class="form-label">From</label>
                        <input class="form-control input_form datepicker-here digits" name="start_date" id="start_date" data-date-Format="yyyy-mm-dd" value="{{ $nowdate }}" placeholder="Start date">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="end_date" class="form-label">To</label>
                        <input class="form-control input_form datepicker-here digits" name="end_date" id="end_date" data-date-Format="yyyy-mm-dd" value="{{ $nowdate }}" placeholder="End date">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="customer" class="form-label">Customer</label>
                        <select name="customer" id="customer" class="form-select form-control">
                            <option value="-1">Select a Customer</option>
                            @foreach ($customers as $customer)
                                <option {{ $selectedCustomer==$customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->user_id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="mac_address" class="form-label">Mac address</label>
                        <input type="text" name="mac_address" id="mac_address" value="{{$selectedMacAddress}}" placeholder="mac address" class="form-control">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="ip_address" class="form-label">IP address</label>
                        <input type="text" name="ip_address" id="ip_address" value="{{$selectedIpAddress}}" placeholder="ip address" class="form-control">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="nas" class="form-label">NAS</label>
                        <select name="nas" id="nas" class="form-select form-control">
                            <option value="-1" selected>Select a NAS</option>
                            @foreach ($nas as $ns)
                                <option {{ $selectedNas==$ns->id? 'selected' : '' }} value="{{ $ns->id }}">{{ $ns->shortname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-center gap-4">
                        <button type="button" class="btn btn-sm btn-info text-white" onclick="this.disabled=true;this.form.submit();"><i class="fa-sharp fa-solid fa-eye me-1"></i>View</button>
                        <button type="button" class="btn btn-sm btn-warning text-white" onclick="this.disabled=true;window.print()"><i class="fa-solid fa-print me-1"></i>Print</button>
                    </div>
                </div>
            </form>

            <div class="QA_table px-3 ">
                @if ($radaccts->count())
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col"><small class="text-nowrap">ID</small></th>
                                    <th scope="col"><small class="text-nowrap">IP</small></th>
                                    <th scope="col"><small class="text-nowrap">Mac Address</small></th>
                                    <th scope="col"><small class="text-nowrap">NAS</small></th>
                                    <th scope="col"><small class="text-nowrap">Start Time</small></th>
                                    <th scope="col"><small class="text-nowrap">End Time</small></th>
                                    <th scope="col"><small class="text-nowrap">Download</small></th>
                                    <th scope="col"><small class="text-nowrap">Upload</small></th>
                                    <th scope="col"><small class="text-nowrap">Session Time</small></th>
                                    <th scope="col"><small class="text-nowrap">Termination Cause</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($radaccts as $radacct)
                                    <tr>
                                        <td>{{ $radacct->username }}</td>
                                        <td>{{ $radacct->framedipaddress }}</td>
                                        <td>{{ $radacct->callingstationid }}</td>
                                        <td>{{ $radacct->nasipaddress }}</td>
                                        <td>{{ $radacct->acctstarttime }}</td>
                                        <td>{{ $radacct->acctstoptime }}</td>
                                        <td>{{ $radacct->acctinputoctets/(131072*1024) }}</td>
                                        <td>{{ $radacct->cctoutputoctets/(131072*1024) }}</td>
                                        <td>{{ $radacct->acctsessiontime/60 }}</td>
                                        <td>{{ $radacct->acctterminatecause }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No records found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection