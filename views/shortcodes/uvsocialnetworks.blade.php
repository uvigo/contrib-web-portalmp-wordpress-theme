<div class="social-link-block {{ $uvsocialnetworks_classname }}">
  @if( ! empty( $uvsocialnetworks_facebook )  )
    <a href="{{ $uvsocialnetworks_facebook }}" target="_blank" class="social-link facebook">
      <span class="sr-only">Facebook</span>
    </a>
  @endif
  @if( ! empty( $uvsocialnetworks_twitter )  )
    <a href="{{$uvsocialnetworks_twitter}}" target="_blank" class="social-link twitter">
      <span class="sr-only">Twitter</span>
    </a>
  @endif
  @if( ! empty( $uvsocialnetworks_instagram )  )
    <a href="{{$uvsocialnetworks_instagram}}" target="_blank" class="social-link instagram">
      <span class="sr-only">Instagram</span>
    </a>
  @endif
  @if( ! empty( $uvsocialnetworks_youtube )  )
    <a href="{{$uvsocialnetworks_youtube}}" target="_blank" class="social-link youtube">
      <span class="sr-only">Youtube</span>
    </a>
  @endif
  @if( ! empty( $uvsocialnetworks_linkedin )  )
    <a href="{{$uvsocialnetworks_linkedin}}" target="_blank" class="social-link linkedin">
      <span class="sr-only">Linkedin</span>
    </a>
  @endif
</div>
