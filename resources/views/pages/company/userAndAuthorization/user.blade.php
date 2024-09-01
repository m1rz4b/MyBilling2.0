@extends('layouts.main')

@section('main-container')
    <div class="main_content_iner mt-0">
        <div class="container-fluid p-0 sm_padding_15px">

            <div class="">
                <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                    <h5 class="mb-0 text-white text-center">User</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addUserModal">Add</a>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Profile</th>
                            <th scope="col">Company</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <th scope="col">Permission</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Muhammad Syed</td>
                            <td>muhammad.syed.bd@gmail.com</td>
                            <td>+8801762448984</td>
                            <td>1</td>
                            <td>Nextech Limited</td>
                            <td>Active</td>
                            <td><button class="btn btn-sm btn-success px-3" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button></td>
                            <td><button class="btn btn-sm btn-warning px-3">Update</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Muhammad Syed 2</td>
                            <td>mdsyed165@gmail.com</td>
                            <td>+8801762448984</td>
                            <td>1</td>
                            <td>Nextech Limited</td>
                            <td>Active</td>
                            <td><button class="btn btn-sm btn-success px-3" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button></td>
                            <td><button class="btn btn-sm btn-warning px-3">Update</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- edit modal --}}
            <div class="modal fade" id="editUserModal" tabindex="-1"
                aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="editUserModalLabel">Edit User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        {{-- <form class="" method="POST" action="{{ route('zone.store') }}"> --}}
                            @csrf
                            {{-- @method('PUT') --}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="" class="form-label">User Name: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Email: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Company Address: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Company Name: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Status: </label>
                                            <select type="text" class="form-control" id="" name="">
                                                <option value="">Select a Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Password: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Phone: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Address: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Profile Type: </label>
                                            <select type="text" class="form-control" id="" name="">
                                                <option value="">Select Profile Type</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Edit</button>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
            
            {{-- add modal --}}
            <div class="modal fade" id="addUserModal" tabindex="-1"
                aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="addUserModalLabel">Add New User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        {{-- <form class="" method="POST" action="{{ route('zone.store') }}"> --}}
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="" class="form-label">User Name: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Email: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Company Address: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Company Name: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Status: </label>
                                            <select type="text" class="form-control" id="" name="">
                                                <option value="">Select a Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="" class="form-label">Password: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Phone: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Address: </label>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                        <div class="mb-2">
                                            <label for="" class="form-label">Profile Type: </label>
                                            <select type="text" class="form-control" id="" name="">
                                                <option value="">Select Profile Type</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn-custom-1 py-1" type="submit" onclick="this.disabled=true;this.form.submit();">Add</button>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection