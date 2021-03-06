<?php

require_once __DIR__ . '/../config/config.php';

$id = isset($_GET['id']) ? $_GET['id'] : false;

if(!$id) {
	echo 'id не передан';
	exit();
}

$sql = "SELECT * FROM images WHERE id = $id";

$galleryItem = showForRender($sql);

if(!$galleryItem) {
	echo "404";
	die;
}

$galleryContent = renderGallery($galleryItem, "galleryItem.tpl");

echo render(TEMPLATES_DIR . 'index.tpl', [
	'title' => $galleryItem[0]['title'],
	'content' => $galleryContent,
	'h1' => $galleryItem[0]['title']
]);

$newViewCount = $galleryItem[0]['views'] + 1;
$sqlViewCount = 'UPDATE `images` SET `views` = '.$newViewCount.' WHERE `images`.`id` = '.$id;
execQuery($sqlViewCount);
