@php($place = get_post_meta(get_the_ID(), 'uvigo_news_event_place', true))
@php($place_url = get_post_meta(get_the_ID(), 'uvigo_news_event_place_url', true))
@php($date = get_post_meta(get_the_ID(), 'uvigo_news_event_start_date', true))

<article @php(post_class('mb-12'))>
  <header>
    @if (has_post_thumbnail())
      <a href="{{ get_permalink() }}" class="d-block mb-2">
        {!! UVigoThemeWPApp::getThumbnailBackground('square') !!}
      </a>
    @endif
    {{-- @include('partials/entry-meta') --}}
    <p class="mb-2">
        <span class="icon_clock_alt" aria-hidden="true"></span>
        {{ $date }}
    </p>
    <p class="entry-title mb-4"><a class="font-weight-normal" href="{{ get_permalink() }}">{{ get_the_title() }}</a></p>
    <p class="mb-0">
        <span class="icon_pin_alt" aria-hidden="true"></span>
        @if($place_url)
            <a target="_blank" class="font-weight-regular" href="{!! $place_url !!}">{{ $place }}</a>
        @else
            {{ $place }}
        @endif
    </p>

  </header>
</article>
