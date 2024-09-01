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
                    <h5 class="mb-0 text-white">Email and SMS</h5>
                </div>
            </div>

            <div class="d-flex">
                <div class="border border-success m-3 w-50 p-3">
                    <h5 class="text-center fw-bold">Send Type</h5>
                    <div class="text-center mt-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="send_options" id="email" value="option1">
                            <label class="form-check-label" for="email">Email</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="send_options" id="sms" value="option2">
                            <label class="form-check-label" for="sms">SMS</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="send_options" id="both" value="option3" checked>
                            <label class="form-check-label" for="both">Email & SMS</label>
                        </div>
                    </div>
                </div>

                <div class="border border-success m-3 w-50 p-3">
                    <h5 class="text-center fw-bold">Select Customer</h5>
                    <div class="">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="allcustomer">
                            <label class="form-check-label fw-semibold" for="allcustomer">Send To All Customers</label>
                        </div>
                        <select name="" id="" class="p-2 form-select form-select-sm">
                            <option value="">Select a Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->email }}">{{ $customer->customer_name }} -> {{ $customer->email }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <div class="border border-success m-3 w-50 p-3" id="emailDiv">
                    <h5 class="text-center fw-bold">Body For Email</h5>
                    <div class="mb-2">
                        <label for="email_subject" class="form-label fw-semibold">Subject: </label>
                        <input type="text" class="form-control" id="email_subject" name="">
                    </div>
                    <div class="mb-2 d-flex flex-column">
                        <label for="email_atch" class="form-label fw-semibold">Attachments: </label>
                        <input type="file" class="" id="email_atch" name="">
                    </div>
                    <div class="mb-2">
                        <label for="email_body" class="form-label fw-semibold">Body </label>
                        <textarea class="form-control" id="email_body" name="" rows="2"></textarea>
                    </div>
                </div>

                <div class="border border-success m-3 w-50 p-3" id="smsDiv">
                    <h5 class="text-center fw-bold">Body For SMS</h5>
                    <div class="mb-2">
                        <label for="sms_body" class="form-label fw-semibold">Body </label>
                        <textarea class="form-control" id="sms_body" name="" rows="2"></textarea>
                        <a id="char_count">Total Characters: 0</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end m-3 mt-0">
                <a type="button" class="btn btn-sm btn-info">Send</a>
            </div>

        </div>
    </div>

    {{-- jquery for showing in real time the number of character being typed --}}
    <script>
        $(document).ready(function () {
            $('#sms_body').on('input', function () {
                var charCount = $(this).val().length;
                $('#char_count').text('Total Characters: ' + charCount);
            });
        });
    </script>

    {{-- jquery for making only the selected visible --}}
    <script>
        $(document).ready(function () {
            $('input[type=radio][name=send_options]').change(function () {
                if (this.value === 'option1') { // Email selected
                    $('#emailDiv').show().find('input, textarea, select').prop('disabled', false);
                    $('#smsDiv').hide().find('input, textarea, select').prop('disabled', true);
                } else if (this.value === 'option2') { // SMS selected
                    $('#smsDiv').show().find('input, textarea, select').prop('disabled', false);
                    $('#emailDiv').hide().find('input, textarea, select').prop('disabled', true);
                } else if (this.value === 'option3') { // Email & SMS selected
                    $('#emailDiv, #smsDiv').show().find('input, textarea, select').prop('disabled', false);
                }
            });
    
            // Trigger the change event initially to set the initial state based on the default checked radio button
            $('input[type=radio][name=send_options]:checked').trigger('change');
        });
    </script>
    
@endsection