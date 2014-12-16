$(document).ready(function(){
    $('a.top-menu').click(function() {
        $('a.top-menu').removeClass('active');
        $(this).addClass('active');
        var id = $(this).attr('id');
        localStorage.setItem('topMenu', id);
        //localStorage.getItem();
        //localStorage.removeItem();
        var main = $(this).text();
        $.ajax({ // na potrzby wyszukiwania
            type: 'POST',
            url: '../set_session.php',
            data: {value : main }, 
            cache: false,
            async: false
        });
    });
    $('a#top-menu-1').click( function () {
        localStorage.removeItem('topMenu');
        $.ajax({// na potrzeby wyszukiwania
            type: 'POST',
            url: '../unset_session.php',
            data: {value : 'main' }, 
            cache: false,
            async: false
        });
    });
    var ids = localStorage.getItem('topMenu');
    if( ids == 'top-menu-1'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(62,86,189)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(90,112,206) 0%,rgb(62,86,189) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(90,112,206)'});
        $('#wrapper1-1').css({'color':'rgb(90,112,206)'});
    }else if( ids == 'top-menu-2'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(182,0,99)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(225,0,122) 0%,rgb(182,0,99) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(225,0,122)'});
        $('#wrapper1-1').css({'color':'rgb(225,0,122)'});
    }else if( ids == 'top-menu-3'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(2,114,184)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(56,155,217) 0%,rgb(2,114,184) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(56,155,217)'});
        $('#wrapper1-1').css({'color':'rgb(56,155,217)'});
    }else if( ids == 'top-menu-4'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(230,164,0)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(255,215,0) 0%,rgb(230,164,0) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(255,215,0)'});
        $('#wrapper1-1').css({'color':'rgb(255,215,0)'});
    }else if( ids == 'top-menu-5'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(3,24,129)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(16,72,160) 0%,rgb(3,24,129) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(16,72,160)'});
        $('#wrapper1-1').css({'color':'rgb(16,72,160)'});
    }else if( ids == 'top-menu-6'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(133,173,0)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(169,218,0) 0%,rgb(133,173,0) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(169,218,0)'});
        $('#wrapper1-1').css({'color':'rgb(169,218,0)'});
    }else if( ids == 'top-menu-7'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(151,34,185)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(187,97,213) 0%,rgb(151,34,185) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(187,97,213)'});
        $('#wrapper1-1').css({'color':'rgb(187,97,213)'});
    }else if( ids == 'top-menu-8'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(2,177,188)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(45,209,228) 0%,rgb(2,177,188) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(45,209,228)'});
        $('#wrapper1-1').css({'color':'rgb(45,209,228)'});
    }else if( ids == 'top-menu-9'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(3,145,204)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(35,190,254) 0%,rgb(3,145,204) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(35,190,254)'});
        $('#wrapper1-1').css({'color':'rgb(35,190,254)'});
    }else if( ids == 'top-menu-10'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(6,15,92)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(7,52,120) 0%,rgb(6,15,92) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(7,52,120)'});
        $('#wrapper1-1').css({'color':'rgb(7,52,120)'});
    }else if( ids == 'top-menu-11'){
        $('#wrapper4').css({'border-bottom':'5px solid rgb(102,173,1)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(189,224,67) 0%,rgb(102,173,1) 100%)');
        $('#'+ids).addClass('active');
        $('#wrapper1').css({'border-color':'rgb(189,224,67)'});
        $('#wrapper1-1').css({'color':'rgb(189,224,67)'});
    }else if( ids == 'top-menu-backroom'){
        // nothing
    }else{
        $('#wrapper4').css({'border-bottom':'5px solid rgb(40,40,40)'});
        $('#wrapper3, #'+ids).css('background','linear-gradient(to bottom, rgb(248,248,248) 0%,rgb(185,185,185) 100%)');
        $('#'+ids).removeClass('active');
        $('#wrapper1').css({'border-color':'rgb(248,248,248)'});
        $('#wrapper1-1').css({'color':'rgb(248,248,248)'});
    }
});