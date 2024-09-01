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
    <form action="{{ route('sendsinglesms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white;">SMS Test</h5>
                </div>
            </div>

            <div class="w-50 mx-auto py-5">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <fieldset class="border rounded-3 p-3 theme-border">
                        <legend class="float-none w-auto px-3 theme-text fs-5 fw-semibold">SMS Test</legend>
                        <div class="mb-2">
                            <label for="mobile_no" class="form-label">Mobile No<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="mobile_no" name="mobile_no">
                        </div>
                        <div class="mb-2">
                            <label for="sms_body" class="form-label">SMS Body<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="sms_body" rows="2"></textarea>
                        </div>

                        <div class="mb-2 form-group">
                            <label for="api" class="form-label">Use API<span class="text-danger">*</span></label>
                            <select class="form-select form-control" id="api" name="api" required>
                                <option selected>Select an API name</option>
                                @foreach ($single_sms as $sms)
                                    <option value="{{ $sms->id }}">{{ $sms->name }}</option>
                                @endforeach                      
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="btn btn-primary" value="Send" onclick="this.disabled=true;this.form.submit();">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </form>
</div>
@endsection