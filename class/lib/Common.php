<?php
class Common extends Controller_AdminExec
{
	protected function run($aArgs)
	{}
	
	public function uploadImage($sFileElem){
		
		if ( empty($sFileElem) == false ) {
			$aImage = $sFileElem;
			
			$aInfo = pathInfo(  $aImage['filename'] );
			
			$sImgExtension = strtolower($aInfo['extension']);
			
			if ( !in_array($sImgExtension, array('gif', 'jpg', 'jpeg', 'png', 'bmp')) ) {
				return false;
			}
			
			$aImage['upload_name'] = md5(uniqid(rand(), true)) . '.' . $sImgExtension;
			$aImage['upload_path'] = self::getUploadPath().'image/';
			self::makeUploadDir( $aImage['upload_path'] );
			$mResult = $this->Upload->moveUploadedFile($aImage['tmpname'],  $aImage['upload_path'] , $aImage['upload_name'] );
			
			//var_dump($mResult);
				
			if ( $mResult == false) {
				return false;
			}else{
				return $aImage;
			}
		}
		
	}
	
	public function removeImage($sImagePathName){
		if($this->Storage->file_exists($sImagePathName)){
			return $this->Storage->unlink( $sImagePathName );
		}else{
			return false;
		}
	}
	
	
	public function makeUploadDir( $sPath )
	{
		if ( $this->Storage->is_dir( $sPath) ) {
			$this->Storage->mkdir( $sPath , true );
		}
	}
	public function getUploadPath()
	{
		return "public_files/" . date('Y') . "/" .date('m') . "/" . date('d') . "/";
	}
	
	
	
	public function delDir($dirPath) {
		if ($this->Storage->is_dir($dirPath)) {
			$objects = $this->Storage->scandir($dirPath);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if ($this->Storage->filetype($dirPath."/".$object) == "dir"){
						$this->delDir($dirPath."/".$object);
					}else{
						$this->Storage->unlink($dirPath."/".$object);
					}
				}
				reset($objects);
				$this->Storage->rmdir($dirPath);
			}
		}
	}
	
	public function pager($iPage,$iLimit,$iTotCount){
		
		$sData = '';
		//class="current"
		if($iTotCount > 0){
			$iPages = ceil($iTotCount / $iLimit);
			
			if(($iPage-1) > 0){
				$sData .= '<p class="prev"><a href="?page='.($iPage-1).'"></a></p>';
			}
			
			$sData .= '<ol class="eventbanner_pagination pagination np nm nl">';
			
			for($iCounter = 0;$iCounter < $iPages; $iCounter++){
				$iPageStatusClass = (($iCounter+1) == $iPage) ? 'class="current"': '';
				$sData .= '<li><a '.$iPageStatusClass.' href="?page='.($iCounter+1).'">'.($iCounter+1).'</a></li>';
			}
			
			
			$sData .= '</ol>';
			
			if(($iPage+1) <= $iPages){
				$sData .= '<p class="next"><a href="?page='.($iPage+1).'"></a></p>';
			}
			
		}
		
		return $sData;
		
	}
	
	
	/*
	 * @description
	* 	->sort array via array key
	* 
	*  @params
	* 	$array -> (array) array to sort
	* 	$on -> (string) array key to sort with
	*   $order -> () sort to ascending or descending
	*
	* @implementation
	* 
	* foreach( $aData as $key=>$value) {
	*		$aData[$key] = unserialize($value);
	*	}
	*	
	*  return array_sort($aData,'seq',SORT_DESC);
	*
	* */
	public function array_sort($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();
	
		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}
	
			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}
	
			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}
	
		return $new_array;
	}
	
	/*
 	Function to search a Multidimensional array.
	Pass in :
	$theNeedle as what you want to find. 
	$theHaystack as the array 
	$keyToSearch as what key in the array you want to find the value in. 
	 
	 * */
	public function multi_array_search($theNeedle, $theHaystack, $keyToSearch){
		foreach($theHaystack as $theKey => $theValue){
			$intCurrentKey = $theKey;
	
			if($theValue[$keyToSearch] == $theNeedle){
				return $intCurrentKey ;
			}else{
				return 0;
			}
		}
	}
	
	
	
	public function color_inverse($color){
		
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){ return '000000'; }
		$rgb = '';
		for ($x=0;$x<3;$x++){
			$c = 255 - hexdec(substr($color,(2*$x),2));
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
		}
		return $rgb;
	}
	
	
	
	
}