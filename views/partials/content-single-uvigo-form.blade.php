<article @php(post_class())>
  <header class="mb-6">
    <h1 class="entry-title">{{ get_the_title() }}</h1>
    <div class="entry-meta">
      <span class="entry-type">{{ App::getPostTypeTitle(get_post_type()) }}</span>
      <span class="entry-type">| {{ $uvigo_form_taxonomy->name }}</span>
    </div>
  </header>
  <div class="entry-content page-content">
    @php(the_content())
    <div class="entry-documents">
      <p class="font-weight-500 text-primary">Documentos</p>
        <ul class="list-peak">
          @if($uvigo_form_document_doc)
            <li><a target="_blank" href="{{ $uvigo_form_document_doc['url'] }}"> <span class="text-uppercase">{{ App::getFileTypeAlias($uvigo_form_document_doc['subtype']) }}</span>({{ size_format($uvigo_form_document_doc['filesize']) }})</a></li>
          @endif
          @if($uvigo_form_document_odt)
            <li><a target="_blank" href="{{ $uvigo_form_document_odt['url'] }}"> <span class="text-uppercase">{{ App::getFileTypeAlias($uvigo_form_document_odt['subtype']) }}</span>({{ size_format($uvigo_form_document_odt['filesize']) }})</a></li>
          @endif
          @if($uvigo_form_document_pdf)
            <li><a target="_blank" href="{{ $uvigo_form_document_pdf['url'] }}"> <span class="text-uppercase">{{ App::getFileTypeAlias($uvigo_form_document_pdf['subtype']) }}</span>({{ size_format($uvigo_form_document_pdf['filesize']) }})</a></li>
          @endif
        </ul>
    </div>
  </div>
</article>
