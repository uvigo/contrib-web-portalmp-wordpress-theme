<div class="col-md-6 col-lg-4">
  <div class="featured__item featured__item--noback card mb-8">
    <div class="featured__item__type card-header text-uppercase">{{ UVigoThemeWPApp::getPostTypeTitle(get_post_type()) }}</div>
    <div class="entry-thumbnail">
        <a href="{{ get_permalink() }}" style="">
        {!! UVigoThemeWPApp::getThumbnailBackground('featured-thumbnail', ['class' => 'card-img-top']) !!}
      </a>
    </div>
    <div class="card-body">
      <h3 class="featured__item__title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h3>
      @php(the_excerpt())
    </div>
  </div>
</div>
