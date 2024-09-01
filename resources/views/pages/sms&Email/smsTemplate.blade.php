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
    <form action="{{ route('smstemplate.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white;">SMS Template</h5>
                    <a class="btn-custom-1" href="#" data-bs-toggle="modal" data-bs-target="#addNewBlockReason"><small><i class="fa-solid fa-plus me-1 fw-extrabold"></i></small>Add</a>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addNewBlockReason" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('smstemplate.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-header theme_bg_1">
                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Add SMS Template</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-2">
                                            <label for="command" class="fw-medium">For</label>
                                            <input type="text" class="form-control" id="command" name="command">
                                        </div>
                                        <div class="mb-2">
                                            <label for="description" class="fw-medium d-block">SMS Body</label>
                                            <label for="description" class="fw-medium">Body- Keyword: <span>@{{ clients_name }}</span> , <span>@{{ user_id }}</span> , <span>@{{ block_date }}</span> , <span>@{{ due }}</span></label>
                                            <textarea name="description" id="description" class="form-control"></textarea>
                                        </div>
                                        <div>
                                            <label for="status" class="fw-medium">Status: </label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="1">On</option>
                                                <option value="2">Off</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-sm btn-primary" value="Add" onclick="this.disabled=true;this.form.submit();">
                            </div>
                        </form>
                    </div>
                </div>
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
                                <th scope="col">For</th>
                                <th scope="col">Description</th>
                                <th scope="col">Use Type(System/User)</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($sms_templates as $sms)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $sms->command }}</td>
                                <td>{{ $sms->description }}</td>
                                <td>{{ $sms->type ==1 ? 'System' : 'User'}}</td>
                                <td>{{ $sms->status ==1 ? 'On': 'Off'}}</td>
                                <td class="text-end text-nowrap" width='10%'>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_sms_template-{{$sms->id}}">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_sms_template-{{$sms->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{route('smstemplate.update', ['smstemplate' => $sms])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header theme_bg_1">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Edit SMS Template</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(100%);"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="command" class="fw-medium">For</label>
                                                            <input type="text" class="form-control" id="command" name="command" value="{{ $sms->command }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="description" class="fw-medium d-block">SMS Body</label>
                                                            <label for="description" class="fw-medium">Body- Keyword: <span>@{{ clients_name }}</span> , <span>@{{ user_id }}</span> , <span>@{{ block_date }}</span> , <span>@{{ due }}</span></label>
                                                            <textarea name="description" id="description" class="form-control">{{ $sms->description }}</textarea>
                                                        </div>
                                                        <div>
                                                            <label for="status" class="fw-medium">Status: </label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option value="1">On</option>
                                                                <option value="2">Off</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-sm btn-success" value="Update" onclick="this.disabled=true;this.form.submit();">
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
    </form>
</div>

<script>
    $(document).ready(function() {
	counter = function() {
    var value = $('#description').val();

    if (value.length == 0) {
        $('#totalChars').html(0);
        return;
    }
    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    var totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;
    $('#totalChars').html(totalChars);
};
});
$(document).ready(function() {
    $('#description').change(counter);
    $('#description').keydown(counter);
    $('#description').keypress(counter);
    $('#description').keyup(counter);
    $('#description').blur(counter);
    $('#description').focus(counter);
});

    $('span').click(function(e) {
    var txtarea = $('#description').val();
    var txt = $(e.target).text();
    $('#description').val(txtarea + txt + ' ');
    });
</script>
@endsection