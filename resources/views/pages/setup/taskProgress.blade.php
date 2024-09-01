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
    <form action="{{ route('taskprogress.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white;">Task Progress</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addNewTaskProgress">Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addNewTaskProgress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('taskprogress.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Add New Task Progress</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label for="description" class="form-label">Task Progress Description</label>
                                            <input type="text" class="form-control" id="description" name="description">
                                        </div>
                                        <div class="mb-2">
                                            <label for="duration" class="form-label">Task Progress Duration</label>
                                            <input type="text" class="form-control" id="duration" name="duration">
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Task Progress Description</th>
                                <th scope="col">Task Progress Duration</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($task_progresses as $task_progress)
                            <tr>
                                <td>{{ $task_progress->id }}</td>
                                <td>{{ $task_progress->description }}</td>
                                <td>{{ $task_progress->duration }}</td>
                                <td>{{ $task_progress->status ==1 ? 'Active': 'Inactive'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_task_progress-{{$task_progress->id}}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_task_progress-{{ $task_progress->id }}">Delete</button>
                                </td>
                            </tr>
    
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_task_progress-{{$task_progress->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('taskprogress.update', ['taskprogress' => $task_progress])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit Task Progress</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="description" class="form-label">Task Progress Description</label>
                                                            <input type="text" class="form-control" value="{{ $task_progress->description}}" id="description" name="description">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="duration" class="form-label">Task Progress Duration</label>
                                                            <input type="text" class="form-control" value="{{ $task_progress->duration}}" id="duration" name="duration">
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
                                                <input type="submit" class="btn btn-sm btn-success" value="Submit" onclick="this.disabled=true;this.form.submit();">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete_task_progress-{{$task_progress->id}}" tabindex="-1" aria-labelledby="delete_task_progressModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('taskprogress.destroy', ['taskprogress' => $task_progress])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="delete_task_progressModalLabel{{ $task_progress->id }}">Delete Task Progress ?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="description" class="form-label">Task Progress Description</label>
                                                            <input type="text" class="form-control" value="{{ $task_progress->description}}" id="description" name="description" disabled>
                                                        </div>
                                                        <div>
                                                            <label for="duration" class="form-label">Task Progress Duration</label>
                                                            <input type="text" class="form-control" value="{{ $task_progress->duration}}" id="duration" name="duration" disabled>
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