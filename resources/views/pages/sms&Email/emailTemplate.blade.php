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
                    <h5 class="mb-0 text-white text-center">Email Template</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addEmailTemplateModal">Add</a>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#SL</th>
                            <th scope="col">For</th>
                            <th scope="col">Desctiption</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width: 14%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $slNumber = 1 @endphp
                        @foreach ($emailtemplates as $emailtemplate)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $emailtemplate->command }}</td>
                                <td>{{ $emailtemplate->description }}</td>
                                <td>{{ $emailtemplate->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editEmailTemplateModal{{ $emailtemplate->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEmailTemplateModal{{ $emailtemplate->id }}">Delete</button>
                                </td>
                            </tr>

                            {{-- edit modal --}}
                            <div class="modal fade" id="editEmailTemplateModal{{ $emailtemplate->id }}" tabindex="-1"
                                aria-labelledby="editEmailTemplateModalLabel{{ $emailtemplate->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                                            <h1 class="modal-title fs-5 text-white" id="editEmailTemplateModalLabel{{ $emailtemplate->id }}">Edit Email Template</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>

                                        <form class="" method="POST" action="{{ route('emailtemplate.template_update', ['emailtemplate' => $emailtemplate]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="command" class="form-label fw-bold">For: </label>
                                                    <input type="text" class="form-control" id="command" name="command" value="{{ $emailtemplate->command }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="description" class="form-label fw-bold">Description: </label>
                                                    <textarea class="form-control" id="description" name="description" rows="2">{{ $emailtemplate->description }}</textarea>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label fw-bold">Status: </label>
                                                    <select name="status" id="status" class="p-2 form-control">
                                                        <option {{ $emailtemplate->status == "1" ? "selected" : '' }} value="1">Active</option>
                                                        <option {{ $emailtemplate->status == "2" ? "selected" : '' }} value="2">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Edit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            {{-- delete modal --}}
                            <div class="modal fade" id="deleteEmailTemplateModal{{ $emailtemplate->id }}" tabindex="-1"
                                aria-labelledby="deleteEmailTemplateModalLabel{{ $emailtemplate->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                                            <h1 class="modal-title fs-5 text-white" id="deleteEmailTemplateModalLabel{{ $emailtemplate->id }}">Delete Email Template</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>

                                        <form class="" method="POST" action="{{ route('emailtemplate.template_destroy', ['emailtemplate' => $emailtemplate]) }}">
                                            @csrf
                                            @method('Delete')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="command" class="form-label fw-bold">For: </label>
                                                    <input disabled type="text" class="form-control" id="command" name="command" value="{{ $emailtemplate->command }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="description" class="form-label fw-bold">Description: </label>
                                                    <textarea disabled class="form-control" id="description" name="description" rows="2">{{ $emailtemplate->description }}</textarea>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label fw-bold">Status: </label>
                                                    <select disabled name="status" id="status" class="p-2 form-control">
                                                        <option {{ $emailtemplate->status == "1" ? "selected" : '' }} value="1">Active</option>
                                                        <option {{ $emailtemplate->status == "2" ? "selected" : '' }} value="2">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
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

            {{-- add modal --}}
            <div class="modal fade" id="addEmailTemplateModal" tabindex="-1"
                aria-labelledby="addEmailTemplateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="addEmailTemplateModalLabel">Add New Email Template</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="filter: invert(100%);"></button>
                        </div>

                        <form class="" method="POST" action="{{ route('emailtemplate.template_store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="command" class="form-label fw-bold">For: </label>
                                    <input type="text" class="form-control" id="command" name="command">
                                </div>
                                <div class="mb-2">
                                    <label for="description" class="form-label fw-bold">Description: </label>
                                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label fw-bold">Status: </label>
                                    <select name="status" id="status" class="p-2 form-control">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn-custom-1 py-1" type="submit" onclick="this.disabled=true;this.form.submit();">Add</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection