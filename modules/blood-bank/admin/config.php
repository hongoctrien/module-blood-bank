<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['config'];
$groups_list = nv_groups_list();

$data = array();
if( $nv_Request->isset_request( 'savesetting', 'post' ) )
{
	$data['per_page'] = $nv_Request->get_int( 'per_page', 'post', 20 );
	$_groups_post = $nv_Request->get_array( 'groups_view_member', 'post', array() );
	$data['groups_view_member'] = ! empty( $_groups_post ) ? implode( ',', nv_groups_post( array_intersect( $_groups_post, array_keys( $groups_list ) ) ) ) : '';

	$sth = $db->prepare( "UPDATE " . NV_PREFIXLANG . '_' . $module_data . "_config SET config_value = :config_value WHERE config_name = :config_name" );
	foreach( $data as $config_name => $config_value )
	{
		$sth->bindParam( ':config_name', $config_name, PDO::PARAM_STR, 30 );
		$sth->bindParam( ':config_value', $config_value, PDO::PARAM_STR );
		$sth->execute();
	}

	nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['config'], "Config", $admin_info['userid'] );
	nv_del_moduleCache( $module_name );

	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=' . $op );
	die();
}

$groups_view = explode( ',', $array_config['groups_view_member'] );
$array['groups_view'] = array();
foreach( $groups_list as $key => $title )
{
	$array['groups_view'][] = array(
		'key' => $key,
		'title' => $title,
		'checked' => in_array( $key, $groups_view ) ? ' checked="checked"' : ''
	);
}

$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'DATA', $array_config );

foreach( $array['groups_view'] as $group )
{
	$xtpl->assign( 'GROUPS_VIEW', $group );
	$xtpl->parse( 'main.groups_view_member' );
}

$xtpl->parse( 'main' );

$contents .= $xtpl->text( 'main' );
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';