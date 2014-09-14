//**
//ruch t³a
$(window).scroll(function() {
    // inscription scroll
    var pos=150+($(this).scrollTop()*0.6);
    if( pos <= 288 ){
        $('#titi').css({'top': pos + 'px','position':'absolute'});
    }
});
$(window).scroll(function() {
    // background scroll
    var pos1=($(this).scrollTop()/3);
    $('body').css('background-position', 'center -'+pos1+'px');
    //var pos2=($(this).scrollTop()/3);
    $('.image-bg').css('background-position', 'center -'+pos1+'px');
    var pos3=190-($(this).scrollTop());
    $('.title-bg').css('top', pos3+'px');
});
//**
$(document).ready(function(){
    //full square active
    $('.full-click').click(function() {
        $('.full-click').removeClass('active');
        $(this).addClass('active');
    });
});
//**
$(document).ready(function(){
    //left menu active
    $('input.left-menu').click(function() {
        $('input.left-menu').removeClass('active');
        $(this).addClass('active');
        //alert('im here');
    });
});
//**
function submitOnClick(formName){//do klikania diva i odpalania formy
    //echo '<div class="product-square" onclick="submitOnClick(\'#productForm'.$cat['id'].'\')">';
    $(formName).submit();
} 
//**
$(document).ready(function(){
    // set/unset session for top menu
    $('a.top-menu').click(function() {
        $('a.top-menu').removeClass('active');
        $(this).addClass('active');
        var valu = $(this).attr('id');
        //$.post('../set_session.php', { 'value' : valu});                
        $.ajax({
            async: false,
            type: 'POST',
            url: '../set_session.php',
            data: {value : valu}                  
        });
    });
    $('a.top-menu').click( function () {
        var del = 'sub';
        $.ajax({ 
          async: false,
          type: 'POST', 
          url: '../unset_session.php',
          data: {value : del}
        });
        //alert('asdasd');
    });
    $('a#top-menu-1').click( function () {
        var del = 'main';
        $.ajax({ 
          async: false,
          type: 'POST', 
          url: '../unset_session.php',//if home click 
          data: {value : del}
        });
        //alert('asdasd');
    });
});