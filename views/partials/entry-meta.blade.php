<div class="entry-meta">
  {{--
  <p class="byline author vcard">
    <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">{{ get_the_author() }}</a>
  </p>
  --}}
  <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
  <span class="entry-type">| {{ UVigoThemeWPApp::getPostTypeTitle(get_post_type()) }}</span>
</div>
