$(function(){
	
	var iSeq = '<?php echo $seq; ?>';
	var iSlidertop = '<?php echo $slidertop; ?>';
	
	//setCarousel(iSeq);
	
	 /*image slider*/
    $('.banner_event_images_'+iSeq).jCarouselLite({
         visible: 1,
         btnGo: $('.bullets_'+iSeq)
                
     });
    
    /*bullet image number marker*/
    $('.bullets_'+iSeq).bind('mouseover',function(){
        $('.bullets_'+iSeq).removeClass('enabled_'+iSeq);
        $('.bullets_'+iSeq).addClass('disabled_'+iSeq);
        
        $(this).removeClass('disabled_'+iSeq);
                        
        $(this).removeClass('disabled_'+iSeq);
        $(this).addClass('enabled_'+iSeq);
    });
    
		/*give dimensions for image titles
		if($('.eventbanner_titlebox_'+iSeq+' img').length > 0){
			
           
           
                 $('.eventbanner_titlebox_'+iSeq+' img').load(function() {
     
                    var orgWidth = $(this).width();
                    var orgHeight = $(this).height();
                    
                      $('.eventbanner_titlebox_'+iSeq).width(orgWidth);
                      $('.eventbanner_titlebox_'+iSeq).height(orgHeight);
                      
                      if($('.eventbanner_titlebox_'+iSeq+' img').width() == 0 ){
                    	  
	                      if($('.banner_event_images_'+iSeq+' ul').width() == 0){
	                        var totImageContentWidth = 0;
	                        $.each($('.banner_event_images_'+iSeq+' img'),function(){
	                            totImageContentWidth += $(this).width();
	                        });
	                        $('.banner_event_images_'+iSeq+' ul').width(totImageContentWidth);
	                        $('.banner_event_images_'+iSeq+' ul').css('left','-'+orgWidth);
	                      }
	                      
	                      
                      }
                      
                      if($('.banner_event_images_'+iSeq+' ul').width() == 0){
	                        var totImageContentWidth = 0;
	                        $.each($('.banner_event_images_'+iSeq+' img'),function(){
	                            totImageContentWidth += $(this).width();
	                        });
	                        $('.banner_event_images_'+iSeq+' ul').width(totImageContentWidth);
	                        $('.banner_event_images_'+iSeq+' ul').css('left','-'+orgWidth);
	                  }
                      
                      $('.banner_event_images_'+iSeq).width(orgWidth);
                      $('.banner_event_images_'+iSeq+' li').width(orgWidth);
                      $('.banner_event_images_'+iSeq+' img').width(orgWidth);
                      
                      setCarousel(iSeq);
                });
           
           
			
		}else{
            setCarousel(iSeq);
            
        }*/
		
		
	
	
	
	
});

function setCarousel(iSeq){
    
    /*image slider*/
    $('.banner_event_images_'+iSeq).jCarouselLite({
         visible: 1,
         btnGo: $('.bullets_'+iSeq)
                
     });
    
    /*bullet image number marker*/
    $('.bullets_'+iSeq).bind('mouseover',function(){
        $('.bullets_'+iSeq).removeClass('enabled_'+iSeq);
        $('.bullets_'+iSeq).addClass('disabled_'+iSeq);
        
        $(this).removeClass('disabled_'+iSeq);
                        
        $(this).removeClass('disabled_'+iSeq);
        $(this).addClass('enabled_'+iSeq);
    });

}