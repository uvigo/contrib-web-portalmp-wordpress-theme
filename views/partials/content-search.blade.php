<article @php(post_class('mb-8'))>
  <header>
    <div class="entry-meta mb-2">
          <span class="entry-type">{{ UVigoThemeWPApp::getPostTypeTitle(get_post_type()) }}</span>
          @if (get_post_type() === 'post')
            <time class="updated" datetime="{{ get_post_time('c', true) }}">| {{ get_the_date() }}</time>
          @endif
    </div>
    <h2 class="entry-title mb-2"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
    <p class="entry-link">{{ get_permalink() }}</p>
  </header>
</article>
