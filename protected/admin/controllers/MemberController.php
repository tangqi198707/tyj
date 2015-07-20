<?php 
class MemberController extends Controller{
	
	public $layout='adminLayout';
	
	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function actionAdmin()
	{
		$model=new Member('search');
		$model->unsetAttributes();  // clear any default values
		$paramArr = array();
		if(isset($_GET['Member'])){
			$model->attributes=$_GET['Member'];
		
			if($_GET ['Member'] && array_filter($_GET ['Member'])){
				$paramArr['Member'] = $_GET ['Member'];
			}
			$_GET['Member_page'] = isset($_GET['Member_page'])?$_GET['Member_page']:1;
			if($_GET['Member_page']){
				$paramArr['Member_page'] = $_GET['Member_page'];
			}
		}
		$this->render('admin',array(
			'model'=>$model,
			'search'=> isset($_GET['Member'])?$_GET ['Member']:'',
			'paramArr' => $paramArr,
		));
	}
	
	public function actionDelete()
	{	
		$str = isset ( $_GET ['str'] ) ? $_GET ['str'] : '';
		$page = isset ( $_GET ['Member_page'] ) ? $_GET ['Member_page'] : 1;
		$search = isset ( $_GET ['Member'] ) ? $_GET ['Member'] : '';
		$arr = explode ( ',', $str );
		$whereStr = '';
		for($i = 0; $i < count ( $arr ); $i ++) {
			if ($i == count ( $arr ) - 1) {
				$whereStr .= 'id="' . $arr [$i] . '" ';
			} else {
				$whereStr .= 'id="' . $arr [$i] . '" or ';
			}
		}
		if (Member::model ()->deleteAll ( $whereStr )) {
			header('content-type:text/html;charset=utf-8');
			exit ( CHtml::script ( "alert('删除成功!');location.href='" . $this->createUrl ( 'Member/admin' ) . "';" ) );
		} else
		{
			header('content-type:text/html;charset=utf-8');
			exit ( "<script>alert('删除失败,请重试!'),opener.location.reload();</script>" );
		}
	}
	
	public function actionUpdate()
	{
		$model = new Member();
		$id = $_GET ['id'];
		
		if(isset($_POST['Member']))
		{
			$adminId = Yii::app()->user->getState('adminId');
			$model->update_id = $adminId;
			
			if ($model->updateByPk($id, array('tel'=>$_POST['Member']['tel'],'attention'=>$_POST['Member']['attention'],'integral'=>$_POST['Member']['integral'],'update_id'=>$adminId ,'update_time'=>time()))) {
				header('content-type:text/html;charset=utf-8');
				exit ( CHtml::script ( "alert('修改成功');location.href='" . $this->createUrl ( 'Member/admin' ) . "';" ) );
			} else {
				header('content-type:text/html;charset=utf-8');
				exit ( "<script>alert('修改失败,请重试!')</script>" );
			}
		}
		$memberinfo = $model->findByPk($id);
		$this->renderpartial('update',array(
			'model'=>$memberinfo,
		));
	}
}
?>