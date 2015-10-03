<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 10 May 2015 01:36:45 GMT
 */

if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_BLOOD_BANK', true );
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

if( $op == 'main' )
{
	if( sizeof( $array_op ) == 1 and preg_match( '/^([a-z0-9\-]+)\-([0-9]+)$/i', $array_op[0], $m1 ) and ! preg_match( '/^page\-([0-9]+)$/', $array_op[0], $m2 ) )
	{
		$op = 'detail';
		$id = $m1[2];
	}
}
