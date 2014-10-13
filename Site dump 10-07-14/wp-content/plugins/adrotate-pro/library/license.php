<?php
/*  
Copyright 2010-2013 Arnan de Gans - AJdG Solutions (email : info@ajdg.net)
*/

/*-------------------------------------------------------------
 Name:      AJdG Solutions Licensing Library
 Version:	1.0.1
-------------------------------------------------------------*/

function adrotate_license_activate() {
	if(wp_verify_nonce($_POST['adrotate_nonce_license'], 'adrotate_license')) {
		$a = array();
		if(isset($_POST['adrotate_license_key'])) $a['k'] = trim($_POST['adrotate_license_key'], "\t\n ");
		if(isset($_POST['adrotate_license_email'])) $a['e'] = trim($_POST['adrotate_license_email'], "\t\n ");

		if(!empty($a['k']) AND !empty($a['e'])) {
			list($a['v'], $a['l'], $a['s']) = explode("-", $a['k'], 3);
			if(!preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $a['e'])) {
				adrotate_return('adrotate-settings', 603);
				exit();
			}
			$a['i'] = uniqid(rand(1000,9999));
			$a['u'] = get_option('siteurl');
			
			if(strtolower($a['l']) == "s") $a['l'] = "Single";
			if(strtolower($a['l']) == "d") $a['l'] = "Duo";
			if(strtolower($a['l']) == "m") $a['l'] = "Multi";
			if(strtolower($a['l']) == "u") $a['l'] = "Developer";
	
			if($a) adrotate_license_response('activation', $a);
			adrotate_return('adrotate-settings', 604);
		} else {
			adrotate_return('adrotate-settings', 601);
			exit;
		}
	} else {
		adrotate_nonce_error();
		exit;
	}
}

function adrotate_license_deactivate() {
	if(wp_verify_nonce($_POST['adrotate_nonce_license'], 'adrotate_license')) {
		$a = get_option('adrotate_activate');
		if($a) adrotate_license_response('deactivation', $a);
		adrotate_return('adrotate-settings', 600);
	} else {
		adrotate_nonce_error();
		exit;
	}
}

function adrotate_license_deactivate_uninstall() {
	$a = get_option('adrotate_activate');
	if($a) adrotate_license_response('deactivation', $a, true);
}

function adrotate_license_reset() {
	if(wp_verify_nonce($_POST['adrotate_nonce_license'], 'adrotate_license')) {
		$a = get_option('adrotate_activate');
		if($a) adrotate_license_response('activation_reset', $a);
		adrotate_return('adrotate-settings', 600);
	} else {
		adrotate_nonce_error();
		exit;
	}
}

function adrotate_license_response($request = '', $a = array(), $uninstall = false) {
	$license_domain = 'http://www.adrotateplugin.com';
	//$license_domain = 'http://dev4.ajdg.net';

	$args = $license = array();
	if($request == 'activation') $args = array('request' => 'activation', 'email' => $a['e'], 'licence_key' => $a['k'], 'product_id' => $a['l'], 'instance' => $a['i'], 'platform' => $a['u']);
	if($request == 'deactivation') $args = array('request' => 'deactivation', 'email' => $a['email'], 'product_id' => $a['type'], 'licence_key' => $a['key'], 'instance' => $a['instance']);
	if($request == 'activation_reset') $args = array('request' => 'activation_reset', 'email' => $a['email'], 'product_id' => $a['type'], 'licence_key' => $a['key']);

	$response = wp_remote_get(add_query_arg('wc-api', 'software-api', $license_domain) . '&' . http_build_query($args));
		
	if($uninstall) return;

    if(!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300) {
		$data = json_decode($response['body'], 1);
		
		if(empty($data['code'])) $data['code'] = 0;

		if($data['code'] == 100) {
			adrotate_return('adrotate-settings', 600);
			exit;
		} else if($data['code'] == 101) {
			adrotate_return('adrotate-settings', 604);
			exit;
		} else if($data['code'] == 102) {
			adrotate_return('adrotate-settings', 605);
			exit;
		} else if($data['code'] == 103) {
			adrotate_return('adrotate-settings', 606);
			exit;
		} else if($data['code'] == 104) {
			adrotate_return('adrotate-settings', 607);
			exit;
		} else if($data['code'] == 0 && $data['activated'] == 1) {
			update_option('adrotate_activate', array('status' => 1, 'instance' => $a['i'], 'activated' => current_time('timestamp'), 'deactivated' => '', 'type' => $a['l'], 'key' => $a['k'], 'email' => $a['e'], 'version' => $a['v'], 'firstrun' => 0));
			unset($a, $args, $response, $data);
			if($request == 'activation') adrotate_return('adrotate-settings', 608);
			exit;
		} else if($data['code'] == 0 && $data['reset'] == 1) {
			update_option('adrotate_activate', array('status' => 0, 'instance' => '', 'activated' => $a['activated'], 'deactivated' => current_time('timestamp'), 'type' => '', 'key' => '', 'email' => '', 'version' => '', 'firstrun' => 1));
			unset($a, $args, $response, $data);
			if($request == 'deactivation') adrotate_return('adrotate-settings', 609);
			if($request == 'activation_reset') adrotate_return('adrotate-settings', 610);
			exit;
		} else {
			adrotate_return('adrotate-settings', 600);
			exit;
		}
	} else {
		adrotate_return('adrotate-settings', 602);
		exit;
	}
}
?>