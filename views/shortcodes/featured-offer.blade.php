
<div class="col-md-6 col-lg-4">
  <div class="featured__item card bg-graylight mb-8">
    <div class="featured__item__type card-header text-uppercase">Ofertas de emprego</div>
    <div class="card-body">
      @while($featured_items->have_posts()) @php($featured_items->the_post())
        @php($start_date =  mysql2date( 'U', get_post_meta(get_the_ID(), 'uvigo_offers_offer_start_date', true), false ))
        @php($end_date =  mysql2date( 'U', get_post_meta(get_the_ID(), 'uvigo_offers_offer_end_date', true), false ))
        <div class="featured__item__group">
          <p class="text-gray mb-1 pt-0">Publicada: {{ date(get_option('date_format'), $start_date) }}</p>
          <p class="mb-1 pt-0"><a class="btn btn-link btn-icon btn-inline font-weight-500" href="{{ get_permalink() }}">{{ get_the_title() }}</a></p>
          <p class="mb-0 pt-0">Peche oferta: {{ date(get_option('date_format'), $end_date) }}</p>
        </div>
      @endwhile
      <p><a class="btn btn-link btn-icon" href="/ofertas-de-emprego">Ver todas as ofertas</a></p>
    </div>
  </div>
</div>
