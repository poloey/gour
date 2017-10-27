jQuery(document).ready(function($){
	//final width --> this is the quick view image slider width
	//maxQuickWidth --> this is the max-width of the quick-view panel
	var sliderFinalWidth = 480,
		maxQuickWidth = 960;

		var allowClicks = true;

	

	//open the quick view panel
	$('.getbowtied_product_quick_view_button').on('click', function(event){

		var $this = $(this);

		$this.parent().find('.product_thumbnail').addClass('loading');

		var product_id  = $(this).data('product_id');
		var selectedImage = $(this).parents('li').find('.product_thumbnail img');

		$.ajax({
			url: shopkeeper_ajaxurl,
			data: {
				"action" : "getbowtied_product_quick_view",
				'product_id' : product_id
			},
			success: function(results) {

				// console.log(results);

				$('.cd-quick-view').empty().html(results);
				
				animateQuickView(selectedImage, sliderFinalWidth, maxQuickWidth, 'open');
			},
			error: function(errorThrown) { console.log(errorThrown); },

		}).done(function(){

			$this.parent().find('.product_thumbnail').removeClass('loading');
		});

		// //update the visible slider image in the quick view panel
		// //you don't need to implement/use the updateQuickView if retrieving the quick view data with ajax
		// updateQuickView(selectedImageUrl);
	});

	//close the quick view panel
	$('body').on('click', function(event){
		if( ($(event.target).is('.cd-close') || $(event.target).is('body.overlay-layer')) && allowClicks === true ) {
			closeQuickView( sliderFinalWidth, maxQuickWidth);
		}
	});
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
    	if(event.which=='27'){
			closeQuickView( sliderFinalWidth, maxQuickWidth);
		}
	});

	//center quick-view on window resize
	$(window).on('resize', function(){
		if($('.cd-quick-view').hasClass('is-visible')){
			window.requestAnimationFrame(resizeQuickView);
		}
	});


	function resizeQuickView() {
		var quickViewLeft = ($(window).width() - $('.cd-quick-view').width())/2,
			quickViewTop = ($(window).height() - $('.cd-quick-view').height())/2;
		$('.cd-quick-view').css({
		    "top": quickViewTop,
		    "left": quickViewLeft,
		});
	} 

	function closeQuickView(finalWidth, maxQuickWidth) {
		var close = $('.cd-close'),
		selectedImage = $('.empty-box').find('img');

		//update the image in the gallery
		if( !$('.cd-quick-view').hasClass('velocity-animating') && $('.cd-quick-view').hasClass('add-content')) {
			animateQuickView(selectedImage, finalWidth, maxQuickWidth, 'close');
		} else {
			closeNoAnimation(selectedImage, finalWidth, maxQuickWidth);
		}
	}

	function animateQuickView(image, finalWidth, maxQuickWidth, animationType) {
		//store some image data (width, top position, ...)
		//store window data to calculate quick view panel position
		var parentListItem = image.parents('li'),
			topSelected = image.offset().top - $(window).scrollTop(),
			leftSelected = image.offset().left,
			widthSelected = image.width(),
			heightSelected = image.height(),
			windowWidth = $(window).width(),
			windowHeight = $(window).height(),
			finalLeft = (windowWidth - finalWidth)/2,
			finalHeight = 596,
			finalTop = (windowHeight - finalHeight)/2,
			quickViewWidth = ( windowWidth * .8 < maxQuickWidth ) ? windowWidth * .8 : maxQuickWidth ,
			quickViewLeft = (windowWidth - quickViewWidth)/2;

		if( animationType == 'open') {
			$('body').addClass('overlay-layer');
			//hide the image in the gallery
			parentListItem.addClass('empty-box');
			//place the quick view over the image gallery and give it the dimension of the gallery image
			$('.cd-quick-view').css({
			    "top": topSelected,
			    "left": leftSelected,
			    "width": widthSelected,
			    "height": finalHeight
			}).velocity({
				//animate the quick view: animate its width and center it in the viewport
				//during this animation, only the slider image is visible
			    'top': finalTop+ 'px',
			    'left': finalLeft+'px',
			    'width': finalWidth+'px',
			}, 1000, [ 400, 20 ], function(){
				//animate the quick view: animate its width to the final value
				$('.cd-quick-view').addClass('animate-width').velocity({
					'left': quickViewLeft+'px',
			    	'width': quickViewWidth+'px',
				}, 300, 'ease' ,function(){
					//show quick view content
					$('.cd-quick-view').addClass('add-content');

					var qvSlider = new Swiper('.cd-quick-view .swiper-container', {		

						pagination: '.swiper-pagination',
						nextButton: '.swiper-button-next',
						prevButton: '.swiper-button-prev',	
						preventClick: true,
						preventClicksPropagation: true,
						grabCursor: true,
						onTouchStart: function (){
						    allowClicks = false;
						  },
						 onTouchMove: function (){
						    allowClicks = false;
						},
						onTouchEnd: function (){
						    setTimeout(function(){allowClicks = true;},300);
						},
						
					});

					var form_variation = $(".cd-quick-view").find('.variations_form');
					var form_variation_select = $(".cd-quick-view").find('.variations_form .variations select');
	            	
	            	form_variation.wc_variation_form();
	            	form_variation_select.change();

	            	form_variation.on('change', 'select', function() {
						qvSlider.slideTo(0);
					});

				});
			}).addClass('is-visible');
		} else {
			//close the quick view reverting the animation
			$('.cd-quick-view').removeClass('add-content').velocity({
			    'top': finalTop+ 'px',
			    'left': finalLeft+'px',
			    'width': finalWidth+'px',
			}, 300, 'ease', function(){
				$('body').removeClass('overlay-layer');
				$('.cd-quick-view').removeClass('animate-width').velocity({
					"top": topSelected,
				    "left": leftSelected,
				    "width": widthSelected,
				}, 500, 'ease', function(){
					$('.cd-quick-view').removeClass('is-visible');
					parentListItem.removeClass('empty-box');
				});
			});
		}
	}
	function closeNoAnimation(image, finalWidth, maxQuickWidth) {
		var parentListItem = image.parents('li'),
			topSelected = image.offset().top - $(window).scrollTop(),
			leftSelected = image.offset().left,
			widthSelected = image.width();

		//close the quick view reverting the animation
		$('body').removeClass('overlay-layer');
		parentListItem.removeClass('empty-box');
		$('.cd-quick-view').velocity("stop").removeClass('add-content animate-width is-visible').css({
			"top": topSelected,
		    "left": leftSelected,
		    "width": widthSelected,
		});
	}
});