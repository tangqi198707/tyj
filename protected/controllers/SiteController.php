<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/*
	*首页
	*/
	public function actionIndex(){
		$this->render('index');
	}
	
	/*
	*活动
	*/
	public function actionActivity()
	{
		$this->render('activity');
	}

	/*
	*会员
	*/
	public function actionMember()	
	{
		$this->render('member');
	}

	/*
	*最新资讯
	*/
	public function actionNews()
	{
		$this->render('news');
	}
	

	/*
	*常见问题
	*/
	public function actionIssue()
	{
		$this->render('issue');
	}

	/*
	*视频酷图
	*/
	public function actionPicture()
	{
		$this->render('picture');
	}

	/*
	*排队预订
	*/
	public function actionReserve()
	{
		$this->render('reserve');
	}

	/*
	*联系我们
	*/
	public function actionConnact()
	{
		$this->render('connact');
	}
}