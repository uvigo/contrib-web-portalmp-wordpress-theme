<article @php(post_class('list-feed-item'))>
    @php($uvigo_form_document_doc = get_field('uvigo_form_document_doc'))
    @php($uvigo_form_document_odt = get_field('uvigo_form_document_odt'))
    @php($uvigo_form_document_pdf = get_field('uvigo_form_document_pdf'))
    <div class="list-feed-item-preline">
        {!! App::theTerms(get_the_ID(), 'uvigo-tax-form', ' <span class="text-uppercase">', '</span> | <span class="text-uppercase">', '</span>') !!}
    </div>
    <span class="list-feed-item-link">{{ get_the_title() }}</span>
    <ul class="list-inline">
        @if($uvigo_form_document_doc)
            <li><a target="_blank" title="{{ get_the_title() }}" href="{{ $uvigo_form_document_doc['url'] }}">(<span class="text-lowercase">{{ App::getFileTypeAlias($uvigo_form_document_doc['subtype']) }}</span>)</a></li>
        @endif
        @if($uvigo_form_document_odt)
            <li><a target="_blank" title="{{ get_the_title() }}" href="{{ $uvigo_form_document_odt['url'] }}">(<span class="text-lowercase">{{ App::getFileTypeAlias($uvigo_form_document_odt['subtype']) }}</span>)</a></li>
        @endif
        @if($uvigo_form_document_pdf)
            <li><a target="_blank" title="{{ get_the_title() }}" href="{{ $uvigo_form_document_pdf['url'] }}">(<span class="text-lowercase">{{ App::getFileTypeAlias($uvigo_form_document_pdf['subtype']) }}</span>)</a></li>
        @endif
    </ul>
</article>