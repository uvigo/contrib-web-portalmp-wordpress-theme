@extends('layouts.app')

@section('content')
  @php
   $document = get_post();
   if( ! empty($document) ) {
    // Documento o URL
    $origin_type = get_field( 'uvigo_document_origin_type', $document->ID );
    $url = '#';
    switch ($origin_type) {
      case 'file':
        $file = get_field( 'uvigo_document_file', $document->ID );
        if ( $file ) {
          $url = $file['url'];
        }
        break;
      case 'url':
        $url = get_field( 'uvigo_document_url', $document->ID );
        break;
    }
    if( ! empty($url) ) {
      wp_redirect( $url );
      exit;
    }
   }
   @endphp
@endsection
       