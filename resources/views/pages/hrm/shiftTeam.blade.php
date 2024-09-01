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
                <h5 class="mb-0 text-white text-center">Shift Team</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addShiftTeamModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addShiftTeamModal" tabindex="-1" aria-labelledby="addShiftTeamModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addShiftTeamModalLabel">Add Shift Team</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('shiftteam.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="team_id" class="form-label">Team: </label>
                                    <select name="team_id" id="team_id" class="form-select">
                                        <option value="">Select a team</option>
                                        @foreach ($scheduleteams as $scheduleteam)
                                            <option value="{{ $scheduleteam->id }}">{{ $scheduleteam->team_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="emp_id" class="form-label">Employee: </label>
                                    <select name="emp_id" id="emp_id" class="form-select">
                                        <option value="">Select an employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="level" class="form-label">Level: </label>
                                    <input type="text" class="form-control" id="level" name="level">
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status: </label>
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
                            <th scope="col">#SL</th>
                            <th scope="col">Team</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Level</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $slNumber = 1 @endphp
                        @foreach ($shiftTeams as $shiftTeam)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $shiftTeam->team_id }}</td>
                                <td>{{ $shiftTeam->emp_id }}</td>
                                <td>{{ $shiftTeam->level }}</td>
                                <td>{{ ($shiftTeam->status == "1") ? "Active" : "Inactive" }}</td>
                                <td class="text-center text-nowrap" width='10%'>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editShiftTeamModal{{ $shiftTeam->id }}">Edit</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editShiftTeamModal{{ $shiftTeam->id }}" tabindex="-1" aria-labelledby="editShiftTeamModalLabel{{ $shiftTeam->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editShiftTeamModalLabel{{ $shiftTeam->id }}">Edit Shift Team</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('shiftteam.update', ['shiftteam' => $shiftTeam]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="team_id" class="form-label">Team: </label>
                                                    <select name="team_id" id="team_id" class="form-select">
                                                        @foreach ($scheduleteams as $scheduleteam)
                                                            <option {{ ($scheduleteam->id == $shiftTeam->team_id) ? 'selected' : '' }} value="{{ $scheduleteam->id }}">{{ $scheduleteam->team_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="emp_id" class="form-label">Employee: </label>
                                                    <select name="emp_id" id="emp_id" class="form-select">
                                                        @foreach ($employees as $employee)
                                                            <option {{ ($employee->id == $shiftTeam->emp_id) ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="level" class="form-label">Level: </label>
                                                    <input type="text" class="form-control" id="level" name="level" value="{{ $shiftTeam->level }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status: </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ ($shiftTeam->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($shiftTeam->status == "2") ? "selected" : "" }} value="2">Inactive</option>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection