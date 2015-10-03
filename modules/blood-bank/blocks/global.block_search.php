<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if( ! nv_function_exists( 'nv_block_search' ) )
{
	function nv_block_search( $block_config )
	{
		global $module_info, $site_mods, $module_config, $global_config, $db, $module_name, $lang_module, $op;

		$module = $block_config['module'];
		$mod_file = $site_mods[$module]['module_file'];

		if( $module == $module_name ) return '';

		if( !isset( $array_search ) )
		{
			$array_search = array( 'keywords' => '', 'blood_group' => '' );
		}

		if( file_exists( NV_ROOTDIR . '/themes/' . $global_config['module_theme']  . '/modules/' . $mod_file . '/block_search.tpl' ) )
		{
			$block_theme = $global_config['module_theme'] ;
		}
		else
		{
			$block_theme = 'default';
		}

		if ( $module != $module_name )
		{
			$lang_temp = $lang_module;
			if ( file_exists( NV_ROOTDIR . "/modules/" . $mod_file . "/language/" . NV_LANG_INTERFACE . ".php" ) )
			{
				require_once NV_ROOTDIR . "/modules/" . $mod_file . "/language/" . NV_LANG_INTERFACE . ".php";
			}
			$lang_module = $lang_module + $lang_temp;
			unset($lang_temp);
		}

		$array_blood_group = array(
			'-' => $lang_module['not_know'],
			'o' => $lang_module['blood_group'] . ' O',
			'a' => $lang_module['blood_group'] . ' A',
			'b' => $lang_module['blood_group'] . ' B',
			'ab' => $lang_module['blood_group'] . ' AB'
		);

		$xtpl = new XTemplate( 'block_search.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'OP', 'main' );
		$xtpl->assign( 'ACTION', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module );

		if( !empty( $array_blood_group ) )
		{
			foreach( $array_blood_group as $key => $value )
			{
				$sl = $array_search['blood_group'] == $key ? 'selected="selected"' : '';
				$xtpl->assign( 'BLOOD', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
				$xtpl->parse( 'main.blood_group' );
			}
		}

		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}

if( defined( 'NV_SYSTEM' ) )
{
	global $site_mods, $module_name;

	$content = nv_block_search( $block_config );
}
