<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Assets Manifest
    |--------------------------------------------------------------------------
    |
    | Your asset manifest is used by Sage to assist WordPress and your views
    | with rendering the correct URLs for your assets. This is especially
    | useful for statically referencing assets with dynamically changing names
    | as in the case of cache-busting.
    |
    */

    'manifest' => is_child_theme() ? get_template_directory().'/dist/assets.json' : get_theme_file_path().'/dist/assets.json',

    /*
    |--------------------------------------------------------------------------
    | Assets Path URI
    |--------------------------------------------------------------------------
    |
    | The asset manifest contains relative paths to your assets. This URI will
    | be prepended when using Sage's asset management system. Change this if
    | you are using a CDN.
    |
    */

    'uri' => is_child_theme() ? get_template_directory_uri().'/dist' : get_theme_file_uri().'/dist',
];
