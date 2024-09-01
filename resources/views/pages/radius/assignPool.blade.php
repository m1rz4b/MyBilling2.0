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
                <h5 class="mb-0" style="color: white;">Package</h5>
            </div>

            <div class="QA_table p-3 pb-0">
                @php
                    $count  = 1;
                @endphp
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Package Name</th>
                                <th scope="col">NAS</th>
                                <th scope="col">Bandwidth</th>
                                <th scope="col">IP Pool</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rad_group_reply as $rad_reply)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $rad_reply->name }}</td>
                                @if($ip == '')
                                    <td>{{ "Any" }}</td>
                                @else
                                    <td>{{ $nas->shortname }}</td>
                                @endif
                                </td>
                                <td>{{ $mikrotik_rate_limit->value }}</td>
                                <td>{{ $framed_pool->value }}</td>
                                <td>Active</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_assign_pool-{{$rad_reply->id}}">Edit</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_assign_pool-{{$rad_reply->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('assignpool.update', ['assignpool' => 1])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit Profile</h1>
                                                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="package" class="form-label">Package Name</label>
                                                            <select class="form-select" aria-label="Small select example" id="package" name="package">
                                                                @foreach ($packages as $package)
                                                                    <option {{$rad_reply->id==$package->id?'selected':''}} value="{{ $package->id }}">{{ $package->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="router_id" class="form-label">NAS</label>
                                                            <select class="form-select" aria-label="Small select example" id="router_id" name="router_id">
                                                                @php
                                                                $any = '';
                                                                    if ($ip != '') {
                                                                        $nasaddress = str_replace(' ', '', $ip);
                                                                    } else {
                                                                        $any = 'selected';
                                                                    }
                                                                @endphp 
                                                                @foreach ($naslist as $nas)
                                                                    <option {{$rad_reply->id==$nas->id?'selected':''}} value="{{ $nas->id }}">{{ $nas->shortname }}</option>
                                                                @endforeach
                                                                <option value="any" {{$any}} >Any</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="mikrotik_rate_limit">Mikrotik-Rate-Limit() <small>If you use PCQ Please remove rate limit</small></label>
                                                            <input type="text" class="form-control" value="{{ $mikrotik_rate_limit->value }}" name="mikrotik_rate_limit" id="mikrotik_rate_limit">
                                                        </div>
                                                        <div>
                                                            <label for="framed_pool" class="form-label">IP Pool</label>
                                                            <select class="form-select" aria-label="Small select example" id="framed_pool" name="framed_pool">
                                                                @foreach ($ip_pools as $ip_pool)
                                                                    <option {{$framed_pool->id==$ip_pool->id?'selected':''}} value="{{ $ip_pool->id }}">{{ $ip_pool->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-sm btn-primary" value="Update">
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
</div>
@endsection