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
                    <h5 class="mb-0 text-white text-center">Designations</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#adddesignationModal">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="adddesignationModal" tabindex="-1" aria-labelledby="adddesignationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="adddesignationModalLabel">Add New Designation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form class="" method="POST" action="{{ route('designation.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="designation" class="form-label">Designation: </label>
                                    <input type="text" class="form-control" id="designation" name="designation">
                                </div>
                                <div class="mb-2">
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
                            <th scope="col">Sl</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $slNumber = 1 @endphp
                        @foreach ($designations as $designation)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $designation->designation }}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editdesignationModal{{ $designation->id }}">
                                        Edit
                                    </button>

                                    <button href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletedesignationModal{{ $designation->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editdesignationModal{{ $designation->id }}" tabindex="-1" aria-labelledby="editdesignationModalLabel{{ $designation->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editdesignationModalLabel{{ $designation->id }}">Edit Designation</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form id="editForm" method="POST" action="{{ route('designation.update', ['designation' => $designation]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="designation" class="form-label">Designation: </label>
                                                    <input type="text" class="form-control" id="designation" name="designation" value="{{ $designation->designation }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ ($designation->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($designation->status == "2") ? "selected" : "" }} value="2">Inactive</option>
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
                            <div class="modal fade" id="deletedesignationModal{{ $designation->id }}" tabindex="-1" aria-labelledby="deletedesignationModalLabel{{ $designation->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="deletedesignationModalLabel{{ $designation->id }}">Are you sure ?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form class="" method="POST" action="{{ route('designation.destroy', ['designation' => $designation]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="designation" class="form-label">Designation: </label>
                                                    <input readonly type="text" class="form-control" id="designation" name="designation" value="{{ $designation->designation }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select disabled name="status" id="status" class="form-select">
                                                        <option {{ ($designation->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($designation->status == "2") ? "selected" : "" }} value="2">Inactive</option>
                                                    </select>
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
@endsection