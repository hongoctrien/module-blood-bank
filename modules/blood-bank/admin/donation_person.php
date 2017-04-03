<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 07 Jun 2015 03:32:00 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$is_edit = false;
$row = array();
$row['donation_id'] = $nv_Request->get_int( 'donation_id', 'post,get', 0 );
if( empty( $row['donation_id'] ) )
{
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=donation' );
	die();
}
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&donation_id=' . $row['donation_id'];

if( $nv_Request->isset_request( 'check_identity_card', 'post' ) )
{
	$identity_card = $nv_Request->get_title( 'identity_card', 'post', '' );
	$result = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE identity_card=' . $db->quote( $identity_card ) );
	if( $result->fetchColumn() > 0 )
	{
		die( 'OK_' . $lang_module['is_member'] );
	}
	else
	{
		die( 'NO_' . $lang_module['non_member'] );
	}
}

if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		list( $donation_id ) = $db->query( 'SELECT donation_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation_person WHERE id=' . $id )->fetch( 3 );

		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation_person  WHERE id = ' . $db->quote( $id ) );

		// Cap nhat so luong nguoi hien mau
		$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donation SET num_blood_donor=num_blood_donor-1 WHERE id=' . $donation_id );

		$nv_Cache->delMod( $module_name );
		Header( 'Location: ' . $base_url );
		die();
	}
}

$error = array();
$row['id'] = $nv_Request->get_int( 'id', 'post,get', 0 );

$array_donation = array();
$result = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation WHERE id=' . $row['donation_id'] );
if( $result->rowCount() )
{
	$array_donation = $result->fetch();
}

