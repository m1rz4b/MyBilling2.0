@extends('layouts.main')

@section('main-container')
    <style>gttotal_bill
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
                    <h5 class="mb-0 text-white text-center">Delete Journal</h5>
                </div>
            </div>

            <form action="{{ route('deletejournal.show') }}" method="get">
                @csrf
                <div class="m-3">
                    <div class="row mb-3">
					
					 <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="start_date" class="form-label">From</label>
                        <input class="form-control input_form datepicker-here digits" name="start_date" id="start_date" data-date-Format="yyyy-mm-dd" value="{{ $start_date }}" placeholder="Start date">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="fw-medium" for="end_date" class="form-label">To</label>
                        <input class="form-control input_form datepicker-here digits" name="end_date" id="end_date" data-date-Format="yyyy-mm-dd" value="{{ $end_date }}" placeholder="End date">
                    </div>


                  <div class="col-sm-4">
				  <label class="fw-medium" for="end_date" class="form-label">Voucher type</label>
				  
				    <div class="input-group input-group-sm flex-nowrap">
                            <select name="voucher_type" id="voucher_type"  class="form-control input-sm">
                                	<option value="">Select Voucher Type</option>
                                	<option value="JV">JV</option>
                                	<option value="Pay">Pay</option>
                                	<option value="REC">REC</option>
									<option {{ ($selectedvoucher_type) ? "selected" : "" }}  value="{{ $selectedvoucher_type }}">{{ $selectedvoucher_type }}</option>
                                </select>
                     </div>
                   </div>

                        <div class="col-sm-4">
                            <button type="button" class="btn btn-sm btn-primary me-2"  onclick="this.disabled=true;this.form.submit();"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
                            <a class="btn btn-warning btn-sm text-white me-2" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Print</a>
                            <a class="btn btn-success btn-sm"><i class="fa-regular fa-file-excel me-1"></i>Excel</a>
                        </div>
                    </div>
                </div>
            </form>
				
		            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
					$gccollamnt=0;
 
                @endphp


                <table class="table table-responsive">
                    <thead>
                        <tr>
						<th ><b>Journal ID</b></th>
						<th ><b>Journal No</b></th>
						<th ><b>Journal Type</b></th>
						<th ><b>Journal Date</b></th>
						<th ><b>Action</b></th>
					</tr>
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journal_lists as $journal_list)
							<tr>
                             <td>{{ $journal_list->journalid }}</td>
                            <td>{{ $journal_list->journalno }}</td>
                            <td>{{ $journal_list->journaltype }}</td>
                            <td>{{ $journal_list->journaldate }}</td>
                            <td>
							
									
						 <form action="{{ route('deletejournal.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="hidden" id="journalid" name="journalid" value="{{ $journal_list->journalid }}">
							<input type="hidden" id="start_date" name="start_date" value="{{ $start_date }}">
							<input type="hidden" id="end_date" name="end_date" value="{{ $end_date }}">
							<input type="hidden" id="voucher_type" name="voucher_type" value="{{ $selectedvoucher_type }}">
							<div class="col-sm-12 form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-primary"  onclick="this.disabled=true;this.form.submit();">Delete</button>
						 </div>
						  </form>
						 
						 </td>
                            </tr>	
							

				@endforeach  
		
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
		
    </script>
@endsection