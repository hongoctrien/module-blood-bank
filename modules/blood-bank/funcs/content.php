<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 10 May 2015 01:36:45 GMT
 */

if ( ! defined( 'NV_IS_MOD_BLOOD_BANK' ) ) die( 'Stop!!!' );

if( ! nv_user_in_groups( $array_config['groups_view_member'] ) )
{
	$redirect = '<meta http-equiv="Refresh" content="4;URL=' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php', true ) . '" />';
	nv_info_die( $lang_module['error_not_permission_title'], $lang_module['error_not_permission_title'], $lang_module['error_not_permission_content'] . $redirect );
	exit();
}

if( !defined( 'NV_IS_USER' ) )
{
	Header( 'Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
	die();
}

if( $nv_Request->isset_request( 'get_district', 'post' ) )
{
	$option = '';
	$provinceid = $nv_Request->get_string( 'provinceid', 'post', '' );
	$sl_district = $nv_Request->get_string( 'sl_district', 'post', '' );

	if( empty( $provinceid ) ) die();

	$result = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_location_district WHERE provinceid=' . $db->quote( $provinceid ) );
	while( $row = $result->fetch() )
	{
		$sl = $sl_district == $row['districtid'] ? 'selected="selected"' : '';
		$row['name'] = is_numeric( $row['name'] ) ? $row['type'] . ' ' . $row['name'] : $row['name'];
		$option .= '<option value="' . $row['districtid'] . '" ' . $sl . ' >' . $row['name'] . '</ontion>';
	}
	die( $option );
}

if( $nv_Request->isset_request( 'get_ward', 'post' ) )
{
	$option = '';
	$districtid = $nv_Request->get_string( 'districtid', 'post', '' );
	$sl_ward = $nv_Request->get_string( 'sl_ward', 'post', '' );

	if( empty( $districtid ) ) die();

	$result = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_location_ward WHERE districtid=' . $db->quote( $districtid ) );
	while( $row = $result->fetch() )
	{
		$sl = $sl_ward == $row['wardid'] ? 'selected="selected"' : '';
		$row['name'] = is_numeric( $row['name'] ) ? $row['type'] . ' ' . $row['name'] : $row['name'];
		$option .= '<option value="' . $row['wardid'] . '" ' . $sl . ' >' . $row['name'] . '</ontion>';
	}
	die( $option );
}

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
$error = array();
$array_data = array();
$array_user = array();
$is_success = 0;

$result = $db->query( 'SELECT email, first_name, last_name, gender, birthday FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $user_info['userid'] );
$array_user = $result->fetch();

$result = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE userid=' . $user_info['userid'] );
if( $result->rowCount() )
{
	$array_data = $result->fetch();
}
else
{
	$array_data['id'] = 0;
	$array_user['first_name'] = $array_user['first_name'];
	$array_user['last_name'] = $array_user['last_name'];
	$array_user['birthday'] = $array_user['birthday'];
	$array_user['gender'] = $array_user['gender'];
	$array_data['phone'] = '';
	$array_data['identity_card'] = '';
	$array_data['blood_group'] = '';
	$array_data['rh_'] = 0;
	$array_data['width'] = '';
	$array_data['weight'] = '';
	$array_data['recent_time'] = '';
	$array_data['platelet'] = 0;
	$array_data['organizetype'] = 0;
	$array_data['organize'] = '';
	$array_data['resident'] = 0;
	$array_data['temporarily'] = 0;
	$array_data['resident_p'] = '';
	$array_data['resident_d'] = '';
	$array_data['resident_w'] = '';
	$array_data['temporarily_p'] = '';
	$array_data['temporarily_d'] = '';
	$array_data['temporarily_w'] = '';
	$array_data['temporarily_s'] = '';
	$array_data['fcode'] = '';
}

if( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$array_user['first_name'] = $nv_Request->get_title( 'first_name', 'post', '' );
	$array_user['last_name'] = $nv_Request->get_title( 'last_name', 'post', '' );
	$array_user['gender'] = $nv_Request->get_title( 'gender', 'post', 'N' );
	$array_data['phone'] = $nv_Request->get_title( 'phone', 'post', '' );
	$array_data['identity_card'] = $nv_Request->get_title( 'identity_card', 'post', '' );
	$array_data['blood_group'] = $nv_Request->get_title( 'blood_group', 'post', '' );
	$array_data['rh_'] = $nv_Request->get_int( 'rh_', 'post', 0 );
	$array_data['width'] = $nv_Request->get_title( 'width', 'post', 0 );
	$array_data['weight'] = $nv_Request->get_title( 'weight', 'post', 0 );
	$array_data['recent_time'] = $nv_Request->get_title( 'recent_time', 'post', '' );
	$array_data['platelet'] = $nv_Request->get_int( 'platelet', 'post', 0 );
	$array_data['organizetype'] = $nv_Request->get_title( 'organizetype', 'post', 0 );
	$array_data['organize'] = $nv_Request->get_title( 'organize', 'post', '' );
	$array_data['fcode'] = $nv_Request->get_title( 'fcode', 'post', '' );

	$array_data['resident_p'] = $nv_Request->get_title( 'province1', 'post', 0 );
	$array_data['resident_d'] = $nv_Request->get_title( 'district1', 'post', 0 );
	$array_data['resident_w'] = $nv_Request->get_title( 'ward1', 'post', 0 );

	$array_data['temporarily_p'] = $nv_Request->get_title( 'province2', 'post', 0 );
	$array_data['temporarily_d'] = $nv_Request->get_title( 'district2', 'post', 0 );
	$array_data['temporarily_w'] = $nv_Request->get_title( 'ward2', 'post', 0 );
	$array_data['temporarily_s'] = $nv_Request->get_title( 'temporarily_s', 'post', '' );

	$count_identity_card = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE identity_card=' . $db->quote( $array_data['identity_card'] ) . ' AND id != ' . $array_data['id'] )->fetchColumn();

	if( empty( $array_user['first_name'] ) )
	{
		$error[] = $lang_module['error_first_name'];
	}
	if( empty( $array_user['last_name'] ) )
	{
		$error[] = $lang_module['error_last_name'];
	}
	if( empty( $array_data['identity_card'] ) )
	{
		$error[] = $lang_module['error_identity_card'];
	}
	elseif( $count_identity_card > 0 )
	{
		$error[] = $lang_module['error_identity_card_exist'];
	}
	if( ! nv_capcha_txt( $array_data['fcode'] ) )
	{
		$error[] = $lang_module['error_captcha'];
	}

	if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'birthday', 'post' ), $m ) )
	{
		$_hour = 0;
		$_min = 0;
		$array_user['birthday'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$array_user['birthday'] = 0;
	}

	if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'recent_time', 'post' ), $m ) )
	{
		$_hour = 0;
		$_min = 0;
		$array_data['recent_time'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$array_data['recent_time'] = 0;
	}

	if( empty( $array_user['birthday'] ) )
	{
		$error[] = $lang_module['error_birthday'];
	}

	if( empty( $error ) )
	{
		// Cap nhat thong tin thanh vien
		$sth = $db->prepare( 'UPDATE ' . NV_USERS_GLOBALTABLE . ' SET first_name=:first_name,last_name=:last_name,gender=:gender,birthday=:birthday WHERE userid=:userid' );
		$sth->bindParam( ':first_name', $array_user['first_name'], PDO::PARAM_STR );
		$sth->bindParam( ':last_name', $array_user['last_name'], PDO::PARAM_STR );
		$sth->bindParam( ':gender', $array_user['gender'], PDO::PARAM_STR );
		$sth->bindParam( ':birthday', $array_user['birthday'], PDO::PARAM_STR );
		$sth->bindParam( ':userid', $user_info['userid'], PDO::PARAM_INT );
		$sth->execute();
		unset( $sth );

		$count = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE userid=' . $user_info['userid'] )->fetchColumn();
		if( $count > 0 )
		{
			$sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET last_name=:last_name,first_name=:first_name,birthday=:birthday,gender=:gender,phone=:phone,identity_card=:identity_card,blood_group=:blood_group,rh_=:rh_,width=:width,weight=:weight,recent_time=:recent_time,platelet=:platelet,organizetype=:organizetype,organize=:organize,resident_p=:resident_p, resident_d=:resident_d, resident_w=:resident_w, temporarily_p=:temporarily_p, temporarily_d=:temporarily_d,temporarily_w=:temporarily_w, temporarily_s=:temporarily_s WHERE userid=:userid' );
		}
		else
		{
			$email = $db->query( 'SELECT email FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $user_info['userid'] )->fetchColumn();

			$sth = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (userid, last_name, first_name, birthday, email, gender, phone, identity_card, blood_group, rh_, width, weight, recent_time, platelet, organizetype, organize, resident_p, resident_d, resident_w, temporarily_p, temporarily_d, temporarily_w, temporarily_s) VALUES
			( :userid,:last_name,:first_name,:birthday,:email,:gender,:phone,:identity_card,:blood_group,:rh_,:width,:weight,:recent_time,:platelet, :organizetype, :organize,:resident_p, :resident_d, :resident_w,:temporarily_p, :temporarily_d, :temporarily_w, :temporarily_s )' );
			$sth->bindParam( ':email', $email, PDO::PARAM_INT );
		}
		$sth->bindParam( ':userid', $user_info['userid'], PDO::PARAM_INT );
		$sth->bindParam( ':first_name', $array_user['first_name'], PDO::PARAM_STR );
		$sth->bindParam( ':last_name', $array_user['last_name'], PDO::PARAM_STR );
		$sth->bindParam( ':gender', $array_user['gender'], PDO::PARAM_STR );
		$sth->bindParam( ':birthday', $array_user['birthday'], PDO::PARAM_STR );
		$sth->bindParam( ':phone', $array_data['phone'], PDO::PARAM_STR );
		$sth->bindParam( ':identity_card', $array_data['identity_card'], PDO::PARAM_STR );
		$sth->bindParam( ':blood_group', $array_data['blood_group'], PDO::PARAM_STR );
		$sth->bindParam( ':rh_', $array_data['rh_'], PDO::PARAM_INT );
		$sth->bindParam( ':width', $array_data['width'], PDO::PARAM_STR );
		$sth->bindParam( ':weight', $array_data['weight'], PDO::PARAM_STR );
		$sth->bindParam( ':recent_time', $array_data['recent_time'], PDO::PARAM_STR );
		$sth->bindParam( ':platelet', $array_data['platelet'], PDO::PARAM_STR );
		$sth->bindParam( ':organizetype', $array_data['organizetype'], PDO::PARAM_INT );
		$sth->bindParam( ':organize', $array_data['organize'], PDO::PARAM_STR );
		$sth->bindParam( ':resident_p', $array_data['resident_p'], PDO::PARAM_STR );
		$sth->bindParam( ':resident_d', $array_data['resident_d'], PDO::PARAM_STR );
		$sth->bindParam( ':resident_w', $array_data['resident_w'], PDO::PARAM_STR );
		$sth->bindParam( ':temporarily_p', $array_data['temporarily_p'], PDO::PARAM_STR );
		$sth->bindParam( ':temporarily_d', $array_data['temporarily_d'], PDO::PARAM_STR );
		$sth->bindParam( ':temporarily_w', $array_data['temporarily_w'], PDO::PARAM_STR );
		$sth->bindParam( ':temporarily_s', $array_data['temporarily_s'], PDO::PARAM_STR );
		if( $sth->execute() )
		{
			$is_success = 1;
		}
	}
}

$sql = 'SELECT * FROM ' . $db_config['prefix'] . '_location_province';
$array_province = $nv_Cache->db( $sql, 'provinceid', $module_name );

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_organizetype WHERE status=1 ORDER BY id DESC';
$array_organizetype = $nv_Cache->db( $sql, 'id', $module_name );

$contents = nv_theme_blood_bank_content( $array_data, $array_user, $is_success, $error );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
