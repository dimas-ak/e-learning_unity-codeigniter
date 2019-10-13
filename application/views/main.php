<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?PHP echo $title ?></title>
	<link href="<?PHP echo $css ?>" rel="stylesheet">
	<?PHP if(isset($css_table)): ?>
		<link href="<?PHP echo $css_table ?>" rel="stylesheet">
	<?PHP endif; ?>
	<link href="https://fonts.googleapis.com/css?family=Krub" rel="stylesheet">
	<script type="text/javascript" src="<?PHP echo $jquery ?>"></script>
	<?PHP if(isset($tinymce)): ?>
		<script src="<?PHP echo $tinymce ?>"></script>
	<?PHP endif; ?>
</head>
<body>

	<?PHP echo $view ?>

	<script type="text/javascript" src="<?PHP echo $js ?>"></script>
	<?PHP if(isset($js_table)): ?>
		<script type="text/javascript" src="<?PHP echo $js_table ?>"></script>
	<?PHP endif; ?>
</body>
</html>