$(function(){
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
    });
    $( '.full-mini-img .mini-image-pr-list' ).click(function(){
        var src = $( this ).attr('src');// zwraca sciezke wzglwdna
        //var src = $( this ).prop('src');// zwraca sciezke bezwzgledna
        //console.log(src);
        $( '.lightbox' ).show();
        $( '.lightbox-in-in' ).html( con+src+tent );
        //$( '.image-pr-list' ).removeClass('current').removeClass('next-img').removeClass('prev-img');
        //$( this ).addClass('current');
        //$( this ).next('img.image-pr-list').addClass('next-img');
        //$( this ).prev('img.image-pr-list').addClass('prev-img');
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
    });
    // $( document ).on('click', '.lightbox', function(){
        // $( '.lightbox' ).hide();
    // });
    // $( document ).on('click', '.now-displayed-image', function(event){
        // //event.preventDefault();
        // event.isDefaultPrevented();
        // return false;
    // });
});