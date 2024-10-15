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
                <h5 class="mb-0 text-white text-center">Manage Employee Loan</h5>
                <a class="btn-custom-1" data-bs-toggle="modal" data-bs-target="#addEmploanModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addEmploanModal" tabindex="-1" aria-labelledby="addEmploanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addEmploanModalLabel">Add Employee Loan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('emp-loan.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
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
                                            <label for="sanctiondate" class="form-label">Sanction Date: </label>
                                            <input type="date" class="form-control datepicker-here" id="sanctiondate" name="sanctiondate">
                                        </div>
                                        <div class="mb-2">
                                            <label for="startdate" class="form-label">Start Date: </label>
                                            <input type="date" class="form-control datepicker-here" id="startdate" name="startdate">
                                        </div>
                                        <div class="mb-2">
                                            <label for="emi" class="form-label">EMI: </label>
                                            <input type="text" class="form-control" id="emi" name="emi" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="amount" class="form-label">Amount: </label>
                                            <input type="text" class="form-control" id="amount" name="amount">
                                        </div>
                                        <div class="mb-2">
                                            <label for="interest" class="form-label">Interest % : </label>
                                            <input type="text" class="form-control" id="interest" name="interest">
                                        </div>
                                        <div class="mb-2">
                                            <label for="installments" class="form-label">No. of Installment: </label>
                                            <input type="text" class="form-control" id="installments" name="installments">
                                        </div>
                                        <div class="mb-2">
                                            <label for="loanstatus" class="form-label">Loan Status </label>
                                            <select name="loanstatus" id="loanstatus" class="form-select">
                                                <option value="">Select a Status</option>
                                                @foreach ($hrmloanstatuses as $hrmloanstatus)
                                                    <option value="{{ $hrmloanstatus->id }}">{{ $hrmloanstatus->name }}</option>
                                                @endforeach
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

            <div class="QA_table table-responsive p-3 pb-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Sanction Date</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Interest %</th>
                            <th scope="col">No. of Interest</th>
                            <th scope="col">EMI</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($tblemploans as $tblemploan)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                @foreach ($employees as $employee)
                                    @if ($employee->id == $tblemploan->emp_id)
                                        <td>{{ $employee->emp_name }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $tblemploan->sanction_date }}</td>
                                <td>{{ $tblemploan->start_date }}</td>
                                <td>{{ $tblemploan->amnt }}</td>
                                <td>{{ $tblemploan->interest }} %</td>
                                <td>{{ $tblemploan->no_of_installment }}</td>
                                <td>{{ $tblemploan->emi }}</td>
                                <td>{{ $tblemploan->status }}</td>
                                <td>
                                    <button href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewEmploanModal{{ $tblemploan->id }}">
                                        View EMI
                                    </button>
                                    <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editEmploanModal{{ $tblemploan->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editEmploanModal{{ $tblemploan->id }}" tabindex="-1" aria-labelledby="editEmploanModalLabel{{ $tblemploan->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="editEmploanModalLabel{{ $tblemploan->id }}">Edit Employee Loan</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form method="POST" action="{{ route('emp-loan.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="empname" class="form-label">Employee: </label>
                                                            <select name="empname" id="empname" class="form-select">
                                                                @foreach ($employees as $employee)
                                                                    <option {{ $employee->emp_id == $tblemploan->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="sanctiondate" class="form-label">Sanction Date: </label>
                                                            <input type="date" class="form-control datepicker-here" id="sanctiondate" name="sanctiondate" value="{{ $tblemploan->sanction_date }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="startdate" class="form-label">Start Date: </label>
                                                            <input type="date" class="form-control datepicker-here" id="startdate" name="startdate" value="{{ $tblemploan->start_date }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="emi" class="form-label">EMI: </label>
                                                            <input type="text" class="form-control" id="emi" name="emi"  value="{{ $tblemploan->emi }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label for="amount" class="form-label">Amount: </label>
                                                            <input type="text" class="form-control" id="amount" name="amount" value="{{ $tblemploan->amnt }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="interest" class="form-label">Interest % : </label>
                                                            <input type="text" class="form-control" id="interest" name="interest" value="{{ $tblemploan->interest }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="installments" class="form-label">No. of Installment: </label>
                                                            <input type="text" class="form-control" id="installments" name="installments" value="{{ $tblemploan->no_of_installment }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="loanstatus" class="form-label">Loan Status </label>
                                                            <select name="loanstatus" id="loanstatus" class="form-select">
                                                                <option value="">Select a Status</option>
                                                                @foreach ($hrmloanstatuses as $hrmloanstatus)
                                                                    <option {{ $tblemploan->status == $hrmloanstatus->id ? 'selected' : '' }} value="{{ $hrmloanstatus->id }}">{{ $hrmloanstatus->name }}</option>
                                                                @endforeach
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection