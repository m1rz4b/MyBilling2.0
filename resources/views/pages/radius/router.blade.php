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
                    <h5 class="mb-0 text-white">Router</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addRouterModal">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addRouterModal" tabindex="-1" aria-labelledby="addRouterModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addRouterModalLabel">Add New Router</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>

                        <form class="" method="POST" action="{{ route('router.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="router_name" class="form-label">Router Name: </label>
                                            <input type="text" class="form-control" id="router_name" name="router_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="router_username" class="form-label">Router User Name: </label>
                                            <input type="text" class="form-control" id="router_username" name="router_username">
                                        </div>
                                        <div class="mb-2">
                                            <label for="router_location" class="form-label">Router Location: </label>
                                            <input type="text" class="form-control" id="router_location" name="router_location">
                                        </div>
                                        <div class="mb-2">
                                            <label for="ssh_port" class="form-label">SSH Port: </label>
                                            <input type="text" class="form-control" id="ssh_port" name="ssh_port">
                                        </div>
                                        <div class="mb-2">
                                            <label for="dns1" class="form-label">DNS 1: </label>
                                            <input type="text" class="form-control" id="dns1" name="dns1">
                                        </div>
                                        <div class="mb-2">
                                            <label for="radius_acct" class="form-label">Radius Acct: </label>
                                            <input type="number" class="form-control" id="radius_acct" name="radius_acct">
                                        </div>
                                        <div class="mb-2">
                                            <label for="lan_interface" class="form-label">LAN Interface: </label>
                                            <input type="text" class="form-control" id="lan_interface" name="lan_interface">
                                        </div>
                                        <div class="mb-2">
                                            <label for="suboffice_id" class="form-label">Suboffice</label>
                                            <select class="form-select form-control" id="suboffice_id" name="suboffice_id">
                                                <option>Select a Suboffice</option>
                                                @foreach ($subOffices as $subOffice)
                                                    <option value="{{ $subOffice->id }}">{{ $subOffice->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="status" class="form-label">Status: </label>
                                            <select name="status" id="status" class="p-2 form-control">
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="router_ip" class="form-label">Router IP: </label>
                                            <input type="text" class="form-control" id="router_ip" name="router_ip">
                                        </div>
                                        <div class="mb-2">
                                            <label for="router_password" class="form-label">Router Password: </label>
                                            <input type="text" class="form-control" id="router_password" name="router_password">
                                        </div>
                                        <div class="mb-2">
                                            <label for="local_address" class="form-label">Local Address: </label>
                                            <input type="text" class="form-control" id="local_address" name="local_address">
                                        </div>
                                        <div class="mb-2">
                                            <label for="port" class="form-label">API Port: </label>
                                            <input type="number" class="form-control" id="port" name="port">
                                        </div>
                                        <div class="mb-2">
                                            <label for="dns2" class="form-label">DNS 2: </label>
                                            <input type="text" class="form-control" id="dns2" name="dns2">
                                        </div>
                                        <div class="mb-2">
                                            <label for="radius_auth" class="form-label">Radius Auth: </label>
                                            <input type="number" class="form-control" id="radius_auth" name="radius_auth">
                                        </div>
                                        <div class="mb-2">
                                            <label for="r_secret" class="form-label">Radius Secret: </label>
                                            <input type="text" class="form-control" id="r_secret" name="r_secret">
                                        </div>
                                        <div class="mb-2">
                                            <label for="radius_server_id" class="form-label">Radius Server</label>
                                            <select class="form-select form-control" id="radius_server_id" name="radius_server_id">
                                                <option>Select a Radius Server</option>
                                                @foreach ($radiusServers as $radiusServer)
                                                    <option value="{{ $radiusServer->id }}">{{ $radiusServer->server_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
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

            <div class="QA_table p-3 pb-0 table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Router ID</th>
                            <th scope="col">Router Name</th>
                            <th scope="col">Router IP</th>
                            <th scope="col">Router Location</th>
                            <th scope="col">Router Username</th>
                            <th scope="col">Active Client</th>
                            <th scope="col">API Port</th>
                            <th scope="col">Ath Port</th>
                            <th scope="col">Act Port</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <th scope="col">Api Connection Check</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($routers as $router)
                            <tr>
                                <td>{{ $router->id }}</td>
                                <td>{{ $router->router_name }}</td>
                                <td>{{ $router->router_ip }}</td>
                                <td>{{ $router->router_location }}</td>
                                <td>{{ $router->router_username }}</td>
                                <td>{{ $router->active_client }}</td>
                                <td>{{ $router->port }}</td>
                                <td>{{ $router->radius_auth }}</td>
                                <td>{{ $router->radius_acct }}</td>
                                <td>{{ $router->status ==1 ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <button href="#" class="btn_1 text-center px-3 py-1" style="background: #198754" data-bs-toggle="modal" data-bs-target="#editRouterModal{{ $router->id }}">
                                        Edit
                                    </button>
                                
                                    <button href="#" class="btn_1 text-center px-3 py-1" style="background: #dc3545" data-bs-toggle="modal" data-bs-target="#deleteRouterModal{{ $router->id }}">
                                        Delete
                                    </button>
                                </td>
                                <td>
                                    <button id="{{ $router->id }}" onclick="checkApi(this)" class="btn_1 text-center px-3 py-1" style="background: #5cb85c">Api connection check</button>
                                    <button id="{{ $router->id }}" onclick="checkSsh(this)" class="btn_1 text-center px-3 py-1" style="background: #5b9dde">SSH connection check</button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editRouterModal{{ $router->id }}" tabindex="-1" aria-labelledby="editRouterModalLabel{{ $router->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editRouterModalLabel{{ $router->id }}">Edit Router</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form class="" id="editForm" method="POST" action="{{ route('router.update', ['router' => $router]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="router_name" class="form-label">Router Name: </label>
                                                            <input type="text" class="form-control" id="router_name" name="router_name" value="{{ $router->router_name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="router_username" class="form-label">Router User Name: </label>
                                                            <input type="text" class="form-control" id="router_username" name="router_username" value="{{ $router->router_username }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="router_location" class="form-label">Router Location: </label>
                                                            <input type="text" class="form-control" id="router_location" name="router_location" value="{{ $router->router_location }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="ssh_port" class="form-label">SSH Port: </label>
                                                            <input type="text" class="form-control" id="ssh_port" name="ssh_port" value="{{ $router->ssh_port }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="dns1" class="form-label">DNS 1: </label>
                                                            <input type="text" class="form-control" id="dns1" name="dns1" value="{{ $router->dns1 }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="radius_acct" class="form-label">Radius Acct: </label>
                                                            <input type="text" class="form-control" id="radius_acct" name="radius_acct" value="{{ $router->radius_acct }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="lan_interface" class="form-label">LAN Interface: </label>
                                                            <input type="text" class="form-control" id="lan_interface" name="lan_interface" value="{{ $router->lan_interface }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="suboffice_id" class="form-label">Suboffice</label>
                                                            <select class="form-select form-control" id="suboffice_id" name="suboffice_id">
                                                                <option>Select a Suboffice</option>
                                                                @foreach ($subOffices as $subOffice)
                                                                    <option {{$router->suboffice_id==$subOffice->id?'selected':''}} value="{{ $subOffice->id }}">{{ $subOffice->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="status" class="form-label">Status: </label>
                                                            <select name="status" id="status" class="p-2 form-control">
                                                                <option {{ ($router->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                                <option {{ ($router->status == "2") ? "selected" : "" }} value="2">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="router_ip" class="form-label">Router IP: </label>
                                                            <input type="text" class="form-control" id="router_ip" name="router_ip" value="{{ $router->router_ip }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="router_password" class="form-label">Router Password: </label>
                                                            <input type="text" class="form-control" id="router_password" name="router_password" value="{{ $router->router_password }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="local_address" class="form-label">Local Address: </label>
                                                            <input type="text" class="form-control" id="local_address" name="local_address" value="{{ $router->local_address }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="port" class="form-label">API Port: </label>
                                                            <input type="text" class="form-control" id="port" name="port" value="{{ $router->port }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="dns2" class="form-label">DNS 2: </label>
                                                            <input type="text" class="form-control" id="dns2" name="dns2" value="{{ $router->dns2 }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="radius_auth" class="form-label">Radius Auth: </label>
                                                            <input type="text" class="form-control" id="radius_auth" name="radius_auth" value="{{ $router->radius_auth }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="r_secret" class="form-label">Radius Secret: </label>
                                                            <input type="text" class="form-control" id="r_secret" name="r_secret" value="{{ $router->r_secret }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="radius_server_id" class="form-label">Radius Server</label>
                                                            <select class="form-select form-control" id="radius_server_id" name="radius_server_id">
                                                                <option>Select a Radius Server</option>
                                                                @foreach ($radiusServers as $radiusServer)
                                                                    <option {{$router->radius_server_id==$radiusServer->id?'selected':''}} value="{{ $radiusServer->id }}">{{ $radiusServer->server_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
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
                            <div class="modal fade" id="deleteRouterModal{{ $router->id }}" tabindex="-1" aria-labelledby="deleteRouterModalLabel{{ $router->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="deleteRouterModalLabel{{ $router->id }}">Are you sure ?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>

                                        <form class="" method="POST" action="{{ route('router.destroy', ['router' => $router]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="router_name" class="form-label">Router Name: </label>
                                                            <input readonly type="text" class="form-control" id="router_name" name="router_name" value="{{ $router->router_name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="router_username" class="form-label">Router User Name: </label>
                                                            <input readonly type="text" class="form-control" id="router_username" name="router_username" value="{{ $router->router_username }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="router_ip" class="form-label">Router IP: </label>
                                                            <input readonly type="text" class="form-control" id="router_ip" name="router_ip" value="{{ $router->router_ip }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="router_location" class="form-label">Router Location: </label>
                                                            <input readonly type="text" class="form-control" id="router_location" name="router_location" value="{{ $router->router_location }}">
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
    <script type="text/javascript">
        
        function checkApi(e) {

            //console.log(e.id);
            var id = e.id;
              
            $.ajax({
                
                url: `{{ url('routerApiCheck/'.'${id}') }}`,
                
                type: 'POST',
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    router: id,
                },
                success: function(data) {
                    // log response into console
                    alert(data['msg']+data['data'])
                    console.log(data);
                }

            });
        }

        function checkSsh(e) {

        //console.log(e.id);
        var id = e.id;
        
        $.ajax({
            
            url: `{{ url('routerSShCheck/'.'${id}') }}`,
            
            type: 'POST',
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                router: id,
            },
            success: function(data) {
                // log response into console
                alert(data['msg']+data['data'])
                console.log(data);
            }

        });
        }
        
    </script>
@endsection