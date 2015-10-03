<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 06 Jun 2015 11:16:13 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if( $nv_Request->isset_request( 'get_district', 'post' ) )
{
	$option = '';
	$provinceid = $nv_Request->get_string( 'provinceid', 'post', '' );
	$sl_district = $nv_Request->get_string( 'sl_district', 'post', '' );

	$option .= '<option value="">---' . $lang_module['company_address_district_c'] . '---</option>';

	$result = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_location_district WHERE provinceid=' . $db->quote( $provinceid ) );
	while( $row = $result->fetch() )
	{
		$sl = $sl_district == $row['districtid'] ? 'selected="selected"' : '';
		$row['name'] = is_numeric( $row['name'] ) ? $row['type'] . ' ' . $row['name'] : $row['name'];
		$option .= '<option value="' . $row['districtid'] . '" ' . $sl . ' >' . $row['name'] . '</ontion>';
	}
	die( $option );
}

//change status
if( $nv_Request->isset_request( 'change_status', 'post, get' ) )
{
	$id = $nv_Request->get_int( 'id', 'post, get', 0 );
	$content = 'NO_' . $id;

	$query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location_donor WHERE id=' . $id;
	$row = $db->query( $query )->fetch();
	if( isset( $row['status'] ) )
	{
		$status = ( $row['status'] ) ? 0 : 1;
		$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_location_donor SET status=' . intval( $status ) . ' WHERE id=' . $id;
		$db->query( $query );
		$content = 'OK_' . $id;
	}
	nv_del_moduleCache( $module_name );
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}

if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location_donor  WHERE id = ' . $db->quote( $id ) );
		nv_del_moduleCache( $module_name );
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
	$row['type_id'] = $nv_Request->get_int( 'type_id', 'post', 0 );
	$row['description'] = $nv_Request->get_string( 'description', 'post', '' );
	$row['province'] = $nv_Request->get_title( 'province', 'post', '' );
	$row['district'] = $nv_Request->get_title( 'district', 'post', '' );
	$row['extend'] = $nv_Request->get_title( 'extend', 'post', '' );

	if( empty( $row['title'] ) )
	{
		$error[] = $lang_module['error_required_title'];
	}
	elseif( empty( $row['type_id'] ) )
	{
		$error[] = $lang_module['error_required_type_id'];
	}
	elseif( empty( $row['province'] ) )
	{
		$error[] = $lang_module['error_required_province'];
	}
	elseif( empty( $row['district'] ) )
	{
		$error[] = $lang_module['error_required_district'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{
				$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_location_donor (title, type_id, description, province, district, extend, status) VALUES (:title, :type_id, :description, :province, :district, :extend, 1)' );
			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_location_donor SET title = :title, type_id = :type_id, description = :description, province = :province, district = :district, extend = :extend WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':title', $row['title'], PDO::PARAM_STR );
			$stmt->bindParam( ':type_id', $row['type_id'], PDO::PARAM_INT );
			$stmt->bindParam( ':description', $row['description'], PDO::PARAM_STR, strlen($row['description']) );
			$stmt->bindParam( ':province', $row['province'], PDO::PARAM_STR );
			$stmt->bindParam( ':district', $row['district'], PDO::PARAM_STR );
			$stmt->bindParam( ':extend', $row['extend'], PDO::PARAM_STR );

			$exc = $stmt->execute();
			if( $exc )
			{
				nv_del_moduleCache( $module_name );
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
	$row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location_donor WHERE id=' . $row['id'] )->fetch();
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
	$row['type_id'] = 0;
	$row['description'] = '';
	$row['province'] = '';
	$row['district'] = '';
	$row['extend'] = '';
}
$array_type_id_blood_bank = array();
$_sql = 'SELECT id,title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_locationtype';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_type_id_blood_bank[$_row['id']] = $_row;
}


$array_search = array();
$array_search['q'] = $nv_Request->get_title( 'q', 'post,get' );
$array_search['type_id'] = $nv_Request->get_int( 'type_id', 'post,get', 0 );

// Fetch Limit
$show_view = false;
if ( ! $nv_Request->isset_request( 'id', 'post,get' ) )
{
	$where = '';
	if( ! empty( $array_search['q'] ) )
	{
		$where .= ' AND title LIKE :q_title or description LIKE :q_description';
	}
	if( ! empty( $array_search['type_id'] ) )
	{
		$where .= ' AND type_id=' . $array_search['type_id'];
	}

	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . NV_PREFIXLANG . '_' . $module_data . '_location_donor' )
		->where( '1=1' . $where );

	$sth = $db->prepare( $db->sql() );

	if( ! empty( $array_search['q'] ) )
	{
		$sth->bindValue( ':q_title', '%' . $array_search['q'] . '%' );
		$sth->bindValue( ':q_description', '%' . $array_search['q'] . '%' );
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'id DESC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $array_search['q'] ) )
	{
		$sth->bindValue( ':q_title', '%' . $array_search['q'] . '%' );
		$sth->bindValue( ':q_description', '%' . $array_search['q'] . '%' );
	}
	$sth->execute();
}

$sql = 'SELECT * FROM ' . $db_config['prefix'] . '_location_province';
$array_province = nv_db_cache( $sql, 'provinceid', $module_name );

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
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
$xtpl->assign( 'SEARCH', $array_search );

// Danh sach Tinh/Thanh pho
if( !empty( $array_province ) )
{
	foreach( $array_province as $province )
	{
		$province['selected'] = $row['province'] == $province['provinceid'] ? 'selected="selected"' : '';
		$xtpl->assign( 'PROVINCE', $province );
		$xtpl->parse( 'main.province' );
	}
}

foreach( $array_type_id_blood_bank as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['title'],
		'selected' => ($value['id'] == $row['type_id']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_type_id' );
}

if( $show_view )
{
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	if( ! empty( $array_search['q'] ) )
	{
		$base_url .= '&q=' . $array_search['q'];
	}
	if( ! empty( $array_search['type_id'] ) )
	{
		$base_url .= '&type_id=' . $array_search['type_id'];
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
		if( $view['status'] == 1 )
		{
			$check = 'checked';
		}
		else
		{
			$check = '';
		}
		$xtpl->assign( 'CHECK', $check );
		$view['type_id'] = $array_type_id_blood_bank[$view['type_id']]['title'];
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}

	foreach( $array_type_id_blood_bank as $value )
	{
		$xtpl->assign( 'OPTION', array(
			'key' => $value['id'],
			'title' => $value['title'],
			'selected' => ($value['id'] == $array_search['type_id']) ? ' selected="selected"' : ''
		) );
		$xtpl->parse( 'main.view.select_type_id_search' );
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

$page_title = $lang_module['location_donor'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';