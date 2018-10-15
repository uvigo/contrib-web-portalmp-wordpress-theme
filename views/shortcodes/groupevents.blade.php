
<div class="featured__item card bg-graylight">
<div class="featured__item__type card-header text-uppercase">
    <a href="{{ get_term_link($taxonomy) }}" class="text-white">{{ $taxonomy->name }}</a>
</div>
<div class="card-body">
    <p class="text-uppercase font-weight-500 text-gray mb-4">{{ __('Next conference', 'uvigothemewp') }}</p>
    @while($featured_items->have_posts()) @php($featured_items->the_post())
        @php($textdate = get_post_meta(get_the_ID(), 'uvigo_news_event_start_date', true))
        @php($date =  mysql2date( 'U', get_post_meta(get_the_ID(), 'uvigo_news_event_date', true), false ))
        @php($place = get_post_meta(get_the_ID(), 'uvigo_news_event_place', true))
        @php($place_url = get_post_meta(get_the_ID(), 'uvigo_news_event_place_url', true))
        @php($speaker = get_post_meta(get_the_ID(), 'uvigo_news_event_speaker', true))
        @php($speaker_position = get_post_meta(get_the_ID(), 'uvigo_news_event_speaker_position', true))
        <div class="mb-4">
            <div class="h3 featured__item__title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></div>
            <div class="mb-4">
                <p class="mb-1 pt-0 text-primary font-weight-normal">{{ $speaker }}</p>
                <p class="text-gray mb-1 pt-0 font-weight-normal">{!! nl2br($speaker_position) !!}</p>
            </div>
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
    @endwhile
    <p><a class="btn btn-link btn-icon" href="{{ get_term_link($taxonomy) }}">Ver programa completo</a></p>
</div>
</div>
