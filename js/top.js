$(function(){
    $(".top").on("click", (event) => {
        var target = $(event.currentTarget).data('target');
        
        var modal = document.getElementsByClassName(target);
        
        var com_id =  $(event.currentTarget).attr('id');

        $('input[name="post_id"]').val(com_id);

        $(modal[0]).fadeIn();
        $(modal[1]).fadeIn();
    
        $('#back').on('click', () => {
            $(modal[0]).fadeOut();
            $(modal[1]).fadeOut();
        })
    
    });
    
})