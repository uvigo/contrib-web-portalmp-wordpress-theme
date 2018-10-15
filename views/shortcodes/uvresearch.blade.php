<div class="research floor primary">
  <div class="container">
    @if($uvresearch_title)
      <h2 class="research__title h2 text-center">{{ $uvresearch_title }}</h2>
    @else
      <h2 class="research__title h2 text-center">{{ __('Research lines', 'uvigothemewp') }}</h2>
    @endif
    @if(sizeof($uvresearch_terms) > 0)
      <div class="research__terms">
        @foreach ($uvresearch_terms as $term)
          <div class="research__term">
            <a href="{!! get_term_link($term->term_id) !!}">
              <img src="{!! UVigoThemeWPApp::getResearchLineImageAssetPath($term->term_id) !!}" width="108" height="95" alt="{{ $term->name }}">
              <span>{{ $term->name }}</span>
            </a>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
