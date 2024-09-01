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

    <div class="main_content_iner mt-0">
        <div class="container-fluid p-0 sm_padding_15px">

            <div class="mb-2">
                <div class="px-4 py-1 theme_bg_1">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Static IP</h5>
                        <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addipModal">Add</a>
                    </div>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addipModal" tabindex="-1"
                aria-labelledby="addipModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addipModalLabel">Add New ip</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('staticip.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="name" class="form-label">Name: </label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="mb-2">
                                    <label for="range" class="form-label">Range: </label>
                                    <input type="text" class="form-control" id="range" name="range">
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status: </label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-sm btn-primary" value="Submit" onclick="this.disabled=true;this.form.submit();">
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
                    <table class="table datatable compact">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Name</th>
                                <th scope="col">Range</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stat_ips as $ip)
                                <tr style="height: 30px">
                                    <td style="color: black; font-size: small;">{{ $count++ }}</td> 
                                    <td style="color: black; font-size: small;">{{ $ip->name }}</td>
                                    <td style="color: black; font-size: small;">{{ $ip->range }}</td>
                                    <td style="color: black; font-size: small;">{{ $ip->status ==1 ? 'Active': 'Inactive'}}</td>
                                    <td class="text-end text-nowrap" width='10%'>
                                        <button class="btn btn-success py-0" data-bs-toggle="modal" data-bs-target="#editipModal{{ $ip->id }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger py-0" data-bs-toggle="modal" data-bs-target="#deleteipModal{{ $ip->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editipModal{{ $ip->id }}" tabindex="-1"
                                    aria-labelledby="editipModalLabel{{ $ip->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="editipModalLabel{{ $ip->id }}">Edit ip</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <form class="" id="editForm" method="POST" action="{{ route('staticip.update', ['staticip' => $ip]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="name" class="form-label">Name: </label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $ip->name }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="range" class="form-label">Range: </label>
                                                        <input type="text" class="form-control" id="range" name="range" value="{{ $ip->range }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="status" class="form-label">Status: </label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-sm btn-success" value="Submit" onclick="this.disabled=true;this.form.submit();">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteipModal{{ $ip->id }}" tabindex="-1"
                                    aria-labelledby="deleteipModalLabel{{ $ip->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteipModalLabel{{ $ip->id }}">Delete {{ $ip->name }}?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <form class="" id="editForm" method="POST" action="{{ route('staticip.destroy', ['staticip' => $ip]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="ip_name" class="form-label">Name: </label>
                                                        <input type="text" class="form-control" id="ip_name" name="ip_name" value="{{ $ip->name }}" disabled>
                                                    </div>
                                                    <div>
                                                        <label for="ip_value" class="form-label">Range: </label>
                                                        <input type="text" class="form-control" id="ip_name" name="ip_name" value="{{ $ip->range }}" disabled>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="status" class="form-label">Status: </label>
                                                        <select class="form-control" name="status" id="status" disabled>
                                                            <option {{ $ip->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                                            <option {{ $ip->status == 2 ? 'selected' : '' }} value="2">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-sm btn-danger" type="submit" onclick="this.disabled=true;this.form.submit();">Delete</button>
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
@endsection