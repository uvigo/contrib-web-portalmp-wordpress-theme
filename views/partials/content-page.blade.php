<div class="page-content">

  @if (has_excerpt())
    <div class="page-excerpt">
      @php(the_excerpt())
    </div>
  @endif

  @if (has_post_thumbnail())
    <div class="page-thumbnail">
      {!! UVigoThemeWPApp::getThumbnailAndCaption('large') !!}
    </div>
  @endif

  @php(the_content())

  {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'uvigothemewp'), 'after' => '</p></nav>']) !!}
</div>
