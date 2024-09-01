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
    <form action="{{ route('smssetup.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white;">SMS Setup</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addNewBlockReason"><small><i class="fa-solid fa-plus me-1 fw-extrabold"></i></small>SMS</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addNewBlockReason" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('smssetup.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Add SMS</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label for="name" class="fw-medium">Name</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="sms_url" class="fw-medium">URL</label>
                                            <input type="text" class="form-control" id="sms_url" name="sms_url">
                                        </div>
                                        <div class="mb-2">
                                            <label for="submit_param" class="fw-medium">SMS Param (username =your user name, password=your password, receiver = @{{mobile}},message = @{{smsbody}} Others parameters add like this ) Do not change @{{mobile}},@{{smsbody}}</label>
                                            <textarea name="submit_param" id="submit_param" class="form-control"></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label for="type" class="fw-medium">Submit Type: </label>
                                            <select class="form-control" name="type" id="type">
                                                <option selected>Select Any</option>
                                                <option value="get">Get</option>
                                                <option value="post">Post</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="status" class="fw-medium">Status: </label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-sm btn-primary" value="Add" onclick="this.disabled=true;this.form.submit();">
                            </div>
                        </form>
                    </div>
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
                                <th scope="col">Name</th>
                                <th scope="col">URL</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($sms_setup as $sms)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $sms->name }}</td>
                                <td>{{ $sms->sms_url }}</td>
                                <td>{{ $sms->status ==1 ? 'On': 'Off'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_sms_template-{{$sms->id}}">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_sms_template-{{$sms->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('smssetup.update', ['smssetup' => $sms])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit SMS</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="name" class="fw-medium">Name</label>
                                                            <input type="text" class="form-control" id="name" value="{{ $sms->name }}" name="name">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="sms_url" class="fw-medium">URL</label>
                                                            <input type="text" class="form-control" id="sms_url" value="{{ $sms->sms_url }}" name="sms_url">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="submit_param" class="fw-medium">SMS Param (username =your user name, password=your password, receiver = @{{mobile}},message = @{{smsbody}} Others parameters add like this ) Do not change @{{mobile}},@{{smsbody}}</label>
                                                            <textarea name="submit_param" id="submit_param" class="form-control">{{ $sms->submit_param }}</textarea>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="type" class="fw-medium">Submit Type: </label>
                                                            <select class="form-control" name="type" id="type">
                                                                <option selected>Select Any</option>
                                                                <option {{ ($sms->type == "get") ? "selected" : "" }} value="get">Get</option>
                                                                <option {{ ($sms->type == "post") ? "selected" : "" }} value="post">Post</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="status" class="fw-medium">Status: </label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option {{ ($sms->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                                <option {{ ($sms->status == "1") ? "selected" : "" }} value="1">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-sm btn-success" value="Update" onclick="this.disabled=true;this.form.submit();">
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
    </form>
</div>

@endsection