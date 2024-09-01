@extends('layouts.main')

@section('main-container')
    <div class="main_content_iner mt-0">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">Radius Report</h5>
                </div>
            </div>

            {{-- <form action="{{route('accesslog.search')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row p-3">
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="from_date" class="form-label">From</label>
                        <input class="form-control input_form datepicker-here digits" name="from_date" id="from_date" value="{{ $nowdate }}" data-date-Format="yyyy-mm-dd" placeholder="Start date">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="to_date" class="form-label">To</label>
                        <input class="form-control input_form datepicker-here digits" name="to_date" id="to_date" value="{{ $nowdate }}" data-date-Format="yyyy-mm-dd" placeholder="End date">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="customer" class="form-label">Customer</label>
                        <select name="customer" id="customer" class="form-select form-control">
                            <option value="">Select a Customer</option>
                            <option value="Customer 1">Customer 1</option>
                            <option value="Customer 2">Customer 2</option>
                            <option value="Customer 3">Customer 3</option>
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="mac_address" class="form-label">Mac address</label>
                        <input type="text" name="mac_address" id="mac_address" placeholder="mac address" class="form-control">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="ip_address" class="form-label">IP address</label>
                        <input type="text" name="ip_address" id="ip_address" placeholder="ip address" class="form-control">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="nas" class="form-label">NAS</label>
                        <select name="nas" id="nas" class="form-select form-control">
                            <option value="-1" selected>Select a NAS</option>
                            @foreach ($nas as $ns)
                                <option value="{{ $ns->id }}">{{ $ns->shortname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
                
            <div class="d-flex justify-content-center gap-4 mb-2">
                <button type="button" class="btn btn-sm btn-info text-white" onclick="this.disabled=true;this.form.submit();"><i class="fa-sharp fa-solid fa-eye me-1"></i>View</button>
                <button type="button" class="btn btn-sm btn-warning text-white" onclick="this.disabled=true;window.print()"><i class="fa-solid fa-print me-1"></i>Print</button>
            </div> --}}

            <div class="QA_table p-3 pb-0">
                <h2 classname="mb-0 text-white">Search Results</h2>
                @if ($radaccts->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Acct ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">MAC Address</th>
                                <th scope="col">IP Address</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">Stop Time</th>
                                <th scope="col">NAS</th>
                            </tr>
                        </thead>
                        {{-- <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">IP</th>
                                <th scope="col">Mac Address</th>
                                <th scope="col">NAS</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
                                <th scope="col">Download</th>
                                <th scope="col">Upload</th>
                                <th scope="col">Session Time</th>
                                <th scope="col">Termination Cause</th>
                            </tr>
                        </thead> --}}
                        
                        <tbody>
                            @foreach ($radaccts as $radacct)
                                <tr>
                                    <td>{{ $radacct->acctsessionid }}</td>
                                    <td>{{ $radacct->username }}</td>
                                    <td>{{ $radacct->callingstationid }}</td>
                                    <td>{{ $radacct->framedipaddress }}</td>
                                    <td>{{ $radacct->acctstarttime }}</td>
                                    <td>{{ $radacct->acctstoptime }}</td>
                                    <td>{{ $radacct->nas->nasname ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tbody>
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
                        </tbody> --}}
                    </table>
                    {{ $radaccts->links() }}
                @else
                    <p>No records found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
