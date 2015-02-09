/* SZero sliders functions plugin
|* by Don Nuwinda
|* http://www.stepzero.solutions
|* version: 1.0
|* updated: Jan 26, 2015
|* since 2015
|* licensed under the MIT License
|* Enjoy.
|* 
*/
(function ( $ ) {

    // test for feature support and return if failure
	$.fn.szeroslider = function( status ) {
		var bwidth = $(window).width();
		if( bwidth>=768){
			$('.carousel-inner').children('div').each(function () {
				var imgsrc = $(this).find('img').data('src');
				$(this).find('img').attr('src', imgsrc);
			});
		}
	}
	$('.carousel-slider').szeroslider();
})(jQuery);
