@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'uvigothemewp') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  <div class="list-feed">
  @while (have_posts()) @php(the_post())
    @include('partials.content-'.get_post_type())
  @endwhile
  </div>

  {!! get_the_posts_pagination(['type' => 'list', 'mid_size' => 4]) !!}
@endsection
