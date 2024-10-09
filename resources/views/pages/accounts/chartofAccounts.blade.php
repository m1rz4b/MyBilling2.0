@extends('layouts.main')

@section('main-container')
    <style>
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
  
  
    <div class="main_content_iner mt-0">
        
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white text-center">Chart of Accounts</h5>
                </div>
            </div>

            <form action="{{ route('chartofaccounts.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">

                        <div class="col-sm-3">
                            <a class="btn btn-warning btn-sm text-white me-2" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Print</a>

                        </div>
                    </div>
                </div>
            </form>
					<div class="px-4 py-1">
                    <h5 class="mb-0 text-center">Millennium Computers And Networking</h5>
					<h5 class="mb-0 text-center">Chart of Accounts</h5>
					
                </div>


            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$opencashdr = 0;
					$opencashcr = 0;
					$openbankdr= 0;
					$openbankcr= 0;
		           @endphp

                @foreach ($glcodes as $glcode)
		@php
					$gl_code = $glcode->gl_code;
					$description = $glcode->description;
					$gl_code_11 = $glcode->gl_code_11;
					$gl_code_12 = $glcode->gl_code_12;


						if ($gl_code_11=='0000') { 
						       echo "<font face=\"Arial\" size=\"4\" color=\"#FF0000\"><strong>$gl_code $description </strong></font><br> \n";
							}elseif ($gl_code_11!='0000' && $gl_code_12=='00') {
							  echo "<font face=\"Arial\" size=\"3\" color=\"#000080\"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $gl_code $description </strong></font><br> \n";
							}elseif($gl_code_12!='00'){
							  echo "<font face=\"Arial\" size=\"2\" color=\"#008000\"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $gl_code $description </strong></font><br> \n";
							}

		@endphp
		
				@endforeach 
            </div>
        </div>
 
 
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });
    </script>
@endsection