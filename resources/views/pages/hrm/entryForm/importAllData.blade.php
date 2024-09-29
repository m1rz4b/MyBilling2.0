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
    <div class="container-fluid p-0 pb-3 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white;">Import Client</h5>
            </div>
        </div>

        <div class="row p-3">
            <div class="col-sm-6">
                <form action="{{route('approveleave.show')}}" class="row" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-6">
                        <label class="fw-bold">Choose Excel File: </label>
                        <input type="file" name="file" id="file" accept=".xls,.xlsx">
                    </div>
                    <div class="col-sm-6 d-flex d-sm-inline justify-content-end">
                        <br class="d-none d-sm-block">
                        <button type="button" class="btn btn-sm btn-dark"  onclick="this.disabled=true;this.form.submit();">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-2 d-flex d-sm-inline justify-content-end">
                <br class="d-none d-sm-block">
                <a href="checkinout_temp.xlsx" id="submit" name="import"  class="btn btn-sm btn-primary" download>Example Excel Sheet</a>
            </div>
            <div class="col-sm-2 d-flex d-sm-inline justify-content-end">
                <br class="d-none d-sm-block">
                <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();">Sync Data</button>
            </div>
        </div>

        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Check Time</th>
                            <th>Check Type</th>
                            <th><div class="d-flex align-items-center"><input type="checkbox" id="select_all" class="me-1 mb-0"/>Select All</div></th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    {{-- <tbody>
                        @foreach ($day_off_entries as $day_off_entry)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $day_off_entry->emp_name }}</td>
                            <td>{{ $day_off_entry->emp_no }}</td>
                            <td>{{ date('d M Y, l', strtotime($from_date)) }}</td>                    
                            <td>{{ $day_off_entry->department }}</td>
                            <td>{{ $day_off_entry->designation }}</td>
                            <td>
                                @if ($day_off_entry->id != '')
                                    {{'Holyday'}}
                                @else
                                    {{'Working Day'}}
                                @endif
                            </td>
                            <td class="text-end text-nowrap" width='10%'>
                                <label class="rocker rocker-small">
                                    <input type="checkbox" value="1" 
                                        @if($day_off_entry->id != '') checked @php $val = 'yes'; @endphp 
                                        @else @php $val = 'no'; @endphp 
                                        @endif
                                        onChange="saveOffDay({{ $day_off_entry->id }}, '{{ $val }}', '{{ $from_date }}')"
                                    >
                                    <span class="switch-left">OFF</span>
                                    <span class="switch-right">ON</span>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody> --}}
                </table>
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