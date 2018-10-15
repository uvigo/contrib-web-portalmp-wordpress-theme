<div class="top-header">
  <div class="container">
    <div class="row no-gutters align-items-center">
      <div class="col justify-content-start">
        <a href="http://uvigo.gal" target="_blank"><img class="logo-uvigo" width="200" height="30" src="@asset('images/uvigo.svg')" alt="Universidade de Vigo"></a>
      </div>
      <div class="col justify-content-center text-center d-none d-md-block">
        <ul class="top-header-links">
          <li><a href="https://www.uvigo.gal/estudar/organizacion-academica/centros" target="_blank">Centros</a></li>
          <li><a href="https://www.uvigo.gal/estudar/organizacion-academica/departamentos" target="_blank">Departamentos</a></li>
          <li><a href="https://www.uvigo.gal/universidade/biblioteca" target="_blank">Biblioteca</a></li>
        </ul>
      </div>
      <div class="col justify-content-end text-right d-none d-md-block">
        <ul class="top-header-links">
          {{-- <li><a href="#" target="_blank">Sede electrónica</a></li> --}}
          <li><a href="https://secretaria.uvigo.gal/" class="elegant-icon" target="_blank"><span aria-hidden="true" class="icon_profile"></span> Secretaría</a></li>
        </ul>
        {{--
        {!! UVigoThemeWPApp::languagesMenuSwitcher() !!}
        <button type="button" id="globalsearch__toggle-button" data-toggle="search" data-target="#globalsearch" class="btn globalsearch__toggle-button" data-icon="&#x55;"><span class="sr-only">{{ _e( 'Search', 'uvigothemewp' ) }}</span></button>
        --}}
      </div>
      <div class="col justify-content-end text-right d-md-none">
        <button type="button" id="asdf" data-toggle="search2" data-target="#globalsearch" class="toggle-button">
            <span class="sr-only">{{ _e( 'Menu', 'uvigothemewp' ) }}</span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
          </button>
      </div>
    </div>
  </div>
</div>
