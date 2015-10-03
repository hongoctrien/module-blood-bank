<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 10 May 2015 01:36:45 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_int( 'id', 'get', 0 );

if( $nv_Request->isset_request( 'get_user_json', 'post, get' ) )
{
	$q = $nv_Request->get_title( 'q', 'post, get', '' );

	$db->sqlreset()
		->select( 'userid, username, email, first_name, last_name' )
		->from( NV_USERS_GLOBALTABLE )
		->where( '( username LIKE :username OR email LIKE :email OR first_name like :first_name OR last_name like :last_name ) AND userid NOT IN (SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . ' )' )
		->order( 'username ASC' )
		->limit( 20 );

	$sth = $db->prepare( $db->sql() );
	$sth->bindValue( ':username', '%' . $q . '%', PDO::PARAM_STR );
	$sth->bindValue( ':email', '%' . $q . '%', PDO::PARAM_STR );
	$sth->bindValue( ':first_name', '%' . $q . '%', PDO::PARAM_STR );
	$sth->bindValue( ':last_name', '%' . $q . '%', PDO::PARAM_STR );
	$sth->execute();

	$array_data = array();
	while( list( $userid, $username, $email, $first_name, $first_name ) = $sth->fetch( 3 ) )
	{
		$array_data[] = array( 'id' => $userid, 'username' => $username, 'fullname' => nv_show_name_user( $first_name, $last_name ) );
	}

	header( 'Cache-Control: no-cache, must-revalidate' );
	header( 'Content-type: application/json' );

	ob_start( 'ob_gzhandler' );
	echo json_encode( $array_data );
	exit();
}

if( $nv_Request->isset_request( 'get_district', 'post' ) )
{
	$option = '';
	$provinceid = $nv_Request->get_string( 'provinceid', 'post', '' );
	$sl_district = $nv_Request->get_string( 'sl_district', 'post', '' );
	$c_district = $nv_Request->get_int( 'c_district', 'post', 0 );

	$option .= '<option value="">---' . $lang_module['district_c'] . '---</option>';

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
	$c_ward = $nv_Request->get_int( 'c_ward', 'post', 0 );

	$option .= !empty( $c_ward ) ? '<option value="">---' . $lang_module['ward_c'] . '---</option>' : '';

	$result = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_location_ward WHERE districtid=' . $db->quote( $districtid ) );
	while( $row = $result->fetch() )
	{
		$sl = $sl_ward == $row['wardid'] ? 'selected="selected"' : '';
		$row['name'] = is_numeric( $row['name'] ) ? $row['type'] . ' ' . $row['name'] : $row['name'];
		$option .= '<option value="' . $row['wardid'] . '" ' . $sl . ' >' . $row['name'] . '</ontion>';
	}
	die( $option );
}

$array_data = array();
$error = array();

