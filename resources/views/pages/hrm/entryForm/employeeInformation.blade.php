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
        <div class="">
            <div class="px-4 py-1 theme_bg_1">
                <h5 class="mb-0" style="color: white;">Employee</h5>
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
                            <th scope="col"><small class="text-nowrap">Sl</small></th>
                            <th scope="col"><small class="text-nowrap">Employee Name</small></th>
                            <th scope="col"><small class="text-nowrap">Date of Joining</small></th>
                            <th scope="col"><small class="text-nowrap">Department</small></th>
                            <th scope="col"><small class="text-nowrap">Designation</small></th>
                            <th scope="col"><small class="text-nowrap">Mobile</small></th>
                            <th scope="col"><small class="text-nowrap">Email</small></th>
                            <th scope="col"><small class="text-nowrap">Status</small></th>
                            <th scope="col" class="text-center"><small class="text-nowrap">Action</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($mas_employees as $mas_employee)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $mas_employee->account_no }}</td>
                            <td>{{ $mas_employee->user_id }}</td>
                            <td>{{ $mas_employee->emp_name }}</td>
                            <td>{{ $mas_employee->mac_address }}</td>
                            <td>{{ $mas_employee->ip_number }}</td>
                            <td>{{ $mas_employee->mobile1 }}</td>
                            <td>{{ $mas_employee->package }}</td>
                            <td>{{ $mas_employee->inv_name }}</td>
                            <td>{{ $mas_employee->bandwidth_plan }}</td>
                            <td>{{ $mas_employee->client_type_name }}</td>
                            <td>{{ $mas_employee->router_ip }}</td>
                            <td>{{ $mas_employee->block_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
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

    const selectClientStatus = document.getElementById('client_status');
    const selectExpDate = document.getElementById('exp_date');
    
    selectClientStatus.addEventListener("change", (event) => {
        if (event.target.value == 2){
            selectExpDate.setAttribute('readonly', '');
        } else {
            selectExpDate.removeAttribute('readonly');
        }
    });



    const selectPackage = document.getElementById('package');
    const inputPackageRate = document.getElementById('package_rate');
        
    selectPackage.addEventListener("change", (event) => {
        inputPackageRate.value = selectPackage.value;
        console.log(event.target.value);
    });
</script>

@endpush
@endsection