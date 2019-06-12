<div class="featured floor">
  <div class="container">
    <h2 class="featured__title h2 text-center mt-12 mb-11">{{ __('News', 'uvigothemewp') }}</h2>

    <div class="row">

      @while($featured_items->have_posts()) @php($featured_items->the_post())
        <div class="col-4">
          <div class="featured__item card mb-8">
            <div class="featured__item__type card-header text-uppercase">{{ App::getPostTypeTitle(get_post_type()) }}</div>
            <div class="entry-thumbnail">
              <a href="{{ get_permalink() }}">
                {!! get_the_post_thumbnail(null, 'featured-thumbnail', ['class' => 'card-img-top']) !!}
              </a>
            </div>
            <div class="card-body">
              <h3 class="featured__item__title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h3>
              @php(the_excerpt())
            </div>
          </div>
        </div>
      @endwhile

    </div>

  </div>
</div>
