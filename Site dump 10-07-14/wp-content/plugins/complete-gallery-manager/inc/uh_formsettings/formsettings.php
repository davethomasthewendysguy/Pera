<?php

class uh_form_structure { 

	var $type = '';
	var $change_function = '';
	var $filelocation_url = '';
	var $group_show_hide = '';
	var $theme_current_save = '';
	var $current_post_id = '';
	function uh_form_structure($type = 'default' , $change_function = '', $current_post_id = 0){
		$filelocation_array = explode('wp-content',dirname(__FILE__));
		$filelocation_url = trailingslashit(get_option('siteurl')) . 'wp-content' . $filelocation_array[1].'/'; 
		$filelocation_url = str_replace("\\","/",$filelocation_url);//windows based server issue.
		
		$this->filelocation_url = $filelocation_url;
		$this->current_post_id = $current_post_id;
     	wp_register_style( 'uh_formsetting_css', $filelocation_url.'formsettings.css');
    	wp_enqueue_style( 'uh_formsetting_css' );
    	wp_register_script( 'uh_formsettings_js',  $filelocation_url.'uh_formsettings.js');
		wp_enqueue_script( 'uh_formsettings_js' );

		$current_user = wp_get_current_user(); 
		$this->group_show_hide = get_user_meta($current_user->ID,'cgw_show_hide_settings',true);

		$this->type = $type;
		$this->change_function = $change_function;
	}

