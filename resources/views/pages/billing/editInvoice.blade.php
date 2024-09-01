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
                    <h5 class="mb-0" style="color: white;">Modify Invoice</h5>
                </div>
            </div>
            <form action="{{route('masinvoice.editinvoiceshow')}}">
                <div class="row p-3">
                    <div class="col-sm-3 form-group">
                        <label for="month" class="fw-medium">Month</label>
                        <select class="form-select form-select-sm form-control" id="month" name="month">
                            @foreach(range(1,12) as $month)
                                    <option value="{{$month}}">
                                            {{date("M", strtotime('2016-'.$month))}}
                                    </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="year" class="fw-medium">Year</label>
                        <select class="form-select form-select-sm form-control" id="year" name="year" >
                            <option>Please Choose A Year</option>
                            @foreach (range(now()->year - 10, now()->year + 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="client" class="fw-medium">Client</label>
                        <select class="select2 form-select form-select-sm" id="client" name="client">
                            <option selected>Select a Client</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
                            @endforeach                   
                        </select>
                    </div>

                    <div class="col-sm-2 form-group d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <input type="submit" class="btn btn-sm btn-primary"></button>
                    </div>
                </div>
            </form>


            
        </div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });
</script>

@endpush
@endsection