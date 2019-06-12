<article @php(post_class())>
  <header class="mb-6">
    <h1 class="entry-title">{{ get_the_title() }}</h1>
    <div class="entry-meta">
      <time class="updated text-secondary font-weight-500">{{ $uvigo_act_date }}</time>
      <span class="entry-type">| {{ UVigoThemeWPApp::getPostTypeTitle(get_post_type()) }}</span>
      <span class="entry-type">| {{ $uvigo_act_taxonomy->name }}</span>
    </div>
  </header>
  <div class="entry-content page-content">
    <div class="entry-documents">
      <p class="font-weight-500 text-primary">Documentos</p>
        @if($uvigo_act_documents)
        <ul class="list-peak">
            @foreach($uvigo_act_documents as $document)
              <li><a target="_blank" href="{{ $document['uvigo_act_document_file']['url'] }}">{{ $document['uvigo_act_document_title'] }} (<span class="text-uppercase">{{ $document['uvigo_act_document_file']['subtype'] }}</span>, {{ size_format($document['uvigo_act_document_file']['filesize']) }})</a></li>
            @endforeach
        </ul>
        @endif
    </div>
    @php(the_content())
  </div>
</article>
