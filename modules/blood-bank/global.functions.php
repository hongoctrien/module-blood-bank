<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$array_blood_group = array(
	'-' => $lang_module['not_know'],
	'o' => $lang_module['blood_group'] . ' O',
	'a' => $lang_module['blood_group'] . ' A',
	'b' => $lang_module['blood_group'] . ' B',
	'ab' => $lang_module['blood_group'] . ' AB'
);

$array_platelet = array(
	'0' => $lang_module['platelet_0'],
	'1' => $lang_module['platelet_1'],
	'2' => $lang_module['platelet_2']
);

$array_sex = array( 'N' => 'N/A', 'M' => $lang_module['sex_1'], 'F' => $lang_module['sex_0'] );

$array_dose = array();
$array_dose['250'] = '250ml';
$array_dose['350'] = '350ml';
$array_dose['450'] = '450ml';
$array_dose['500'] = '500ml';

$array_config = array();
$_sql = 'SELECT config_name, config_value FROM ' . NV_PREFIXLANG . '_' . $module_data . '_config';
$_query = $db->query( $_sql );
while( list( $config_name, $config_value ) = $_query->fetch( 3 ) )
{
	$array_config[$config_name] = $config_value;
}

function nv_get_location( $provinceid, $districtid, $wardid )
{
	global $db, $db_config, $module_data;

	if( empty( $provinceid ) or empty( $districtid ) or empty( $wardid ) ) return '';

	$location_str = '';
	$province = $db->query( 'SELECT name, type FROM ' . $db_config['prefix'] . '_location_province WHERE provinceid=' . $db->quote( $provinceid ) )->fetch();
	if( $province )
	{
		$location_str['province'] = $province['type'] . ' ' . $province['name'];
	}

	$district = $db->query( 'SELECT name, type FROM ' . $db_config['prefix'] . '_location_district WHERE districtid=' . $db->quote( $districtid ) )->fetch();
	if( $district )
	{
		$location_str['district'] = $district['type'] . ' ' . $district['name'];
	}

	$ward = $db->query( 'SELECT name, type FROM ' . $db_config['prefix'] . '_location_ward WHERE wardid=' . $db->quote( $wardid ) )->fetch();
	if( $ward )
	{
		$location_str['ward'] = $ward['type'] . ' ' . $ward['name'];
	}

	return $location_str;
}
