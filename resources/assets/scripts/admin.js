/*eslint no-console: ["error", { allow: ["warn", "error", "log"] }] */
jQuery(function($){

  function loadImageContainer( $key ) {
    // Set all variables to be used in scope
    var frame,
        metaBox = $('.image-container-' + $key), // Your meta box id here
        addImgLink = metaBox.find('.upload-custom-img-' + $key),
        delImgLink = metaBox.find( '.delete-custom-img-' + $key),
        imgContainer = metaBox.find( '.custom-img-container-' + $key),
        imgIdInput = metaBox.find( '.custom-img-id-' + $key );

    // ADD IMAGE LINK
    addImgLink.on( 'click', function( event ){

      event.preventDefault();

      // If the media frame already exists, reopen it.
      if ( frame ) {
        frame.open();
        return;
      }

      // Create a new media frame
      frame = wp.media({
        title: 'Select or Upload Media Of Your Chosen Persuasion',
        button: {
          text: 'Use this media',
        },
        multiple: false,  // Set to true to allow multiple files to be selected
      });


      // When an image is selected in the media frame...
      frame.on( 'select', function() {

        // Get media attachment details from the frame state
        var attachment = frame.state().get('selection').first().toJSON();

        // Send the attachment URL to our custom image input field.
        imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

        // Send the attachment id to our hidden input
        imgIdInput.val( attachment.id );

        // Hide the add image link
        addImgLink.addClass( 'hidden' );

        // Unhide the remove image link
        delImgLink.removeClass( 'hidden' );
      });

      // Finally, open the modal on click
      frame.open();
    });


    // DELETE IMAGE LINK
    delImgLink.on( 'click', function( event ){

      event.preventDefault();

      // Clear out the preview image
      imgContainer.html( '' );

      // Un-hide the add image link
      addImgLink.removeClass( 'hidden' );

      // Hide the delete image link
      delImgLink.addClass( 'hidden' );

      // Delete the image id from the hidden input
      imgIdInput.val( '' );

    });
  }

  loadImageContainer('image');
  loadImageContainer('icon');

  // Custom Sidebars
  // Add Custom Sidebar
  $('#sidebar-management').on('click', '.add-sidebar', function (event) {
    event.preventDefault();

    var $sidebarManagement = $(this).closest('#sidebar-management');
    var $newSidebarTitle = $('#new_sidebar_name');
    var newSidebarTitle = $newSidebarTitle.val();

    if (newSidebarTitle !== '') {
      var $sidebarNumber = $('#custom_sidebars_number'),
        sidebar_number = Number($sidebarNumber.val()) + 1,
        sidebar_name = $sidebarNumber.attr('name').split('_number]');

      $sidebarNumber.val(sidebar_number);

      var $sidebarList = $('.sidebar-management__list', $sidebarManagement);
      $sidebarList.find('p').hide();
      if($sidebarList.find('ul').length === 0) {
        $sidebarList.append('<ul />');
      }

      $('ul', $sidebarList).append('<li>' +
        newSidebarTitle +
        '<a href="#" class="sidebar_del" title="Eliminar"><span class="dashicons-before dashicons-no"></span></a> ' +
        '<input type="hidden" name="' + sidebar_name[0] + '][' + sidebar_number + ']" value="' + newSidebarTitle + '" />' +
      '</li>');

      $newSidebarTitle.val('');

      $('#sidebar-management__container').find('.text-right-button').addClass('active');
    }

    return false;
  });

  // Remove Custom Sidebar
  $('#sidebar-management').on('click', '.sidebar_del', function () {
    var $sidebarManagement = $(this).closest('#sidebar-management'),
      $sidebarNumber = $('#custom_sidebars_number'),
      del_sidebar_number = Number($sidebarNumber.val()) - 1,
      li_input = {},
      li_input_val = '';

    if (confirm( 'Seguro de eliminar o Sidebar' )) {
      $sidebarNumber.val(del_sidebar_number);
      $(this).parent().remove();

      for (var n = 1; n <= del_sidebar_number; n += 1) {
        var $li = $('ul li:eq(' + (n - 1) + ')', $sidebarManagement);
        li_input = $li.find('input[type="hidden"]');
        li_input_val = li_input.attr('name').split('_-_');
        li_input.attr( { name :  li_input_val[0] + '_-_' + n + ']'} );
      }

      if(del_sidebar_number <= 0) {
        $('.sidebar-management__list', $sidebarManagement).find('p').show();
      }

      $('#sidebar-management__container').find('.text-right-button').addClass('active');
    }

    return false;
  });

});
