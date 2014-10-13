<?php

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');

  
global $cgm_admin_post_list;

function send_error_die($msg){
	die(json_encode(array('R'=>'ERR','MSG'=>$msg)));
}

if(!is_user_logged_in()){
	send_error_die(__('You are not logged in.','act'));
}


if($_POST['cqw_list_type'] != 'grid'){
	$CLASSTYPE1 = 'object-listtype1';	 	
} else if($_POST['cqw_list_type'] == 'grid'){
	$CLASSTYPE1 = 'object-gridtype1';	 	
}

$result = '';
$count = $_POST['cgm_current_img_selelcted'];

if(!empty($_POST['listDataImage']) && !empty($_POST['listDataPost'])){
	$my_wp_query = new WP_Query();
	
	
	if($_POST['listDataImage'] == 'postc'){
		$querys = $my_wp_query->query(  array('posts_per_page'=>-1, 'category__in' => explode(',',$_POST['listDataPost'])));
		$listDataPost = array();
		$listDataImages = array();
		foreach($querys as $query){
			if(has_post_thumbnail($query->ID))
			{
				$listDataPost[$query->ID] = $query->ID;
				$listDataImages[$query->ID] = get_post_thumbnail_id($query->ID);
			}
			
		}
	} else if($_POST['listDataImage'] == 'pagep'){
		$all_wp_pages = $my_wp_query->query(array('post_type' => 'page','orderby' => 'title', 'order' => 'ASC','post_status'     => 'publish','numberposts' => -1));
		$tmp_datas = explode(",", $_POST['listDataPost']);	
		$listDataPost = array();
		$listDataImages = array();		
		
		foreach($tmp_datas as $tmp_data)
		{
			$portfolio_childrens = get_page_children($tmp_data, $all_wp_pages);
			foreach($portfolio_childrens as $portfolio_children)
			{
				if(has_post_thumbnail($portfolio_children->ID))
				{
					$listDataPost[$portfolio_children->ID] = $portfolio_children->ID;
					$listDataImages[$portfolio_children->ID] = get_post_thumbnail_id($portfolio_children->ID);
				}
			}
		}
	} else {
		$listDataImages = explode(",", $_POST['listDataImage']);
		$listDataPost = explode(",", $_POST['listDataPost']);	
	}

	if(!empty($listDataImages)){
		foreach($listDataImages as	$tmp_key => $listDataImage){
			$temp_content = '';
			if($_POST['datatype'] == 'gallery' and !empty($listDataImage)){
				$temp_content = get_post_meta($listDataPost[$tmp_key], 'cgm_comments', true);
			}
		
		
			$result .= $cgm_admin_post_list->create_template(array('[CLASSTYPE1]'=> $CLASSTYPE1,
													  '[TITLE]'=>'',
													  '[CONTENT]'=>	$temp_content,
													  '[LINK]'=>'',
													  '[POSTID]'=> $listDataImage,
													  '[CGM-MAIN_SHOW]'=> true,
													  '[INDEXNUMBER]'=> $count,
													  '[TYPEOBJECT]' => $_POST['datatype'],
													  '[ATTACTEDID]' => $listDataPost[$tmp_key],
													  '[CATEGORY]'=> ''),false,$_POST['currentid']);
	
			$count++;
		}	
	}

} else {
	$result= array('R'=>'ERROR','MSG' => 'Missing data');
	die(json_encode($result));
}

$result= array('R'=>'OK','DATA' => $result,'COUNT' => ($count-$_POST['cgm_current_img_selelcted']));
die(json_encode($result));	 
?>