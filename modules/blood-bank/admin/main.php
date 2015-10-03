<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 10 May 2015 01:36:45 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];

if( $nv_Request->isset_request( 'del', 'post' ) )
{
	$id = $nv_Request->get_int( 'id', 'post', 0 );

	if( empty( $id ) ) die( 'NO' );

	$result = $db->query( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id );
	if( $result )
	{
		die( 'OK' );
	}
	die( 'NO' );
}

$array_data = array();
$array_search = array( 'keywords' => '', 'blood_group' => '', 'gender' => '', 'user_group' => '', 'province' => 0, 'district' => 0, 'ward' => 0, 'recent_time' => '' );
$page = $nv_Request->get_int( 'page', 'get', 1 );
$per_page = $array_config['per_page'];
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
$where = '';

if( $nv_Request->isset_request( 'search', 'get' ) )
{
	$array_search['keywords'] = $nv_Request->get_title( 'keywords', 'get', '' );
	$array_search['user_group'] = $nv_Request->get_title( 'user_group', 'get', '' );
	$array_search['blood_group'] = $nv_Request->get_title( 'blood_group', 'get', '' );
	$array_search['gender'] = $nv_Request->get_title( 'gender', 'get', '' );
	$array_search['province'] = $nv_Request->get_title( 'province', 'get', '' );
	$array_search['district'] = $nv_Request->get_title( 'district', 'get', '' );
	$array_search['ward'] = $nv_Request->get_title( 'ward', 'get', '' );
	$array_search['recent_time'] = $nv_Request->get_int( 'recent_time', 'get', 0 );
	$base_url .= '&search=1';

	if( !empty( $array_search['keywords'] ) )
	{
		$where .= ' AND t1.first_name like "%' . $array_search['keywords'] . '%" OR t1.last_name like "%' . $array_search['keywords'] . '%" OR t1.email like "%' . $array_search['keywords'] . '%" OR phone like "%' . $array_search['keywords'] . '%" OR identity_card like "%' . $array_search['keywords'] . '%" OR width like "%' . $array_search['keywords'] . '%" OR weight like "%' . $array_search['keywords'] . '%" OR organize like "%' . $array_search['keywords'] . '%"';
		$base_url .= '&keywords=' . $array_search['keywords'];
	}

	if( !empty( $array_search['user_group'] ) )
	{
		if( $array_search['user_group'] == 4 ) // Thanh vien
		{
			$where .= ' AND t1.userid != 0';
		}
		elseif( $array_search['user_group'] == 5 ) // Khach
		{
			$where .= ' AND t1.userid=0';
		}
		else
		{
			$where .= ' AND group_id=' . $db->quote( $array_search['user_group'] ) ;
			$base_url .= '&user_group=' . $array_search['user_group'];
		}
		$base_url .= '&user_group=' . $array_search['user_group'];
	}

	if( !empty( $array_search['blood_group'] ) )
	{
		$where .= ' AND blood_group=' . $db->quote( $array_search['blood_group'] ) ;
		$base_url .= '&blood_group=' . $array_search['blood_group'];
	}

	if( !empty( $array_search['gender'] ) )
	{
		$where .= ' AND t1.gender=' . $db->quote( $array_search['gender'] ) ;
		$base_url .= '&gender=' . $array_search['gender'];
	}

	if( !empty( $array_search['ward'] ) )
	{
		$where .= ' AND temporarily_w=' . $db->quote( $array_search['ward'] ) ;
		$base_url .= '&ward=' . $array_search['ward'];
	}
	elseif( !empty( $array_search['district'] ) )
	{
		$where .= ' AND temporarily_d=' . $db->quote( $array_search['district'] ) ;
		$base_url .= 'district=' . $array_search['district'];
	}
	elseif( !empty( $array_search['province'] ) )
	{
		$where .= ' AND temporarily_p=' . $db->quote( $array_search['province'] ) ;
		$base_url .= 'province=' . $array_search['province'];
	}
	elseif( !empty( $array_search['recent_time'] ) )
	{
		$where .= ' AND recent_time=0 OR recent_time < ' . ( NV_CURRENTTIME - ( $array_search['recent_time'] * 86400 ) ) ;
		$base_url .= 'recent_time=' . $array_search['recent_time'];
	}
}

