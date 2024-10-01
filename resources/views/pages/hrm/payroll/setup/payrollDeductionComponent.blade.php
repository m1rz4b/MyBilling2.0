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
                <h5 class="mb-0 text-white text-center">Deduction Component</h5>
                <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addDeductionComponentModal">Add</a>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addDeductionComponentModal" tabindex="-1" aria-labelledby="addDeductionComponentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="addDeductionComponentModalLabel">Add Deduction Component</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form method="POST" action="{{ route('payrolldeductcomponent.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="deductcomp" class="form-label fw-bold">Deduction Component: </label>
                                    <input type="text" class="form-control" id="deductcomp" name="deductcomp">
                                </div>
                                <div class="mb-2">
                                    <label for="type" class="form-label fw-bold">Type: </label>
                                    <select class="form-select" name="type" id="type">
                                        <option value="">Select a Type</option>
                                        @foreach ($comptypes as $comptype)
                                            <option value="{{ $comptype->id }}">{{ $comptype->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="percent" class="form-label fw-bold">Percent (%): </label>
                                    <input type="text" class="form-control" id="percent" name="percent" value="0">
                                </div>
                                <div class="mb-2">
                                    <label for="amount" class="form-label fw-bold">Amount: </label>
                                    <input type="text" class="form-control" id="amount" name="amount" value="0">
                                </div>
                                <div class="mb-2">
                                    <label for="glcode" class="form-label fw-bold">Gl Code: </label>
                                    <select name="glcode" id="glcode" class="form-select">
                                        <option value="">Select a Gl Code</option>
                                        @foreach ($masgls as $masgl)
                                            <option value="{{ $masgl->gl_code }}">{{ $masgl->description }}</option>
                                        @endforeach
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
                            <th scope="col" class="text-center">#Sl</th>
                            <th scope="col" class="text-center">Deduction Component</th>
                            <th scope="col" class="text-center">Type</th>
                            <th scope="col" class="text-center">Amount</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php 
                            $slNumber = 1 
                        @endphp
                        @foreach ($deductcomps as $deductcomp)
                            <tr>
                                <td class="text-center">{{ $slNumber++ }}</td>
                                <td class="text-center">{{ $deductcomp->deduct_comp_name }}</td>
                                <td class="text-center">{{ $deductcomp->type }}</td>
                                <td class="text-center">{{ $deductcomp->amnt }}</td>
                                <td class="text-center text-nowrap" width='10%'>
                                    <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_Deduction_Component_Modal{{ $deductcomp->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_Deduction_Component_Modal{{ $deductcomp->id }}" tabindex="-1" aria-labelledby="edit_Deduction_Component_Modal_Label{{ $deductcomp->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="edit_Deduction_Component_Modal_Label{{ $deductcomp->id }}">Edit Deduction Component</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form class="" id="editForm" method="POST" action="{{ route('payrolldeductcomponent.update', ['payrolldeductcomponent' => $deductcomp]) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="deductcomp" class="form-label fw-bold">Deduction Component: </label>
                                                    <input type="text" class="form-control" id="deductcomp" name="deductcomp" value="{{ $deductcomp->deduct_comp_name }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="type" class="form-label fw-bold">Type: </label>
                                                    <select class="form-select" name="type" id="type">
                                                        @foreach ($comptypes as $comptype)
                                                            <option {{ $deductcomp->type == $comptype->id ? 'selected' : '' }} value="{{ $comptype->id }}">{{ $comptype->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="percent" class="form-label fw-bold">Percent (%): </label>
                                                    <input type="text" class="form-control" id="percent" name="percent" value="{{ $deductcomp->percent }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="amount" class="form-label fw-bold">Amount: </label>
                                                    <input type="text" class="form-control" id="amount" name="amount" value="{{ $deductcomp->amnt }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="glcode" class="form-label fw-bold">Gl Code: </label>
                                                    <select name="glcode" id="glcode" class="form-select">
                                                        @foreach ($masgls as $masgl)
                                                            <option {{ $masgl->gl_code == $deductcomp->gl_code ? 'selected' : '' }} value="{{ $masgl->gl_code }}">{{ $masgl->description }}</option>
                                                        @endforeach
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