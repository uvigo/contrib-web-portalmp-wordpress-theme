/*eslint no-console: ["error", { allow: ["warn", "error", "log"] }] */
/*global inlineEditPost*/
jQuery(function($){

  // it is a copy of the inline edit function
  var wp_inline_edit_function = inlineEditPost.edit;

  // we overwrite the it with our own
  inlineEditPost.edit = function( post_id ) {

    // let's merge arguments of the original function
    wp_inline_edit_function.apply( this, arguments );

    // get the post ID from the argument
    var id = 0;
    if ( typeof( post_id ) == 'object' ) { // if it is object, get the ID number
      id = parseInt( this.getId( post_id ) );
    }

    //if post id exists
    if ( id > 0 ) {

      // add rows to variables
      var specific_post_edit_row = $( '#edit-' + id ),
      specific_post_row = $( '#post-' + id );
      var sidebar = $( '.column-sidebar', specific_post_row ).text();
      if(sidebar.length === 0) {
        sidebar = 'none';
      } else {
        sidebar = 'sidebar-' + sidebar;
      }

      // populate the inputs with column data
      $( 'select[name="uvigo_page_template_sidebar"]', specific_post_edit_row ).val( sidebar );
    }
  };

  $( document ).on( 'click', '#bulk_edit', function() {
    // define the bulk edit row
    var $bulk_row = $( '#bulk-edit' );

    // get the selected post ids that are being edited
    var $post_ids = [];
    $bulk_row.find( '#bulk-titles' ).children().each( function() {
      $post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
    });

    // get the data
    var $sidebar_id = $bulk_row.find( 'select[name="uvigo_page_template_sidebar_bulk_edit"]' ).val();

    console.log($sidebar_id);

    // save the data
    $.ajax({
      // this is a variable that WordPress has already defined for us
      url: ajaxurl, // eslint-disable-line
      type: 'POST',
      async: false,
      cache: false,
      data: {
        action: 'save_bulk_edit_sidebar', // this is the name of our WP AJAX function that we'll set up next
        post_ids: $post_ids,
        uvigo_page_template_sidebar_bulk_edit: $sidebar_id,
      },
    });
  });

});
