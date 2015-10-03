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
$array_data = array();
$array_history = array();

if( ! nv_user_in_groups( $array_config['groups_view_member'] ) )
{
	$redirect = '<meta http-equiv="Refresh" content="4;URL=' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php', true ) . '" />';
	nv_info_die( $lang_module['error_not_permission_title'], $lang_module['error_not_permission_title'], $lang_module['error_not_permission_content'] . $redirect );
	exit();
}

$result = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id );
if( $result->rowCount() > 0 )
{
	$array_data = $result->fetch();
}
else
{
	Header( 'Location: ' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name, true ) );
	die();
}

$row['photo'] = '';
$result = $db->query( 'SELECT photo FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $array_data['userid'] );
if( $result->rowCount() > 0 )
{
	$array_data['photo'] = $result->fetchColumn();
}

$result = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation_person WHERE identity_card=' . $db->quote( $array_data['identity_card'] ) );
while( $row = $result->fetch() )
{
	$row['time'] = 0;
	$_result = $db->query( 'SELECT start_time FROM ' . NV_PREFIXLANG . '_' . $module_data . '_donation WHERE id=' . $row['donation_id'] );
	if( $_result->rowCount() )
	{
		$row['time'] = $_result->fetchColumn();
	}
	$array_history[] = $row;
}

$contents = nv_theme_blood_bank_detail( $array_data, $array_history );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
