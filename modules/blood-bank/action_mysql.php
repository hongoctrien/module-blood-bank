<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 29 Jun 2015 10:50:55 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_donation";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_donation_person";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_location_donor";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_locationtype";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_organize";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_organizetype";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  username varchar(50) NOT NULL DEFAULT '',
  last_name varchar(50) NOT NULL,
  first_name varchar(50) NOT NULL,
  birthday int(11) unsigned NOT NULL DEFAULT '0',
  email varchar(50) NOT NULL,
  gender varchar(1) NOT NULL,
  phone varchar(20) NOT NULL COMMENT 'Điện thoại',
  identity_card varchar(15) NOT NULL COMMENT 'Số CMND',
  blood_group varchar(2) NOT NULL COMMENT 'Nhóm máu',
  rh_ tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Máu hiếm',
  width float unsigned NOT NULL COMMENT 'Chiều cao',
  weight float unsigned NOT NULL COMMENT 'Cân nặng',
  recent_time int(11) NOT NULL COMMENT 'Thời gian hiến máu gần nhất',
  platelet tinyint(1) unsigned NOT NULL COMMENT 'Hiến tiểu cầu',
  organizetype tinyint(2) unsigned NOT NULL DEFAULT '0',
  organize varchar(255) NOT NULL COMMENT 'Tổ chức',
  resident_p varchar(10) NOT NULL COMMENT 'Thường trú - Tỉnh',
  resident_d varchar(10) NOT NULL COMMENT 'Thường trú - Huyện',
  resident_w varchar(10) NOT NULL COMMENT 'Thường trú - Xã',
  temporarily_p varchar(10) NOT NULL COMMENT 'Tạm trú - Tỉnh',
  temporarily_d varchar(10) NOT NULL COMMENT 'Tạm trú - Huyện',
  temporarily_w varchar(10) NOT NULL COMMENT 'Tạm trú - Xã',
  temporarily_s varchar(255) NOT NULL COMMENT 'Đường / Số nhà',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config(
  config_name varchar(30) NOT NULL,
  config_value varchar(255) NOT NULL,
  UNIQUE KEY config_name (config_name)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_donation(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID đợt hiến máu',
  title varchar(255) NOT NULL COMMENT 'Tiêu đề đợt hiến máu',
  organ_id mediumint(4) unsigned NOT NULL DEFAULT '0' COMMENT 'ID tổ chức thực hiện',
  donor_id mediumint(4) unsigned NOT NULL COMMENT 'ID địa điểm hiến máu',
  start_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Ngày bắt đầu',
  end_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Ngày kết thúc',
  num_blood_donor mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'Số lượng người hiến',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_donation_person(
  id int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID người hiến máu',
  donation_id mediumint(8) unsigned NOT NULL COMMENT 'ID sự kiện hiến máu',
  identity_card varchar(15) NOT NULL,
  card_code varchar(20) NOT NULL COMMENT 'Mã thẻ hiến máu',
  dose float unsigned NOT NULL COMMENT 'Lượng máu hiến',
  weight float unsigned NOT NULL COMMENT 'Cân nặng',
  pulse float NOT NULL COMMENT 'Mạch đập',
  blood_pressure varchar(20) NOT NULL COMMENT 'Huyết áp',
  state varchar(255) NOT NULL COMMENT 'Tình trạng lâm sàn',
  adduser int(11) unsigned NOT NULL COMMENT 'Người nhập',
  addtime int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian nhập',
  PRIMARY KEY (id),
  KEY id_member (addtime)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_location_donor(
  id mediumint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID địa điểm',
  title varchar(255) NOT NULL COMMENT 'Tên địa điểm',
  type_id tinyint(2) unsigned NOT NULL,
  description text NOT NULL COMMENT 'Mô tả địa điểm',
  province varchar(10) NOT NULL COMMENT 'ID Tỉnh/Thành phố',
  district varchar(10) NOT NULL COMMENT 'ID Quận/Huyện',
  extend varchar(255) NOT NULL COMMENT 'Địa chỉ mở rộng',
  status tinyint(1) unsigned NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_locationtype(
  id tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi loại địa điểm',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_organize(
  id mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_organizetype(
  id tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi loại tổ chức',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (config_name, config_value) VALUES('per_page', '20');";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (config_name, config_value) VALUES('groups_view_member', '6');";