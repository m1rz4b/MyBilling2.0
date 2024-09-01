@extends('layouts.main')

@section('main-container')


<div class="main_content_iner">
    <form action="{{ route('weeklyholiday.update', ['weeklyholiday' => 1]) }}" method="POST" enctype="multipart/form-data">
        {{-- Here 1 is being passed as a required parameter --}}
        @csrf
        @method('put')
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="px-4 py-1 theme_bg_1">
                <h5 class="mb-0" style="color: white;">Manage Weekly Holidays</h5>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-4 py-3">
                    @foreach ($weekends as $weekend)
                    <div class="d-flex align-items-center">
                        <input class="form-check-input mt-0" type="checkbox" {{$weekend->weekend == 1?'checked':''}} value="{{$weekend->id}}" name="weekend[]" aria-label="Checkbox for following text input">
                        <p class="ms-2 text-dark">{{$weekend->name}}</p>
                    </div>
                    @endforeach
                    <input type="submit" class="btn btn-sm btn-primary mt-2" value="Update" onclick="this.disabled=true;this.form.submit();">
                </div>
            </div>
        </div>
    </form>
</div>

@endsection