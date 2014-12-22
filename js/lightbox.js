$(function(){
    function disableScrolling(){
        var x=window.scrollX;
        var y=window.scrollY;
        window.onscroll=function(){window.scrollTo(x, y);};
    }
    function enableScrolling(){
        window.onscroll=function(){};
    }
    var con = '<div class="lightbox-button" ><img class="now-displayed-image" src="';
    var tent = '" /><div class="prev"></div><div class="close"></div><div class="next"></div></div>';
    $( '.image-pr-list' ).click(function(){
        var src = $( this ).attr('src');// zwraca sciezke wzglwdna
        //var src = $( this ).prop('src');// zwraca sciezke bezwzgledna
        //console.log(src);
        $( '.lightbox' ).show();
        $( '.lightbox-in-in' ).html( con+src+tent );
        $( '.image-pr-list' ).removeClass('current').removeClass('next-img').removeClass('prev-img');
        $( this ).addClass('current');
        $( this ).next('img.image-pr-list').addClass('next-img');
        $( this ).prev('img.image-pr-list').addClass('prev-img');
        //
        //$( 'body' ).css( 'overflow','hidden' );
        disableScrolling();
    });
    $( '.full-mini-img .mini-image-pr-list' ).click(function(){
        var src = $( this ).attr('src');// zwraca sciezke wzglwdna
        $( '.lightbox' ).show();
        $( '.lightbox-in-in' ).html( con+src+tent );
        //
        //$( 'body' ).css( 'overflow','hidden' );
        disableScrolling();
    });
    $( document ).on('click', '.next', function(event){
        $( '.current' ).removeClass('current');
        $( '.next-img' ).addClass('current').removeClass('next-img');
        if ( $( '.current' ).length == 0 ) {
            $( 'img.image-pr-list' ).first().addClass('current');
        }
        $( '.prev-img').removeClass('prev-img');
        $( '.current' ).next('img.image-pr-list').addClass('next-img');
        $( '.current' ).prev('img.image-pr-list').addClass('prev-img');
        //var lkl = $( '.current' ).length;
        //console.log(lkl);
        var src = $( '.current' ).attr('src');
        $( '.lightbox-in-in' ).html( con+src+tent );
        
    });
    $( document ).on('click', '.prev', function(event){
        $( '.current' ).removeClass('current');
        $( '.prev-img' ).addClass('current').removeClass('prev-img');
        if ( $( '.current' ).length == 0 ) {
            $( 'img.image-pr-list' ).last().addClass('current');
        }
            $( '.next-img').removeClass('next-img');
            $( '.current' ).prev('img.image-pr-list').addClass('prev-img');
            $( '.current' ).next('img.image-pr-list').addClass('next-img');
            var src = $( '.current' ).attr('src');
            $( '.lightbox-in-in' ).html( con+src+tent );
    });
    $( document ).on('click', '.close', function(){
        $( '.lightbox' ).hide();
        //
        //$( 'body' ).css( 'overflow','auto' );
        enableScrolling();
    });
    // $( '.lightbox-in' ).on('click', '.lightbox-in-in', function(){
        // //$( '.lightbox' ).hide();
        // console.log('in');
    // });
    // $( document ).on('click', '.now-displayed-image', function(event){
        // //event.preventDefault();
        // event.isDefaultPrevented();
        // return false;
    // });
});