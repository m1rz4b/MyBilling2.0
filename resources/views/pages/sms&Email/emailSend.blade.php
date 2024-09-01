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
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">Send Email</h5>
                </div>
            </div>
            
            <div class="d-flex justify-content-center">
                <div class="border border-info m-3 w-75 p-3" id="emailDiv">
                    <form class="" method="POST" action="{{ route('sendemail.esend_store') }}">
                        @csrf
                        {{-- <h5 class="text-center fw-bold">Email Test</h5> --}}
                        <div class="mb-2">
                            <label for="receiver_email" class="form-label fw-semibold">Email: </label>
                            <input type="text" class="form-control" id="receiver_email" name="receiver_email">
                        </div>
                        <div class="mb-2">
                            <label for="subject" class="form-label fw-semibold">Subject: </label>
                            <input type="text" class="form-control" id="subject" name="subject">
                        </div>
                        <div class="mb-2 d-flex flex-column">
                            <label for="email_atch" class="form-label fw-semibold">Attachments: </label>
                            <input type="file" class="" id="email_atch" name="">
                        </div>
                        <div class="mb-2">
                            <label for="body_text" class="form-label fw-semibold">Body </label>
                            <textarea class="form-control" id="body_text" name="body_text" rows="2"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-check-label fw-semibold" for="email">Use Email</label>
                            <select name="email" id="email" class="p-2 form-control">
                                <option value="Email 1">Email 1</option>
                                <option value="Email 2">Email 2</option>
                                {{-- @foreach ($customers as $customer)
                                    <option value="{{ $customer->email }}">{{ $customer->customer }} -> {{ $customer->email }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input class="btn btn-sm btn-info" type="submit" value="Send">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection