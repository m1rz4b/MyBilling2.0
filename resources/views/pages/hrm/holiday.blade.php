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
    <form action="{{ route('holiday.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                <h5 class="mb-0" style="color: white;">Manage Holidays</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addNewHoliday">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addNewHoliday" tabindex="-1" aria-labelledby="holiday" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('holiday.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="holiday">Add New Holiday</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label for="holiday_name" class="form-label">Holiday</label>
                                            <input type="text" class="form-control" id="holiday_name" name="holiday_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="holiday_date" class="form-label">Date</label>
                                            <input type="text" class="form-control datepicker-here digits" id="holiday_date" name="holiday_date" data-date-Format="yyyy-mm-dd">
                                        </div>
                                        <div>
                                            <label for="allowance_status" class="form-label">Allowance Status: </label>
                                            <select class="form-control" name="allowance_status" id="allowance_status">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
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
                                <th scope="col">Holiday</th>
                                <th scope="col">Date</th>
                                <th scope="col">Allowance Status</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($holidays as $holiday)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $holiday->holiday_name }}</td>
                                <td>{{ $holiday->holiday_date }}</td>
                                <td>{{ $holiday->allowance_status ==1 ? 'Yes': 'No'}}</td>
                                <td>{{ $holiday->status ==1 ? 'Active': 'Inactive'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_holiday-{{$holiday->id}}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_holiday-{{ $holiday->id }}">Delete</button>
                                </td>
                            </tr>
    
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_holiday-{{$holiday->id}}" tabindex="-1" aria-labelledby="holiday" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('holiday.update', ['holiday' => $holiday])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="holiday">Edit Holiday</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="holiday_name">Holiday</label>
                                                            <input type="text" class="form-control" value="{{ $holiday->holiday_name}}" name="holiday_name" id="holiday_name">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="holiday_date">Date</label>
                                                            <input type="text" class="form-control datepicker-here digits" value="{{ $holiday->holiday_date}}" name="holiday_date" id="holiday_date" data-date-Format="yyyy-mm-dd">
                                                        </div>
                                                        <div>
                                                            <label for="allowance_status" class="form-label">Allowance Status: </label>
                                                            <select class="form-control" name="allowance_status" id="allowance_status">
                                                                <option value="1">Yes</option>
                                                                <option value="2">No</option>
                                                            </select>
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
                            <div class="modal fade" id="delete_holiday-{{$holiday->id}}" tabindex="-1" aria-labelledby="deleteHolidayModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('holiday.destroy', ['holiday' => $holiday])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteHolidayModalLabel{{ $holiday->id }}">Delete {{ $holiday->holiday_name }}?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="holiday_name">Holiday</label>
                                                            <input type="text" class="form-control" value="{{ $holiday->holiday_name}}" name="holiday_name" id="holiday_name" disabled>
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