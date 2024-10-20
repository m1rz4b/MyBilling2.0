@extends('layouts.main')
@inject('carbon', 'Carbon\Carbon')

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
                <h5 class="mb-0" style="color: white;">Leave Transaction</h5>
            </div>
        </div>

        <div class="QA_table px-3">
            <div>
                @php
                    $count = ($leaves->currentPage() - 1) * $leaves->perPage() + 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Employee</th>
                            <th>Approve Date</th>
                            <th>Leave Type</th>
                            <th>Days</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($leaves as $leave)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $leave->emp_name }}</td>
                            <td>
                                @if ($leave->approved_time != '0000/00/00')
                                    {{ $leave->approved_time }}
                                @else
                                    {{ "Not Approve Yet" }}
                                @endif
                            </td>
                            <td>{{ $leave->leavetype_name }}</td>
                            <td>{{ $leave->days }}</td>
                            <td>{{ $leave->from_date }}</td>
                            <td>{{ $leave->to_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $leaves->links() !!}
            </div>
        </div>
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