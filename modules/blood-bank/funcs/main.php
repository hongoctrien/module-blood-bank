<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 10 May 2015 01:36:45 GMT
 */

if ( ! defined( 'NV_IS_MOD_BLOOD_BANK' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

if( ! nv_user_in_groups( $array_config['groups_view_member'] ) )
{
	$redirect = '<meta http-equiv="Refresh" content="4;URL=' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php', true ) . '" />';
	nv_info_die( $lang_module['error_not_permission_title'], $lang_module['error_not_permission_title'], $lang_module['error_not_permission_content'] . $redirect );
	exit();
}

$where = '';
$array_search = array( 'keywords' => '', 'blood_group' => '' );
$array_data = array();
$page = ( isset( $array_op[0] ) and substr( $array_op[0], 0, 5 ) == 'page-' ) ? intval( substr( $array_op[0], 5 ) ) : 1;
$per_page = $array_config['per_page'];
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;

if( $nv_Request->isset_request( 'search', 'get' ) )
{
	$array_search['keywords'] = $nv_Request->get_title( 'keywords', 'get', '' );
	$array_search['blood_group'] = $nv_Request->get_title( 'blood_group', 'get', '' );

	$base_url .= '&search=1';

	if( !empty( $array_search['keywords'] ) )
	{
		$where .= ' AND first_name like "%' . $array_search['keywords'] . '%" OR last_name like "%' . $array_search['keywords'] . '%" OR email like "%' . $array_search['keywords'] . '%" OR phone like "%' . $array_search['keywords'] . '%" OR identity_card like "%' . $array_search['keywords'] . '%" OR width like "%' . $array_search['keywords'] . '%" OR weight like "%' . $array_search['keywords'] . '%" OR organize like "%' . $array_search['keywords'] . '%"';
		$base_url .= '&keywords=' . $array_search['keywords'];
	}

	if( !empty( $array_search['blood_group'] ) )
	{
		$where .= ' AND blood_group=' . $db->quote( $array_search['blood_group'] ) ;
		$base_url .= '&blood_group=' . $array_search['blood_group'];
	}
}

$db->sqlreset()
  ->select( 'COUNT(*)' )
  ->from( NV_PREFIXLANG . '_' . $module_data )
  ->where( '1=1' . $where );

$all_page = $db->query( $db->sql() )->fetchColumn();

$db->select( 'id, userid, organize, last_name, first_name, birthday, gender, blood_group' )
  ->order( 'id DESC' )
  ->limit( $per_page )
  ->offset( ($page - 1) * $per_page );

$_query = $db->query( $db->sql() );
while( $row = $_query->fetch() )
{
	$row['alias'] = change_alias( $row['last_name'] . ' ' . $row['first_name'] ) . '-' . $row['id'];
	$row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '/' . $row['alias'];

	$array_data[$row['id']] = $row;
}

$generate_page = nv_alias_page( $page_title, $base_url, $all_page, $per_page, $page );

$contents = nv_theme_blood_bank_main( $array_data, $array_search, $generate_page );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
