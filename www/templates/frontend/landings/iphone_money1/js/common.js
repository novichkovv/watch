//Select
$(document).ready(function(){
	var buff=$(".price span").text();
	$('#iphone-price').val(buff);
	$(document).on('change','.trigger',function(){
		if($('#c1').prop('checked')){
			$('.foto img').removeClass("active");
			$('.foto').children('img').eq(5).addClass("active");
			$('#iphone-model').val("IPhone 6s");
			$('#iphone-color').val("Серебристый");
		}
		else if($('#c2').prop('checked')){
			$('.foto img').removeClass("active");
			$('.foto').children('img').eq(4).addClass("active");
			$('#iphone-model').val("IPhone 6s");
			$('#iphone-color').val("Золотой");
		}
		else if($('#c3').prop('checked')){
			$('.foto img').removeClass("active");
			$('.foto').children('img').eq(7).addClass("active");
			$('#iphone-model').val("IPhone 6s");
			$('#iphone-color').val("Серый космос");
		}
      	else if($('#c4').prop('checked')){
			$('.foto img').removeClass("active");
			$('.foto').children('img').eq(6).addClass("active");
			$('#iphone-model').val("IPhone 6s");
			$('#iphone-color').val("Розовое золото");
		}
/*
		var price = 0;
		var currentPrice = 0;
		
		if($('#m1').prop('checked')){
			$('.trigger').each(function(){
				if($(this).prop('checked')){
					currentPrice = $(this).attr('data-price-6');
					currentPrice = parseInt(currentPrice,10);
					price += currentPrice;
				}
			});
		}
		
		if($('#m2').prop('checked')){
			$('.trigger').each(function(){
				if($(this).prop('checked')){
					currentPrice = $(this).attr('data-price-6s');
					currentPrice = parseInt(currentPrice,10);
					price += currentPrice;
				}
			});
		}
		$(".price span").text(price);*/
	});
	
	$('.trigger').eq(1).trigger("click");
	$('.trigger').eq(0).trigger("click");
});
//Anchor
	 $(document).ready(function(){
	      $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
	    });

//Fancybox
	$(document).ready(function() {

	  //   $(".fancybox").fancybox({});   
			// $(".modalbox2").fancybox({
			// 	closeBtn: false,
			// });
			// $(".fb-close").click(function(){
			// 	$.fancybox.close();
			// });		
	});	
	

//Maskinput
    	jQuery(function() {
     	 
     	 });    	    
     	 //   jQuery(function() {
     	 // jQuery(".do").mask("A-Z");      
     	 //
//Hover
$(document).ready(function(){
	$('.colors .wrap-img').on('mouseenter',function(){
		$(this).find('.showImg').css('opacity','0');
		$(this).find('.hideImg').css('opacity','1');
	});
	$('.colors .wrap-img').on('mouseleave',function(){
		$(this).find('.showImg').css('opacity','1');
		$(this).find('.hideImg').css('opacity','0');
	});	
	
	
	//
  $('.modal-order a').click(function(e) {
  	$('html, body').stop().animate({
      scrollTop: $('#to_order').offset().top
    }, 1000);
    e.preventDefault();
  });

});