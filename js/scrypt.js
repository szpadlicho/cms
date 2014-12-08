$(window).scroll(function() {
    // inscription scroll
    var pos1 = 155+($(this).scrollTop()*0.6);
    if( pos1 <= 295 ){
        $('#titi').css({'top': pos1 + 'px','position':'absolute'});
    }
});
$(window).scroll(function() {
    // background scroll
    var pos2=($(this).scrollTop()/3);
    $('body').css('background-position', 'center -'+pos2+'px');
    // .title-bg H3 scroll with scrollbar 
    $('.image-bg').css('background-position', 'center -'+pos2+'px');
    var pos3 = 230-($(this).scrollTop());
    $('.title-bg').css('top', pos3+'px');
});
$(document).ready(function(){
    //full square active
    $('.full-click').click(function() {
        $('.full-click').removeClass('active');
        $(this).addClass('active');
    });
    //left menu active
    $('input.left-menu').click(function() {
        $('input.left-menu').removeClass('active');
        $(this).addClass('active');
    });
});
var submitOnClick = function(formName){//do klikania diva i odpalania formy
    //echo '<div class="product-square" onclick="submitOnClick(\'#productForm'.$cat['id'].'\')">';
    $(formName).submit();
} 
$(function(){
    /**
    * uncomment if when press top menu 
    * left menu must reset and show all 
    **/
    // $('a.top-menu').click( function () {
        // var del = 'sub';
        // $.ajax({ 
            // async: false,
            // type: 'POST', 
            // url: '../unset_session.php',
            // data: {value : del},
            // dataType: 'text',
            // success: function(data){
                // //console.log(data);
            // }
        // });
    // });
});
$(function(){
    /**
    * Debugger function show hide
    **/
    var ww = $( '#debugger' ).width();
    console.log(ww);
    var wwp = 0.95 * ww ;
    $( '#debugger' ).css( 'right',-wwp+'px' );
    $( '#debugger' ).hover(function() {
        $(this).animate({'right':'0px'}, 500);
    }, function() {
        $(this).animate({ 'right':-wwp+'px'}, 500);
    });  
});
$(function(){
    /**
    * Resetuje pozycje top menu przy rejestracji
    **/
    //11.user -> if register click unset ( 'menu_id' => string 'top-menu-6' (length=10))
    $('[name="user_register"]').click( function () {
        localStorage.removeItem('topMenu');
    });
});