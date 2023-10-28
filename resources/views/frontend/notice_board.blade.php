@extends('frontend.layout.master')

@section('body')

@if($notice)
<div class="container border mt-4 p-5 shadow-lg bg-white">
    <div class="row p-2 border rounded">
        <div class="col-lg-12 rounded-3 " style="background: #467cf2;">
            <h4 class="text center text-white p-2">Notice Board</h4>
        </div>
        <div class="col-lg-12 py-4 px-2">
           <h3>{{$notice->title_en}}</h3>
           <a href="{{asset('backend')}}/noticePdf/{{$notice->pdf_file}}" class="btn btn-lg btn-danger">Download</a>
        </div>
        <div class="col-lg-12 ">
        <embed src="{{asset('backend')}}/noticePdf/{{$notice->pdf_file}}" type="application/pdf" width="100%" height="1000px" />
        </div>
    </div>
</div>
@else
<div class="container border mt-4 p-5 shadow-lg bg-white">
    <div class="row p-2 border rounded">
        <div class="col-lg-12 rounded-3 " style="background: #467cf2;">
            <h4 class="text center text-white p-2">Notice Board</h4>
        </div>
        <div class="col-lg-12 py-4 px-2">
           <h3>Notice Not Found .....</h3>
        </div>
</div>
@endif

@endsection