{{--
  Template Name: Entradiñas
--}}

@extends('layouts.fullscreen')

@section('content')
  @while(have_posts()) @php(the_post())
    <h1 class="sr-only">{!! UVigoThemeWPApp::title() !!}</h1>
    @php(the_content())
  @endwhile
@endsection

