# UVigo WordPress Theme

WordPress Theme for use with multiproposal webs in Universidade de Vigo.


## Features

* WordPress Theme based on [Sage 9](https://roots.io/sage/)
* ES6 for JavaScript
* [Webpack](https://webpack.github.io/) for compiling assets, optimizing images, and concatenating and minifying files
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* [Laravel Blade](https://laravel.com/docs/5.3/blade) as a templating engine
* [Controller](https://github.com/soberwp/controller) for passing data to Blade templates
* Use [UVigoweb Frontend](https://github.com/uvigo/contrib-web-portalmp-frontend) CSS framework, based on [Bootstrap 4](http://getbootstrap.com/)
* Font Awesome


## Requirements

Make sure all dependencies have been installed before moving on:

* [WordPress](https://wordpress.org/) >= 4.9
* [PHP](http://php.net/manual/en/install.php) >= 7.0
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 6.9.x
* [Yarn](https://yarnpkg.com/en/docs/install)


## Theme structure

```shell
themes/uvigothemewp/   # → Root of your Sage based theme
├── app/                  # → Theme PHP
│   ├── admin/            # → Admin files
│   ├── controllers/      # → Controller files
│   ├── shortcodes/       # → Shortcodes files
│   ├── widgets/          # → Widgets files
│   ├── wordpress/        # → Custom hooks files
│   ├── filters.php       # → Theme filters
│   ├── helpers.php       # → Helper functions
│   ├── setup.php         # → Theme setup
│   └── update.php        # → Theme external update
├── composer.json         # → Autoloading for `app/` files
├── composer.lock         # → Composer lock file (never edit)
├── dist/                 # → Built theme assets (never edit)
├── functions.php         # → Composer autoloader, theme includes
├── index.php             # → Never manually edit
├── languages/            # → Languages .mo and .po files
├── node_modules/         # → Node.js packages (never edit)
├── package.json          # → Node.js dependencies and scripts
├── resources/            # → Theme assets and templates
│   ├── assets/           # → Front-end assets
│   │   ├── config.json   # → Settings for compiled assets
│   │   ├── build/        # → Webpack and ESLint config
│   │   ├── fonts/        # → Theme fonts
│   │   ├── images/       # → Theme images
│   │   ├── scripts/      # → Theme JS
│   │   └── styles/       # → Theme stylesheets
├── screenshot.png        # → Theme screenshot for WP admin
├── style.css             # → Theme meta information
├── vendor/               # → Composer packages (never edit)
├── views/                # → Theme templates
│   ├── layouts/          # → Base templates
│   └── partials/         # → Partial templates
```


## Theme setup

Edit `app/setup.php` to enable or disable theme features, setup navigation menus, post thumbnail sizes, and sidebars.


## Theme development

* Run `yarn` from the theme directory to install dependencies
* Update `resources/assets/config.json` settings:
  * `devUrl` should reflect your local development hostname
  * `publicPath` should reflect your WordPress folder structure (`/wp-content/themes/uvigothemewp`)


### Build commands

* `yarn run start` — Compile assets when file changes are made, start Browsersync session
* `yarn run build` — Compile and optimize the files in your assets directory
* `yarn run build:production` — Compile assets for production
* `yarn run deploy` — Compile assets for production and deploy in zip file


## Documentation

Sage 9 documentation is currently in progress and can be viewed at [https://github.com/roots/docs/tree/sage-9/sage](https://github.com/roots/docs/tree/sage-9/sage).

Controller documentation is available at [https://github.com/soberwp/controller#usage](https://github.com/soberwp/controller#usage).

