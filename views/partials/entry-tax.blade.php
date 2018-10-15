{{--
    @php(the_tags('<div class="tag-list"><span>' . __('Tags', 'uvigothemewp') . '</span><ul class="tags"><li class="tag-list__item">', '</li><li class="tag-list__item">', '</li></ul></div>'))
@php(the_terms(null, 'spectator', '<div class="tag-list"><span>' . __('Spectators', 'uvigothemewp') . '</span><ul class="spectator"><li class="tag-list__item">', '</li class="tag-list__item"><li>', '</li></ul></div>'))
@php(the_terms(null, 'universe', '<div class="tag-list"><span>' . __('Universes', 'uvigothemewp') . '</span><ul class="universe"><li class="tag-list__item">', '</li><li class="tag-list__item">', '</li></ul></div>'))
@php(the_terms(null, 'geographic', '<div class="tag-list"><span>' . __('Geographic', 'uvigothemewp') . '</span><ul class="geographic"><li class="tag-list__item">', '</li><li class="tag-list__item">', '</li></ul></div>'))
--}}

@php($terms = UVigoThemeWPApp::getTerms(['post_tag', 'spectator', 'universe', 'geographic']))
@if($terms)
    <div class="entry-tax">
        <div class="tag-list">
            <span>Etiquetas</span>
            <ul>
                @foreach ($terms as $term)
                    <li class="tag-list__item {{ $term->taxonomy }}">
                        <a href="{{ get_term_link($term) }}" rel="tag">{{ $term->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

