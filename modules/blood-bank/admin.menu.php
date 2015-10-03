<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 04 May 2014 12:41:32 GMT
 */

if( ! defined( 'NV_ADMIN' ) ) die( 'Stop!!!' );

$allow_func = array( 'main', 'content', 'config', 'organize', 'location_type', 'location_donor', 'donation', 'donation_person', 'organize_type' );

$submenu['content'] = $lang_module['add_member'];
$submenu['donation'] = $lang_module['donation'];
$submenu['organize'] = $lang_module['organize_execute'];
$submenu['location_donor'] = $lang_module['location_donor'];
$submenu['location_type'] = $lang_module['location_type'];
$submenu['organize_type'] = $lang_module['organize_type'];
$submenu['config'] = $lang_module['config'];