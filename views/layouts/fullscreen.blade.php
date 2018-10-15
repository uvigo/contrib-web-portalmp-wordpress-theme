<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class())>
    @php(do_action('get_header'))
    <header class="banner">
      @include('partials/header-uvigo')
    </header>
    <div class="wrap" role="document">
      <main class="main">
        @yield('content')
      </main>
    </div>
    @php(do_action('get_footer'))
    @include('partials.footer')
    @php(wp_footer())
  </body>
</html>
