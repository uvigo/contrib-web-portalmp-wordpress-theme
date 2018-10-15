
<div class="col-md-6 col-lg-4">
  <div class="featured__item featured__item--noback card mb-8">
    <div class="featured__item__type card-header text-uppercase">{{ UVigoThemeWPApp::getPostTypeTitle(get_post_type()) }}</div>
    <div class="entry-thumbnail">
      <a href="{{ get_permalink() }}">
        {!! UVigoThemeWPApp::getThumbnailBackground('featured-thumbnail', ['class' => 'card-img-top']) !!}
      </a>
    </div>
    <div class="card-body">
      <h3 class="featured__item__title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h3>

      @php($place = get_post_meta(get_the_ID(), 'uvigo_news_event_place', true))
      @php($place_url = get_post_meta(get_the_ID(), 'uvigo_news_event_place_url', true))
      @php($textdate = get_post_meta(get_the_ID(), 'uvigo_news_event_start_date', true))
      @php($date =  mysql2date( 'U', get_post_meta(get_the_ID(), 'uvigo_news_event_date', true), false ))
      @php($speaker = get_post_meta(get_the_ID(), 'uvigo_news_event_speaker', true))
      @php($speaker_position = get_post_meta(get_the_ID(), 'uvigo_news_event_speaker_position', true))

      <div class="featured__item__date">
        @if($textdate)
            {{ $textdate }}
        @else
            {{ date(get_option('date_format') . ' ' . get_option('time_format') , $date) }}
        @endif
      </div>
      <div class="featured__item__place">
        @if($place_url)
            <a target="_blank" href="{!! $place_url !!}">{{ $place }}</a>
        @else
            {{ $place }}
        @endif
      </div>

    </div>
  </div>
</div>
