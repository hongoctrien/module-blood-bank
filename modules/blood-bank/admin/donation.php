<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 06 Jun 2015 15:06:19 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation  WHERE id = ' . $db->quote( $id ) );
		$nv_Cache->delMod( $module_name );
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int( 'id', 'post,get', 0 );
if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$row['title'] = $nv_Request->get_title( 'title', 'post', '' );
	$row['organ_id'] = $nv_Request->get_int( 'organ_id', 'post', 0 );
	$row['donor_id'] = $nv_Request->get_int( 'donor_id', 'post', 0 );
	if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'start_time', 'post' ), $m ) )
	{
		$_hour = 0;
		$_min = 0;
		$row['start_time'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$row['start_time'] = 0;
	}
	if( preg_match( '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string( 'end_time', 'post' ), $m ) )
	{
		$_hour = 0;
		$_min = 0;
		$row['end_time'] = mktime( $_hour, $_min, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$row['end_time'] = 0;
	}

	if( empty( $row['title'] ) )
	{
		$error[] = $lang_module['error_required_title'];
	}
	elseif( empty( $row['organ_id'] ) )
	{
		$error[] = $lang_module['error_required_organ_id'];
	}
	elseif( empty( $row['donor_id'] ) )
	{
		$error[] = $lang_module['error_required_donor_id'];
	}
	elseif( empty( $row['start_time'] ) )
	{
		$error[] = $lang_module['error_required_start_time'];
	}
	elseif( empty( $row['end_time'] ) )
	{
		$error[] = $lang_module['error_required_end_time'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{

				$row['num_blood_donor'] = 0;

				$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_donation (title, organ_id, donor_id, start_time, end_time) VALUES (:title, :organ_id, :donor_id, :start_time, :end_time)' );
			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_donation SET title = :title, organ_id = :organ_id, donor_id = :donor_id, start_time = :start_time, end_time = :end_time WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':title', $row['title'], PDO::PARAM_STR );
			$stmt->bindParam( ':organ_id', $row['organ_id'], PDO::PARAM_INT );
			$stmt->bindParam( ':donor_id', $row['donor_id'], PDO::PARAM_INT );
			$stmt->bindParam( ':start_time', $row['start_time'], PDO::PARAM_INT );
			$stmt->bindParam( ':end_time', $row['end_time'], PDO::PARAM_INT );

			$exc = $stmt->execute();
			if( $exc )
			{
				$nv_Cache->delMod( $module_name );
				Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
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
elseif( $row['id'] > 0 )
{
	$row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation WHERE id=' . $row['id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['id'] = 0;
	$row['title'] = '';
	$row['organ_id'] = 0;
	$row['donor_id'] = 0;
	$row['start_time'] = 0;
	$row['end_time'] = 0;
}

if( empty( $row['start_time'] ) )
{
	$row['start_time'] = '';
}
else
{
	$row['start_time'] = date( 'd/m/Y', $row['start_time'] );
}

if( empty( $row['end_time'] ) )
{
	$row['end_time'] = '';
}
else
{
	$row['end_time'] = date( 'd/m/Y', $row['end_time'] );
}
$array_organ_id_blood_bank = array();
$_sql = 'SELECT id,title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_organize';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_organ_id_blood_bank[$_row['id']] = $_row;
}

$array_donor_id_blood_bank = array();
$_sql = 'SELECT id,title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location_donor';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_donor_id_blood_bank[$_row['id']] = $_row;
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
		->from( '' . NV_PREFIXLANG . '_' . $module_data . '_donation' );

	if( ! empty( $q ) )
	{
		$db->where( 'title LIKE :q_title OR organ_id LIKE :q_organ_id OR donor_id LIKE :q_donor_id OR start_time LIKE :q_start_time OR end_time LIKE :q_end_time' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_title', '%' . $q . '%' );
		$sth->bindValue( ':q_organ_id', '%' . $q . '%' );
		$sth->bindValue( ':q_donor_id', '%' . $q . '%' );
		$sth->bindValue( ':q_start_time', '%' . $q . '%' );
		$sth->bindValue( ':q_end_time', '%' . $q . '%' );
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
		$sth->bindValue( ':q_title', '%' . $q . '%' );
		$sth->bindValue( ':q_organ_id', '%' . $q . '%' );
		$sth->bindValue( ':q_donor_id', '%' . $q . '%' );
		$sth->bindValue( ':q_start_time', '%' . $q . '%' );
		$sth->bindValue( ':q_end_time', '%' . $q . '%' );
	}
	$sth->execute();
}


$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'ROW', $row );

foreach( $array_organ_id_blood_bank as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['title'],
		'selected' => ($value['id'] == $row['organ_id']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_organ_id' );
}
foreach( $array_donor_id_blood_bank as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['title'],
		'selected' => ($value['id'] == $row['donor_id']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_donor_id' );
}
$xtpl->assign( 'Q', $q );

if( $show_view )
{
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
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
		$view['number'] = ++$number;
		$view['start_time'] = ( empty( $view['start_time'] )) ? '' : nv_date( 'd/m/Y', $view['start_time'] );
		$view['end_time'] = ( empty( $view['end_time'] )) ? '' : nv_date( 'd/m/Y', $view['end_time'] );
		$view['organ_id'] = $array_organ_id_blood_bank[$view['organ_id']]['title'];
		$view['donor_id'] = $array_donor_id_blood_bank[$view['donor_id']]['title'];
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
		$view['link_blood_donor'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=donation_person&amp;donation_id=' . $view['id'];
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}
	$xtpl->parse( 'main.view' );
}


if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['donation'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';