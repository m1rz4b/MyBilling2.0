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
                <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                    <h5 class="mb-0 text-white text-center">Mikrotik Graph</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addMikrotikModal">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addMikrotikModal" tabindex="-1" aria-labelledby="addMikrotikModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addMikrotikModalLabel">Add New Mikrotik Graph</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>

                        <form class="" method="POST" action="{{ route('mikrotikgraph.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2 d-flex flex-column">
                                    <label for="router_id" class="form-label">Router </label>
                                    <select name="router_id" id="router_id" class="form-select">
                                        <option value="">Select a Router</option>
                                        @foreach ($routers as $router)
                                            <option value="{{ $router->id }}">{{ $router->router_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 d-flex flex-column">
                                    <label for="interface" class="form-label">Interface </label>
                                    <select name="interface" id="interface" class="form-select">
                                        <option value="">Select an Interface</option>
                                        @foreach ($routers as $router)
                                            <option value="{{ $router->lan_interface }}">{{ $router->lan_interface }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="allow_address" class="form-label">Allow Address </label>
                                    <input type="text" class="form-control border border-secondary" placeholder="0.0.0.0/0" id="allow_address" name="allow_address">
                                </div>
                                <div class="mb-2 d-flex flex-column">
                                    <label for="store_on" class="form-label">Store On Disk </label>
                                    <select name="store_on" id="store_on" class="form-select">
                                        <option value="yes">yes</option>
                                        <option value="no">no</option>
                                    </select>
                                </div>
                                <div class="mb-2 d-flex flex-column">
                                    <label for="status" class="form-label">Status </label>
                                    <select name="status" id="status" class="form-select">
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
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#SL</th>
                            <th scope="col">Router Name</th>
                            <th scope="col">Interface</th>
                            <th scope="col">Allow Address</th>
                            <th scope="col">Store On Disk</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $slNumber = 1 @endphp
                        @foreach ($mikrotiks as $mikrotik)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                @foreach ($routers as $router)
                                    @if ($mikrotik->router_id == $router->id)
                                        <td>{{ $router->router_name }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $mikrotik->interface }}</td>
                                <td>{{ $mikrotik->allow_address }}</td>
                                <td>{{ $mikrotik->store_on }}</td>
                                <td>{{ $mikrotik->status == 1 ? 'Active': 'Inactive' }}</td>
                                <td class="text-center text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_mikrotik_modal-{{$mikrotik->id}}">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_mikrotik_modal-{{ $mikrotik->id }}" tabindex="-1" aria-labelledby="editMikrotikModalLabel{{ $mikrotik->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editMikrotikModalLabel{{ $mikrotik->id }}">Edit Mikrotik</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form class="" id="editForm" method="POST" action="{{ route('mikrotikgraph.update', ['mikrotikgraph' => $mikrotik]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2 d-flex flex-column">
                                                    <label for="router_id" class="form-label">Router </label>
                                                    <select name="router_id" id="router_id" class="form-select">
                                                        @foreach ($routers as $router)
                                                            <option {{ ($mikrotik->router_id == $router->id) ? "selected" : "" }} value="{{ $router->id }}">{{ $router->router_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2 d-flex flex-column">
                                                    <label for="interface" class="form-label">Interface </label>
                                                    <select name="interface" id="interface" class="form-select">
                                                        @foreach ($routers as $router)
                                                            <option {{ ($mikrotik->interface == $router->lan_interface) ? "selected" : "" }} value="{{ $router->lan_interface }}">{{ $router->lan_interface }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="allow_address" class="form-label">Allow Address </label>
                                                    <input type="text" class="form-control border border-secondary" placeholder="0.0.0.0/0" id="allow_address" name="allow_address" value="{{ $mikrotik->allow_address }}">
                                                </div>
                                                <div class="mb-2 d-flex flex-column">
                                                    <label for="store_on" class="form-label">Store On Disk </label>
                                                    <select name="store_on" id="store_on" class="form-select">
                                                        <option {{ ($mikrotik->store_on == "yes") ? "selected" : "" }} value="yes">Yes</option>
                                                        <option {{ ($mikrotik->store_on == "no") ? "selected" : "" }} value="no">No</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2 d-flex flex-column">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ ($mikrotik->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($mikrotik->status == "2") ? "selected" : "" }} value="2">Inactive</option>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
@endsection