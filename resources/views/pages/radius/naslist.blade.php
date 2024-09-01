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
    
    <div class="main_content_iner mt-0">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1 d-flex justify-content-between">
                    <h5 class="mb-0 text-white">Nas List</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#radius_restartModal">Restart Radius</a>
                </div>
            </div>

            <div class="QA_table p-3 pb-0">
                @php
                    $count  = 1;
                @endphp
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Nas Name</th>
                            <th scope="col">Nas IP</th>
                            <th scope="col">Type</th>
                            <th scope="col">Secret</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($naslist as $nas)
                            <tr style="height: 30px">
                                <td>{{ $count++ }}</td>
                                <td>{{ $nas->nasname }}</td>
                                <td>{{ $nas->shortname }}</td>
                                <td>{{ $nas->type }}</td>
                                <td>{{ $nas->secret }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="radius_restartModal" tabindex="-1"
                aria-labelledby="radius_restartModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header theme_bg_1">
                            <h1 class="modal-title fs-5 text-white" id="radius_restartModalLabel">Restart Radius</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" style="filter: invert(100%);"></button>
                        </div>
                        <form class="" method="POST" action="{{ route('nas.radius_restart') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <h4>Are you sure you want to restart radius?</h4>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="btn btn-sm btn-danger" type="submit" onclick="this.disabled=true;this.form.submit();">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection