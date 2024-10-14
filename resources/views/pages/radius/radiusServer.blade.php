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
    <form action="{{ route('radius-server.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white;">Radius Server</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addNewIp">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addNewIp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('radius-server.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Add Radius Server</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label for="server_ip" class="form-label">Server IP</label>
                                            <input type="text" class="form-control" id="server_ip" name="server_ip">
                                        </div>
                                        <div class="mb-2">
                                            <label for="server_name" class="form-label">Server Name</label>
                                            <input type="text" class="form-control" id="server_name" name="server_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="auth_api_url" class="form-label">Auth API URL</label>
                                            <input type="text" class="form-control" id="auth_api_url" name="auth_api_url">
                                        </div>
                                        <div class="mb-2">
                                            <label for="acct_api_url" class="form-label">Acct API URL</label>
                                            <input type="text" class="form-control" id="acct_api_url" name="acct_api_url">
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
                                <th scope="col">Server IP</th>
                                <th scope="col">Server Name</th>
                                <th scope="col">Auth API URL</th>
                                <th scope="col">Acct API URL</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($radiusServer as $radius)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $radius->server_ip }}</td>
                                <td>{{ $radius->server_name }}</td>
                                <td>{{ $radius->auth_api_url }}</td>
                                <td>{{ $radius->acct_api_url }}</td>
                                <td>{{ $radius->status ==1 ? 'Active': 'Inactive'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_radius_server-{{$radius->id}}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_radius_server-{{ $radius->id }}">Delete</button>
                                </td>
                            </tr>
    
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_radius_server-{{$radius->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('radius-server.update', ['radius_server' => $radius])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit Radius Server</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="server_ip" class="form-label">Server IP</label>
                                                            <input type="text" class="form-control" id="server_ip" name="server_ip" value="{{ $radius->server_ip }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="server_name" class="form-label">Server Name</label>
                                                            <input type="text" class="form-control" id="server_name" name="server_name" value="{{ $radius->server_name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="auth_api_url" class="form-label">Auth API URl</label>
                                                            <input type="text" class="form-control" id="auth_api_url" name="auth_api_url" value="{{ $radius->auth_api_url }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="acct_api_url" class="form-label">Acct API URl</label>
                                                            <input type="text" class="form-control" id="acct_api_url" name="acct_api_url" value="{{ $radius->acct_api_url }}">
                                                        </div>
                                                        <div>
                                                            <label for="status" class="form-label">Status: </label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option {{$radius->status==1?'selected':''}} value="1">Active</option>
                                                                <option {{$radius->status==2?'selected':''}} value="2">Inactive</option>
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
                            <div class="modal fade" id="delete_radius_server-{{$radius->id}}" tabindex="-1" aria-labelledby="deleteRadiusServerModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('radius-server.destroy', ['radius_server' => $radius])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteRadiusServerModalLabel {{ $radius->id }}">Delete Radius Server?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="server_name" class="form-label">Server Name</label>
                                                            <input type="text" class="form-control" id="server_name" name="server_name" value="{{ $radius->server_name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="server_ip" class="form-label">Server IP</label>
                                                            <input type="text" class="form-control" id="server_ip" name="server_ip" value="{{ $radius->server_ip }}">
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