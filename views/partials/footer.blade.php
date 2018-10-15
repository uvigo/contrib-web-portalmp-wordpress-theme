<footer class="content-info">
  <div class="container">
    @if(is_active_sidebar('sidebar-footer'))
        <div class="footer-items">
        @php(dynamic_sidebar('sidebar-footer'))
        </div>
    @endif
    @if(is_active_sidebar('sidebar-sponsor'))
        <div class="sponsor">
        @php(dynamic_sidebar('sidebar-sponsor'))
        </div>
    @endif
  </div>
  <div class="uvigo-footer">
    <div id="reorder-footer" class="container">
      @include('partials/footer-uvigo')
    </div>
  </div>
</footer>
