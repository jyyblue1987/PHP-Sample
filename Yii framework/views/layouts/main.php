<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mystyle.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/token-input.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/token-input-facebook.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jqueryui.css" />

	<?php
        $cs = Yii::app()->clientScript;

        $cs->scriptMap = array(
            'jquery.js' => '',//Yii::app()->request->baseUrl.'/js/jquery.js',
            'jquery.yii.js' => Yii::app()->request->baseUrl.'/js/jquery.min.js',
        );

        //$cs->registerCoreScript('jquery');
        //$cs->registerCoreScript('jquery.ui');
    ?>

	<script type='text/javascript' src='./js/jquery.min.js'></script>
    <script type='text/javascript' src='./js/jquery.ui.js'></script>
    <!--<script type='text/javascript' src='./js/jquery.tokeninput.js'></script>-->
    <script type='text/javascript' src='./js/jquery.browser.min.js'></script>
    <!--<script type='text/javascript' src='./js/jquery-ui.custom.min.js'></script>-->

    <script type='text/javascript' src='./js/jquery.appear-1.1.1.js'></script>
    <script type='text/javascript' src='./js/tooltip.min.js'></script>

    <script type='text/javascript' src='./js/tinymce.editor.js'></script>

    <script type='text/javascript' src='./js/core.js'></script>
    <script type='text/javascript' src='./js/ajax.js'></script>
    <script type='text/javascript' src='./js/funcs.js' type='text/javascript'></script>
        

	<script type='text/javascript'>
        //$(document).ready(function(){
        var changes_warning = 'Y';
        $(function(){
                $.runCart('A');
        });
        //});
    </script>

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/css/images/smartaxa.ico" />
	<title>
		<?php //echo CHtml::encode($this->pageTitle); ?>
		PhoneBook
	</title>
</head>

<body>

    <?php   require_once("topmenu.php"); ?>
	<?php
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	?>

    <div id="main_column" class="clear">
        <div>
                <?php echo $content; ?>
        </div>
    </div>

</body>
</html>
