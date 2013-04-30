<?php

/*include common class */
require_once('lib/Common.php');
require_once('lib/DB.php');

/*will display the modify form via selected event seq*/
class adminModify extends Controller_Admin
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
    	$this->importJS('modify');
    	
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
    	$aData = array(DB::select(libKey::BA_KEY,$aArgs['event']));
    	$this->assign('aBannerData',$aData[0]);
    	
    	$this->assign('sImageHtml',self::getBannerImageHtml($aData));
    }
    
    private function getBannerImageHtml($aData){
    	$sHtmlData = '';
    	 
    	$iBannerImageLimit = 5;
    	
    	foreach($aData[0]['banner_image'] as $key=>$val){
    		$i = ($key+1);
    		
    		$sHtmlData .= '<tr>';
    		$sHtmlData .= '<td class="bggrey">Banner '.$i;
    		$sHtmlData .= ($i === 1) ? '<span class="required">*</span></td>' : '';
    		$sHtmlData .= '<td>';
    		$sHtmlData .= '<div class="container mb10 fl">';
    		$sHtmlData .= '<span class="fl w100">File Upload</span>';
    		$sHtmlData .= '<input type="text"  name="banner_image_realname_'.$i.'"  value="'.$val['img_realname'].'" class="inputbtn bggrey" readonly ';
    		$sHtmlData .= ($i === 1) ? 'validate="required|accept[jpg,png,jpeg,gif,ico]" ' : 'validate="accept[jpg,png,jpeg,gif,ico]"';
    		$sHtmlData .= '/>';
    		
    		$sHtmlData .= '<div class="inputbrowse">';
    		$sHtmlData .= '<input type="file" class="file" name="banner_image_file_'.$i.'" />';
    		$sHtmlData .= 'Browse...';
    		$sHtmlData .= '</div>';
    		
    		
    		if($val['img_path'] && $val['img_name']){
    			$aImageDim =  $this->Storage->getimagesize(($val['img_path'].$val['img_name']));
    			$sImageSize = $aImageDim[0];
    			$sTitle = 'Banner Image '.($key+1);
    			$sHtmlData .= '<a href="javascript:void(0)" title="'.$sTitle.'/'.$sImageSize.'" alt="[pfile='.str_replace('public_files/','',$val['img_path']).$val['img_name'].']"  class="preview_img btn btn_search02">';
    			$sHtmlData .= '<em class="ir icoFind ml10">Search</em>';
    			$sHtmlData .= '</a>';
    		}
    		
    		/*hidden*/
    		$sHtmlData .= '<input type="hidden" name="banner_modify_images_img_path_'.$i.'" value="'.$val['img_path'].'" />';
    		$sHtmlData .= '<input type="hidden" name="banner_modify_images_img_name_'.$i.'" value="'.$val['img_name'].'" />';
    		
    		$sHtmlData .= '<a class="btndelcreate btnDelFile ml10" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>';
    		$sHtmlData .= '</div>';
    		$sHtmlData .= '<div class="container mb10 fl">';
    		$sHtmlData .= '<span class="fl w100">Link URL</span>';
    		$sHtmlData .= '<div class="holder">';
    		$sHtmlData .= '<span class="mr5">http://</span><input type="text" name="banner_image_url_'.$i.'"  value="'.$val['img_url'].'" class="w350 banner_image_url"';
    		$sHtmlData .= '/>';
    		$sHtmlData .= '</div>';
    		$sHtmlData .= '</div>';
    		$sHtmlData .= '</td>';
    		$sHtmlData .= '</tr>';
    		
    	}
    	 
    	return 	$sHtmlData;
    	 
    }
    
    public function color_inverse($color){
    	
		return Common::color_inverse($color);
	}
    
    
}