if( $id > 0 )
{
	$page_title = $lang_module['edit_member'];

	$result = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id );
	if( $result->rowCount() == 0 )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
		die();
	}
	$array_data = $result->fetch();
}
else
{
	$page_title = $lang_module['add_member'];

	$array_data['first_name'] = '';
	$array_data['last_name'] = '';
	$array_data['birthday'] = '';
	$array_data['username'] = '';
	$array_data['gender'] = '';
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
	$array_data['username'] = $nv_Request->get_title( 'username', 'post', '' );
	$array_data['userid'] = $nv_Request->get_int( 'userid', 'post', 0 );
	$array_data['first_name'] = $nv_Request->get_title( 'first_name', 'post', '' );
	$array_data['last_name'] = $nv_Request->get_title( 'last_name', 'post', '' );
	$array_data['email'] = $nv_Request->get_title( 'email', 'post', '' );
	$array_data['gender'] = $nv_Request->get_title( 'gender', 'post', 'N' );
	$array_data['phone'] = $nv_Request->get_title( 'phone', 'post', '' );
	$array_data['identity_card'] = $nv_Request->get_title( 'identity_card', 'post', '' );
	$array_data['blood_group'] = $nv_Request->get_title( 'blood_group', 'post', '' );
	$array_data['rh_'] = $nv_Request->get_int( 'rh_', 'post', 0 );
	$array_data['width'] = $nv_Request->get_title( 'width', 'post', 0 );
	$array_data['weight'] = $nv_Request->get_title( 'weight', 'post', 0 );
	$array_data['recent_time'] = $nv_Request->get_title( 'recent_time', 'post', '' );
	$array_data['platelet'] = $nv_Request->get_int( 'platelet', 'post', 0 );
	$array_data['organizetype'] = $nv_Request->get_int( 'organizetype', 'post', 0 );
	$array_data['organize'] = $nv_Request->get_title( 'organize', 'post', '' );

	$array_data['resident_p'] = $nv_Request->get_title( 'province1', 'post', 0 );
	$array_data['resident_d'] = $nv_Request->get_title( 'district1', 'post', 0 );
	$array_data['resident_w'] = $nv_Request->get_title( 'ward1', 'post', 0 );

	$array_data['temporarily_p'] = $nv_Request->get_title( 'province2', 'post', 0 );
	$array_data['temporarily_d'] = $nv_Request->get_title( 'district2', 'post', 0 );
	$array_data['temporarily_w'] = $nv_Request->get_title( 'ward2', 'post', 0 );
	$array_data['temporarily_s'] = $nv_Request->get_title( 'temporarily_s', 'post', '' );

	$count_identity_card = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE identity_card=' . $db->quote( $array_data['identity_card'] ) . ' AND id != ' . $id )->fetchColumn();

	if( empty( $array_data['first_name'] ) )
	{
		$error[] = $lang_module['error_first_name'];
	}
	if( empty( $array_data['last_name'] ) )
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

	if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'birthday', 'post' ), $m ) )
	{
		$_hour = 0;
		$_min = 0;
		$array_data['birthday'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$array_data['birthday'] = 0;
	}

	if( empty( $array_data['birthday'] ) )
	{
		$error[] = $lang_module['error_birthday'];
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

	if( empty( $error ) )
	{
		// Cap nhat thong tin thanh vien
		if( $array_data['userid'] > 0 )
		{
			$sth = $db->prepare( 'UPDATE ' . NV_USERS_GLOBALTABLE . ' SET first_name=:first_name,last_name=:last_name,gender=:gender,birthday=:birthday WHERE userid=:userid' );
			$sth->bindParam( ':first_name', $array_data['first_name'], PDO::PARAM_STR );
			$sth->bindParam( ':last_name', $array_data['last_name'], PDO::PARAM_STR );
			$sth->bindParam( ':gender', $array_data['gender'], PDO::PARAM_STR );
			$sth->bindParam( ':birthday', $array_data['birthday'], PDO::PARAM_STR );
			$sth->bindParam( ':userid', $array_data['userid'], PDO::PARAM_INT );
			$sth->execute();
			unset( $sth );
		}

		if( $id > 0 )
		{
			$sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET userid=:userid, username=:username,last_name=:last_name,first_name=:first_name,birthday=:birthday,email=:email,gender=:gender,phone=:phone,identity_card=:identity_card,blood_group=:blood_group,rh_=:rh_,width=:width,weight=:weight,recent_time=:recent_time,platelet=:platelet,organizetype=:organizetype,organize=:organize,resident_p=:resident_p, resident_d=:resident_d, resident_w=:resident_w, temporarily_p=:temporarily_p, temporarily_d=:temporarily_d,temporarily_w=:temporarily_w,temporarily_s=:temporarily_s WHERE id=' . $id );
		}
		else
		{
			$sth = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (userid, username, last_name, first_name, birthday, email, gender, phone, identity_card, blood_group, rh_, width, weight, recent_time, platelet, organizetype, organize, resident_p, resident_d, resident_w, temporarily_p, temporarily_d, temporarily_w, temporarily_s) VALUES
			( :userid, :username, :last_name,:first_name,:birthday,:email,:gender,:phone,:identity_card,:blood_group,:rh_,:width,:weight,:recent_time,:platelet,:organizetype,:organize,:resident_p, :resident_d, :resident_w,:temporarily_p, :temporarily_d, :temporarily_w, :temporarily_s )' );
		}

		$sth->bindParam( ':username', $array_data['username'], PDO::PARAM_STR );
		$sth->bindParam( ':userid', $array_data['userid'], PDO::PARAM_INT );
		$sth->bindParam( ':first_name', $array_data['first_name'], PDO::PARAM_STR );
		$sth->bindParam( ':last_name', $array_data['last_name'], PDO::PARAM_STR );
		$sth->bindParam( ':birthday', $array_data['birthday'], PDO::PARAM_STR );
		$sth->bindParam( ':email', $array_data['email'], PDO::PARAM_STR );
		$sth->bindParam( ':gender', $array_data['gender'], PDO::PARAM_STR );
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
			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
			die();
		}
	}
}

