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
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white;">IP</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addNewIp">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addNewIp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('ip.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Add IP</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label for="package" class="form-label">Package</label>
                                            <select class="form-select" aria-label="Small select example" id="package" name="package">
                                                <option selected>Select a Package</option>
                                                <option value="10 MB">10 MB</option>
                                                <option value="10 Days">10 Days</option>
                                                <option value="15 Days">15 Days</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="ip" class="form-label">IP</label>
                                            <input type="text" class="form-control" id="ip" name="ip">
                                        </div>
                                        <div>
                                            <label for="status" class="form-label">Status: </label>
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
                                <input type="submit" class="btn btn-sm btn-primary" value="Submit">
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
                                <th scope="col">Package</th>
                                <th scope="col">IP</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ips as $ip)
                            <tr>
                                <td>{{ $ip->id }}</td>
                                <td>{{ $ip->package }}</td>
                                <td>{{ $ip->ip }}</td>
                                <td>{{ $ip->status ==1 ? 'Active': 'Inactive'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_ip-{{$ip->id}}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_ip-{{ $ip->id }}">Delete</button>
                                </td>
                            </tr>
    
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_ip-{{$ip->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('ip.update', ['ip' => $ip])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit IP</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="package" class="form-label">Package</label>
                                                            <select class="form-select" aria-label="Small select example" id="package" name="package">
                                                                <option selected>{{ $ip->package}}</option>
                                                                <option value="10 MB">10 MB</option>
                                                                <option value="10 Days">10 Days</option>
                                                                <option value="15 Days">15 Days</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="ip">IP</label>
                                                            <input type="text" class="form-control" value="{{ $ip->ip}}" name="ip" id="ip">
                                                        </div>
                                                        <div>
                                                            <label for="status" class="form-label">Status: </label>
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
                                                <input type="submit" class="btn btn-sm btn-success" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete_ip-{{$ip->id}}" tabindex="-1" aria-labelledby="deleteIpModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('ip.destroy', ['ip' => $ip])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteIpModalLabel {{ $ip->id }}">Delete IP?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="package" class="form-label">Package</label>
                                                            <select class="form-select" aria-label="Small select example" id="package" name="package" disabled>
                                                                <option selected>{{ $ip->package}}</option>
                                                                <option value="10 MB">10 MB</option>
                                                                <option value="10 Days">10 Days</option>
                                                                <option value="15 Days">15 Days</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="ip">IP</label>
                                                            <input type="text" class="form-control" value="{{ $ip->ip}}" name="ip" id="ip" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-sm btn-danger" value="Delete" onclick="this.disabled=true;this.form.submit();">
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