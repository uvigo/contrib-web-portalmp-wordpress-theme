@extends('layouts.frontpage')

@section('content')
  @while(have_posts()) @php(the_post())
    <h1 class="sr-only">{!! App::title() !!}</h1>
    @php(the_content())
  @endwhile
@endsection