if( $nv_Request->isset_request( 'export', 'get' ) )
{
	if( file_exists( NV_ROOTDIR . "/includes/class/PHPExcel.php" ) )
	{
		require_once (NV_ROOTDIR . "/includes/class/PHPExcel.php");

		// Create new PHPExcel object
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load( NV_ROOTDIR . "/modules/" . $module_file . "/template.xls" );

		// Worksheet
		$objWorksheet = $objPHPExcel->getActiveSheet( );

		// Cell begin
		$Excel_Cell_Begin = 4;

		// Set page orientation and size
		$objWorksheet->getPageSetup( )->setOrientation( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
		$objWorksheet->getPageSetup( )->setPaperSize( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );
		$objWorksheet->getPageSetup( )->setHorizontalCentered( true );

		$objPHPExcel->getActiveSheet( )->getPageSetup( )->setRowsToRepeatAtTopByStartAndEnd( 1, $Excel_Cell_Begin );

		// Set Tittle
		$array_title = array(
			'no' => $lang_module['no'],
			'last_name' => $lang_module['last_name'],
			'first_name' => $lang_module['first_name'],
			'birthday' => $lang_module['birthday'],
			'gender' => $lang_module['sex'],
			'phone' => $lang_module['tel'],
			'identity_card' => $lang_module['identity_card'],
			'blood_group' => $lang_module['blood_group'],
			'width' => $lang_module['width'] . ' (m)',
			'weight' => $lang_module['weight'] . ' (kg)',
			'organize' => $lang_module['organize'],
			'resident' => $lang_module['resident'],
			'temporarily' => $lang_module['temporarily']
		);

		foreach( $array_title as $key => $value )
		{
			$TextColumnIndex = PHPExcel_Cell::stringFromColumnIndex( $columnIndex );
			$objWorksheet->setCellValue( $TextColumnIndex . '4', $value );
			$columnIndex++;
		}

		$pRow = $Excel_Cell_Begin;

		$data_export = array();
		$db->sqlreset()
		  ->select( '*' )
		  ->from( NV_PREFIXLANG . '_' . $module_data )
		  ->where( '1=1' . $where );

		$_query = $db->query( $db->sql() );

		$i=1;
		while( $row = $_query->fetch() )
		{
			$row['no'] = $i;
			$row['birthday'] = !empty( $row['birthday'] ) ? nv_date( 'd/m/Y', $row['birthday'] ) : '';
			$row['resident'] = nv_get_location( $row['resident_p'], $row['resident_d'], $row['resident_w'] );
			$row['resident'] = implode( ', ', $row['resident'] );
			$row['temporarily'] = nv_get_location( $row['temporarily_p'], $row['temporarily_d'], $row['temporarily_w'] );
			$row['temporarily'] = implode( ', ', $row['temporarily'] );
			$row['gender'] = $array_sex[$row['gender']];

			$data_export[$row['id']] = $row;
			$i++;
		}

		if( !empty( $data_export ) )
		{
			foreach( $data_export as $v )
			{
				$pRow++;
				$columnIndex = 0;
				foreach( $array_title as $key => $key_data )
				{
					$TextColumnIndex = PHPExcel_Cell::stringFromColumnIndex( $columnIndex );
					$objWorksheet->setCellValue( $TextColumnIndex . $pRow, $v[$key] );
					$objWorksheet->getStyle( 'A' . $pRow )->getAlignment( )->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
					$objWorksheet->getStyle( 'H' . $pRow )->getAlignment( )->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
					$columnIndex++;
				}
			}
		}

		$highestRow = $objWorksheet->getHighestRow( );
		$highestColumn = $objWorksheet->getHighestColumn( );

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $Excel_Cell_Begin . ':' . $highestColumn . $highestRow)->applyFromArray($styleArray);

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . change_alias( $lang_module['member_list'] ) . '.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		die();
	}
}

