@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'uvigothemewp') }}
    </div>
    {!! get_search_form(false) !!}
  @else

    <div class="row">
    @while (have_posts()) @php(the_post())
      @if (UVigoThemeWPApp\display_sidebar())
        <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4">
      @else
        <div class="col-lg-3">
      @endif
        @include('partials.content-'.get_post_type())
      </div>
    @endwhile
    </div>

    {!! get_the_posts_pagination(['type' => 'list', 'mid_size' => 4]) !!}

  @endif

@endsection
