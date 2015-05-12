<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<!-- Apple devices fullscreen -->
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<!-- Apple devices fullscreen -->
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
		<title>
			<?php echo $cakeDescription ?>:
			<?php echo $this->fetch('title') ?>
		</title>
		<!-- Bootstrap -->
		<?php echo $this->Html->css('bootstrap.min') ?>
		<!-- Bootstrap Datepicker-->
		<?php echo $this->Html->css('plugins/datepicker/datepicker') ?>
		<!-- jQuery UI -->
		<?php echo $this->Html->css('plugins/jquery-ui/jquery-ui.min') ?>
		<!-- PageGuide -->
		<?php echo $this->Html->css('plugins/pageguide/pageguide') ?>
		<!-- chosen -->
		<?php echo $this->Html->css('plugins/chosen/chosen') ?>
		<!-- select2 -->
		<?php echo $this->Html->css('plugins/select2/select2') ?>
		<!-- icheck -->
		<?php echo $this->Html->css('plugins/icheck/all') ?>
		<!-- Notify -->
		<?php echo $this->Html->css('plugins/gritter/jquery.gritter') ?>
		<!-- Theme CSS -->
		<?php echo $this->Html->css('style') ?>
		<!-- Color CSS -->
		<?php echo $this->Html->css('themes') ?>
		<!-- FancyBox CSS -->
		<?php echo $this->Html->css('/FancyBox/source/jquery.fancybox') ?>
		<?php echo $this->Html->css('/FancyBox/source/helpers/jquery.fancybox-thumbs') ?>
		<!-- Custom CSS -->
		<?php echo $this->Html->css('custom') ?>
		<!-- jQuery -->
		<?php echo $this->Html->script('jquery.min') ?>
		<!-- Select 2 CDN -->
		<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/css/select2.min.css"/>
		<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
		<!-- MultiSelect -->
		<link rel="stylesheet" type="text/css" href="http://loudev.com/css/multi-select.css">
		<script src="http://loudev.com/js/jquery.multi-select.js"></script>
		<!-- Quicksearch -->
		<?php echo $this->Html->script('plugins/quicksearch/jquery.quicksearch') ?>
		<!-- Nice Scroll -->
		<?php echo $this->Html->script('plugins/nicescroll/jquery.nicescroll.min') ?>
		<!-- Validation -->
		<?php echo $this->Html->script('plugins/validation/jquery.validate.min') ?>
		<?php echo $this->Html->script('plugins/validation/additional-methods.min') ?>
		<!-- jQuery UI -->
		<?php echo $this->Html->script('plugins/jquery-ui/jquery-ui.js') ?>
		<!-- Touch enable for jquery UI -->
		<?php echo $this->Html->script('plugins/touch-punch/jquery.touch-punch.min') ?>
		<!-- slimScroll -->
		<?php echo $this->Html->script('plugins/slimscroll/jquery.slimscroll.min') ?>
		<!-- Bootstrap -->
		<?php echo $this->Html->script('bootstrap.min') ?>
		<!-- Bootstrap Datepicker -->
		<?php echo $this->Html->script('plugins/datepicker/bootstrap-datepicker') ?>
		<!-- Bootstrap Datepicker Lang ES -->
		<?php echo $this->Html->script('plugins/datepicker/locales/bootstrap-datepicker.es') ?>
		<!-- vmap -->
		<?php echo $this->Html->script('plugins/vmap/jquery.vmap.min') ?>
		<?php echo $this->Html->script('plugins/vmap/jquery.vmap.world') ?>
		<?php echo $this->Html->script('plugins/vmap/jquery.vmap.sampledata') ?>
		<!-- Bootbox -->
		<?php echo $this->Html->script('plugins/bootbox/jquery.bootbox') ?>
		<!-- Flot -->
		<?php echo $this->Html->script('plugins/flot/jquery.flot.min') ?>
		<?php echo $this->Html->script('plugins/flot/jquery.flot.bar.order.min') ?>
		<?php echo $this->Html->script('plugins/flot/jquery.flot.pie.min') ?>
		<?php echo $this->Html->script('plugins/flot/jquery.flot.resize.min') ?>
		<!-- imagesLoaded -->
		<?php echo $this->Html->script('plugins/imagesLoaded/jquery.imagesloaded.min') ?>
		<!-- PageGuide -->
		<?php echo $this->Html->script('plugins/pageguide/jquery.pageguide') ?>
		<!-- Chosen -->
		<?php echo $this->Html->script('plugins/chosen/chosen.jquery.min') ?>
		<!-- select2 -->
		<?php echo $this->Html->script('plugins/select2/select2.min') ?>
		<!-- icheck -->
		<?php echo $this->Html->script('plugins/icheck/jquery.icheck.min') ?>
		<!-- Notify -->
		<?php echo $this->Html->script('plugins/gritter/jquery.gritter.min') ?>
		<!-- Masked inputs -->
		<?php echo $this->Html->script('plugins/maskedinput/jquery.maskedinput.min') ?>
		<!-- Form JS -->
		<?php echo $this->Html->script('plugins/form/jquery.form.min') ?>
		<!-- Wizard -->
		<?php echo $this->Html->script('plugins/wizard/jquery.form.wizard.min') ?>
		<?php echo $this->Html->script('plugins/mockjax/jquery.mockjax') ?>
		<!-- FancyBox JS -->
		<?php echo $this->Html->script('/FancyBox/source/jquery.fancybox.pack') ?>
		<?php echo $this->Html->script('/FancyBox/source/helpers/jquery.fancybox-thumbs') ?>
		<!-- Theme framework -->
		<?php echo $this->Html->script('eakroko.min') ?>
		<!-- Theme scripts -->
		<?php echo $this->Html->script('application.min') ?>
		<!-- Just for demonstration -->
		<?php echo $this->Html->script('demonstration.min') ?>
		<!-- App -->
		<?php echo $this->Html->script('app') ?>
		<!--[if lte IE 9]>
			<script src="<?php echo $this->Html->script('plugins/placeholder/jquery.placeholder.min.js') ?>"></script>
			<script>
				$(document).ready(function() {
					$('input, textarea').placeholder();
				});
			</script>
		<![endif]-->
		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" />
		<!-- Apple devices Homescreen icon -->
		<link rel="apple-touch-icon-precomposed" href="<?php echo $this->Html->url('/img/apple-touch-icon-precomposed.png') ?>"/>
	</head>