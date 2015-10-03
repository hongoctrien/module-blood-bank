<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 10 May 2015 01:36:45 GMT
 */

if ( ! defined( 'NV_IS_MOD_BLOOD_BANK' ) ) die( 'Stop!!!' );

/**
 * nv_theme_blood_bank_main()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_blood_bank_main ( $array_data, $array_search, $generate_page )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_sex, $page, $per_page, $array_blood_group;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'SEARCH', $array_search );

	if( !empty( $array_data ) )
	{
		$i = $page > 1 ? ( $per_page * ( $page - 1 ) ) + 1 : 1;
		foreach( $array_data as $data )
		{
			$data['no'] = $i;
			$data['birthday'] = !empty( $data['birthday'] ) ? nv_date( 'd/m/Y', $data['birthday'] ) : '';
			$data['gender'] = $array_sex[$data['gender']];

			$xtpl->assign( 'DATA', $data );
			$xtpl->parse( 'main.loop' );
			$i++;
		}
	}

	if( !empty( $array_blood_group ) )
	{
		foreach( $array_blood_group as $key => $value )
		{
			$sl = $array_search['blood_group'] == $key ? 'selected="selected"' : '';
			$xtpl->assign( 'BLOOD', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
			$xtpl->parse( 'main.blood_group' );
		}
	}

	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_blood_bank_detail()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_blood_bank_detail ( $array_data, $array_history )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_sex, $array_blood_group;

	$array_data['birthday'] = !empty( $array_data['birthday'] ) ? nv_date( 'd/m/Y', $array_data['birthday'] ) : '';
	$array_data['recent_time'] = !empty( $array_data['recent_time'] ) ? nv_date( 'd/m/Y', $array_data['recent_time'] ) : '';
	$array_data['gender'] = $array_sex[$array_data['gender']];
	$array_data['blood_group'] = !empty( $array_data['blood_group'] ) ? $array_blood_group[$array_data['blood_group']] : $lang_module['not_know'];
	$array_data['resident'] = nv_get_location( $array_data['resident_p'], $array_data['resident_d'], $array_data['resident_w'] );
	$array_data['temporarily'] = nv_get_location( $array_data['temporarily_p'], $array_data['temporarily_d'], $array_data['temporarily_w'] );

	if( ! empty( $array_data['photo'] ) and file_exists( NV_ROOTDIR . '/' . $array_data['photo'] ) )
	{
		$array_data['photo'] = NV_BASE_SITEURL . $array_data['photo'];
	}
	else
	{
		$array_data['photo'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/users/no_avatar.jpg';
	}

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'DATA', $array_data );

	if( !empty( $array_data ) )
	{
		foreach( $array_data as $key => $data )
		{
			if( !empty( $data ) )
			{
				$admin_field = array( 'email', 'phone', 'identity_card' );
				if( in_array( $key, $admin_field ) and !defined( 'NV_IS_MODADMIN' ) )
				{
					continue;
				}
				$xtpl->parse( 'main.' . $key );
			}
		}
	}

	if( !empty( $array_history ) )
	{
		foreach( $array_history as $history )
		{
			$history['time'] = !empty( $history['time'] ) ? nv_date( 'd/m/Y', $history['time'] ) : '';
			$xtpl->assign( 'HISTORY', $history );
			$xtpl->parse( 'main.history.loop' );
		}
		$xtpl->parse( 'main.history' );
	}

	if ( defined( 'NV_IS_MODADMIN' ) )
	{
		$xtpl->parse( 'main.admin' );
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_blood_bank_content()
 *
 * @param mixed $array_data
 * @param mixed $array_user
 * @param mixed $is_success
 * @param mixed $error
 * @return
 */
function nv_theme_blood_bank_content ( $array_data, $array_user, $is_success, $error )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_blood_group, $array_platelet, $array_province, $array_sex, $array_organizetype;

	$array_user['birthday'] = !empty( $array_user['birthday'] ) ? nv_date( 'd/m/Y', $array_user['birthday'] ) : '';
	$array_data['recent_time'] = !empty( $array_data['recent_time'] ) ? nv_date( 'd/m/Y', $array_data['recent_time'] ) : '';
	$array_data['width'] = !empty( $array_data['width'] ) ? $array_data['width'] : '';
	$array_data['weight'] = !empty( $array_data['weight'] ) ? $array_data['weight'] : '';
	$array_data['rh_'] = $array_data['rh_'] ? 'checked="checked"' : '';

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_LANG_INTERFACE', NV_LANG_INTERFACE );
    $xtpl->assign( 'DATA', $array_data );
    $xtpl->assign( 'USER', $array_user );
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
		$sl = $array_user['gender'] == $key ? 'selected="selected"' : '';
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

	if( !empty( $error ) )
	{
		$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
		$xtpl->parse( 'main.error' );
	}

	if( $is_success )
	{
		$xtpl->parse( 'main.success' );
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_blood_bank_search()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_blood_bank_search ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );



    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}