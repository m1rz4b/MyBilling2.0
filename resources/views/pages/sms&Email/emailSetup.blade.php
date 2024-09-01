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
                    <h5 class="mb-0 text-white text-center">Email Setup</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addEmailSetupModal">Add</a>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Email Setup Name</th>
                            <th scope="col">Set From</th>
                            <th scope="col">Host</th>
                            <th scope="col">SMTP Auth</th>
                            <th scope="col">Port</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $slNumber = 1 @endphp
                        @foreach ($email_setups as $email_setup)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $email_setup->name }}</td>
                                <td>{{ $email_setup->setFrom }}</td>
                                <td>{{ $email_setup->Host }}</td>
                                <td>{{ $email_setup->SMTPAuth }}</td>
                                <td>{{ $email_setup->port }}</td>
                                <td>{{ $email_setup->status }}</td>
                                <td><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editEmailSetupModal{{ $email_setup->id }}">Edit</button></td>
                            </tr>

                            {{-- edit modal --}}
                            <div class="modal fade" id="editEmailSetupModal{{ $email_setup->id }}" tabindex="-1"
                                aria-labelledby="editEmailSetupModalLabel{{ $email_setup->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                                            <h1 class="modal-title fs-5 text-white" id="editEmailSetupModalLabel{{ $email_setup->id }}">Edit Email Settings</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>

                                        <form class="" method="POST" action="{{ route('emailsetup.update', ['emailsetup' => $email_setup]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="name" class="form-label fw-bold">Email Setup Name: </label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $email_setup->name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="setFrom" class="form-label fw-bold">Set From: </label>
                                                            <input type="text" class="form-control" id="setFrom" name="setFrom" value="{{ $email_setup->setFrom }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="port" class="form-label fw-bold">Port: </label>
                                                            <input type="text" class="form-control" id="port" name="port" value="{{ $email_setup->port }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="Mailer" class="form-label fw-bold">Mail From: </label>
                                                            <input type="text" class="form-control" id="Mailer" name="Mailer" value="{{ $email_setup->Mailer }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="addReplyTo" class="form-label fw-bold">Reply To: </label>
                                                            <input type="text" class="form-control" id="addReplyTo" name="addReplyTo" value="{{ $email_setup->addReplyTo }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="addBCC" class="form-label fw-bold">Add BCC: </label>
                                                            <input type="text" class="form-control" id="addBCC" name="addBCC" value="{{ $email_setup->name }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="department_id" class="form-label fw-bold">Department: </label>
                                                            <select name="department_id" id="department_id" class="p-2 form-select">
                                                                @foreach ($departments as $department)
                                                                    <option {{ ($email_setup->department_id == $department->id) ? "selected" : '' }} value="{{ $department->id }}">{{ $department->department }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="status" class="form-label fw-bold">Status: </label>
                                                            <select name="status" id="status" class="p-2 form-select">
                                                                <option {{ $email_setup->status == "1" ? "selected" : '' }} value="1">Active</option>
                                                                <option {{ $email_setup->status == "2" ? "selected" : '' }} value="2">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="SMTPAuth" class="form-label fw-bold">SMTP Auth: </label>
                                                            <input type="text" class="form-control" id="SMTPAuth" name="SMTPAuth" value="{{ $email_setup->SMTPAuth }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="SMTPSecure" class="form-label fw-bold">SMTP Secure: </label>
                                                            <input type="text" class="form-control" id="SMTPSecure" name="SMTPSecure" value="{{ $email_setup->SMTPSecure }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="Host" class="form-label fw-bold">Host: </label>
                                                            <input type="text" class="form-control" id="Host" name="Host" value="{{ $email_setup->Host }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="Username" class="form-label fw-bold">Username: </label>
                                                            <input type="text" class="form-control" id="Username" name="Username" value="{{ $email_setup->Username }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="Password" class="form-label fw-bold">Password: </label>
                                                            <input type="text" class="form-control" id="Password" name="Password" value="{{ $email_setup->Password }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="addCC" class="form-label fw-bold">Add CC: </label>
                                                            <input type="text" class="form-control" id="addCC" name="addCC" value="{{ $email_setup->addCC }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="isHTML" class="form-label fw-bold">HTML: </label>
                                                            <input type="text" class="form-control" id="isHTML" name="isHTML" value="{{ $email_setup->isHTML }}">
                                                        </div>
                                                        <div class="mb-2 mt-5 text-center text-lg d-flex justify-content-center gap-4">
                                                            <div>
                                                                <input type="checkbox" class="form-check-input" id="receive_email" name="receive_email" {{ $email_setup->receive_email == 1 ? 'checked' : '' }}>
                                                                <label for="receive_email" class="form-label fw-bold">Email Receive </label>
                                                            </div>
                                                            <div>
                                                                <input type="checkbox" class="form-check-input" id="send_email" name="send_email" {{ $email_setup->send_email == 1 ? 'checked' : '' }}>
                                                                <label for="send_email" class="form-label fw-bold">Email Send </label>
                                                            </div>
                                                        </div>
                                                    </div>
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

                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- add modal --}}
            <div class="modal fade" id="addEmailSetupModal" tabindex="-1"
                aria-labelledby="addEmailSetupModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2d1967; padding: 0.8rem 1rem;">
                            <h1 class="modal-title fs-5 text-white" id="addEmailSetupModalLabel">Add New Email Settings</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="filter: invert(100%);"></button>
                        </div>

                        <form class="" method="POST" action="{{ route('emailsetup.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="name" class="form-label fw-bold">Email Setup Name: </label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="setFrom" class="form-label fw-bold">Set From: </label>
                                            <input type="text" class="form-control" id="setFrom" name="setFrom">
                                        </div>
                                        <div class="mb-2">
                                            <label for="port" class="form-label fw-bold">Port: </label>
                                            <input type="text" class="form-control" id="port" name="port">
                                        </div>
                                        <div class="mb-2">
                                            <label for="Mailer" class="form-label fw-bold">Mail From: </label>
                                            <input type="text" class="form-control" id="Mailer" name="Mailer">
                                        </div>
                                        <div class="mb-2">
                                            <label for="addReplyTo" class="form-label fw-bold">Reply To: </label>
                                            <input type="text" class="form-control" id="addReplyTo" name="addReplyTo">
                                        </div>
                                        <div class="mb-2">
                                            <label for="addBCC" class="form-label fw-bold">Add BCC: </label>
                                            <input type="text" class="form-control" id="addBCC" name="addBCC">
                                        </div>
                                        <div class="mb-2">
                                            <label for="department_id" class="form-label fw-bold">Department: </label>
                                            <select name="department_id" id="department_id" class="p-2 form-select">
                                                <option value="">Select a Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="status" class="form-label fw-bold">Status: </label>
                                            <select name="status" id="status" class="p-2 form-select">
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="SMTPAuth" class="form-label fw-bold">SMTP Auth: </label>
                                            <input type="text" class="form-control" id="SMTPAuth" name="SMTPAuth">
                                        </div>
                                        <div class="mb-2">
                                            <label for="SMTPSecure" class="form-label fw-bold">SMTP Secure: </label>
                                            <input type="text" class="form-control" id="SMTPSecure" name="SMTPSecure">
                                        </div>
                                        <div class="mb-2">
                                            <label for="Host" class="form-label fw-bold">Host: </label>
                                            <input type="text" class="form-control" id="Host" name="Host">
                                        </div>
                                        <div class="mb-2">
                                            <label for="Username" class="form-label fw-bold">Username: </label>
                                            <input type="text" class="form-control" id="Username" name="Username">
                                        </div>
                                        <div class="mb-2">
                                            <label for="Password" class="form-label fw-bold">Password: </label>
                                            <input type="text" class="form-control" id="Password" name="Password">
                                        </div>
                                        <div class="mb-2">
                                            <label for="addCC" class="form-label fw-bold">Add CC: </label>
                                            <input type="text" class="form-control" id="addCC" name="addCC">
                                        </div>
                                        <div class="mb-2">
                                            <label for="isHTML" class="form-label fw-bold">HTML: </label>
                                            <select name="isHTML" id="isHTML" class="p-2 form-control">
                                                <option value="true">True</option>
                                                <option value="false">False</option>
                                            </select>
                                        </div>
                                        <div class="mb-2 mt-5 text-center text-lg d-flex justify-content-center gap-4">
                                            <div>
                                                <input type="checkbox" class="form-check-input" id="receive_email" name="receive_email">
                                                <label for="receive_email" class="form-label fw-bold">Email Receive </label>
                                            </div>
                                            <div>
                                                <input type="checkbox" class="form-check-input" id="send_email" name="send_email">
                                                <label for="send_email" class="form-label fw-bold">Email Send </label>
                                            </div>
                                        </div>
                                    </div>
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