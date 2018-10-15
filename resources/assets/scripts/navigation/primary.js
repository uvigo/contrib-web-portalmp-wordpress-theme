/*eslint no-console: ["error", { allow: ["log", "warn", "error"] }] */

class NavPrimary {

  constructor() {
    console.warn('Constructor NavPrimary');
  }

  static start() {
    // console.warn('start component');

    $('.sidebar-menu').on('click', '.menu-item-has-children > .menu-item-link', function(event) {

      if ( ! $(event.target).is('a') ) {

          var $blockLink = $(this);
          var $lastActive = $blockLink.closest('.menunav').find('.menu-item-link.active');

          if ( ! $blockLink.parent().hasClass('current_page_ancestor') && ! $blockLink.parent().hasClass('current_page_item') ) {

              if ( ! $blockLink.hasClass('active')) {
                  $lastActive.next().slideUp(400);
                  $lastActive.removeClass('active');
              }

              $blockLink.next('.children').slideToggle('400', function() {});
              $blockLink.toggleClass('active');
          }
      }
    });

    $('.sidebar-menu-toggle').on('click', function(event) {
      event.preventDefault();
      $(this).toggleClass('open');

      if ( ! $(this).hasClass('open') ) {

          var $activeMenus = $(this).next().find('.active');
          $activeMenus.each(function(index, el) {
              $(el).removeClass('active');
              // $(el).next().hide();
          });

      }
    });

  }

}

export default NavPrimary;