	function create_form($data,$key,$saved_data = '',$saved_data2 = ''){
		if(!empty($data['help'])){
			$data['help_action']['onMouseOver'] = 'uh_activate_help(this,\''.$data['title'].'\',\''.$data['help'].'\')';
		}	
	
		if(empty($data['extra']['onChange']) && !empty($this->change_function)){
			$data['extra']['onChange'] = $this->change_function.'();';
		}	

		switch ($data['type']) {
    		case 'title':
        		return $this->create_form_title($data,$key,$saved_data);
        		break;
    		case 'number':
       			return $this->create_form_start($data).$this->create_form_number($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;
    		case 'dropdown':
       			return $this->create_form_start($data).$this->create_form_dropdown($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;
    		case 'categorygroup':
       			return $this->create_form_start($data).$this->create_form_categorygroup($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;
	   		case 'categorysort':
       			return $this->create_form_start($data).$this->create_form_categorysort($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;
    		case 'string':
       			return $this->create_form_start($data).$this->create_form_string($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;
    		case 'checkbox':
       			return $this->create_form_start($data).$this->create_form_checkbox($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;
     		case 'textarea':
       			return $this->create_form_start($data).$this->create_form_textarea($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;
    		case 'boolean':
       			return $this->create_form_start($data).$this->create_form_boolean($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;	
    		case 'color':
       			return $this->create_form_start($data).$this->create_form_color($data,$key,$saved_data).$this->create_help($data).$this->create_form_end();
       			break;	
    		case 'div_start':
       			return $this->create_form_div_start($data,$key,$saved_data);
       			break;	
    		case 'div_break':
       			return $this->create_form_div_break($data,$key,$saved_data);
       			break;	
    		case 'div_end':
       			return $this->create_form_div_end($data,$key,$saved_data);
       			break;	
    		case 'groupStart':
       			return $this->create_groupStart($data,$key,$saved_data);
       			break;	
    		case 'groupEnd':
       			return $this->create_groupEnd($data,$key,$saved_data);
       			break;
    		case 'themeselectorStart':
       			return $this->create_form_title($data,$key,$saved_data,'uh_post_theme_h4').$this->create_groupStart($data,$key,$saved_data,'uh_post_group_theme').$this->create_themeselectorStart($data,$key,$saved_data).$this->create_help($data).$this->create_groupEnd($data,$key,$saved_data);
       			break;	
    		case 'themeselectorEnd':
       			return $this->create_themeselectorEnd($data,$key,$saved_data);
       			break;
       		default:
      			return '';
		}
	}
	
	function create_form_title($data,$key,$saved_data = '',$theme_color = ''){
		$tmp = '<div class="uh_post_div" id="'.$theme_color.'" onClick="uh_show_hide_group(this,\''.$data['ID'].'\');" style="cursor:pointer" >';
		$tmp .= '<h4 ';
		
		if(!empty($theme_color)){
			$tmp .= ' class="'.$theme_color.'"';	
		}
		
		if(!empty($data['ID'])){
			$tmp .= 'id="'.$data['ID'].'" ';
		}
		
		$tmp .='>'.$data['title'].'</h4>';

		
		$tmp .= '<div ';
		
		if(empty($this->group_show_hide[$data['ID']]) || $this->group_show_hide[$data['ID']]== 'false' || ($data['ID'] != 'theme_settings')){
			$tmp .= 'class="uh_arrow_down" ';
		} else {
			$tmp .= 'class="uh_arrow_up" ';
		}
		$tmp .= '></div>';
		$tmp .= '</div>';
		return $tmp;
	}
	
	function create_groupStart($data,$key,$saved_data = '',$extraclass = ''){
		$tmp = '<div class="uh_groupClass '.$extraclass.'" ';
		
		if(empty($this->group_show_hide[$data['ID']]) || $this->group_show_hide[$data['ID']]== 'false'){
			$tmp .= 'style="display:block;" ';
		}
		
		if(!empty($data['ID'])){
			$tmp .= 'id="group_'.$data['ID'].'"';
		}		
		$tmp .= ' >';

		return $tmp;
	}
	function create_groupEnd($data,$key,$saved_data){
		$tmp = '</div>';
		return $tmp;
	}

	function create_form_string($data,$key,$saved_data){
	
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
	
	
		$tmp = '<input type="text" class="uh_post_input" name="'.$this->type.'_'.$data['name'].'" value="'.$saved_data.'" ';
		if(!empty($data['extra'])){		
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .=' >';
		return $tmp;
	}
	
	
	
	
	function create_themeselectorStart($data,$key,$saved_data){

		$templatetypelist = array();
		$templatetypeshowlist = array();
		$templatetypeshowlist2 = array();
		$templatetype = 'custom';

		if(!empty($data['slidertype'])){
			$templatetypelist = get_option('cgm-templatetypelist_'.$data['slidertype']);
			
			
			$templatetypedata = json_decode(get_post_meta($this->current_post_id, 'cgm_data',true),true);
			if(!empty($templatetypedata) and !empty($templatetypedata['templatetype_'.$data['slidertype']])){
				$templatetype = $templatetypedata['templatetype_'.$data['slidertype']];
			}
			
		}
		
		if(empty($templatetype)){
			$templatetype = 'custom';
		} 
		
		
		
		$templatetypeshowlist[''] = '-- Select Template --';
		if(!empty($templatetypelist)){
			foreach($templatetypelist as $temp_key => $temp_data){
				$templatetypeshowlist[$temp_key] = $temp_key;
			}
		}

		
		$templatetypeshowlist2 = $templatetypeshowlist;
		
		if(count($templatetypelist) == 0 or (current_user_can('manage_options') || current_user_can('cgm_template_customize'))){
			$templatetypeshowlist['custom'] = 'Custom';
		} 
		
		if(empty($data['name'])){
			$data['name'] = '';
		}

		//main page
		$tmp = '<span id="cgm_template_main" style="width:100%;opacity:1">';
		
		$tmp .= '<table><tr>';
		$tmp .= '<td valign="top"><lable class="uh_post_lable">Select templates :</lable></td>';
		
		$tmp .= '<td valign="top"><img ref="'.$this->type.'_'.$data['name'].'" onClick="uh_activate_help(this,\''.$data['title'].'\',\''.$data['help_main'].'\')" src="'.$this->filelocation_url.'images/question.png" style="margin-right: 2px;margin-top: 3px;cursor:pointer"></td>';
		
		$tmp .= '<td valign="top" width="100%">'.$this->create_form_dropdown(array('extra' => array('onChange'=>'uh_template_changelist(this,\''.$data['slidertype'].'\',\''.$this->filelocation_url.'\');return false;'),'default'=>'custom','name' => 'templatetype_'.$data['slidertype'],'list'=> $templatetypeshowlist),$key,$templatetype).'</td>';
		$tmp .= '</tr><tr>';
		
		$tmp .= '<td valign="top"></td>';
		$tmp .= '<td valign="top"></td>';
		$tmp .= '<td valign="top" width="100%">';
		
		if(current_user_can('manage_options') || current_user_can('cgm_template_customize')){
			$tmp .= '<input class="button-secondary" type="submit" value="Delete menu" onclick="uh_template_goto(\''.$data['ID'].'\',0,2);return false;" style="margin-right:5px;"><input class="button-secondary" type="submit" value="Save Menu" onclick="uh_template_goto(\''.$data['ID'].'\',0,1);return false;">';
		}
		$tmp .= '</td>';

		$tmp .= '</tr></table>';
		$tmp .= '</span>';
		
		// delete page
		$tmp .= '<span id="cgm_template_save" style="opacity: 0; width: 100%; display: none;">';		
		$tmp .= '<table><tr>';
		$tmp .= '<td valign="top"><lable class="uh_post_lable">Select templates :</lable></td>';
		
		$tmp .= '<td valign="top"><img ref="'.$this->type.'_'.$data['name'].'" onClick="uh_activate_help(this,\''.$data['title'].'\',\''.$data['help_save'].'\')" src="'.$this->filelocation_url.'images/question.png" style="margin-right: 2px;margin-top: 3px;cursor:pointer"></td>';
		
		$tmp .= '<td valign="top" width="100%">'.$this->create_form_dropdown(array('extra' => array('onChange'=>'uh_template_saveoverwrite(this,\''.$data['ID'].'\',\''.$this->filelocation_url.'\',\''.$data['slidertype'].'\');return false;'),'default'=>'','name' => 'templatetypelistsave_'.$data['slidertype'],'list'=> $templatetypeshowlist2),$key,'').'</td>';
		$tmp .= '</tr><tr>';
		
		$tmp .= '<td valign="top"></td>';
		$tmp .= '<td valign="top"></td>';
		$tmp .= '<td valign="top" width="100%" style="text-align: center;"><b>or</b></td>';
		$tmp .= '</tr><tr>';
		
		
		$tmp .= '<td valign="top"><lable class="uh_post_lable">New file name :</lable></td>';
		
		$tmp .= '<td valign="top"><img ref="'.$this->type.'_'.$data['name'].'" onClick="uh_activate_help(this,\'Title for new file\',\'Only for new files\')" src="'.$this->filelocation_url.'images/question.png" style="margin-right: 2px;margin-top: 3px;cursor:pointer"></td>';
		
		$tmp .= '<td valign="top" width="100%"><input id="uh_post_input_savenew_files" class="uh_post_input" type="text"></td>';
		$tmp .= '</tr><tr>';		
		
		$tmp .= '<td valign="top"></td>';
		$tmp .= '<td valign="top"></td>';
		
		$tmp .= '<td valign="top" width="100%" id="cgm_template_save_buttons"><input class="button-secondary" type="submit" value="Back" onclick="uh_template_goto(\''.$data['ID'].'\',1,0);return false;" style="margin-right:5px;"><input class="button-primary" type="submit" value="Save as new" onclick="uh_template_save(\''.$data['ID'].'\',\''.$this->filelocation_url.'\',\''.$data['slidertype'].'\');return false;"></span></td>';
		
		$tmp .= '</tr></table>';
		$tmp .= '</span>';
		
		
		
		
		
		
		// save new templates
		$tmp .= '<span id="cgm_template_delete" style="opacity: 0; width: 100%; display: none;">';	
		$tmp .= '<table><tr>';
		$tmp .= '<td valign="top"><lable class="uh_post_lable">Select templates :</lable></td>';
		
		$tmp .= '<td valign="top"><img ref="'.$this->type.'_'.$data['name'].'" onClick="uh_activate_help(this,\''.$data['title'].'\',\''.$data['help_delete'].'\')" src="'.$this->filelocation_url.'images/question.png" style="margin-right: 2px;margin-top: 3px;cursor:pointer"></td>';
		
		$tmp .= '<td valign="top" width="100%">'.$this->create_form_dropdown(array('default'=>'','name' => 'templatetypelistdelete_'.$data['slidertype'],'list'=> $templatetypeshowlist2),$key,'').'</td>';
		$tmp .= '</tr><tr>';

		$tmp .= '<td valign="top"></td>';
		$tmp .= '<td valign="top"></td>';
		$tmp .= '<td valign="top" width="100%" id="cgm_template_delete_buttons"><input class="button-secondary" type="submit" value="Back" onclick="uh_template_goto(\''.$data['ID'].'\',2,0);return false;" style="margin-right:5px;"><input class="button-primary" type="submit" value="Delete" onclick="uh_template_delete(\''.$this->type.'\',\''.$data['slidertype'].'\',\''.$data['ID'].'\',\''.$this->filelocation_url.'\');return false;"></td>';
		
		$tmp .= '</tr></table>';
		$tmp .= '</span>';
		
		return $tmp;
	}	
	
	function create_themeselectorEnd($data,$key,$saved_data = ''){
		return '<script>uh_template_changelist(\'#'.$this->type.'_'.'templatetype_'.$data['slidertype'].'\');</script>';
	}
	
	function create_form_checkbox($data,$key,$saved_data){
	
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
	
		$tmp = '<input type="checkbox" class="uh_post_checkbox" name="'.$this->type.'_'.$data['name'].'" value="true" ';
		
		if($saved_data == 'true'){
			$tmp .= ' checked = "checked" '; 
		}
		if(!empty($data['extra'])){
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .=' >';
		return $tmp;
	}	
	
	function create_form_textarea($data,$key,$saved_data){
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
	
		$tmp = '<textarea class="uh_post_textarea" name="'.$this->type.'_'.$data['name'].'" ';
		if(!empty($data['extra'])){
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .=' >'.$saved_data.'</textarea>';
		return $tmp;
	}
	
	

	function create_form_number($data,$key,$saved_data){
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
	
		$tmp = '<input type="text" onKeyPress="return uh_numbersonly(this, event)" class="uh_post_input_numbers" name="'.$this->type.'_'.$data['name'].'" value="'.$saved_data.'" ';
		if(!empty($data['extra'])){
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .=' >';		
		
		return $tmp;
	}
	
	
	function create_form_categorygroup($data,$key,$saved_data){
		$tmp = '';
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
		$tmp .= '<table><tr><td style="width:100%">';
		$tmp .= '<input id="'.$this->type.'_'.$data['name'].'_add" class="uh_post_input" >';
		$tmp .= '</td><td>';
		$tmp .= '<input type="submit" value="Add" onclick="uh_categorygroup_add(\''.$this->type.'\',\''.$data['name'].'\');return false;" class="button-secondary" style="margin-left: 10px; margin-right: -2px;">';
		$tmp .= '</td></tr></table>';
		
		$tmp .= '<input type="hidden" id="'.$this->type.'_'.$data['name'].'" class="uh_post_input" name="'.$this->type.'_'.$data['name'].'" value="'.$saved_data.'" >';
		
		$tmp .= '<div id="'.$this->type.'_'.$data['name'].'_list" class="'.$this->type.'_categorygroup">';
		
		
		if(!empty($this->current_post_id)){
			$lock_terms = wp_get_post_terms($this->current_post_id,'cgm-category'); 
		}
		
	  	$create_default_categoryes = '';
		$taxonomies=get_categories(array('hide_empty' => 0,'taxonomy' => 'cgm-category'));
		
		
		
		if(!empty($saved_data)){
			$saved_data = json_decode(urldecode($saved_data));
			
			foreach($saved_data as $tmp_data){
				$create_default_categoryes = '';
				
				if(!empty($taxonomies)){
					foreach($taxonomies as $taxonomie){
						$create_default_categoryes_tmp = '<input  style="margin-right: 4px;" type="checkbox" id="categoryid'.$taxonomie->term_id.'" value="'.$taxonomie->term_id.'" onChange="uh_categorygroup_ref(\''.$this->type.'\',\''.$data['name'].'\');"';
						
						if(!empty($tmp_data->data)){
							foreach($tmp_data->data as $cat){
								if($cat == $taxonomie->term_id){
									$create_default_categoryes_tmp .= ' checked="checked" ';
									break;
								}
							}
						}
						$create_default_categoryes_tmp .= ' >'.$taxonomie->name.'<br>';
						
						if(!empty($lock_terms)){
							foreach($lock_terms as $lock_term){
								if($lock_term->term_id == $taxonomie->term_id){
									$create_default_categoryes .= $create_default_categoryes_tmp;
									break;
								}
							}
						} else {
							$create_default_categoryes .= $create_default_categoryes_tmp;	
						}
					}	
				}


				$tmp .= '<span style="margin-top: 20px; display: block;"><table><tr><td style="width:100%">';
				$tmp .= '<input onkeyup="uh_categorygroup_ref_key(\''.$this->type.'\',\''.$data['name'].'\')" class="uh_post_input" value="'.$tmp_data->name.'" >';
				$tmp .= '</td><td>';	
				$tmp .= '<input type="submit" value="Remove" onclick="uh_categorygroup_remove(this,\''.$this->type.'\',\''.$data['name'].'\');return false;" class="button-secondary" style="margin-left: 10px; margin-right: -2px;">';
				$tmp .= '</td></tr><tr><td colspan="2"><div class="cgm_categorychecklist_checkuplist" style="width:100%;max-height:100px;overflow: auto;">';
				$tmp .= $create_default_categoryes;
				$tmp .= '</div></td></tr></table></span>';
			}
		}
		
		$tmp .= '</div>';

		return $tmp;
		
	}
	
	
	
	
	
	function create_form_categorysort($data,$key,$saved_data){
		$tmp = '';
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
		
		
		$tmp .= '
<script>
jQuery(function() {

	jQuery( "#cgm_filtersDirrection").change(function(){
		if(jQuery(this).val() == \'MANUALT\'){
			jQuery("#'.$this->type.'_'.$data['name'].'_div").parent().parent().parent().parent().parent().show();
		} else {
			jQuery("#'.$this->type.'_'.$data['name'].'_div").parent().parent().parent().parent().parent().hide();
		
		}
	
	});
	setTimeout(function() {
		if(jQuery( "#cgm_filtersDirrection").val() == \'MANUALT\'){
			jQuery("#'.$this->type.'_'.$data['name'].'_div").parent().parent().parent().parent().parent().show();
		} else {
			jQuery("#'.$this->type.'_'.$data['name'].'_div").parent().parent().parent().parent().parent().hide();
		}
	},100);


	jQuery( "#'.$this->type.'_'.$data['name'].'_div #sortable" ).sortable({
	revert: true,
	placeholder: "ui-state-highlight",
	stop: function() {uh_categorysort_pos(\'#'.$this->type.'_'.$data['name'].'\');}
	});

});
</script>';
		
		
		$create_default_categoryes = '';
		$taxonomies=get_categories(array('hide_empty' => 0,'taxonomy' => 'cgm-category','orderby' => 'name'));
		
		
		$tmp .= '<input type="hidden" id="'.$this->type.'_'.$data['name'].'" class="uh_post_input" name="'.$this->type.'_'.$data['name'].'" value="'.$saved_data.'" >';
		$tmp .= '<div id="'.$this->type.'_'.$data['name'].'_div" class="uh_post_sort"><ul id="sortable">';
		
		if(!empty($saved_data)){
			$saved_data = explode(',',$saved_data);
			if(is_array($saved_data) and count($saved_data)>0){
				foreach($saved_data as $tmp_data){
					if(!empty($taxonomies)){
						foreach($taxonomies as $ttkey => $taxonomie){
							if($tmp_data == $taxonomie->term_id){
								$tmp .= '<li datatmp="'.$taxonomie->term_id.'"><div>'.$taxonomie->name.'</div></li>';
								unset($taxonomies[$ttkey]);
								break;
							}
						}
					}	
				}
			}
		}
		
		if(!empty($taxonomies)){	
			foreach($taxonomies as $ttkey => $taxonomie){
				$tmp .= '<li datatmp="'.$taxonomie->term_id.'"><div>'.$taxonomie->name.'</div></li>';
			}
		}
		
		$tmp .= '</ul>';
		$tmp .= '</div>';

		return $tmp;
		
	}
	
	
	
	

	function create_form_dropdown($data,$key,$saved_data){
		$tmp = '';
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
		$tmp .= '<select  id="'.$this->type.'_'.$data['name'].'" name="'.$this->type.'_'.$data['name'].'" class="uh_post_dropdown" ';
		if(!empty($data['extra'])){
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .= ' >';
		
		foreach($data['list'] as  $key => $list_tmp){
			$tmp 	.='<option value="'.$key.'" ';
			
			if($key == $saved_data && $key != '---' && $key != '----'){
				$tmp 	.= ' selected="selected" ';
			}
			
			if( ($key == '---' || $key == '----') && !empty($key)){
			$tmp 	.= ' disabled="disabled" ';
			}
			$tmp 	.='>'.__($list_tmp,$this->type).'</option>';
		}
		
		$tmp .='</select>';
		return $tmp;
		
	}
	
	function create_form_boolean($data,$key,$saved_data){
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			}			
		} else if($saved_data == '-0-') {
			$saved_data = '';
		}
	
		if(!empty($data['extra']['onChange'])){
			$data['extra2']['onChange'] = $data['extra']['onChange'];
		}

		$data['extra']['onChange'] = '';	
	
		$tmp = '<div style="margin-top: 4px;"';
		$tmp .= '>';
		$tmp .= '<input type="radio" class="uh_post_radio" name="'.$this->type.'_'.$data['name'].'" value="true" ';
		if(!empty($data['extra2'])){
			$tmp .= $this->create_form_extra($data['extra2']);
		}
		
		if($saved_data == 'true'){
			$tmp .= ' checked="checked" ';
		}
		$tmp .= ' > <lable>'.__('Yes',$this->type ).'</lable> ';
		$tmp .= '<input type="radio" class="uh_post_radio" name="'.$this->type.'_'.$data['name'].'" value="false" ';
		if(!empty($data['extra2'])){
			$tmp .= $this->create_form_extra($data['extra2']);
		}
		
		if($saved_data == 'false' || empty($saved_data)){
			$tmp .= ' checked="checked" ';
		}
		$tmp .= ' > <lable>'.__('No',$this->type ).'</lable></div>';
		return $tmp;
	}
	
	function create_form_color($data,$key,$saved_data){
		if(empty($saved_data) and $saved_data != '-0-'){
			if(!empty($data['default'])){
				$saved_data = $data['default'];
			} else {
				$saved_data = "#";
			}		
		} else if($saved_data == '-0-') {
			$saved_data = "#";
		}

		$tmp = 	 '<div class="farbtastic-holder">';
		$tmp .= 		'<input type="text" onKeyUp="uh_check_color(this);" value="'.$saved_data.'" class="uh_post_color show-colorpicker" name="'.$this->type.'_'.$data['name'].'" id="cs_menu_current_font_color'.$key.'" ';
		if(!empty($data['extra'])){
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .=' >';		
		$tmp .= 		'<div class="pop-farbtastic" rel="#cs_menu_current_font_color'.$key.'" id="pop-farbtastic-'.$key.'" style="float:left;display: block;">';
		$tmp .= 			'<div class="farbtastic">';
		$tmp .=					'<div class="color" style="background-color: rgb(255, 0, 0);"></div>';
		$tmp .=					'<div class="wheel"></div>';
		$tmp .=					'<div class="overlay"></div>';
		$tmp .=					'<div class="h-marker marker" style="left: 97px; top: 13px;"></div>';
		$tmp .=					'<div class="sl-marker marker" style="left: 147px; top: 147px;"></div>';
		$tmp .=				'</div>';
		$tmp .=			'</div>';
		$tmp .=		'</div>';
		return $tmp;
	}

	function create_form_start($data){
		$tmp = '<div class="uh_post_div">';
		$tmp .= '<table width=100%><tr>';
		

		$tmp .= '<td valign="top">';
		$tmp .= '<lable class="uh_post_lable" ';
		if(!empty($data['extra_lable'])){
			$tmp .= $this->create_form_extra($data['extra_lable']);
		}
		$tmp .= ' >'.$data['title'].' :</lable>';
		$tmp .= '</td><td valign="top">';
		if(!empty($data['help_action']['onMouseOver'])){
			$tmp .= '<img ref="'.$this->type.'_'.$data['name'].'" onClick="'.$data['help_action']['onMouseOver'].'" src="'.$this->filelocation_url.'images/question.png" style="margin-right: 2px;margin-top: 3px;cursor:pointer">';
		}
		
		
		$tmp .= '</td><td valign="top" width="100%">';
		return $tmp;
	}
	function create_form_end(){
		$tmp = '</td></tr></table>';
		$tmp .='</div>';
		return $tmp;
	}

	function create_form_extra($extra){
		$tmp = '';
		if(!empty($extra)){
			foreach($extra as $key_tmp => $data_tmp){
				$tmp .= ' '.$key_tmp.'="'.$data_tmp.'" ';
			}
		}
		return $tmp;
	}
	
	function create_form_div_start($data,$key,$saved_data){
		$tmp = '<script type="text/javascript"> var uh_form_URL = \''.$this->filelocation_url .'\';;var uh_call_preview_function = \''.$this->change_function .'\'</script>';
		$tmp .= '<div class="uh_post_div_col" ';
		
		$data['extra']['onChange'] = '';
	
	
	
		if(!empty($data['extra'])){
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .= ' >';
		return $tmp;
	}
	
	function create_form_div_break($data,$key,$saved_data){
		$tmp = '</div><div class="uh_post_div_col" ';
		
		$data['extra']['onChange'] = '';
		if(!empty($data['extra'])){
			$tmp .= $this->create_form_extra($data['extra']);
		}
		$tmp .= ' >';
		return $tmp;
	}
	
	function create_form_div_end($data,$key,$saved_data){

		$tmp = '</div><div class="uh_post_div_clear"></div>';
		return $tmp;
	}
	
	function create_help($data){
		$tmp = '';
		return $tmp;
	}		
}
?>
