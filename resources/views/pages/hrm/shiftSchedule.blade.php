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
                <h5 class="mb-0 text-white text-center">Shift Schedule</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addShiftScheduleModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addShiftScheduleModal" tabindex="-1" aria-labelledby="addShiftScheduleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addShiftScheduleModalLabel">Add Schedule</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('shiftschedule.shiftschdlStore') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="shift_name" class="form-label fw-bold">Schedule Name: </label>
                                            <input type="text" class="form-control" id="shift_name" name="shift_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="begining_start" class="form-label fw-bold">Start In Time: </label>
                                            <input type="time" class="form-control" id="begining_start" name="begining_start">
                                        </div>
                                        <div class="mb-2">
                                            <label for="out_end" class="form-label fw-bold">Last Out Time: </label>
                                            <input type="time" class="form-control" id="out_end" name="out_end">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="start_time" class="form-label fw-bold">Shift Start Time: </label>
                                            <input type="time" class="form-control" id="start_time" name="start_time">
                                        </div>
                                        <div class="mb-2">
                                            <label for="begining_end" class="form-label fw-bold">Last In Time: </label>
                                            <input type="time" class="form-control" id="begining_end" name="begining_end">
                                        </div>
                                        <div class="mb-2">
                                            <label for="status" class="form-label fw-bold">Status: </label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                        
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="end_time" class="form-label fw-bold">Shift End Time: </label>
                                            <input type="time" class="form-control" id="end_time" name="end_time">
                                        </div>
                                        <div class="mb-2">
                                            <label for="out_start" class="form-label fw-bold">Start Out Time: </label>
                                            <input type="time" class="form-control" id="out_start" name="out_start">
                                        </div>
                                    </div>
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
                            <th scope="col">#Sl</th>
                            <th scope="col">Shift Name</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($hrm_tblshifts as $hrm_tblshift)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $hrm_tblshift->shift_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($hrm_tblshift->start_time)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($hrm_tblshift->end_time)->format('h:i A') }}</td>
                                <td>{{ ($hrm_tblshift->status == "1") ? "Active" : "Inactive" }}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editShiftScheduleModal{{ $hrm_tblshift->id }}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteShiftScheduleModal-{{ $hrm_tblshift->id }}">Delete</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editShiftScheduleModal{{ $hrm_tblshift->id }}" tabindex="-1" aria-labelledby="editShiftScheduleModalLabel{{ $hrm_tblshift->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editShiftScheduleModalLabel{{ $hrm_tblshift->id }}">Edit Schedule</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('shiftschedule.shiftschdlUpdate', ['shiftschedule' => $hrm_tblshift]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="shift_name" class="form-label fw-bold">Schedule Name: </label>
                                                            <input type="text" class="form-control" id="shift_name" name="shift_name" value="{{ $hrm_tblshift->shift_name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="begining_start" class="form-label fw-bold">Start In Time: </label>
                                                            <input type="time" class="form-control" id="begining_start" name="begining_start" value="{{ $hrm_tblshift->begining_start }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="out_end" class="form-label fw-bold">Last Out Time: </label>
                                                            <input type="time" class="form-control" id="out_end" name="out_end" value="{{ $hrm_tblshift->out_end }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="start_time" class="form-label fw-bold">Shift Start Time: </label>
                                                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $hrm_tblshift->start_time }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="begining_end" class="form-label fw-bold">Last In Time: </label>
                                                            <input type="time" class="form-control" id="begining_end" name="begining_end" value="{{ $hrm_tblshift->begining_end }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="status" class="form-label fw-bold">Status: </label>
                                                            <select name="status" id="status" class="form-select">
                                                                <option {{ ($hrm_tblshift->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                                <option {{ ($hrm_tblshift->status == "2") ? "selected" : "" }} value="2">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="end_time" class="form-label fw-bold">Shift End Time: </label>
                                                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $hrm_tblshift->end_time }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="out_start" class="form-label fw-bold">Start Out Time: </label>
                                                            <input type="time" class="form-control" id="out_start" name="out_start" value="{{ $hrm_tblshift->out_start }}">
                                                        </div>
                                                    </div>
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
                            <div class="modal fade" id="deleteShiftScheduleModal-{{$hrm_tblshift->id}}" tabindex="-1" aria-labelledby="deleteShiftScheduleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('shiftschedule.shiftschdlDelete', ['shiftschedule' => $hrm_tblshift])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteShiftScheduleModalLabel{{ $hrm_tblshift->id }}">Delete {{ $hrm_tblshift->shift_name }}?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="shift_name">Shift Name</label>
                                                            <input type="text" class="form-control" value="{{ $hrm_tblshift->shift_name}}" name="shift_name" id="shift_name" disabled>
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