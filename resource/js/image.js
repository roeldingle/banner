$(function(){
	
	$('input[type=file]').change(function() { 
		
		//var elem_iframe = parent.$(parent.document.activeElement);
		
		//var file = $(this)[0].files[0];
		//var fileName = file.name;
		//var fileSize = file.size;
		/*
		var validFileExtensions = ["jpg", "jpeg", "bmp", "gif", "png"];
		fileName = fileName.split(".");
		
		var filesizelimit = 2;
		var bValidExtension = jQuery.inArray(fileName[1], validFileExtensions);
		var bValidSize = (fileSize > (filesizelimit * 1048576)) ? false : true ;
		console.log(bValidExtension);*/
		
		//console.log(fileName);return;
		if( $('#image_preview_form').validateForm() ){
			var fname = 'image_preview_form';
		    [SDKJS]
	        var fCallback = function(){
		    	
		    	};
	        Cafe24_SDK_Upload_Submit( $(document.getElementById(fname)), {'callback':fCallback} );
	        return false;
		}
		
	});
	
	/*
	$('.btn_upload').live('click',function(){
		$(this).parent().children('input[type=file]').trigger('click');
		
	});
	*/
	
	
});