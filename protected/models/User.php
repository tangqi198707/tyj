<?php

/**
 * This is the model class for table "{{User}}".
 *
 * The followings are the available columns in table '{{User}}':
 * @property integer $id
 * @property string $wxkey
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'wx_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wxkey,entry_time', 'required'),
			array('entry_time,sex', 'numerical', 'integerOnly'=>true),
			array('wxkey,city_name,province,country', 'length', 'max'=>50),
			array('nickname', 'length', 'max'=>100),
			array('headimgurl', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, wxkey', 'safe', 'on'=>'search'),
		);
	}

	
	public function createNewUser($wxkey,$user){
		$wechatObj = new WechatCallbackapiIsd();
		$userInfo = $wechatObj->getUserInfo($wxkey);
		$user->nickname = $userInfo->nickname;
		$user->sex = $userInfo->sex;
		$user->city_name = $userInfo->city;
		$user->province = $userInfo->province;
		$user->country = $userInfo->country;
		$user->headimgurl = $userInfo->headimgurl;
		$user->wxkey = $wxkey;
		$user->entry_time = time();
		if(!$user->save()){
			return false;
		}
		return $user;
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	public static function getUserName($id)
	{
		if($id){
			$UserName = User::model()->findByPk($id);
		}
		return $UserName->nickname;
	}	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'wxkey' => 'OPENID(微)',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('nickname',$this->nickname,true);

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
			'pagination'=>array(
       			 'pagesize'=>20,
    		),
    		'sort' => array(
				 'defaultOrder' => 't.id desc',
			)
		));
	}
}