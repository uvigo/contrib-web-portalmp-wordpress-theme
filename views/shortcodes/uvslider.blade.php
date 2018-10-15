@if( $uvslider_query->have_posts() )
  <section class="uvigo-slide">
    <div class="slick-slider sliderbehaviour"
      data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "autoplay": {{ $uvslider_autoplay }}, "autoplaySpeed": 6000}'>
        @while($uvslider_query->have_posts()) @php($uvslider_query->the_post())
          <div class="uvigo-slide__item" style="background-image: url('{{ get_the_post_thumbnail_url(null, 'slider-image') }}')">
            {{--
              @if(has_image_size('slider-image'))
                @php(the_post_thumbnail('slider-image'))
              @endif
            --}}
            @if(in_array(get_post_type(), ['post']))
                <div class="uvigo-slide__item__content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="uvigo-slide__item__content__post">
                                    <div class="uvigo-slide__item__content__post__date mb-1" datetime="{{ get_post_time('c', true) }}">ÚLTIMA NOVA | {{ get_the_date() }}</div>
                                    <div class="h2 mb-0 uvigo-slide__item__content__post__title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></div>
                                    {{--
                                    @if(has_excerpt())
                                        @php(the_excerpt())
                                    @endif
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="uvigo-slide__item__content">
                @if(has_excerpt())
                    <div class="video__action">
                        <div class="video_action__container">
                            <span class="video__action__button" data-toggle="modal" data-target="#videoSlideModal">
                                <img src="@asset('images/play.svg')" width="120" alt="Ver vídeo">
                            </span>
                        </div>
                    </div>
                @else
                    <div class="container">
                        @php(the_content())
                    </div>
                @endif
                </div>
            @endif
          </div>
        @endwhile
    </div>

    @while($uvslider_query->have_posts()) @php($uvslider_query->the_post())
        @if(get_post_type() === 'uvigo-slide' && has_excerpt())
            <div class="modal fade" id="videoSlideModal" tabindex="-1" role="dialog" aria-labelledby="videoSlideModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-video" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="videoSlideModalLabel">{{ get_the_title() }}</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Pechar">
                                <span class="sr-only">Pechar</span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div id="ytplayer" data-youtube-id="{{ get_the_excerpt() }}"></div>
                        {{--
                            <iframe class="embed-player slide-media" width="1280" height="720" src="https://www.youtube.com/embed/{{ get_the_excerpt() }}?enablejsapi=1&controls=0&fs=0&iv_load_policy=3&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
                            <div class="video">
                                <iframe class="embed-player slide-media" width="1440" height="540" src="https://www.youtube.com/embed/{{ get_the_excerpt() }}?enablejsapi=1&controls=0&fs=0&iv_load_policy=3&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <div class="uvigo-slide__item__content__background"></div>
                        --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endwhile

  </section>

@endif
