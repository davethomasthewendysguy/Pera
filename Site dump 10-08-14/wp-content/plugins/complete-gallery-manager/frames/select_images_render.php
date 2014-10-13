<?php
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
require_once('../../../../wp-load.php');

  
global $cgm_admin_post_list;




if($_POST['cqw_list_type'] != 'grid'){
	$CLASSTYPE1 = 'object-listtype1';	 	
} else if($_POST['cqw_list_type'] == 'grid'){
	$CLASSTYPE1 = 'object-gridtype1';	 	
}

$result = '';
$count = $_POST['cgm_current_img_selelcted'];

if(!empty($_POST['cgm_load_id_list'])){
	$pieces = explode(",", $_POST['cgm_load_id_list']);

	foreach($pieces as $piece){
	
		$post_tmp = get_post($piece); 
		$result .= $cgm_admin_post_list->create_template(array('[CLASSTYPE1]'=> $CLASSTYPE1,
												  '[TITLE]'=> $post_tmp->post_title,
												  '[CONTENT]'=>	$post_tmp->post_content,
												  '[LINK]'=> get_permalink( $piece ),
												  '[POSTID]'=> $piece,
												  '[CGM-MAIN_SHOW]'=> true,
												  '[INDEXNUMBER]'=> $count,
												  '[TYPEOBJECT]' => 'image',
												  '[ATTACTEDID]' => '',
												  '[CATEGORY]'=> ''),false,$_POST['currentid']);

		$count++;
	}
}
$result= array('R'=>'OK','DATA' => $result);
echo json_encode($result);	 
?>