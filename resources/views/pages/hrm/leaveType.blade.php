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

    <div class="main_content_iner">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                <h5 class="mb-0 text-white text-center">Leave Type</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addLeaveTypeModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addLeaveTypeModal" tabindex="-1" aria-labelledby="addLeaveTypeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addLeaveTypeModalLabel">Add Leave Type</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('leavetype.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="name" class="form-label fw-bold">Type: </label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="mb-2">
                                    <label for="short_name" class="form-label fw-bold">Short Name: </label>
                                    <input type="text" class="form-control" id="short_name" name="short_name">
                                </div>
                                <div class="mb-2">
                                    <label for="default_allocation" class="form-label fw-bold">Allocated Days: </label>
                                    <input type="text" class="form-control" id="default_allocation" name="default_allocation">
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" class="form-check-input" id="carry_forward" name="carry_forward">
                                    <label for="carry_forward" class="form-label fw-bold">Carry Forward </label>
                                </div>
                                <div class="mb-2">
                                    <label for="carry_max_days" class="form-label fw-bold">Carry Max Days: </label>
                                    <input type="text" class="form-control" id="carry_max_days" name="carry_max_days">
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label fw-bold">Status: </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn btn-sm btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Sl</th>
                            <th scope="col" class="text-center">Type</th>
                            <th scope="col" class="text-center">Short Name</th>
                            <th scope="col" class="text-center">Allocated Days</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($leavetypes as $leavetype)
                            <tr>
                                <td class="text-center">{{ $slNumber++ }}</td>
                                <td class="text-center">{{ $leavetype->name }}</td>
                                <td class="text-center">{{ $leavetype->short_name }}</td>
                                <td class="text-center">{{ $leavetype->default_allocation }}</td>
                                <td class="text-center">{{ ($leavetype->status == "1") ? "Active" : "Inactive" }}</td>
                                <td class="text-center text-nowrap" width='10%'>
                                    <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_Leave_Type_Modal{{ $leavetype->id }}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_Leave_Type_Modal-{{ $leavetype->id }}">Delete</button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_Leave_Type_Modal{{ $leavetype->id }}" tabindex="-1" aria-labelledby="editLeaveTypeModalLabel{{ $leavetype->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editLeaveTypeModalLabel{{ $leavetype->id }}">Edit Leave Type</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form class="" id="editForm" method="POST" action="{{ route('leavetype.update', ['leavetype' => $leavetype]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="name" class="form-label fw-bold">Type: </label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $leavetype->name }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="short_name" class="form-label fw-bold">Short Name: </label>
                                                    <input type="text" class="form-control" id="short_name" name="short_name" value="{{ $leavetype->short_name }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="default_allocation" class="form-label fw-bold">Allocated Days: </label>
                                                    <input type="text" class="form-control" id="default_allocation" name="default_allocation" value="{{ $leavetype->default_allocation }}">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="checkbox" class="form-check-input" id="carry_forward" name="carry_forward" {{ $leavetype->carry_forward == 1 ? 'checked' : '' }}>
                                                    <label for="carry_forward" class="form-label fw-bold">Carry Forward: </label>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="carry_max_days" class="form-label fw-bold">Carry Max Days: </label>
                                                    <input type="text" class="form-control" id="carry_max_days" name="carry_max_days" value="{{ $leavetype->carry_max_days }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label fw-bold">Status: </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ ($leavetype->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($leavetype->status == "2") ? "selected" : "" }} value="2">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete_Leave_Type_Modal-{{$leavetype->id}}" tabindex="-1" aria-labelledby="deleteLeaveTypeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('leavetype.destroy', ['leavetype' => $leavetype])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteLeaveTypeModalLabel{{ $leavetype->id }}">Delete {{ $leavetype->name }}?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="leavetype_name">Leave Type</label>
                                                            <input type="text" class="form-control" value="{{ $leavetype->name}}" name="leavetype_name" id="leavetype_name" disabled>
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
@endsection