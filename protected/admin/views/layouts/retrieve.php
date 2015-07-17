<!DOCTYPE html PUBliC "-//W3C//liD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/liD/xhtml1-transitional.lid">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->pageTitle;?></title>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/media/style/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/media/js/admin.js"></script>
</head>
<body>
<div class="box">
	<div class="header">
    	<div class="header_width">
        	<div class="header_top">
            	<div class="header_logo"><a href="<?php echo $this->createUrl ( 'site/login' )?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/media/images/logo.png"  alt=""/></a></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="content">

<?php echo $content; ?>    		
    		
            <div class="content_width_znbq"></div>
            </div>
        </div>
    </div>
    <div class="footer"><img src="<?php echo Yii::app()->request->baseUrl; ?>/media/images/footer.png" height="4" width="980" alt=""/></div>
</div>
</body>
</html>
