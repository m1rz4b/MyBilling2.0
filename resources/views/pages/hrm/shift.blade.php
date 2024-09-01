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
                <h5 class="mb-0 text-white text-center">Shift</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addShiftModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addShiftModal" tabindex="-1" aria-labelledby="addShiftModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addShiftModalLabel">Add Shift</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('shift.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="sch_name" class="form-label fw-bold">Schedule Name: </label>
                                            <input type="text" class="form-control" id="sch_name" name="sch_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="begining_start" class="form-label fw-bold">Start In Time: </label>
                                            <input type="time" class="form-control" id="begining_start" name="begining_start">
                                        </div>
                                        <div class="mb-2">
                                            <label for="out_start" class="form-label fw-bold">Start Out Time: </label>
                                            <input type="time" class="form-control" id="out_start" name="out_start">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="start_time" class="form-label fw-bold">On-Duty Time: </label>
                                            <input type="time" class="form-control" id="start_time" name="start_time">
                                        </div>
                                        <div class="mb-2">
                                            <label for="begining_end" class="form-label fw-bold">Last In Time: </label>
                                            <input type="time" class="form-control" id="begining_end" name="begining_end">
                                        </div>
                                        <div class="mb-2">
                                            <label for="out_end" class="form-label fw-bold">Last Out Time: </label>
                                            <input type="time" class="form-control" id="out_end" name="out_end">
                                        </div>
                                    </div>
                                        
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="end_time" class="form-label fw-bold">Off-Duty Time: </label>
                                            <input type="time" class="form-control" id="end_time" name="end_time">
                                        </div>
                                        <div class="mb-2">
                                            <label for="late_time" class="form-label fw-bold">Absent Start Time: </label>
                                            <input type="time" class="form-control" id="late_time" name="late_time">
                                        </div>
                                        <div class="mb-2">
                                            <label for="status" class="form-label fw-bold">Status: </label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
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
                            <th scope="col">#SL</th>
                            <th scope="col">Schedule Name</th>
                            <th scope="col">On-Duty Time</th>
                            <th scope="col">Off-Duty Time</th>
                            <th scope="col">Start In Time</th>
                            <th scope="col">Last In Time</th>
                            <th scope="col">Start Out Time</th>
                            <th scope="col">Last Out Time</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($schedules as $schedule)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $schedule->sch_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->begining_start)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->begining_end)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->out_start)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->out_end)->format('h:i A') }}</td>
                                <td>{{ ($schedule->status == "1") ? "Active" : "Inactive" }}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editShiftModal{{ $schedule->id }}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_shift-{{ $schedule->id }}">Delete</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editShiftModal{{ $schedule->id }}" tabindex="-1" aria-labelledby="editShiftModalLabel{{ $schedule->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editShiftModalLabel{{ $schedule->id }}">Edit Shift</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('shift.update', ['shift' => $schedule]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="sch_name" class="form-label fw-bold">Schedule Name: </label>
                                                            <input type="text" class="form-control" id="sch_name" name="sch_name" value="{{ $schedule->sch_name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="begining_start" class="form-label fw-bold">Start In Time: </label>
                                                            <input type="time" class="form-control" id="begining_start" name="begining_start" value="{{ $schedule->begining_start }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="out_start" class="form-label fw-bold">Start Out Time: </label>
                                                            <input type="time" class="form-control" id="out_start" name="out_start" value="{{ $schedule->out_start }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="start_time" class="form-label fw-bold">On-Duty Time: </label>
                                                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $schedule->start_time }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="begining_end" class="form-label fw-bold">Last In Time: </label>
                                                            <input type="time" class="form-control" id="begining_end" name="begining_end" value="{{ $schedule->begining_end }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="out_end" class="form-label fw-bold">Last Out Time: </label>
                                                            <input type="time" class="form-control" id="out_end" name="out_end" value="{{ $schedule->out_end }}">
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="end_time" class="form-label fw-bold">Off-Duty Time: </label>
                                                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $schedule->end_time }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="late_time" class="form-label fw-bold">Absent Start Time: </label>
                                                            <input type="time" class="form-control" id="late_time" name="late_time" value="{{ $schedule->late_time }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="status" class="form-label fw-bold">Status: </label>
                                                            <select name="status" id="status" class="form-select">
                                                                <option {{ ($schedule->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                                <option {{ ($schedule->status == "2") ? "selected" : "" }} value="2">Inactive</option>
                                                            </select>
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
                            <div class="modal fade" id="delete_shift-{{$schedule->id}}" tabindex="-1" aria-labelledby="deleteShiftModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('shift.destroy', ['shift' => $schedule])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="deleteShiftModalLabel{{ $schedule->id }}">Delete {{ $schedule->sch_name }}?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="sch_name">Shift Name</label>
                                                            <input type="text" class="form-control" value="{{ $schedule->sch_name}}" name="sch_name" id="sch_name" disabled>
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