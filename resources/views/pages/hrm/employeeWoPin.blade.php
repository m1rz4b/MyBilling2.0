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
            <div class="px-4 py-1 theme_bg_1">
                <h5 class="mb-0 text-white text-center">Employee Without Pin</h5>
            </div>

            <div class="QA_table p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Sl</th>
                            <th scope="col" class="text-center">Employee Name</th>
                            <th scope="col" class="text-center">Department</th>
                            <th scope="col" class="text-center">Designation</th>
                            <th scope="col" class="text-center">Mobile</th>
                            <th scope="col" class="text-center">Email</th>
                            <th scope="col" class="text-center">Assigned Pin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($wopinemployees as $wopinemployee)
                            <tr>
                                <td class="text-center">{{ $slNumber++ }}</td>
                                <td class="text-center">{{ $wopinemployee->emp_name }}</td>
                                <td class="text-center">{{ $wopinemployee->department }}</td>
                                <td class="text-center">{{ $wopinemployee->designation }}</td>
                                <td class="text-center">{{ $wopinemployee->mobile }}</td>
                                <td class="text-center">{{ $wopinemployee->email }}</td>
                                <td class="text-center">
                                    <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#assignedPin{{ $wopinemployee->id }}">
                                        <i class="fa-solid fa-pen me-1"></i>Assigned
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="assignedPin{{ $wopinemployee->id }}" tabindex="-1" aria-labelledby="assignedPinLabel{{ $wopinemployee->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="assignedPinLabel{{ $wopinemployee->id }}">Edit Assigned Pin</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form class="p-0" id="editForm" method="POST" action="{{ route('empwopin.woPinUpdate', ['empwopin' => $wopinemployee->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="emp_name" class="form-label fw-bold">Employee Name: </label>
                                                    <input type="text" class="form-control" id="emp_name" name="emp_name" value="{{ $wopinemployee->emp_name }}" readonly>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="emp_pin" class="form-label fw-bold">Employee Pin: </label>
                                                    <input type="text" class="form-control" id="emp_pin" name="emp_pin" value="{{ $wopinemployee->emp_pin }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                <button class="btn btn-sm btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">Update</button>
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