if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$row['identity_card'] = $nv_Request->get_title( 'identity_card', 'post', '' );

	$is_member = false;
	$result = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE identity_card=' . $db->quote( $row['identity_card'] ) );
	if( $result->fetchColumn() > 0 )
	{
		$is_member = true;
	}

	$row['card_code'] = $nv_Request->get_title( 'card_code', 'post', '' );
	$row['dose'] = $nv_Request->get_title( 'dose', 'post', '' );
	$row['width'] = $nv_Request->get_title( 'width', 'post', '' );
	$row['weight'] = $nv_Request->get_title( 'weight', 'post', '' );
	$row['pulse'] = $nv_Request->get_title( 'pulse', 'post', '' );
	$row['blood_pressure'] = $nv_Request->get_title( 'blood_pressure', 'post', '' );
	$row['state'] = $nv_Request->get_title( 'state', 'post', '' );

	if( empty( $row['card_code'] ) )
	{
		$error[] = $lang_module['error_required_card_code'];
	}
	elseif( empty( $row['dose'] ) )
	{
		$error[] = $lang_module['error_required_dose'];
	}
	elseif( empty( $row['weight'] ) )
	{
		$error[] = $lang_module['error_required_weight'];
	}
	elseif( empty( $row['pulse'] ) )
	{
		$error[] = $lang_module['error_required_pulse'];
	}
	elseif( empty( $row['blood_pressure'] ) )
	{
		$error[] = $lang_module['error_required_blood_pressure'];
	}

	if( !$is_member )
	{
		$row['last_name'] = $nv_Request->get_title( 'last_name', 'post', '' );
		$row['first_name'] = $nv_Request->get_title( 'first_name', 'post', '' );
		$row['gender'] = $nv_Request->get_title( 'gender', 'post', 'N' );
		$row['phone'] = $nv_Request->get_title( 'phone', 'post', '' );
		$row['blood_group'] = $nv_Request->get_title( 'blood_group', 'post', '' );
		$row['rh_'] = $nv_Request->get_int( 'rh_', 'post', 0 );

		if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'birthday', 'post' ), $m ) )
		{
			$_hour = 0;
			$_min = 0;
			$row['birthday'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
		}
		else
		{
			$row['birthday'] = 0;
		}

		if( $row['id'] > 0 )
		{
			$sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET last_name=:last_name,first_name=:first_name,birthday=:birthday,phone=:phone,identity_card=:identity_card,blood_group=:blood_group,rh_=:rh_ WHERE id=' . $row['id'] );
		}
		else
		{
			$sth = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' ( last_name, first_name, birthday, gender, phone, identity_card, blood_group, rh_, width, weight) VALUES
			( :last_name,:first_name,:birthday,:gender,:phone,:identity_card,:blood_group,:rh_, :width, :weight)' );
		}

		$sth->bindParam( ':first_name', $row['first_name'], PDO::PARAM_STR );
		$sth->bindParam( ':last_name', $row['last_name'], PDO::PARAM_STR );
		$sth->bindParam( ':birthday', $row['birthday'], PDO::PARAM_STR );
		$sth->bindParam( ':gender', $row['gender'], PDO::PARAM_STR );
		$sth->bindParam( ':phone', $row['phone'], PDO::PARAM_STR );
		$sth->bindParam( ':identity_card', $row['identity_card'], PDO::PARAM_STR );
		$sth->bindParam( ':blood_group', $row['blood_group'], PDO::PARAM_STR );
		$sth->bindParam( ':rh_', $row['rh_'], PDO::PARAM_INT );
		$sth->bindParam( ':width', $row['width'], PDO::PARAM_STR );
		$sth->bindParam( ':weight', $row['weight'], PDO::PARAM_STR );
		$sth->execute();
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{
				$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_donation_person (donation_id, identity_card, card_code, dose, weight, pulse, blood_pressure, state, adduser, addtime) VALUES (:donation_id, :identity_card, :card_code, :dose, :weight, :pulse, :blood_pressure, :state, ' . $admin_info['admin_id'] . ', ' . NV_CURRENTTIME . ')' );
				$stmt->bindParam( ':donation_id', $row['donation_id'], PDO::PARAM_INT );
			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donation_person SET identity_card = :identity_card, card_code = :card_code, dose = :dose, weight = :weight, pulse = :pulse, blood_pressure = :blood_pressure, state = :state WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':identity_card', $row['identity_card'], PDO::PARAM_STR );
			$stmt->bindParam( ':card_code', $row['card_code'], PDO::PARAM_STR );
			$stmt->bindParam( ':dose', $row['dose'], PDO::PARAM_STR );
			$stmt->bindParam( ':weight', $row['weight'], PDO::PARAM_STR );
			$stmt->bindParam( ':pulse', $row['pulse'], PDO::PARAM_STR );
			$stmt->bindParam( ':blood_pressure', $row['blood_pressure'], PDO::PARAM_STR );
			$stmt->bindParam( ':state', $row['state'], PDO::PARAM_STR );

			$exc = $stmt->execute();
			if( $exc )
			{
				// Cap nhat so luong nguoi hien mau
				$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donation SET num_blood_donor=num_blood_donor+1 WHERE id=' . $row['donation_id'] );

				$nv_Cache->delMod( $module_name );
				Header( 'Location: ' . $base_url );
				die();
			}
		}
		catch( PDOException $e )
		{
			trigger_error( $e->getMessage() );
			die( $e->getMessage() ); //Remove this line after checks finished
		}
	}
}

if( $row['id'] > 0 )
{
	$is_edit = true;
	$lang_module['donation_person_add'] = $lang_module['donation_person_edit'];
	$row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation_person WHERE id=' . $row['id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}

	// Lay thong tin nguoi hien mau
	$row['member'] = array();
	$result = $db->query( 'SELECT identity_card, last_name, first_name, birthday, gender, phone, blood_group, rh_ FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE identity_card=' . $row['identity_card'] );
	if( $result->rowCount() > 0 )
	{
		$row['member'] = $result->fetch();
	}
}
else
{
	$row['id'] = 0;
	$row['card_code'] = '';
	$row['dose'] = '';
	$row['weight'] = '';
	$row['pulse'] = '';
	$row['blood_group'] = '';
	$row['gender'] = '';
	$row['blood_pressure'] = '';
	$row['state'] = '';
	$row['donation_id'] = $row['donation_id'];
	$row['member'] = array(
		'identity_card' => '',
		'last_name' => '',
		'first_name' => '',
		'birthday' => 0,
		'gender' => 'N',
		'phone' => '',
		'blood_group' => '',
		'rh_' => 0
	);
}

