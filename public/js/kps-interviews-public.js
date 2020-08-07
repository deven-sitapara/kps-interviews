(function($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  $(window).load(function() {
    $("#nds_add_candidate_meta_ajax_form").submit(function(event) {
      event.preventDefault(); // Prevent the default form submit.

      // serialize the form data
      var ajax_form_data = $("#nds_add_candidate_meta_ajax_form").serialize();

      //add our own ajax check as X-Requested-With is not always reliable
      ajax_form_data = ajax_form_data + "&ajaxrequest=true&submit=Submit+Form";

      $.ajax({
        url: interview.ajaxurl, // domain/wp-admin/admin-ajax.php
        type: "post",
        data: ajax_form_data
      })

        .done(function(response) {
          // response from the PHP action

          $(" #nds_form_feedback ").html(
            "<h2>The request was successful 123 </h2><br>" + response.content
          );
          return false;
        })

        // something went wrong
        .fail(function() {
          $(" #nds_form_feedback ").html("<h2>Something went wrong.</h2><br>");
          return false;
        })

        // after all this time?
        .always(function() {
          event.target.reset();
          return false;
        });

      return false;
    });
  });
})(jQuery);
