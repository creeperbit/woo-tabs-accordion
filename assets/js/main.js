(function ($) {
    $('#woot2a-accordion-container').accordion({
		firstChildExpand: woot2a_first_open,
		allChildsOpen: woot2a_all_open,
		multiExpand: woot2a_multiple_expand,
        slideSpeed: 500,
        dropDownIcon: typeof woot2a_dropdown_icon !== 'undefined' && woot2a_dropdown_icon !== null ? woot2a_dropdown_icon : '&#43'
    });

	$( 'a.woocommerce-review-link' ).click( function(e) {
		e.preventDefault();
		if( $('#woot2a-tab-reviews').is(':hidden') )
			$( '.reviews_tab' ).click();
		$('html, body').animate({
		    scrollTop: $("#woot2a-tab-reviews").offset().top - 40
		}, 1000);
		return true;
	});

	var hash  = window.location.hash;
	var url   = window.location.href;
	if ( hash.toLowerCase().indexOf( 'comment-' ) >= 0 || hash === '#reviews' ) {
		$( '.reviews_tab' ).click();
	} else if ( url.indexOf( 'comment-page-' ) > 0 || url.indexOf( 'cpage=' ) > 0 ) {
		$( '.reviews_tab' ).click();
	}
})(jQuery);