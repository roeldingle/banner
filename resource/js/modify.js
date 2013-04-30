$(function(){
	var ModifyMethods = getModifyMethods();
	var ModifyEvents = getModifyEvents(ModifyMethods);
	ModifyEvents.load();
	
	
});


function getModifyEvents( method ) {
	return {
		
		load : function() {
			var self = this;
			self.events();
			common.radioToggler('banner_radio','banner_option');
			common.colorPicker();
			$('form')[0].reset();
		},
		
		/*clicked events*/
		events : function() {
			
			$('input[name=banner_radio]').live('change',function(){
				common.radioToggler('banner_radio','banner_option');
			});
			
			$('.btnSubmit').click(function(){
				var fname = ('bannerManageForm');
				method.uploadSubmit(fname);
			});
			
			
			$(".btn_remove").live('click', function() {
				var bProceedDeleteImage = ($(this).attr('title') != undefined) ? true : false;
				
				if(bProceedDeleteImage == true){
					method.deleteImage(this);
				}else{
					console.log('nothing to delete');
					common.remove_tr(this);
				}
				
	
			});
			
		}
	}
}

function getModifyMethods() {
	
	return {
		uploadSubmit : function(fname) {
			common.submitForm(fname,'modify');
		},
		
		deleteImage: function(elem){
			common.remove_tr(elem);
		}
		
		
	} /*end method*/
	
}