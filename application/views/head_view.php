<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>ektf.online könyvtár<?php if (isset($title) && $title != ''): echo ' | '; endif; ?><?php echo $title; ?></title>
<?php
if (isset($javascript) && count($javascript) > 0):
	foreach ($javascript as $filename):

?>
	<script src="<?php echo $this->config->item('base_url'); ?>js/<?php echo $filename; ?>.js" type="text/javascript" language="javascript" charset="utf-8"></script>
<?php
	endforeach;
endif;
?>
<?php
if (isset($css) && count($css) > 0):
?>
	<style type="text/css" media="screen">
	/* <![CDATA[ */
<?php
	foreach ($css as $filename):

?>
	@import "<?php echo $this->config->item('base_url'); ?>css/<?php echo $filename; ?>.css";
<?php
	endforeach;
?>
	/* ]]> */
	</style>
<?php
endif;
?>
</head>
<body>
	<div id="login">
	<div id="logo">
		<h1>ektf.online könyvtár</h1>
		<h5>matematika én informatika tanszék</h5>
	</div>
	
		<div id="body">
