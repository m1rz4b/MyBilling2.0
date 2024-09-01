@extends('layouts.main')

@section('main-container')
    <div class="main_content_iner mt-0">
        <div class="container-fluid p-0 sm_padding_15px">

            <div class="">
                <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                    <h5 class="mb-0 text-white text-center">Roles</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addRolesModal">Add</a>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 15%; text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Super Admin</td>
                            <td>
                                <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editRolesModal">
                                    Edit
                                </button>

                                <button href="#" class="btn btn-sm btn-warning">
                                    Permission
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Admin</td>
                            <td>
                                <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editRolesModal">
                                    Edit
                                </button>

                                <button href="#" class="btn btn-sm btn-warning">
                                    Permission
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- edit modal --}}
            <div class="modal fade" id="editRolesModal" tabindex="-1"
                aria-labelledby="editRolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="editRolesModalLabel">Edit Role</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        {{-- <form class="" method="POST" action="{{ route('zone.store') }}"> --}}
                            @csrf
                            {{-- @method('PUT') --}}
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="" class="form-label">Role Name: </label>
                                    <input type="text" class="form-control" id="" name="">
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
            <div class="modal fade" id="addRolesModal" tabindex="-1"
                aria-labelledby="addRolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="addRolesModalLabel">Add New Role</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        {{-- <form class="" method="POST" action="{{ route('zone.store') }}"> --}}
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="" class="form-label">Role Name: </label>
                                    <input type="text" class="form-control" id="" name="">
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