$sql = 'SELECT * FROM ' . $db_config['prefix'] . '_location_province';
$array_province = nv_db_cache( $sql, 'provinceid', $module_name );

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_organizetype WHERE status=1 ORDER BY id DESC';
$array_organizetype = nv_db_cache( $sql, 'id', $module_name );

$array_data['recent_time'] = !empty( $array_data['recent_time'] ) ? nv_date( 'd/m/Y', $array_data['recent_time'] ) : '';
$array_data['birthday'] = !empty( $array_data['birthday'] ) ? nv_date( 'd/m/Y', $array_data['birthday'] ) : '';
$array_data['width'] = !empty( $array_data['width'] ) ? $array_data['width'] : '';
$array_data['weight'] = !empty( $array_data['weight'] ) ? $array_data['weight'] : '';
$array_data['rh_'] = $array_data['rh_'] ? 'checked="checked"' : '';

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_INTERFACE', NV_LANG_INTERFACE );
$xtpl->assign( 'DATA', $array_data );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );

if( !empty( $array_blood_group ) )
{
	foreach( $array_blood_group as $key => $value )
	{
		$sl = $array_data['blood_group'] == $key ? 'selected="selected"' : '';
		$xtpl->assign( 'BLOOD', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
		$xtpl->parse( 'main.blood_group' );
	}
}

if( !empty( $array_platelet ) )
{
	foreach( $array_platelet as $key => $value )
	{
		$sl = $array_data['platelet'] == $key ? 'selected="selected"' : '';
		$xtpl->assign( 'PLA', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
		$xtpl->parse( 'main.platelet' );
	}
}

if( !empty( $array_province ) )
{
	foreach( $array_province as $province )
	{
		$province['selected'] = $array_data['resident_p'] == $province['provinceid'] ? 'selected="selected"' : '';
		$xtpl->assign( 'PROVINCE', $province );
		$xtpl->parse( 'main.province1' );
	}

	foreach( $array_province as $province )
	{
		$province['selected'] = $array_data['temporarily_p'] == $province['provinceid'] ? 'selected="selected"' : '';
		$xtpl->assign( 'PROVINCE', $province );
		$xtpl->parse( 'main.province2' );
	}
}

foreach( $array_sex as $key => $value )
{
	$sl = $array_data['gender'] == $key ? 'selected="selected"' : '';
	$xtpl->assign( 'SEX', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
	$xtpl->parse( 'main.sex' );
}

if( !empty( $array_organizetype ) )
{
	foreach( $array_organizetype as $key => $value )
	{
		$sl = $array_data['organizetype'] == $key ? 'selected="selected"' : '';
		$xtpl->assign( 'ORGTYPE', array( 'key' => $key, 'value' => $value['title'], 'selected' => $sl ) );
		$xtpl->parse( 'main.organizetype' );
	}
}

if( $id > 0 )
{
	$xtpl->parse( 'main.userid_selected' );
}

if( !empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';