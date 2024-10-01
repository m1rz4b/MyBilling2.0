@extends('layouts.main')

@section('main-container')
<style>
    .table th,
    .table td {
        padding: 0.25rem;
    }

    .select2-container .select2-selection--single {
        height: auto !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-top: .25rem !important;
        padding-bottom: .25rem !important;
        font-size: .875rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 3px !important;
        right: 3px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
    }
</style>

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
                <h5 class="mb-0 text-white text-center">Menu</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addMenuModal">Add</a>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header theme_bg_1">
                        <h1 class="modal-title fs-5 text-white" id="addMenuModalLabel">Add New Menu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                    </div>
                    <form class="" method="POST" action="{{ route('menu.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-2 col-sm-6">
                                    <label for="name" class="form-label">Menu Name: </label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="mb-2 col-sm-6">
                                    <label for="pid" class="form-label">Parent: </label>
                                    <select name="pid" id="pid" class="select2 form-select" style="width: 100% !important;">
                                        <option value="0" selected>No Parent</option> 
                                        @foreach ($allmenu as $m)
                                            <option value="{{ $m->id }}">{{ $m->name }}</option>                                                        
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 col-sm-6">
                                    <label for="route" class="form-label">Menu Route: </label>
                                    <input type="text" class="form-control" id="route" name="route">
                                </div>
                                <div class="mb-2 col-sm-6">
                                    <label for="level" class="form-label">Menu Level: </label>
                                    <input type="text" class="form-control" id="level" name="level">
                                </div>
                                <div class="mb-2 col-sm-6">
                                    <label for="serial" class="form-label">Menu Serial: </label>
                                    <input type="text" class="form-control" id="serial" name="serial">
                                </div>
                                <div class="mb-2 col-sm-6">
                                    <label for="icon" class="form-label">Menu Icon: </label>
                                    <input type="text" class="form-control" id="icon" name="icon">
                                </div>
                                <div class="mb-2 col-sm-6">
                                    <label for="status" class="form-label">Status </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="mb-2 col-sm-6">
                                    {{-- <br class="d-none d-sm-block">
                                    <br class="d-none d-sm-block"> --}}
                                    <label for="is_parent" class="form-label">Has Child?: </label>
                                    <select name="is_parent" id="is_parent" class="form-select">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    {{-- <input type="checkbox" id="is_parent" name="is_parent"> --}}
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
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th scope="col">Sl</th> --}}
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Parent</th>
                        <th scope="col">Route/Link</th>
                        <th scope="col">Level</th>
                        <th scope="col">Serial</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $slNumber = 1 @endphp
                    @foreach ($allmenu as $menu)
                        <tr>
                            {{-- <td>{{ $slNumber++ }}</td> --}}
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->pid }}</td>
                            <td>{{ $menu->route }}</td>
                            <td>{{ $menu->level }}</td>
                            <td>{{ $menu->serial }}</td>
                            <td>{{ $menu->icon }}</td>
                            <td>{{ $menu->status==1?'Active': 'Inactive' }}</td>
                            <td class="text-end text-nowrap" width='10%'>
                                <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editMenuModal{{$menu->id}}">
                                    Edit
                                </button>

                                <button href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMenuModal{{$menu->id}}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editMenuModal{{$menu->id}}" tabindex="-1"
                            aria-labelledby="editMenuModalLabel{{$menu->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header theme_bg_1">
                                        <h1 class="modal-title fs-5 text-white" id="editMenuModalLabel{{$menu->id}}">Edit Menu</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                    </div>
                                    <form class="" id="editForm" method="POST" action="{{ route('menu.update', ['menu' => $menu]) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="mb-2 col-sm-6">
                                                    <label for="name" class="form-label">Menu Name: </label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $menu->name }}">
                                                </div>
                                                <div class="mb-2 col-sm-6">
                                                    <label for="pid" class="form-label">Parent: </label>
                                                    <select name="pid" id="pid" class="select2 form-select" style="width: 100% !important;">
                                                        <option value="0">No Parent</option> 
                                                        @foreach ($allmenu as $m)
                                                            <option {{ ($m->id == $menu->pid) ? "selected" : "" }} value="{{ $m->id }}">{{ $m->name }}</option>                                                        
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2 col-sm-6">
                                                    <label for="name" class="form-label">Menu Route: </label>
                                                    <input type="text" class="form-control" id="route" name="route" value="{{ $menu->route }}">
                                                </div>
                                                <div class="mb-2 col-sm-6">
                                                    <label for="name" class="form-label">Menu Level: </label>
                                                    <input type="text" class="form-control" id="level" name="level" value="{{ $menu->level }}">
                                                </div>
                                                <div class="mb-2 col-sm-6">
                                                    <label for="name" class="form-label">Menu Serial: </label>
                                                    <input type="text" class="form-control" id="serial" name="serial" value="{{ $menu->serial }}">
                                                </div>
                                                <div class="mb-2 col-sm-6">
                                                    <label for="name" class="form-label">Menu Icon: </label>
                                                    <input type="text" class="form-control" id="icon" name="icon" value="{{ $menu->icon }}">
                                                </div>
                                                <div class="mb-2 col-sm-6">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ ($menu->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($menu->status == "0") ? "selected" : "" }} value="2">Inactive</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-2 col-sm-6">
                                                    
                                                    <label for="is_parent" class="form-label">Has Child?: </label>
                                                    <select name="is_parent" id="is_parent" class="form-select">
                                                        <option value="0" {{ $menu->is_parent==0 ? "selected":"" }}>No</option>
                                                        <option value="1" {{ $menu->is_parent==1 ? "selected":"" }}>Yes</option>
                                                    </select>
                                                    
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
                        <div class="modal fade" id="deleteMenuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="deleteMenuModalLabel{{ $menu->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header theme_bg_1">
                                        <h1 class="modal-title fs-5 text-white" id="deleteMenuModalLabel{{ $menu->id }}">Are you sure ?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                    </div>
                                    <form class="" method="POST" action="{{ route('menu.destroy', ['menu' => $menu]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label for="name" class="form-label">Menu Name: </label>
                                                <input disabled type="text" class="form-control" id="name" name="name" value="{{ $menu->name }}">
                                            </div>
                                            <div class="mb-2">
                                                <label for="status" class="form-label">Status </label>
                                                <select disabled name="status" id="status" class="form-select">
                                                    <option {{ ($menu->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                    <option {{ ($menu->status == "2") ? "selected" : "" }} value="2">Inactive</option>
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

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });
</script>

@endpush
@endsection