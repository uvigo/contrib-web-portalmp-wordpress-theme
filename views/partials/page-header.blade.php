<div class="page-header">
  <h1>{!! App::title() !!}</h1>
</div>
@if( is_user_logged_in())
  @if(get_field('dev_revision'))
    <div class="page-dev-comments" style="margin-bottom: 30px; margin-top: -15px; border: 1px solid #c00; padding: 10px 10px 0px 10px; background-color: #f5f5f5; font-size: 0.9rem;">
      @php(the_field('dev_revision'))
    </div>
  @endif
@endif
