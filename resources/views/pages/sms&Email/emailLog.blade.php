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

    <div class="main_content_iner mt-0">

        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">Email Log Report</h5>
                </div>
            </div>
            
            <div class="d-flex justify-content-around gap-4 mb-3">
                <div class="w-25">
                    <label for="" class="form-label fw-bold">From: </label>
                    <input class="form-control input_form" name="" id="start_datepicker" placeholder="Start date">
                </div>
                <div class="w-25">
                    <label for="" class="form-label fw-bold">To: </label>
                    <input class="form-control input_form" name="" id="end_datepicker" placeholder="End date">
                </div>
            </div>

            <div class="d-flex justify-content-center gap-4 mb-2 mt-4">
                <a class="btn btn-info">View</a>
                <a class="btn btn-warning" onclick="window.print()">Print</a>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Client Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Email Body</th>
                            <th scope="col">Return Message</th>
                            <th scope="col">Email Status</th>
                            <th scope="col">Send Time</th>
                            <th scope="col">API Name</th>
                            <th scope="col">Sender</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($emaillogs as $emaillog)
                            <tr>
                                <td></td>
                                <td>{{ $emaillog->email }}</td>
                                <td>{{ $emaillog->email_body }}</td>
                                <td>{{ $emaillog->return_message }}</td>
                                <td>{{ $emaillog->email_status }}</td>
                                <td>{{ $emaillog->date_time }}</td>
                                <td></td>
                                <td>{{ $emaillog->snder_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection