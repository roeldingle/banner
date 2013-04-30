<?php

/*include common class */
require_once('lib/DB.php');
require_once('lib/Common.php');

/*
 * controller to view event listing
 * */
class adminIndex extends Controller_Admin
{
	/*class construct*/
    protected function run($aArgs){
    	$this->initTemplate();
    	$this->assignData($aArgs);
    	$this->setView();
    }
    
    /*template getter*/
    private function initTemplate(){
    	
    	$this->UIPackage->addPlugin('Dialog');
    	
    	$this->importJS('libs/common');
    	$this->importJS('index');
    	
    	$this->importCSS('libs/common');
    	$this->importCSS('app');
    }
    
    /*template setter*/
    private function setView(){
    	$bView = $this->View();
    	if ($bView!==false) {
    		$this->setStatusCode('200');
    	}
    }
    
    /*assign table listing and pagination*/
    private function assignData($aArgs)
    {
    	$aData =  DB::select_all(libKey::BA_KEY);
    	$iPage = isset($aArgs['page']) ? $aArgs['page'] : 1;
    	$iLimit = 10;
    	$iOffset = ($iPage - 1) * $iLimit;
    	$iTotCount = count($aData);
    	$aData = array_slice($aData,$iOffset,$iLimit);
    	$this->assign('sPagination',Common::pager($iPage,$iLimit,$iTotCount));
    	$this->assign('sHtmlTbData',$this->getHtmlTbData($aData,$aArgs));
    	
    	$this->assign('aTest',$aData);
    }
    
    /*will loop data array and create html rows*/
    public function getHtmlTbData($aData,$aArgs){
    	$sHtmlData = '';
    	if(!empty($aData)){ 
    		foreach($aData as $key=>$val){
    			if(!isset($val['banner_event']['title'])){
    				$sPathName = $val['banner_event']['img_path'].$val['banner_event']['img_name'];
    				$aImageDim =  $this->Storage->getimagesize(($sPathName));
    				$sImageSize = $aImageDim[0];
    				$sTitle = 'Event title '.$val['seq'];
    				
    				$sTitle = '<td class="subject">
		    						<ul class="title">
			    						<li><a href="[link=admin/Modify]?event='.$val['seq'].'"  ><span style="padding-bottom:50px;">[Image '.$val['banner_event']['img_realname'].']</span></a>
			    						<a href="javascript:void(0)" title="'.$sTitle.'/'.$sImageSize.'" alt="[pfile='.str_replace('public_files/','',$val['banner_event']['img_path']).$val['banner_event']['img_name'].']"   class="preview_img btn btn_search02"><em class="ir icoFind">Search</em></a></li>
		    						</ul>
    						</td>';
    				
    			}else{
    				$sTitle = '<td class="subject" ><a href="[link=admin/Modify]?event='.$val['seq'].'" >'.$val['banner_event']['title'].'</a></td>';
    				$sImageSize = $val['banner_event']['width'];
    			}
    			
    			$sHtmlData .= '<tr class="alternate">';
    			$sHtmlData .= '<td class="table_first"><input type="checkbox" name="banner_ids[]" class="chk_lists"  value="'.$val['seq'].'" /></td>';
    			$sHtmlData .= '<td>'.($key+1).'</td>';
    			$sHtmlData .= '<td>Banner_event_'.$val['seq'].'</td>';
    			$sHtmlData .= $sTitle;
    			
    			if(!$sImageSize){
    				$sImageSize = '<img src="[pfile='.str_replace('public_files/','',$val['banner_event']['img_path']).$val['banner_event']['img_name'].']" style="display:none;" />';
    			}else{
    				$sImageSize = $sImageSize;
    			}
    			
    			
    			$sHtmlData .= '<td class="banner_tbtd_img_size">'.$sImageSize.'</td>';
    			$sHtmlData .= '<td>'.date('Y-m-d',$val['datereg']).'</td>';
    			$sHtmlData .= '<td class="eventbanner_toggle gBtn">';
    			$sHtmlData .= '<a href="#" class="active">';
    			$sHtmlData .= ($val['active'] == 1) ? "Active" : "Inactive";
    			$sHtmlData .= '</a>';
    			$sHtmlData .= '<a href="#"  class="button status_btn btn btnstatus" title="'.$val['seq'].'" alt="'.$val['active'].'" >';		
    			$sHtmlData .= ($val['active'] != 1) ? "<span>Activate</span>" : "<span>Deactivate</span>";
    			$sHtmlData .= '</a>';
    			$sHtmlData .= '</td>';
    			$sHtmlData .= '</tr>';
    		} 
    	}else{ 
    		$sHtmlData .= '<tr><td colspan="7">No record(s)</td></tr>';
    	} 
    	return 	$sHtmlData;
    }
    
    
}
