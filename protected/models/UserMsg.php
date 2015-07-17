<?php

/**
 * This is the model class for table "{{user_msg}}".
 *
 * The followings are the available columns in table '{{user_msg}}':
 * @property integer $id
 * @property integer $uid
 * @property string $content
 * @property integer $keyword
 * @property integer $reply
 * @property integer $star
 * @property integer $entry_time
 */
class UserMsg extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserMsg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wx_user_msg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, content, keyword, reply, star, entry_time,type', 'required'),
			array('uid, keyword, reply, star, entry_time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, content, keyword, reply, star, entry_time', 'safe', 'on'=>'search'),
		);
	}
	
	public function createUserMsg($uid,$content,$gid,$type){
		$model = new UserMsg;
		$model->uid = $uid;
		$model->content = $content;
		$model->type = $type;
		$model->keyword = $gid == 0 ? 0 : 1;
		$model->reply = 0;
		$model->star = 0;
		$model->entry_time = time();
		$model->save();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'uid' => 'Uid',
			'content' => 'Content',
			'keyword' => 'Keyword',
			'reply' => 'Reply',
			'star' => 'Star',
			'entry_time' => 'Entry Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($star)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if($star){
			$criteria->compare('star',1);
		}else{
			$criteria->compare('keyword',$this->keyword);
	
			$criteria->compare('reply',$this->reply);
	
			//按时间搜索
			$start = strtotime ( trim ( $_GET ['UserMsg'] ['start'] ) );
			$end = strtotime ( trim ( $_GET ['UserMsg'] ['end'] ) );
			$end = $end + 86400;
			//exit(date('Y-m-d H:i:s',$start).'***'.date('Y-m-d H:i:s',$end));
			if ($_GET ['UserMsg'] ['start'] && $_GET ['UserMsg'] ['end']) {
				$criteria->addCondition ( array ("t.entry_time > :start", "t.entry_time < :end" ) );
				$criteria->params [':start'] = $start;
				$criteria->params [':end'] = $end;
			} else if ($_GET ['UserMsg'] ['start']) {
				$criteria->addCondition ( "t.entry_time > :start" );
				$criteria->params [':start'] = $start;
			} else if ($_GET ['UserMsg'] ['end']) {
				$criteria->addCondition ( "t.entry_time < :end" );
				$criteria->params [':end'] = $end;
			}
			
			if($this->content){
				$criteria->addCondition ( "t.content like :content" );
				$criteria->params [':content'] = '%'.$this->content.'%';
			}
			
			if($_GET['UserMsg']['nickname']){
				$criteria->with = array( 'user' => array('condition'=>"nickname like :nickname",'params'=>array(':nickname' => $_GET['UserMsg']['nickname'].'%') ));
			}
		}

		return new CActiveDataProvider('UserMsg', array(
			'criteria'=>$criteria,
			'pagination'=>array(
       			 'pagesize'=>20,
    		),
    		'sort' => array(
				 //所以关于csort的设置都可以在这里进行
				 'defaultOrder' => 't.id desc',
			)
		));
	}
}