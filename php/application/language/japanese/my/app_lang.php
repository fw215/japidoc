<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['app_title'] = 'Japidoc';
$lang['app_title_mini'] = 'JAD';

$lang['app_aside_header'] = 'メニュー';
$lang['app_aside'] = array();
$lang['app_aside'][] = array(
	'icon' => '<i class="fa fa-tachometer" aria-hidden="true"></i>',
	'class' => 'dashboard',
	'method' => 'index',
	'link' => '',
	'name' => 'ダッシュボード',
	'children' => array(),
);
$lang['app_aside'][] = array(
	'icon' => '<i class="fa fa-star" aria-hidden="true"></i>',
	'class' => 'projects',
	'method' => 'index',
	'link' => '',
	'name' => 'プロジェクト',
	'children' => array(),
);