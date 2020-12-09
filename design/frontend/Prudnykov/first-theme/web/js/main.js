require(['jquery', 'slick'], function($){
	$(function(){
		$('.slider-product-items').slick({
		  slidesToShow: 4,
		  slidesToScroll: 1,
		  prevArrow: '<button class="product-slider-wrapper-btn product-slider-wrapper-btnprev"><img class="product-slider-wrapper-btnprev-img" src="" alt="arrow" /></button>',
		  nextArrow: '<button class="product-slider-wrapper-btn product-slider-wrapper-btnnext"><img class="product-slider-wrapper-btnnext-img" src="" alt="arrow" /></button>'
		});
	});
});