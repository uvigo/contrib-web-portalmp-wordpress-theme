<div id="widgetsearch" class="widgetsearch">
  <form role="search" method="get" class="globalsearch__form" action="{{ esc_url( home_url( '/' )) }}">
    <label class="globalsearch__form__label">
      <span class="screen-reader-text">{{ _e('Search for:', 'uvigothemewp') }}</span>
      <input type="search" class="form-control" placeholder="{{ _e('Search', 'uvigothemewp') }}&hellip;" value="{{ get_search_query() }}" name="s" />
    </label>
    <div class="globalsearch__form__button">
      <button type="submit" class="btn btn-outline-light btn-icon" data-icon="&#x35;">{{ _e( 'Search', 'uvigothemewp' ) }}</button>
    </div>
  </form>
</div>
<button type="button" id="globalsearch__toggle-button" data-toggle="search" data-target="#widgetsearch" class="btn globalsearch__toggle-button" data-icon="&#x55;"><span class="sr-only">{{ _e( 'Search', 'uvigothemewp' ) }}</span></button>
