$(function(){
	
	var indexMethods = getIndexMethods();
	var indexEvents = getIndexEvents(indexMethods);
	indexEvents.load();
	
	
	
});

function getIndexEvents( method ) {
	return {
		
		load : function() {
			var self = this;
			self.events();
			
			method.imageSizeChecker();
		},
		
		/*clicked events*/
		events : function() {
			
			
			
			$('.check-all').live('click',function () {
			    $('input[type="checkbox"]').attr('checked', this.checked);
			});
			
			
			
			$('.btn_delete_list').click(function(){
				
				if($('input[name="banner_ids[]"]:checked').length > 0){
					var aId = common.getCheckedId();
					method.deleteEventList(aId);
				}else{
					alert('No event choosen');
				}
				
				
			});
			
			$('.status_btn').click(function(){
				
				method.changeStatus(this);
				
			});
			
		}
	}
}

function getIndexMethods() {
	
	return {
		
		deleteEventList: function(aId){
			
			var bConfirm = confirm("Are you sure yo want to delete this item(s)?")
			
			if(bConfirm){
				sUrl = "[link=admin/DeleteExec]?seqs=" + aId.join(",");
				common.redirect(sUrl);
			}
		},
		
		changeStatus: function(elem){
			
				$.ajax({
					type:"GET",
					url: "[link=api/Class]",
					data:{
						seq_id: $(elem).attr('title'),
						active: $(elem).attr('alt'),
						process: 'changeStatus'
						},
					success: function(response){
						//console.log(response);
						common.redirect("[link=admin/Index]");
					}
				});
				
			
		},
		
		imageSizeChecker: function(){
			
			$.each($('.banner_tbtd_img_size'),function(i,v){
				
				if(/^\d+$/.test($(this).text()) == false) {
					var iImageWidth = $(this).children('img').width();
                    
					/*
					if(iImageWidth === 0){
						var tmpImg = new Image();
						tmpImg.src= $(this).children('img').attr('src'); //or  document.images[i].src;
						$(tmpImg).one('load',function(){
						  orgWidth = tmpImg.width;
						  orgHeight = tmpImg.height;
						  $('.banner_tbtd_img_size').eq(i).html(orgWidth);
						});
                        
                        
					}else{*/
						$(this).html(iImageWidth);
					//}
				}
				
				return;
				/*
				if(/^\d+$/.test($(this).text())) {
					$(this).text($(this).text()+' px')
				}else{
					var iImageWidth = $(this).children('img').width();
                    
					if(iImageWidth === 0){
						var tmpImg = new Image();
						tmpImg.src= $(this).children('img').attr('src'); //or  document.images[i].src;
						$(tmpImg).one('load',function(){
						  orgWidth = tmpImg.width;
						  orgHeight = tmpImg.height;
						  $('.banner_tbtd_img_size').eq(i).html(orgWidth+' px');
						});
                        
                        
					}else{
						$(this).html(iImageWidth+' px');
					}
					
				}*/
				
			});
			
		}
	}
	
}