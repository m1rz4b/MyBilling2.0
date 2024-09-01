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
                <h5 class="mb-0 text-white text-center">Support Roster</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addShiftSetupModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addShiftSetupModal" tabindex="-1" aria-labelledby="addShiftSetupModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addShiftSetupModalLabel">Add Support Roster</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('shiftsetup.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="shift_id" class="form-label">Shift: </label>
                                    <select name="shift_id" id="shift_id" class="form-select">
                                        <option value="">Select a Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="team_id" class="form-label">Team: </label>
                                    <select name="team_id" id="team_id" class="form-select">
                                        <option value="">Select a Team</option>
                                        @foreach ($scheduleteams as $scheduleteam)
                                            <option value="{{ $scheduleteam->id }}">{{ $scheduleteam->team_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="shift_team_id" class="form-label">Shift Team: </label>
                                    <select name="shift_team_id" id="shift_team_id" class="form-select">
                                        <option value="">Select a Shift Team</option>
                                        @foreach ($shiftteams as $shiftteam)
                                            <option value="{{ $shiftteam->id }}">{{ $shiftteam->level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                                <div class="d-flex gap-2 justify-content-center">
                                    <input name="sun" id="sun" type="checkbox"><label for="sun">Sun</label>
                                    <input name="mon" id="mon" type="checkbox"><label for="mon">Mon</label>
                                    <input name="tue" id="tue" type="checkbox"><label for="tue">Tue</label>
                                    <input name="wed" id="wed" type="checkbox"><label for="wed">Wed</label>
                                    <input name="thu" id="thu" type="checkbox"><label for="thu">Thu</label>
                                    <input name="fri" id="fri" type="checkbox"><label for="fri">Fri</label>
                                    <input name="sat" id="sat" type="checkbox"><label for="sat">Sat</label>
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
            
            <div class="row p-3">
                <div class="col-sm-4 form-group">
                    <label for="shift_id" class="fw-medium">Shift: </label>
                    <select name="shift_id" id="shift_id" class="form-select form-select-sm form-control">
                        <option value="">Select a Shift</option>
                        @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="team_id" class="fw-medium">Team: </label>
                    <select name="team_id" id="team_id" class="form-select form-select-sm form-control">
                        <option value="">Select a Team</option>
                        @foreach ($scheduleteams as $scheduleteam)
                            <option value="{{ $scheduleteam->id }}">{{ $scheduleteam->team_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <button type="button" class="btn btn-sm btn-info text-white"  onclick="this.disabled=true;this.form.submit();">Submit</button>
                </div>
            </div>

            <div class="QA_table px-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#SL</th>
                            <th scope="col">Shift Name</th>
                            <th scope="col">Team Name</th>
                            <th scope="col">Level</th>
                            <th scope="col">Sun</th>
                            <th scope="col">Mon</th>
                            <th scope="col">Tue</th>
                            <th scope="col">Wed</th>
                            <th scope="col">Thu</th>
                            <th scope="col">Fri</th>
                            <th scope="col">Sat</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($shiftSetups as $shiftSetup)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $shiftSetup->shift_name }}</td>
                                <td>{{ $shiftSetup->team_name }}</td>
                                <td>{{ $shiftSetup->level }}</td>
                                <td>
                                    @if ( $shiftSetup->sun == 1 )
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ( $shiftSetup->mon == 1 )
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ( $shiftSetup->tue == 1 )
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ( $shiftSetup->wed == 1 )
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ( $shiftSetup->thu == 1 )
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ( $shiftSetup->fri == 1 )
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ( $shiftSetup->sat == 1 )
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                                <td>{{ $shiftSetup->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editShiftSetupModal{{ $shiftSetup->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editShiftSetupModal{{ $shiftSetup->id }}" tabindex="-1" aria-labelledby="editShiftSetupModalLabel{{ $shiftSetup->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editShiftSetupModalLabel{{ $shiftSetup->id }}">Edit Support Roster</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('shiftsetup.update', ['shiftsetup' => $shiftSetup->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="shift_id" class="form-label">Shift: </label>
                                                    <select name="shift_id" id="shift_id" class="form-select">
                                                        <option value="">Select a Shift</option>
                                                        @foreach ($shifts as $shift)
                                                            <option {{ ($shift->shift_name == $shiftSetup->shift_name) ? 'selected' : '' }} value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="team_id" class="form-label">Team: </label>
                                                    <select name="team_id" id="team_id" class="form-select">
                                                        <option value="">Select a Team</option>
                                                        @foreach ($scheduleteams as $scheduleteam)
                                                            <option {{ ($scheduleteam->team_name == $shiftSetup->team_name) ? 'selected' : '' }} value="{{ $scheduleteam->id }}">{{ $scheduleteam->team_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="shift_team_id" class="form-label">Shift Team: </label>
                                                    <select name="shift_team_id" id="shift_team_id" class="form-select">
                                                        <option value="">Select a Shift Team</option>
                                                        @foreach ($shiftteams as $shiftteam)
                                                            <option {{ ($shiftteam->level == $shiftSetup->level) ? 'selected' : '' }} value="{{ $shiftteam->id }}">{{ $shiftteam->level }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ ($shiftSetup->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                                        <option {{ ($shiftSetup->status == 2) ? 'selected' : '' }} value="2">Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <input name="sun" id="sun" type="checkbox" {{ $shiftSetup->sun == 1 ? 'checked' : '' }}><label for="sun">Sun</label>
                                                    <input name="mon" id="mon" type="checkbox" {{ $shiftSetup->mon == 1 ? 'checked' : '' }}><label for="mon">Mon</label>
                                                    <input name="tue" id="tue" type="checkbox" {{ $shiftSetup->tue == 1 ? 'checked' : '' }}><label for="tue">Tue</label>
                                                    <input name="wed" id="wed" type="checkbox" {{ $shiftSetup->wed == 1 ? 'checked' : '' }}><label for="wed">Wed</label>
                                                    <input name="thu" id="thu" type="checkbox" {{ $shiftSetup->thu == 1 ? 'checked' : '' }}><label for="thu">Thu</label>
                                                    <input name="fri" id="fri" type="checkbox" {{ $shiftSetup->fri == 1 ? 'checked' : '' }}><label for="fri">Fri</label>
                                                    <input name="sat" id="sat" type="checkbox" {{ $shiftSetup->sat == 1 ? 'checked' : '' }}><label for="sat">Sat</label>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection