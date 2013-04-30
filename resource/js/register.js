$(function(){
	var registerMethods = getRegisterMethods();
	var registerEvents = getRegisterEvents(registerMethods);
	registerEvents.load();
	
});


function getRegisterEvents( method ) {
	return {
		
		load : function() {
			var self = this;
			self.events();
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
			
		}
	}
}

function getRegisterMethods() {

	return {
		uploadSubmit : function(fname) {
			common.submitForm(fname,'register');
		}
	}
	
}