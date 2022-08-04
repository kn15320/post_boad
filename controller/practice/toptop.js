$(function(){
$(".top").on("click", (event) => {
    var target = $(event.currentTarget).data('target');
    console.log(target);
    //表示したいところを取得
    //var modal = $('.modal_content')
    var modal = document.getElementsByClassName(target);
    console.log(modal[0]);
    
    $(modal[0]).fadeIn();
    $(modal[1]).fadeIn();

        $('#back').on('click', () => {
            $(modal[0]).fadeOut();
            $(modal[1]).fadeOut();
        })

});

})