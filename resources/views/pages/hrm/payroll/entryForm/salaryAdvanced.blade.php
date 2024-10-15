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
                <h5 class="mb-0 text-white text-center">Salary Advanced</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addSalaryAdvancedModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addSalaryAdvancedModal" tabindex="-1" aria-labelledby="addSalaryAdvancedModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addSalaryAdvancedModalLabel">Add Salary Advanced</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('salary-advanced.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="empname" class="form-label">Employee: </label>
                                    <select name="empname" id="empname" class="form-select">
                                        <option value="">Select an Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="date" class="form-label">Date: </label>
                                    <input type="date" class="form-control datepicker-here" id="date" name="date">
                                </div>
                                <div class="mb-2">
                                    <label for="amount" class="form-label">Amount: </label>
                                    <input type="text" class="form-control" id="amount" name="amount">
                                </div>
                                <div class="mb-2">
                                    <label for="status" class="form-label">Status </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Select a Status</option>
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

            <div class="QA_table table-responsive p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($salaryadvanced as $salaryadvance)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                @foreach ($employees as $employee)
                                    @if ($employee->id == $salaryadvance->emp_id)
                                        <td>{{ $employee->emp_name }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $salaryadvance->date }}</td>
                                <td>{{ $salaryadvance->amount }}</td>
                                <td>{{ $salaryadvance->status }}</td>
                                <td>
                                    <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editSalaryAdvancedModal{{ $salaryadvance->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="addSalaryAdvancedModal" tabindex="-1" aria-labelledby="addSalaryAdvancedModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="addSalaryAdvancedModalLabel">Edit Salary Advanced</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('salary-advanced.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="empname" class="form-label">Employee: </label>
                                                    <select name="empname" id="empname" class="form-select">
                                                        @foreach ($employees as $employee)
                                                            <option {{ $salaryadvance->emp_id == $employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="date" class="form-label">Date: </label>
                                                    <input type="date" class="form-control datepicker-here" id="date" name="date" value="{{ $salaryadvance->date }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="amount" class="form-label">Amount: </label>
                                                    <input type="text" class="form-control" id="amount" name="amount" value="{{ $salaryadvance->amount }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option {{ $salaryadvance->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                                        <option {{ $salaryadvance->status == 2 ? 'selected' : '' }} value="2">Inactive</option>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection