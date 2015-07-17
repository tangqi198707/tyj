<?php

$backend=dirname(dirname(__FILE__));
$frontend=dirname($backend); 
Yii::setPathOfAlias('backend', $backend);

return array(
	'basePath' => $frontend,
	'name'=>'艾数达',
	'language'=>'zh_cn',
	'timeZone' => 'Asia/Shanghai',
	'charset' => 'utf-8',
	// preloading 'log' component
	'preload'=>array('log'),
	'controllerPath' => $backend.'/controllers',
	'viewPath' => $backend.'/views',
	'runtimePath' => $backend.'/runtime',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.modules.srbac.controllers.SBaseController',
		'application.components.*',
		'application.extensions.*',
		'application.components.phpmailer.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'srbac' => array(
			'userclass'=>'Manager', //default: User  对应用户的model
	        'userid'=>'id', //default: userid   用户表标识位对应字段
	        'username'=>'name', //default:username  用户表中用户名对应字段
	        'debug'=>false, //default :false 调试模式，true则所有用户均开放，可以随意修改权限控制
	        'pageSize'=>15, // default : 15
	        'superUser' =>'admin', //可选， 超级管理员，这个账号可以不受权限控制的管理，对所有页面均有访问权限
	        'css'=>'srbac.css', //default: srbac.css  样式文件
	        'layout'=>'application.admin.views.layouts.adminLayout', //可选,默认是
	        // application.views.layouts.main, 必须是一个存在的路径别名
	        'notAuthorizedView'=>'srbac.views.authitem.unauthorized', // 可选,默认是unauthorized.php
	        //srbac.views.authitem.unauthorized, 必须是一个存在的路径别名
	        'alwaysAllowed'=>array(),   //可选,默认是 array()
	        'userActions'=>array(),//default: array()
	        'listBoxNumberOfLines' => 15, //可选,默认是10
	        'imagesPath' => 'srbac.images', //可选,默认是 srbac.images
	        'imagesPack'=>'tango', //可选,默认是 noia
	        'iconText'=>true, //可选,默认是 false
	        'header'=>'srbac.views.authitem.header', //可选,默认是
	        // srbac.views.authitem.header, 必须是一个存在的路径别名
	        'footer'=>'srbac.views.authitem.footer', //可选,默认是
	        // srbac.views.authitem.footer, 必须是一个存在的路径别名
	        'showHeader'=>false, //可选,默认是false
	        'showFooter'=>false, //可选,默认是false
	        'alwaysAllowedPath'=>'srbac.components', //可选,默认是 srbac.components
	                                   // 必须是一个存在的路径别名
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
		),
		
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=tyj',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'admin',
			'charset' => 'utf8',
		),
		'authManager'=>array(
            'class'=>'application.modules.srbac.components.SDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'authitem',
			'itemChildTable'=>'authitemchild',
			'assignmentTable'=>'authassignment',
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
				/*array( 
		            'class'=>'CWebLogRoute', 
		            'levels'=>'trace',     //级别为trace 
		            'categories'=>'system.db.*' //只显示关于数据库信息,包括数据库连接,数据库执行语句 
		        ),  */
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'adminEmail'=>'webmaster@example.com',
		'pageSize' => 20,
		//'token' => 'isdhkwx2014',
		//'appid' => 'wxc2eafa6390aab781',
		//'appsecret' => 'e651f5c0eb62c8c010301bd9d22a8307'
	),
);