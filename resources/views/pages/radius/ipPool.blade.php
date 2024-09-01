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
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">IP Pool</h5>
                </div>
            </div>
            
            <div class="QA_table p-3 pb-0">
                {{-- <a class="btn_1 p-2 mb-3" href="#" data-bs-toggle="modal" data-bs-target="#addRouterModal">Add New Router</a> --}}
                <div class="ip_pool_router_search">
                    <label for="router_select" class="my-auto">Router</label>
                    <select name="router_select" id="router_select" class="w-25 select2">
                        <option value="">Select a Router</option>

                        @foreach ($routers as $router)
                            <option value="{{ $router->id }}">{{ $router->router_name }}</option>
                        @endforeach
                        
                    </select>
                    <button class="btn_1" type="submit">Search</button>
                </div>
                <label class="fw-bold">IP Pool in Software</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @php $slNumber = 1 @endphp
                        @foreach ($ip_pools as $ip_pool)
                            <tr>
                                <td>{{ $slNumber++ }}</td>
                                <td>{{ $ip_pool->name }}</td>
                                <td class="text-center text-nowrap" width='10%'>
                                    <button href="#" class="btn_1 danger text-center py-2" data-bs-toggle="modal" data-bs-target="#deleteIpPoolModal{{ $ip_pool->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteIpPoolModal{{ $ip_pool->id }}" tabindex="-1" aria-labelledby="deleteIpPoolModalLabel{{ $ip_pool->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header theme_bg_1">
                                            <h1 class="modal-title fs-5 text-white" id="deleteIpPoolModalLabel{{ $ip_pool->id }}">Are you sure ?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                        </div>
                                        <form class="" id="deleteForm" method="POST" action="{{ route('ippool.destroy', ['ippool' => $ip_pool]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="" class="form-label">IP Pool : </label>
                                                    <input readonly type="text" class="form-control" id="" name="" value="{{ $ip_pool->name }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="status" class="form-label">Status </label>
                                                    <select disabled name="status" id="status" class="form-select">
                                                        <option {{ ($ip_pool->status == "1") ? "selected" : "" }} value="1">Active</option>
                                                        <option {{ ($ip_pool->status == "2") ? "selected" : "" }} value="2">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                <button class="btn btn-sm btn-danger" type="submit" onclick="this.disabled=true;this.form.submit();">Delete</button>
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
        {{-- </form> --}}
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });
    </script>
@endsection