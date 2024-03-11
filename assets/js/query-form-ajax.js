jQuery(document).ready(function($) {

    $(window).scroll(function() {
  
        var targetElement = $('#wqf-admin_query_form');
        if (targetElement.length) {
        
            var elementTop = targetElement.offset().top - $(window).scrollTop();
            var viewportHeight = $(window).height();
            if (elementTop >= 0 && elementTop < viewportHeight) {

                var order_id = targetElement.find('#wqf-query_post_id').val();
                $.ajax({
                    type: 'POST',
                    url: woo_query_ajax.ajax_url,
                    data: {
                        action: 'view_queryform', 
                        post_id: order_id ,
                        side : 'admin'
                    },
                    /**
                     * Handle the success response and update the query form container.
                     *
                     * @param {type} response - the response data
                     * @return {type} undefined
                     */
                    success: function (response) {
                   
                        $('.wqf-query-form-container').html(response); 
                        var responderContainer = $('.wqf-query-form-container');
                        if (responderContainer.length > 0) {
                            responderContainer.scrollTop(responderContainer[0].scrollHeight);
                        } 
                                         
                    }
                });

         
            }
        }
    });
    
 
    $('.wqf-refresh-query').click(function(){
        var refreshDiv = $(this);
        var order_id = refreshDiv.attr('data-id');
      
      
        refreshDiv.find('.wqf-refresh-without-loader ').css('display','none');
        refreshDiv.find('.wqf-refresh-with-loader ').css('display','inline-block');

        $.ajax({
            type: 'POST',
            url: woo_query_ajax.ajax_url,
            data: {
                action: 'view_queryform', 
                post_id: order_id ,
                side : 'admin'
            },
            /**
             * Handle the success response and update the query form container.
             *
             * @param {type} response - the response data
             * @return {type} undefined
             */
            success: function (response) {
           
                $('.wqf-query-form-container').html(response); 
                var responderContainer = $('.wqf-query-form-container');
                if (responderContainer.length > 0) {
                    responderContainer.scrollTop(responderContainer[0].scrollHeight);
                } 
                refreshDiv.find('.wqf-refresh-with-loader ').css('display','none');
                refreshDiv.find('.wqf-refresh-without-loader ').css('display','inline-block');
               
            }
        });
    })



    $('.wqf-order-query-form').click(function() {

        var order_id = $(this).attr('href').replace('#','');

        $.ajax({
            type: 'POST',
            url: woo_query_ajax.ajax_url,
            data: {
                action: 'view_queryform', 
                post_id: order_id ,
            },
            /**
             * A function that handles the success response.
             *
             * @param {Object} response - the response received from the server
             * @return {void} 
             */
            success: function (response) {
           
                $(`#wqf-resond_popup${order_id}`).find('.wqf-query-form-container').html(response); 
                var responderContainer =  $(`#wqf-resond_popup${order_id}`).find('.wqf-query-form-container');
                if (responderContainer.length > 0) {
                    responderContainer.scrollTop(responderContainer[0].scrollHeight);
                } 
            }
        });

        $('#wqf-resond_popup'+order_id).css({
            visibility: 'visible',
            opacity: 1
        }); 
    });

    $('.wqf-query-overlay .wqf-close').click(function(){
        var order_id = $(this).attr('href').replace('#','');
        $('#wqf-resond_popup'+order_id).css({
            visibility: 'hidden',
            opacity: 0
        }); 
    });

    var responderContainer = $('.wqf-query-form-container');
    if (responderContainer.length > 0) {
        responderContainer.scrollTop(responderContainer[0].scrollHeight);
    } 

    $('.wqf-customer_query_form_button').on('click', function(e) {
        var button = $(this);

        button.prop('disabled', true);
        button.find('.fa-spinner').show();

        var order_id = $(this).attr('id').replace('wqf-query_form_button','');
         
        let query_message = $('#wqf-query_form'+order_id).find('.wqf-query_message').val();
        let post_id = $('#wqf-query_form'+order_id).find('.wqf-query_post_id').val();
        let user_id = $('#wqf-query_form'+order_id).find('.wqf-query_user_id').val();

        if (query_message.trim() === '') {
      
            alert('Query filed cannot be empty.');
            button.prop('disabled', false);
            button.find('.fa-spinner').hide();
            return; // Exit function
        }
        

        $.ajax({
            type: 'POST',
            url: woo_query_ajax.ajax_url,
            data: {
                action: 'submit_woo_query_form', 
                query_message: query_message,
                post_id: post_id ,
                user_id:user_id,
            },
            /**
             * A callback function for handling successful response.
             *
             * @param {type} response - the response data from the server
             * @return {type} undefined
             */
            success: function (response) {
                $('.wqf-query_message').val("");  
                $(`#wqf-resond_popup${order_id}`).find('.wqf-query-form-container').html(response); 
                button.find('.fa-spinner').hide();   
                button.prop('disabled', false);  
                
                var responderContainer =  $(`#wqf-resond_popup${order_id}`).find('.wqf-query-form-container');
                if (responderContainer.length > 0) {
                    responderContainer.scrollTop(responderContainer[0].scrollHeight);
                } 
            }
        });

    });


    $('#wqf-query_form_button_id').on('click',function(){
        var button = $(this);
        button.prop('disabled', true);
        button.find('.fa-spinner').show();


 
        let query_message = $('#wqf-admin_query_form').find('#wqf-query_message').val();
        let post_id = $('#wqf-admin_query_form').find('#wqf-query_post_id').val();
        let user_id = $('#wqf-admin_query_form').find('#wqf-query_user_id').val();

        // Check if query_message is empty
        if (query_message.trim() === '') {
            // Display an error message or handle the empty query_message case as needed
            // For example:
            alert('Query filed cannot be empty.');
            button.prop('disabled', false);
            button.find('.fa-spinner').hide();
            return; // Exit function
        }
            

        $.ajax({
            type: 'POST',
            url: woo_query_ajax.ajax_url,
            data: {
                action: 'submit_woo_query_form', 
                query_message: query_message,
                post_id: post_id ,
                user_id:user_id,
                side :'admin'
            },
            /**
             * Handles the success response from the server.
             *
             * @param {type} response - the response from the server
             * @return {type} undefined
             */
            success: function (response) {
              $('#wqf-admin_query_form').find('#wqf-query_message').val("");  
              $('.wqf-query-form-container').html(response);  
              button .find('.fa-spinner').hide();  
              button.prop('disabled', false);    
              var responderContainer = $('.wqf-query-form-container');
              if (responderContainer.length > 0) {
                  responderContainer.scrollTop(responderContainer[0].scrollHeight);
              }               
            }
        });

    });



});
