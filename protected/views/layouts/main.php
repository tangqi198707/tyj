<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->pageTitle?></title>
<link href="/style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="box">
	<div class="width_box">
    	<div class="top">
        	<div class="logo"><img src="/images/logo.png"/></div>
            <div class="logo_bt">
            	<div class="index_top">
                    <span><a href="">注册</a></span>
                    <span>|</span>
                    <span><a href="">登录</a></span>
                    <div class="clear"></div>
                </div>
                <div class="index_link">
                    <a href="">购买门票</a>
                    <a href="">责任声明</a>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="nav">
        	<ul>
            	<li class="title"><a href="<?php echo $this->createUrl('site/index')?>" <?php echo strpos($this->route, 'index')!==false ? 'class="nav_vtd"' : '' ?>>首页</a></li>
                <li class="line"><img src="/images/nav_line.png" height="45" width="1" alt=""/></li>
            	<li class="title"><a href="<?php echo $this->createUrl('site/activity')?>" <?php echo strpos($this->route, 'activity')!==false ? 'class="nav_vtd"' : '' ?>>活动</a></li>
                <li class="line"><img src="/images/nav_line.png" height="45" width="1" alt=""/></li>
            	<li class="title"><a href="<?php echo $this->createUrl('site/member')?>" <?php echo strpos($this->route, 'member')!==false ? 'class="nav_vtd"' : '' ?>>会员</a></li>
                <li class="line"><img src="/images/nav_line.png" height="45" width="1" alt=""/></li>
            	<li class="title"><a href="<?php echo $this->createUrl('site/news')?>" <?php echo strpos($this->route, 'news')!==false ? 'class="nav_vtd"' : '' ?>>最新资讯</a></li>
                <li class="line"><img src="/images/nav_line.png" height="45" width="1" alt=""/></li>
            	<li class="title"><a href="<?php echo $this->createUrl('site/issue')?>" <?php echo strpos($this->route, 'issue')!==false ? 'class="nav_vtd"' : '' ?>>常见问题</a></li>
                <li class="line"><img src="/images/nav_line.png" height="45" width="1" alt=""/></li>
            	<li class="title"><a href="<?php echo $this->createUrl('site/picture')?>" <?php echo strpos($this->route, 'picture')!==false ? 'class="nav_vtd"' : '' ?>>视频酷图</a></li>
                <li class="line"><img src="/images/nav_line.png" height="45" width="1" alt=""/></li>
            	<li class="title"><a href="<?php echo $this->createUrl('site/reserve')?>" <?php echo strpos($this->route, 'reserve')!==false ? 'class="nav_vtd"' : '' ?>>派对预订</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    
    <?php echo $content?>
    
    </div>
</div>
</body>
</html>