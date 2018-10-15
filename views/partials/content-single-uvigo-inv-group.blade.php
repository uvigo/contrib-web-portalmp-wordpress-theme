<article @php(post_class())>
  <header>
    <h1 class="entry-title">{{ get_the_title() }}</h1>
    @if (has_excerpt())
      <div class="entry-excerpt">
        @php(the_excerpt())
      </div>
    @endif
    {{-- @include('partials/entry-meta') --}}
    @include('partials/entry-tax')
    @if (has_post_thumbnail())
      <div class="entry-thumbnail">
        {!! UVigoThemeWPApp::getThumbnailAndCaption('large') !!}
      </div>
    @endif
  </header>
  <div class="entry-section general-data">
    <h2>{{ __('General Data', 'uvigothemewp') }}</h2>
    <p class="field">
      <span class="field__label">{{ __('Coordinator', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_general_coordinator', true ) }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Date', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ UVigoThemeWPApp\display_date( get_post_meta( get_the_ID(), 'uvigo_research_group_general_date', true ) ) }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Code', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_general_code', true ) }}</span>
    </p>
  </div>
  <div class="entry-section contact-data">
    <h2>{{ __('Contact Data', 'uvigothemewp') }}</h2>
    <p class="field">
        <span class="field__label">{{ __('Address', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_address', true ) }}</span>
    </p>
    <p class="field">
        <span class="field__label">{{ __('Phone', 'uvigothemewp') }}: </span>
      <span class="field__item">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_phone', true ) }}</span>
    </p>
    <p class="field">
      <span class="field__label">{{ __('Email', 'uvigothemewp') }}: </span>
      <span class="field__item"><a href="mailto:{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_mail', true ) }}" target="_blank">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_mail', true ) }}</a></span>
    </p>
    <p class="field">
        <span class="field__label">{{ __('Web', 'uvigothemewp') }}: </span>
      <span class="field__item"><a href="{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_url', true ) }}" target="_blank">{{ get_post_meta( get_the_ID(), 'uvigo_research_group_contact_url', true ) }}</a></span>
    </p>
  </div>
  <div class="entry-section technological-data">
    <h2>{{ __('Technological Offer', 'uvigothemewp') }}</h2>
    <div class="entry-content">
      {!! get_post_meta( get_the_ID(), 'uvigo_research_group_technological_description', true ) !!}
    </div>
  </div>
  <div class="entry-section entry-content">
    @php(the_content())
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'uvigothemewp'), 'after' => '</p></nav>']) !!}
  </footer>
  @php(comments_template('/partials/comments.blade.php'))
</article>