$db->sqlreset()
  ->select( 'COUNT(*)' )
  ->from( NV_PREFIXLANG . '_' . $module_data . ' t1' )
  ->join( 'LEFT JOIN ' . NV_USERS_GLOBALTABLE . ' t2 ON t1.userid=t2.userid LEFT JOIN ' . $db_config['prefix'] . '_groups_users t3 ON t2.userid=t3.userid' )
  ->where( '1=1' . $where );

$all_page = $db->query( $db->sql() )->fetchColumn();

$lang_module['total_member'] = sprintf( $lang_module['total_member'], $all_page );

$db->select( 't1.id, t1.userid, t1.organize, t1.last_name, t1.first_name, t1.birthday, t1.gender, t1.blood_group, t1.phone' )
  ->order( 't1.first_name' )
  ->limit( $per_page )
  ->offset( ($page - 1) * $per_page );

$_query = $db->query( $db->sql() );

while( $row = $_query->fetch() )
{
	$row['alias'] = change_alias( $row['last_name'] . ' ' . $row['first_name'] ) . '-' . $row['id'];
	$row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '/' . $row['alias'];

	$array_data[$row['id']] = $row;
}

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'SEARCH', $array_search );
$xtpl->assign( 'BASE_URL', $base_url );

if( !empty( $array_data ) )
{
	$i = $page > 1 ? ( $per_page * ( $page - 1 ) ) + 1 : 1;
	foreach( $array_data as $data )
	{
		$data['no'] = $i;
		$data['birthday'] = !empty( $data['birthday'] ) ? nv_date( 'd/m/Y', $data['birthday'] ) : '';
		$data['gender'] = $array_sex[$data['gender']];

		$data['edit_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&id=' . $data['id'];

		$xtpl->assign( 'DATA', $data );
		$xtpl->parse( 'main.loop' );
		$i++;
	}
}

$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );

$groups = array();
$result = $db->query( 'SELECT group_id, title, idsite FROM ' . NV_GROUPS_GLOBALTABLE . ' WHERE group_id NOT IN (6) AND (idsite = ' . $global_config['idsite'] . ' OR (idsite =0 AND siteus = 1)) ORDER BY idsite, weight' );
while( $row = $result->fetch() )
{
	if( $row['group_id'] < 9 ) $row['title'] = $lang_global['level' . $row['group_id']];
	$groups[$row['group_id']] = ( $global_config['idsite'] > 0 and empty( $row['idsite'] ) ) ? '<strong>' . $row['title'] . '</strong>' : $row['title'];
}
if( !empty( $groups ) )
{
	foreach( $groups as $value => $text )
	{
		$sl = $array_search['user_group'] == $value ? 'selected="selected"' : '';
		$xtpl->assign( 'GROUPS', array( 'value' => $value, 'text' => $text, 'selected' => $sl ) );
		$xtpl->parse( 'main.user_group' );
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

foreach( $array_sex as $key => $value )
{
	$sl = $array_search['gender'] == $key ? 'selected="selected"' : '';
	$xtpl->assign( 'SEX', array( 'key' => $key, 'value' => $value, 'selected' => $sl ) );
	$xtpl->parse( 'main.sex' );
}

$sql = 'SELECT * FROM ' . $db_config['prefix'] . '_location_province';
$array_province = nv_db_cache( $sql, 'provinceid', $module_name );
if( !empty( $array_province ) )
{
	foreach( $array_province as $province )
	{
		$province['selected'] = $array_search['province'] == $province['provinceid'] ? 'selected="selected"' : '';
		$xtpl->assign( 'PROVINCE', $province );
		$xtpl->parse( 'main.province' );
	}
}

for( $i = 90; $i<= 360; $i += 30 )
{
	$sl = $array_search['recent_time'] == $i ? 'selected="selected"' : '';
	$xtpl->assign( 'R_TIME', array( 'value' => $i, 'text' => sprintf( $lang_module['recent_time_month'], $i ), 'selected' => $sl ) );
	$xtpl->parse( 'main.recent_time' );
}

if( !empty( $generate_page ) )
{
	$xtpl->assign( 'PAGE', $generate_page );
	$xtpl->parse( 'main.generate_page' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';