$q = $nv_Request->get_title( 'q', 'post,get' );

// Fetch Limit
$show_view = false;
if ( ! $nv_Request->isset_request( 'id', 'post,get' ) )
{
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . NV_PREFIXLANG . '_' . $module_data . '_donation_person' );

	if( ! empty( $q ) )
	{
		$db->where( 'card_code LIKE :q_card_code OR dose LIKE :q_dose OR weight LIKE :q_weight OR pulse LIKE :q_pulse OR blood_pressure LIKE :q_blood_pressure' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_card_code', '%' . $q . '%' );
		$sth->bindValue( ':q_dose', '%' . $q . '%' );
		$sth->bindValue( ':q_weight', '%' . $q . '%' );
		$sth->bindValue( ':q_pulse', '%' . $q . '%' );
		$sth->bindValue( ':q_blood_pressure', '%' . $q . '%' );
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'id DESC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_card_code', '%' . $q . '%' );
		$sth->bindValue( ':q_dose', '%' . $q . '%' );
		$sth->bindValue( ':q_weight', '%' . $q . '%' );
		$sth->bindValue( ':q_pulse', '%' . $q . '%' );
		$sth->bindValue( ':q_blood_pressure', '%' . $q . '%' );
	}
	$sth->execute();
}

$row['member']['birthday'] = !empty( $row['member']['birthday'] ) ? nv_date( 'd/m/Y', $row['member']['birthday'] ) : '';

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'ROW', $row );
$xtpl->assign( 'Q', $q );

if( $show_view )
{
	if( ! empty( $q ) )
	{
		$base_url .= '&q=' . $q;
	}
	$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.view.generate_page' );
	}
	$number = $page > 1 ? $per_page * ( $page - 1 ) : 0;
	while( $view = $sth->fetch() )
	{
		$view['fullname'] = 'N/A';
		$result = $db->query( 'SELECT last_name, first_name FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE identity_card=' . $db->quote( $view['identity_card'] ) );
		if( $result->rowCount() )
		{
			list( $last_name, $first_name )	 = $result->fetch( 3 );
			$view['fullname'] = $last_name . ' ' . $first_name;
		}
		$view['number'] = ++$number;
		$view['link_edit'] = $base_url . '&amp;id=' . $view['id'];
		$view['link_delete'] = $base_url . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}
	$xtpl->parse( 'main.view' );
}

if( !empty( $array_dose ) )
{
	foreach( $array_dose as $key => $text )
	{
		$selected = $key == $row['dose'] ? 'selected="selected"' : '';
		$xtpl->assign( 'DOSE', array( 'key' => $key, 'text' => $text, 'selected' => $selected ) );
		$xtpl->parse( 'main.dose' );
	}
}

if( !empty( $array_blood_group ) )
{
	foreach( $array_blood_group as $key => $value )
	{
		$sl = $row['member']['blood_group'] == $key ? 'selected="selected"' : '';
		$xtpl->assign( 'BLOOD', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
		$xtpl->parse( 'main.blood_group' );
	}
}

foreach( $array_sex as $key => $value )
{
	$sl = $row['member']['gender'] == $key ? 'selected="selected"' : '';
	$xtpl->assign( 'SEX', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
	$xtpl->parse( 'main.sex' );
}

$xtpl->assign( 'ck_rh_', $row['member']['rh_'] ? 'checked="checked"' : '' );

if( $is_edit )
{
	$xtpl->parse( 'main.frm_disabled' );
}

if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = sprintf( $lang_module['donation_person_list'], $array_donation['title'] );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';