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

            <div class="row p-3 pb-0">
                <div class="col-sm-4 form-group">
                    <label for="router_select" class="my-auto">Router</label>
                    <select name="router_select" id="router_select" class="select2 form-select form-select-sm">
                        <option value="">Select a Router</option>
                        @foreach ($routers as $router)
                            <option value="{{ $router->id }}">{{ $router->router_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2 d-flex d-sm-inline justify-content-end">
                    <br class="d-none d-sm-block">
                    <button onclick="search()" class="btn btn-sm btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                <label class="fw-bold">IP Pool in Software</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="ippool_list">
                        
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

            <div class="QA_table p-3 pb-0 d-none" id="router_info_table">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Range</th>
                            <th scope="col" class="text-center">Import</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });

        const search = () => {
            const routerID = document.getElementById('router_select').value;

            // Your JSON data
            const jsonData = { routerID: routerID };

            // Set up options for the fetch request
            const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(jsonData) // Convert JSON data to a string and set it as the request body
            };

            // Make the fetch request with the provided options
            fetch(`{{ url('ippool/search') }}`, options)
            .then(response => {
                // Check if the request was successful
                if (!response.ok) {
                throw new Error('Network response was not ok');
                }
                // Parse the response as JSON
                return response.json();
            })
            .then(data => {
                // Handle the JSON data
                console.log(data);
                data = data.data;
                    for (res of data) {
                        const name = res.name;
                        const ranges = res.ranges;
                        // const routerId = res['.id'];
                        // let id = routerId.replace('*', '');

                        const tbody = document.getElementById("tbody");
                        const row = document.createElement('tr');
                        const routerInfo = document.getElementById("router_info_table");
                        routerInfo.classList.remove('d-none');
                        row.innerHTML = `
                            <td>${name}</td>
                            <td>${ranges}</td>
                            <td class="text-center text-nowrap" width='10%'>
                                <button href="#" class="btn btn-sm btn-info text-white" data-name="${name}" data-ranges="${ranges}" onclick="importRouter(this)" data-bs-toggle="modal" data-bs-target="#deleteIpPoolModal">
                                    <i class="fa fa-cloud-download me-1" aria-hidden="true"></i>Import
                                </button>
                            </td>
                        `
                        tbody.appendChild(row);
                    }
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch
                console.error('Fetch error:', error);
            });
            
            // $.ajax({
            //     url: `{{ url('ippool/'.'${id}') }}`,
            //     type: 'POST',
            //     dataType: "json",
            //     data: {
            //         "_token": "{{ csrf_token() }}",
            //         router: id,
            //     },
            //     success: function(data) {
            //         data = data.data;
            //         for (res of data) {
            //             const name = res.name;
            //             const ranges = res.ranges;
            //             // const routerId = res['.id'];
            //             // let id = routerId.replace('*', '');

            //             const tbody = document.getElementById("tbody");
            //             const row = document.createElement('tr');
            //             const routerInfo = document.getElementById("router_info_table");
            //             routerInfo.classList.remove('d-none');
            //             row.innerHTML = `
            //                 <td>${name}</td>
            //                 <td>${ranges}</td>
            //                 <td class="text-center text-nowrap" width='10%'>
            //                     <button href="#" class="btn btn-sm btn-info text-white" data-name="${name}" data-ranges="${ranges}" onclick="importRouter(this)" data-bs-toggle="modal" data-bs-target="#deleteIpPoolModal">
            //                         <i class="fa fa-cloud-download me-1" aria-hidden="true"></i>Import
            //                     </button>
            //                 </td>
            //             `
            //             tbody.appendChild(row);
            //         }
            //     }
            // });
        }

        const importRouter = (e) => {
            const routerId = document.getElementById('router_select').value;
            const routerName = e.getAttribute('data-name');
            const routerRanges = e.getAttribute('data-ranges');    
            
            let fetchRes = fetch("{{ url('importRouter') }}");
                
            // Your JSON data
            const routerInfo = { routerId: routerId, routerName: routerName, routerRanges: routerRanges };

            // Set up options for the fetch request
            const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(routerInfo) // Convert JSON data to a string and set it as the request body
            };

            // Make the fetch request with the provided options
            fetch("{{ url('importRouter') }}", options)
            .then(res => {
                // Check if the request was successful
                if (!res.ok) {
                throw new Error('Network response was not ok');
                }
                // Parse the response as JSON
                return res.json();
            })
            .then(response => {
                // Handle the JSON data
                console.log(response);
                const data = response.data; 
                const routerId = data.router_id;
                const name = data.name;
                const ranges = data.ranges;
                 console.log(routerId, name, ranges);
                
                const tbody = document.getElementById("ippool_list");
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${response.count}</td>
                    <td>${name}</td>
                    <td class="text-center text-nowrap" width='10%'>
                        <button href="#" class="btn_1 danger text-center py-2" data-bs-toggle="modal" data-bs-target="#deleteIpPoolModal{{ $ip_pool->id }}">
                            Delete
                        </button>
                    </td>
                `
                tbody.appendChild(row);
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch
                console.error('Fetch error:', error);
            });
            

            // $.ajax({
            //     type: "POST",
            //     url: `{{ url('importRouter') }}`,
            //     dataType: "json",
            //     data: {
            //         "_token": "{{ csrf_token() }}",
            //         routerId: routerId,
            //         routerName: routerName,
            //         routerRanges : routerRanges
            //     },
            //     success: function (response)
            //     {   
            //         // console.log(response);
                    
            //         data = response.data;
            //         // console.log(data);
                    

                        
            //             const routerId = data.router_id;
            //             const name = data.name;
            //             const ranges = data.ranges;
            //             // console.log(routerId, name, ranges);
                        
            //             const tbody = document.getElementById("ippool_list");
            //             const row = document.createElement('tr');
            //             row.innerHTML = `
            //                 <td>${response.count}</td>
            //                 <td>${name}</td>
            //                 <td class="text-center text-nowrap" width='10%'>
            //                     <button href="#" class="btn_1 danger text-center py-2" data-bs-toggle="modal" data-bs-target="#deleteIpPoolModal{{ $ip_pool->id }}">
            //                         Delete
            //                     </button>
            //                 </td>
            //             `
            //             tbody.appendChild(row);
                    
            //     }
            // });
        }
    </script>
@endsection