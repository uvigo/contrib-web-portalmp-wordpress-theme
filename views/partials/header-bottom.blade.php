<div class="bottom-header">
  <div class="container">

    <div class="row bottom-header-row no-gutters2">
      <div class="brand-container col-9 col-lg-12">

          <div class="brand-header">
            @if (function_exists('the_custom_logo'))
              <div class="brand-logo">{!! the_custom_logo() !!}</div>
              <div class="brand-mobile-logo">{!! UVigoThemeWPApp::theCustomMobileLogo() !!}</div>
            @endif
          </div>

      </div>
      <div class="menu-toggle col-3">

        <button type="button" data-toggle="togglenav" data-target="#nav-container" class="toggle-button">
          <span class="sr-only">{{ _e( 'Menu', 'uvigothemewp' ) }}</span>
          <span class="toggle-bar"></span>
          <span class="toggle-bar"></span>
          <span class="toggle-bar"></span>
          <span class="toggle-bar"></span>
        </button>

      </div>

      <div id="nav-container" class="menu-container col-12">

        <nav class="nav-primary">
          @if (has_nav_menu('primary_navigation'))
            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav justify-content-end', 'container_id' => 'primary-navigation']) !!}
          @endif

          <div class="header-widgets">
            @include('partials.header-sidebar')
          </div>
        </nav>

      </div>
    </div>

  </div>
</div>
