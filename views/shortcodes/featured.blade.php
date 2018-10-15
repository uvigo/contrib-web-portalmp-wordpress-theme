<div class="featured pt-12 pb-10">
  <div class="container">
    <h2 class="featured__title h2 text-center mt-12 mb-11">{{ __('News', 'uvigothemewp') }}</h2>

    <div class="row justify-content-start">

      @foreach ($featured_list as $item)
        {!! $item['html'] !!}
      @endforeach

    </div>

  </div>
</div>
