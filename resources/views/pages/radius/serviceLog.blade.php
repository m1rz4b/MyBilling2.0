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
    <form action="{{ route('ip.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <div class="">
                    <h5 class="mb-0 text-white">Service Log</h5>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                @php
                    $count  = 1;
                @endphp
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Client ID</th>
                                <th scope="col">Service ID</th>
                                <th scope="col">Action Name</th>
                                <th scope="col">Previus Value</th>
                                <th scope="col">Previus Rate</th>
                                <th scope="col">Previus Vat</th>
                                <th scope="col">Active Date</th>
                                <th scope="col">Current Value</th>
                                <th scope="col">Current Rate</th>
                                <th scope="col">Current Vat</th>
                                <th scope="col">Comments</th>
                                {{-- <th scope="col">Status</th> --}}
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($service_logs as $service)
                            <tr>
                                <td>{{ $count++ }}</td> 
                                <td>{{ $service->TrnClientsService->customer_id }}</td>
                                <td>{{ $service->TrnClientsService->id }}</td>
                                <td>Action Name</td>
                                <td>Previous Value</td>
                                <td>{{ $service->prate }}</td>
                                <td>{{ $service->pvat }}</td>
                                <td>{{ $service->rate_change_date }}</td>
                                <td>Current Value</td>
                                <td>{{ $service->crate }}</td>
                                <td>{{ $service->cvat }}</td>
                                <td>{{ $service->TrnClientsService->comments }}</td>
                                {{-- <td>{{ $service->status ==1 ? 'Active': 'Inactive'}}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection