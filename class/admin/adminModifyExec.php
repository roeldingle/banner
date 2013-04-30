<?php
require_once('lib/Common.php');
require_once('lib/DB.php');

class adminModifyExec extends Controller_AdminExec
{
	private $aFile;
	private $aDbData;
	
	protected function run($aArgs){
		
		$this->aFile = $this->Upload->uploadedFiles();
		
		$bResult = $this->addBannerEvent($aArgs);
		
		if($bResult == true){
			$this->writeJS('alert("Modified successfully!");');
			$this->writeJS('location.href="[link=admin/index]";');
		}else{
			$this->writeJS('alert("Error saving.");');
			$this->writeJS('location.href="[link=admin/modify]";');
			exit;
		}
	}
	
	private function addBannerEvent($aArgs){
		
		/*get db data*/
		$iId = $aArgs['banner_modify_seq'];
		$libKey = libKey::BA_KEY;
		$this->aDbData = DB::select($libKey,$iId);
		
		/*require data*/
		$aData['seq'] = $this->aDbData['seq'];
		$aData['active'] = $this->aDbData['active'];
		$aData['datereg'] = $this->aDbData['datereg'];
		$aData['option'] = $aArgs['banner_radio'];
		
		if($aArgs['banner_radio'] == 'upload'){
			
			/*check if input file has value*/
			if($this->aFile['banner_title_file']){
				$aEventTitleImage = $this->aFile['banner_title_file'];
				$aImgInfo = Common::uploadImage($aEventTitleImage,true);
			}else{
				$aImgInfo['upload_path'] = $aArgs['banner_modify_title_img_path'];
				$aImgInfo['upload_name'] = $aArgs['banner_modify_title_img_name'];
				
				if(!$this->Storage->file_exists($aImgInfo['upload_path'].$aImgInfo['upload_name'])){
					$aImgInfo = false;
				}
			}
			
			/*check if image info has value*/
			if($aImgInfo != false){
				$aData['banner_event'] = array(
						'img_path' => $aImgInfo['upload_path'],
						'img_name' => $aImgInfo['upload_name'],
						'img_realname' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] ) ? $aArgs['banner_title_realname'] : ''
				);
			}else{
				$this->writeJS('alert("Problem modifiying data..");');
				$this->writeJS('location.href="[link=admin/modify]";');
			}
			
		}else{
			/*validate*/
			$aData['banner_event'] = array(
					'title' => (is_string($aArgs['banner_title']) && $aArgs['banner_title'] != '') ? htmlspecialchars(trim($aArgs['banner_title'])) : false,
					'width' => (is_string($aArgs['banner_width']) && $aArgs['banner_width'] != '') ? htmlspecialchars(trim($aArgs['banner_width'])) : false,
					'height' => (is_string($aArgs['banner_height']) && $aArgs['banner_height'] != '') ? htmlspecialchars(trim($aArgs['banner_height'])) : false,
					'ftcolor' => (is_string($aArgs['banner_ftcolor']) && $aArgs['banner_ftcolor'] != '') ? htmlspecialchars(trim($aArgs['banner_ftcolor'])) : false,
					'bgcolor' => (is_string($aArgs['banner_bgcolor']) && $aArgs['banner_bgcolor'] != '') ? htmlspecialchars(trim($aArgs['banner_bgcolor'])) : false
			);
			
			/*validate*/
			foreach($aData['banner_event'] as $k=>$v){
				if($v[$key] === false){
					$this->writeJS('alert("Invalid data ('.$key.').");');
					$this->writeJS('location.href="[link=admin/modify]";');
					exit;
				}
			}
		}
		
		
		
		/*unlink replaced stored image*/
		if($this->aDbData['banner_event']['img_name'] != $aData['banner_event']['img_name']){
			$sImagePathName = $this->aDbData['banner_event']['img_path'].$this->aDbData['banner_event']['img_name'];
			$this->Storage->unlink( $sImagePathName );
		}
		
		$aData['banner_dotimage'] = $this->addBannerDotImages($aArgs);
		$aData['banner_image'] = $this->addBannerImages($aArgs);
		
		$libKey = libKey::BA_KEY;
		return DB::update($libKey,$iId,$aData);
		
	}

	private function addBannerDotImages($aArgs){
		
		$aData = array();
		$aDotImageFile = array('enabled','disabled');
		
		foreach($aDotImageFile as $key=>$val){
			
			if($aEventDotImage = $this->aFile['banner_dotimage_'.$val.'_file']){
				$aImgInfo = Common::uploadImage($aEventDotImage,true);
			}else{
				
				if($aArgs['banner_dotimage_'.$val.'_realname']){
					$aImgInfo['upload_path'] = $aArgs['banner_modify_dotimage_'.$val.'_img_path'];
					$aImgInfo['upload_name'] = $aArgs['banner_modify_dotimage_'.$val.'_img_name'];
					
					if(!$this->Storage->file_exists($aImgInfo['upload_path'].$aImgInfo['upload_name'])){
						$aImgInfo = false;
					}
				}else{
					$aImgInfo = false;
				}
			}
			
			
			if($aImgInfo != false){
				$aData[$val] =
				array(
						'img_path' => $aImgInfo['upload_path'],
						'img_name' => $aImgInfo['upload_name'],
						'img_realname' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] ) ? $aArgs['banner_dotimage_'.$val.'_realname'] : ''
				);
			}else{
				$aData[$val] = 0;
			}
			
			/*unlink replaced stored image*/
			if($this->aDbData['banner_dotimage'][$val]['img_name'] != $aData[$val]['img_name']){
				$sImagePathName = $this->aDbData['banner_dotimage'][$val]['img_path'].$this->aDbData['banner_dotimage'][$val]['img_name'];
				$this->Storage->unlink( $sImagePathName );
			}
		}
		
		
		
		return $aData;
	}
	
	private function addBannerImages($aArgs){
		
		$iBannerImageLimit = 5;
		$aImagesNotToDelete = array();
		
		for($i = 1;$i <= $iBannerImageLimit; $i++){
			
			/*check if input file has value*/
			if($aEventImage = $this->aFile['banner_image_file_'.$i]){
				$aImgInfo = Common::uploadImage($aEventImage,true);
			}else{
				
				if($aArgs['banner_image_realname_'.$i]){
					$aImgInfo['upload_path'] = $aArgs['banner_modify_images_img_path_'.$i];
					$aImgInfo['upload_name'] = $aArgs['banner_modify_images_img_name_'.$i];
						
					if(!$this->Storage->file_exists($aImgInfo['upload_path'].$aImgInfo['upload_name'])){
						$aImgInfo = false;
					}
				}else{
					$aImgInfo = false;
				}
				
			}
			
				
		if($aImgInfo != false){
				$aData[($i-1)] =
					array(
							'img_path' => $aImgInfo['upload_path'],
							'img_name' => $aImgInfo['upload_name'],
							'img_realname' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] ) ? $aArgs['banner_image_realname_'.$i] : '',
							'img_url' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] && $aArgs['banner_image_realname_'.$i]) ? $aArgs['banner_image_url_'.$i] : ''
					);
				
				array_push($aImagesNotToDelete,$aImgInfo['upload_name']);
			}else{
				$aData[($i-1)] = 0;
			}
			
		}
		
		/*delete excess images not in modified data array*/
		foreach($this->aDbData['banner_image'] as $key=>$val){
			if (in_array($val['img_name'], $aImagesNotToDelete) == false) {
				$sImagePathName = $val['img_path'].$val['img_name'];
				$this->Storage->unlink( $sImagePathName );
			}
		}
		
		
		return $aData;
	}
	
	
}
