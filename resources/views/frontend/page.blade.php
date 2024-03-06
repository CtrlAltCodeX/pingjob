

@extends('layouts.theme')

@section('content')

    @section('css')
   body
    {
    background:#fff!important;
    }
    @stop


<div class="blog-listing-header " @if ($page->feature_image) style="background-image:url('{{ asset('/storage/uploads/images/blog/full/' . $page->feature_image) }}')" @endif>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                   <h1>{{$page->title}}</h1>

                </div>
            </div>
        </div>
    </div>


        <div class="container" style="background:#fff;" >
            <div class="row">
                <div class="col-md-12">
                    <div class="blog-single-content pt-3 pb-5">
                        {!! $page->post_content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
