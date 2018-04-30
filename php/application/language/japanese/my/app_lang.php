<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['app_title'] = 'Japidoc';
$lang['app_title_mini'] = 'JAD';

$lang['app_required'] = '&ensp;<span class="label label-danger">必須</span>';
$lang['app_not_exist'] = '検索結果が0件です';
$lang['app_pages'] = 'ページ';

$lang['app_search'] = '検索';
$lang['app_add'] = '登録';
$lang['app_edit'] = '編集';
$lang['app_delete'] = '削除';

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
	'children' => array(
		array(
			'class' => 'projects',
			'method' => 'index',
			'link' => 'projects',
			'name' => '一覧',
		),
		array(
			'class' => 'projects',
			'method' => 'edit',
			'link' => 'projects/edit',
			'name' => '登録&ensp;&middot;&ensp;編集',
		)
	),
);