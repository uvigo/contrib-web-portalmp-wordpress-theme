<article @php(post_class('list-feed-item'))>
    @php($start_date =  mysql2date( 'U', get_field('uvigo_act_date', false, false), false ))
    <div class="list-feed-item-preline">
        <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ the_field('uvigo_act_date') }}</time>
        {!! App::theTerms(get_the_ID(), 'uvigo-tax-act', '| <span class="text-uppercase">', '</span> | <span class="text-uppercase">', '</span>') !!}
    </div>
    <a class="list-feed-item-link" href="{{ get_permalink() }}">{{ get_the_title() }}</a>
</article>
