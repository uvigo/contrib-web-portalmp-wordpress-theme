<article @php(post_class('mb-12'))>
  <header>
    <div class="text-uppercase card-header">{{ UVigoThemeWPApp::getPostTypeTitle(get_post_type()) }}</div>
    @if (has_post_thumbnail())
      <a href="{{ get_permalink() }}" class="d-block mb-2">
        {!! UVigoThemeWPApp::getThumbnailBackground('square') !!}
      </a>
    @endif
    @include('partials/entry-meta')
    <p class="entry-title"><a class="font-weight-normal" href="{{ get_permalink() }}">{{ get_the_title() }}</a></p>
  </header>
</article>
