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
                <h5 class="mb-0 text-white text-center">Schedule Team</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addScheduleTeamModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addScheduleTeamModal" tabindex="-1" aria-labelledby="addScheduleTeamModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addScheduleTeamModalLabel">Add Schedule Team</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('scheduleteam.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="team_name" class="form-label">Team Name: </label>
                                    <input type="text" class="form-control" id="team_name" name="team_name">
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status </label>
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
                            <th scope="col">#Sl</th>
                            <th scope="col">Team Name</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($scheduleteams as $scheduleteam)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $scheduleteam->team_name }}</td>
                                <td class="text-center">{{ ($scheduleteam->status == "1") ? "Active" : "Inactive" }}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editScheduleTeamModal{{ $scheduleteam->id }}">Edit</button>
                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#viewScheduleTeamModal{{ $scheduleteam->id }}">View</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteScheduleTeamModal-{{ $scheduleteam->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach ($scheduleteams as $scheduleteam)
                <!-- Edit Modal -->
                <div class="modal fade" id="editScheduleTeamModal{{ $scheduleteam->id }}" tabindex="-1" aria-labelledby="editScheduleTeamModalLabel{{ $scheduleteam->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="editScheduleTeamModalLabel{{ $scheduleteam->id }}">Edit Schedule Team</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            <form method="POST" action="{{ route('scheduleteam.update', ['scheduleteam' => $scheduleteam]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label for="team_name" class="form-label">Team Name: </label>
                                        <input type="text" class="form-control" id="team_name" name="team_name" value="{{ $scheduleteam->team_name }}">
                                    </div>
                                    <div class="mb-2">
                                        <label for="status" class="form-label">Status </label>
                                        <select name="status" id="status" class="form-select">
                                            <option {{ ($scheduleteam->status == "1") ? "selected" : "" }} value="1">Active</option>
                                            <option {{ ($scheduleteam->status == "2") ? "selected" : "" }} value="2">Inactive</option>
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

                <!-- View Modal -->
                <div class="modal fade" id="viewScheduleTeamModal{{ $scheduleteam->id }}" tabindex="-1" aria-labelledby="viewScheduleTeamModalLabel{{ $scheduleteam->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="viewScheduleTeamModalLabel{{ $scheduleteam->id }}">Edit Schedule Team</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>

                            <div class="modal-body">
                                <div class="text-center">
                                    <button class="btn btn-sm btn-warning mb-2 text-white">Print</button>
                                    @foreach ($companies as $company)
                                        <h4 class="text-center">{{ $company->company_name }}</h4>
                                    @endforeach
                                    <h5 class="text-center">Support Roster - {{ $scheduleteam->team_name }}</h5>
                                </div>
                                <div class="QA_table">
                                    <table class="table border border-black">
                                        <thead>
                                            <tr>
                                                <th scope="col">Day</th>
                                                <th scope="col">Saturday</th>
                                                <th scope="col">Sunday</th>
                                                <th scope="col">Monday</th>
                                                <th scope="col">Tuesday</th>
                                                <th scope="col">Wednesday</th>
                                                <th scope="col">Thursday</th>
                                                <th scope="col">Friday</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stviews as $stview)
                                                @if ($scheduleteam->team_name == $stview->team_name)
                                                    <tr>
                                                        <td>{{ $stview->shift_name }}</td>
                                                        <td>{{ $stview->sun }}</td>
                                                        <td>{{ $stview->mon }}</td>
                                                        <td>{{ $stview->tue }}</td>
                                                        <td>{{ $stview->wed }}</td>
                                                        <td>{{ $stview->thu }}</td>
                                                        <td>{{ $stview->fri }}</td>
                                                        <td>{{ $stview->sat }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="8">
                                                    @foreach ($shiftemployees as $shiftemployee)
                                                        {{ $shiftemployee->level }} - {{ $shiftemployee->emp_name }}, &nbsp; &nbsp; &nbsp;
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-center"></br></br>Checked By</td>
                                                <td colspan="4" class="text-center"></br></br>Approved By</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteScheduleTeamModal-{{$scheduleteam->id}}" tabindex="-1" aria-labelledby="deleteScheduleTeamModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{route('scheduleteam.destroy', ['scheduleteam' => $scheduleteam])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('delete')
                                <div class="modal-header theme_bg_1">
                                    <h1 class="modal-title fs-5 text-white" id="deleteScheduleTeamModalLabel{{ $scheduleteam->id }}">Delete {{ $scheduleteam->team_name }}?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-2">
                                                <label for="team_name">Team Name</label>
                                                <input type="text" class="form-control" value="{{ $scheduleteam->team_name}}" name="team_name" id="team_name" disabled>
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
        </div>
    </div>
@endsection