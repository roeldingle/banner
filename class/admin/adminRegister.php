<?php
class adminRegister extends Controller_Admin
{
    protected function run($aArgs){
    	self::initTemplate();
    	self::assignData($aArgs);
    	self::setView($aArgs);
    }
    
    private function initTemplate(){
    	
    	$this->UIPackage->addPlugin('Dialog');
    	//$this->UIPackage->addPlugin('ColorPicker');
    	$this->importJS('libs/colorpicker');
    	$this->importJS('libs/jquery.validate.mod');
    	$this->importJS('libs/common');
    	$this->importJS('register');
    	 
    	$this->importCSS('libs/common');
    	$this->importCSS('app');
    	$this->importCSS('libs/colorpicker');
    	
    }
    
    private function setView($aArgs){
    	$bView = $this->View();
    	if ($bView!==false) {
    		$this->setStatusCode('200');
    	}
    	
    }
    
    private function assignData($aArgs){
    	$this->assign('sImageHtml',self::getBannerImageHtml($aArgs));
    }
    
    private function getBannerImageHtml($aArgs){
    	$sHtmlData = '';
    	
    	$iBannerImageLimit = 5;
    	
    	for($i = 1;$i <= $iBannerImageLimit; $i++){

    		$sHtmlData .= '<tr>';
    		$sHtmlData .= '<td class="bggrey">Banner '.$i;
    		$sHtmlData .= ($i === 1) ? '<span class="required">*</span></td>' : '';
    		$sHtmlData .= '<td>';
    		$sHtmlData .= '<div class="container mb10 fl">';
    		$sHtmlData .= '<span class="fl w100">File Upload</span>';
    		$sHtmlData .= '<input type="text"  name="banner_image_realname_'.$i.'"  class="inputbtn bggrey" readonly  ';
    		$sHtmlData .= ($i === 1) ? 'validate="required|accept[jpg,png,jpeg,gif,ico]" ' : 'validate="accept[jpg,png,jpeg,gif,ico]"';
    		$sHtmlData .= '/>';
    		
    		$sHtmlData .= '<div class="inputbrowse">';
    		$sHtmlData .= '<input type="file" class="file" name="banner_image_file_'.$i.'" />';
    		$sHtmlData .= 'Browse...';
    		$sHtmlData .= '</div>';
    		//$sHtmlData .= '<em class="ir icoFind ml10">Search</em>';
    		$sHtmlData .= '<a class="btndelcreate btnDelFile ml10" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>';
    		$sHtmlData .= '</div>';
    		$sHtmlData .= '<div class="container mb10 fl">';
    		$sHtmlData .= '<span class="fl w100">Link URL</span>';
    		$sHtmlData .= '<div class="holder">';
    		$sHtmlData .= '<span class="mr5">http://</span><input type="text" name="banner_image_url_'.$i.'"  class="w350 banner_image_url"';
    		$sHtmlData .= '/>';
    		$sHtmlData .= '</div>';
    		$sHtmlData .= '</div>';
    		$sHtmlData .= '</td>';
    		$sHtmlData .= '</tr>';

    	}
    	
    	return 	$sHtmlData;
    	
    }
}
