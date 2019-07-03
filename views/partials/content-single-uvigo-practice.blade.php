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
    <div class="entry-meta">
      <span class="entry-type">{{ get_post_meta(get_the_ID(), 'uvigo_offers_practice_reference', true) }}</span>
      <span class="entry-type">| {{ App::getPostTypeTitle(get_post_type()) }}</span>
    </div>
  </header>
  <div class="entry-content page-content">
    <p class="description-title"><strong>Referencia:</strong> {{ get_post_meta(get_the_ID(), 'uvigo_offers_practice_reference', true) }}</p>
    <p class="description-title"><strong>Empresa:</strong> {{ get_post_meta(get_the_ID(), 'uvigo_offers_practice_company', true) }}</p>
    <p class="description-title"><strong>Lugar de traballo:</strong> {{ get_post_meta(get_the_ID(), 'uvigo_offers_practice_workplace', true) }}</p>
    @php($start_date =  mysql2date( 'U', get_post_meta(get_the_ID(), 'uvigo_offers_practice_start_date', true), false ))
    @php($end_date =  mysql2date( 'U', get_post_meta(get_the_ID(), 'uvigo_offers_practice_end_date', true), false ))
    <!-- <p class="description-title"><strong>Inicio publicación:</strong> {{ date(get_option('date_format'), $start_date) }}</p> -->
    <p class="description-title"><strong>Data fin:</strong> {{ date(get_option('date_format'), $end_date) }}</p>
    @php(the_content())
    <p class="description-url">Máis información na área de práticas extracurriculares da UVigo: <a href="{{ get_post_meta(get_the_ID(), 'uvigo_offers_practice_url', true) }}" target="_blank">{{ get_post_meta(get_the_ID(), 'uvigo_offers_practice_url', true) }}</a></p>
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'uvigothemewp'), 'after' => '</p></nav>']) !!}
  </footer>
  @php(comments_template('/partials/comments.blade.php'))
</article>
