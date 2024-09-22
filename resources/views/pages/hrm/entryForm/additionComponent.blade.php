@extends('layouts.main')

@section('main-container')
<style>
    .table th,
    .table td {
        padding: 0.25rem;
    }

    .select2-container .select2-selection--single {
        height: auto !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-top: .25rem !important;
        padding-bottom: .25rem !important;
        font-size: .875rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 3px !important;
        right: 3px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
    }
</style>

<div>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible my-1" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible my-1" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            @foreach($errors->all() as $error)
            <strong>Error !</strong> {{ $error }}
            @endforeach
        </div>
    @endif
</div>

<div class="main_content_iner">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Monthly Addition Component</h5>
            </div>
        </div>
        <form action="{{ route('additioncomponent.show') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="row p-3">
                <div class="col-sm-3 form-group">
                    <label for="month" class="fw-medium">Month</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
                            <option>{{ now()->format('M') }}</option>
                            @foreach(range(1,12) as $month)
                                <option {{ $selectedMonth==$month? 'selected' : '' }} value="{{ $month }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 form-group">
                    <label for="year" class="fw-medium">Year</label>
                    <div class="input-group input-group-sm flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-calendar-days"></i></span>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            <option>{{ now()->year }}</option>
                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                <option {{ $selectedYear==$year? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Show</button>
                </div>
            </div>
        </form>

        @if ($hrm_emp_monthly_add)
        <div class="QA_table px-3">
            @php
                $count  = 1;
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><small class="text-nowrap">Sl</small></th>
                        <th scope="col"><small class="text-nowrap">Employee</small></th>
                        <th scope="col"><small class="text-nowrap">Year</small></th>
                        <th scope="col"><small class="text-nowrap">Month</small></th>
                        <th scope="col"><small class="text-nowrap">Addition Component</small></th>
                        <th scope="col"><small class="text-nowrap">Amount</small></th>
                        <th scope="col"><small class="text-nowrap">Action</small></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($hrm_emp_monthly_add as $hrm_emp)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $hrm_emp->emp_name }}</td>
                        <td>{{ $hrm_emp->year }}</td>
                        <td>{{ $hrm_emp->month }}</td>
                        <td>{{ $hrm_emp->add_comp_id }}</td>
                        <td>{{ $hrm_emp->amnt }}</td>
                        <td>
                            <button href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_addition_component_modal-{{ $hrm_emp->id }}">Edit</button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="edit_addition_component_modal-{{$hrm_emp->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{route('additioncomponent.update', ['additioncomponent' => $hrm_emp])}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="modal-header theme_bg_1">
                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit Addition Component</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-2">
                                                    <label for="add_comp_name">Addition Component</label>
                                                    <input type="text" class="form-control" value="{{ $hrm_emp->add_comp_name}}" name="add_comp_name" id="add_comp_name" readonly>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="amnt">Amount</label>
                                                    <input type="text" class="form-control" value="{{ $hrm_emp->amnt}}" name="amnt" id="amnt">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-sm btn-success" value="Submit" onclick="this.disabled=true;this.form.submit();">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 form-group d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();">Submit</button>
            </div>
        </div>
        @endif
    </div>
</div>

@push('select2')
<script>
    function showLoader() {
        alert("The form was submitted");
    }
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });
</script>

@endpush
@endsection