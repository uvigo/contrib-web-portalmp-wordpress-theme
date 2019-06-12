<article @php(post_class())>
  <header>
    <h1 class="entry-title">{{ get_the_title() }}</h1>
    @if (has_excerpt())
      <div class="entry-excerpt">
        @php(the_excerpt())
      </div>
    @endif
    @include('partials/entry-tax')
    @if (has_post_thumbnail())
      <div class="entry-thumbnail">
        {!! App::getThumbnailAndCaption('large') !!}
      </div>
    @endif
  </header>
  <div class="entry-section personal-data">
    <h2>{{ __('Personal Data', 'uvigothemewp') }}</h2>
    <p class="field">
        <span class="field__label">{{ __('Department', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ get_post_meta( get_the_ID(), 'uvigo_research_staff_dep_name', true ) }}</span>
    </p>
    <p class="field">
        <span class="field__label">{{ __('Center', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ get_post_meta( get_the_ID(), 'uvigo_research_staff_center_name', true ) }}</span>
    </p>
    <p class="field">
        <span class="field__label">{{ __('Area', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ get_post_meta( get_the_ID(), 'uvigo_research_staff_area_name', true ) }}</span>
    </p>
    <p class="field">
        <span class="field__label">{{ __('Email', 'uvigothemewp') }}: </span>
      <span class="field__item"><a href="mailto:{{ get_post_meta( get_the_ID(), 'uvigo_research_staff_email', true ) }}" target="_blank">{{ get_post_meta( get_the_ID(), 'uvigo_research_staff_email', true ) }}</a></span>
    </p>
  </div>
  <div class="entry-section entry-content">
    @php(the_content())
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'uvigothemewp'), 'after' => '</p></nav>']) !!}
  </footer>
  @php(comments_template('/partials/comments.blade.php'))
</article>
