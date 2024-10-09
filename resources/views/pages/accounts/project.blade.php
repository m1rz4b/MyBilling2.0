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
                    <h5 class="mb-0 text-white text-center">Projects</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addAreaModal">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addAreaModal" tabindex="-1" aria-labelledby="addAreaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addAreaModalLabel">Add New Project</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form class="" method="POST" action="{{ route('project.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="project_name" class="form-label">Project: </label>
                                    <input type="text" class="form-control" id="project_name" name="project_name">
                                </div>
                                <div class="mb-2">
                                    <label for="active_statust" class="form-label">Status </label>
                                    <select name="active_statust" id="active_statust" class="form-select">
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
							 <th scope="col">Status</th>
							<th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
					
                        @php $slNumber = 1 @endphp
                        @foreach ($customerprojects as $customerproject)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $customerproject->project_name }}</td>
									<td>{{ $customerproject->status ==1 ? 'Active': 'Inactive'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editAreaModal{{ $customerproject->id }}">
                                        Edit
                                    </button>

                                    <button href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletetAreaModal{{ $customerproject->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                                
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editAreaModal{{ $customerproject->id }}" tabindex="-1" aria-labelledby="editAreaModalLabel{{ $customerproject->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editAreaModalLabel{{ $customerproject->id }}">Edit Project</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form id="editForm" method="POST" action="{{ route('project.update', ['project' => $customerproject]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="project_name" class="form-label">Project Name: </label>
                                      <input type="text" class="form-control" id="project_name" name="project_name" value="{{ $customerproject->project_name }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="active_statust" class="form-label">Status </label>
                                                    <select name="active_statust" id="active_statust" class="form-select">
                                                        <option {{ ($customerproject->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($customerproject->status == "2") ? "selected" : "" }} value="2">Inactive</option>
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
                            <div class="modal fade" id="deletetAreaModal{{ $customerproject->id }}" tabindex="-1"
                                aria-labelledby="deletetAreaModalLabel{{ $customerproject->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="deletetAreaModalLabel{{ $customerproject->id }}">Are you sure ?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('project.destroy', ['project' => $customerproject]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="project_name" class="form-label">Bank Name: </label>
                                                    <input disabled type="text" class="form-control" id="project_name" name="project_name" value="{{ $customerproject->project_name }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select disabled name="status" id="status" class="form-select">
                                                        <option {{ ($customerproject->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($customerproject->status == "2") ? "selected" : "" }} value="2">Inactive</option>
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