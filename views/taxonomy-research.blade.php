@extends('layouts.app')

@section('content')
  @include('partials.tax-researchline')
  @while(have_posts()) @php(the_post())
    <div class="list-feed">
      @include('partials.content-research')
    </div>
  @endwhile
@endsection
