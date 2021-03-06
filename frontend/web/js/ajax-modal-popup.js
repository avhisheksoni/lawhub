$(function(){
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
//we use on so the dom element can be called again if they are nested, otherwise when we load the content once it kills the dom element and wont let you load anther modal on click without a page refresh
      $(document).on('click', '.showModalButton', function(){
         //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        $(".modal").on('hidden', function() {
            $.fn.modal.Constructor.prototype.enforceFocus = enforceModalFocusFn;
        });

        $(".modal").modal({ backdrop : false });
        
        if ($('#modal').hasClass('in')) {
            //document.getElementById('modalContent').innerHTML = document.getElementById('gif').innerHTML;
            $('#modal').find('#modalContent')
                    .load($(this).attr('value'), function( response, status, xhr ) {
                        if ( status === 'error' ) {
                            $('#modalContent').html(xhr.responseText)
                        }
                      });
            //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        } else {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'), function( response, status, xhr ) {
                        if ( status === 'error' ) {
                            $('#modalContent').html(xhr.responseText)
                        }
                      });
             //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }
    });
    $(".modal").on("hidden.bs.modal", function(){
        document.getElementById('modalContent').innerHTML = document.getElementById('gif').innerHTML;
    });
    
});