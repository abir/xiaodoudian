<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	  
<title><?php echo $page_title;?> | <?php echo $this->settings->item('site_name'); ?></title>
	
<!-- Language: <?php echo CURRENT_LANGUAGE ?> -->
	
<script type="text/javascript">
	var APPPATH_URI = "<?php echo $this->config->item('asset_dir');?>";
	var BASE_URI = "<?php echo BASE_URI;?>";
</script>
        
<?php echo css('style.css').css('layout.css', '_theme_');?>
	
<?php echo js('jquery/jquery.js'); ?>
<?php echo js('facebox.js').css('facebox.css');?>
		
<?php echo js('front.js'); ?>
		
<?php /*<link rel="stylesheet" type="text/css" href="css/print.css" media="print" /> */ ?>

<?php echo $extra_head_content; ?>