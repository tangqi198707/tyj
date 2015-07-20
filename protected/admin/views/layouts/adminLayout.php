<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->pageTitle;?></title>
<link href="/media/style/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app ()->request->baseUrl;?>/media/js/admin.js"></script>
<script type="text/javascript"src="<?php echo Yii::app ()->request->baseUrl;?>/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/media/js/jmpopups/jquery.jmpopups-0.5.1.js"></script>
<script type="text/javascript">
function checkMy(){
	ajaxBox('<?php echo $this->createUrl ( '/manager/update',array('id'=>Yii::app ()->user->getState ( 'adminId' )) )?>');
}
</script>
</head>

<body>
<div class="box">
	<div class="top_box">
	<div class="htym_top">
	    <div class="ht_title_right">
            <span class="tc"><a href="<?php echo $this->createUrl ( '/site/logout' )?>">&nbsp;退出</a></span>
            <span class="xgxx"><a href="javascript:void(0)" onclick="checkMy()">&nbsp;&nbsp;修改个人信息</a></span>
           <span class="name">您好！欢迎&nbsp;&nbsp;<?php echo Yii::app ()->user->id; $adminId = Yii::app ()->user->getState ( 'adminId' );?>&nbsp;&nbsp;进入管理中心!</span>
        </div>       
	</div>
	<div class="logo"><img src="<?php echo Yii::app ()->request->baseUrl;?>/media/images/ishowdata_logo.png" alt=""/></div>
	<div class="ht_title_box">
    <div class="ht_nav_box">
        <div class="ht_nav">
            	<ul>
                    <li><a href="<?php echo $this->createUrl ( 'manager/admin' )?>"<?php echo $this->id == 'manager' || $this->id == 'wxcategory' ? 'class="nav_vtd"' : ''?>>系统</a></li>  
                   <!--  <li><a href="<?php echo $this->createUrl ( '/srbac/authitem/frontpage' )?>"<?php echo $this->id == 'authitem' ? 'class="nav_vtd"' : ''?>>权限管理</a></li> -->
                     <li><a href="<?php echo $this->createUrl ( 'group/admin' )?>"<?php echo $this->id == 'group' || $this->id == 'message' ? 'class="nav_vtd"' : ''?>>回复</a></li>
                    <li><a href="<?php echo $this->createUrl ( 'menu/admin' )?>"<?php echo $this->id == 'menu' ? 'class="nav_vtd"' : ''?>>菜单</a></li>
                    <li><a href="<?php echo $this->createUrl ( 'menu_msg/admin' )?>"<?php echo $this->id == 'menu_msg' ? 'class="nav_vtd"' : ''?>>素材</a></li>
                    <li><a href="<?php echo $this->createUrl ( 'userMsg/admin' )?>"<?php echo $this->id == 'userMsg' ? 'class="nav_vtd"' : ''?>>消息</a></li>
                    <li><a href="<?php echo $this->createUrl ( 'member/admin' )?>"<?php echo $this->id == 'member' ? 'class="nav_vtd"' : ''?>>会员</a></li>
                    <li><a href="<?php echo $this->createUrl ( 'dynamic/admin' )?>"<?php echo $this->id == 'dynamic' ? 'class="nav_vtd"' : ''?>>新闻资讯</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
            </div>
        <div class="ht_title_bei_bottom">
            <div class="childMenu">
        		<div class="childMenuList">
        		<?php if($this->id == 'manager' || $this->id == 'wxcategory'){?>
        			<a href="<?php echo $this->createUrl ( 'manager/admin' )?>"<?php echo $this->id == 'manager' ? 'class="nav_vtd"' : ''?>>管理员</a>
        			<a href="<?php echo $this->createUrl ( 'wxcategory/admin' )?>"<?php echo $this->id == 'wxcategory' ? 'class="nav_vtd"' : ''?>>分类</a>
        		<?php }?>
        		<?php if($this->id == 'article' || $this->id == 'userinfo' || $this->id == 'scoreBack'){?>
        		<a href="<?php echo $this->createUrl ( 'userinfo/admin' )?>"<?php echo $this->route == 'userinfo/admin' ? 'class="nav_vtd"' : ''?>>关键词回复</a>
        			<a href="<?php echo $this->createUrl ( 'article/admin' )?>"<?php echo $this->route == 'article/admin' ? 'class="nav_vtd"' : ''?>>加关注回复</a>
        			<a href="<?php echo $this->createUrl ( 'scoreBack/admin' )?>"<?php echo $this->route == 'scoreBack/admin' ? 'class="nav_vtd"' : ''?>>全部消息</a>
        		<?php }?>
        		<?php if($this->id == 'qnaire' || $this->id == 'user_answer'){?>
        			<a href="<?php echo $this->createUrl ( 'qnaire/admin' )?>"<?php echo $this->id == 'qnaire' ? 'class="nav_vtd"' : ''?>>收藏消息</a>
        		<?php }?>
                <!-- <?php if($this->id == 'authitem'){?>
                         <div class="iconBox">
                            <?php echo SHtml::link(
                                    SHtml::image($this->module->getIconsPath().'/manageAuth.png',
                                            Helper::translate('srbac','Managing auth items'),
                                            array('class'=>'icon',
                                              'title'=>Helper::translate('srbac','Managing auth items'),
                                              'border'=>0
                                              )
                                        )." " .
                                        ($this->module->iconText ?
                                        Helper::translate('srbac','Managing auth items') :
                                        ""),
                                    array('authitem/manage'))
                            ?>
                            </div>
                            <div class="iconBox">
                            <?php echo SHtml::link(
                                    SHtml::image($this->module->getIconsPath().'/usersAssign.png',
                                            Helper::translate('srbac','Assign to users'),
                                            array('class'=>'icon',
                                              'title'=>Helper::translate('srbac','Assign to users'),
                                              'border'=>0,
                                              )
                                        )." " .
                                        ($this->module->iconText ?
                                        Helper::translate('srbac','Assign to users') :
                                        ""),
                                    array('authitem/assign'));?>
                            </div>
                <?php }?> -->
        		</div>
        	</div>
        </div>
    </div>
    </div>
<?php echo $content; ?> 
</div>
</div>
    <div class="hc_footer_box">
    	<div class="ht_box">
        	<div class="ht_footer">
            	<!-- <div class="ht_footer_one">
                	<p>Panasonic China Content Management System.0.042969 * 4</p>
                    <p>Powered by <span>Sushi</span>. Copyright (C) 2008 <span>01media</span>. All rights reserved.</p>
                </div> -->
                <div class="ht_footer_one">
                	<div class="ht_footer_two_left">
                    	<p class="china">首页网站地图服务条款隐私保密声明</p>
                        <p>© Panasonic Corporation of China 2012  </p>
                    </div>
                    <div class="ht_footer_two_center">Area/Country</div>
                    <div class="ht_footer_two_right">京ICP备05031335号　　　京公网安备 110105007254</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
