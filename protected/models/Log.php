<?php

/**
 * This is the model class for table "{{log}}".
 *
 * The followings are the available columns in table '{{log}}':
 * @property integer $id
 * @property string $username
 * @property string $content
 * @property integer $groupid
 * @property integer $keywordid
 * @property string $type
 * @property integer $msgid
 * @property integer $entry_time
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Log the static model class
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
		return 'wx_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, content, groupid, type, msgid, entry_time', 'required'),
			array('groupid, msgid, entry_time', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>1024),
			array('content', 'length', 'max'=>2048),
			array('type', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, content, groupid, keywordid, type, msgid,  entry_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keywordid'),
			'group' => array(self::BELONGS_TO, 'Group', 'groupid'),
			'message' => array(self::BELONGS_TO, 'Message', 'msgid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'username' => '用户名称',
			'content' => '内容',
			'groupid' => '规则',
			'keywordid' => '关键词',
			'type' => '消息类型',
			'msgid' => '消息或优惠券的ID',
			'entry_time' => '发送时间',
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

		$criteria->compare('id',$this->id);

		$criteria->compare('username',trim($this->username),true);

		$criteria->compare('content',$this->content,true);

		$criteria->compare('groupid',$this->groupid);

		$criteria->compare('keywordid',$this->keywordid);

		$criteria->compare('type',$this->type,true);

		$criteria->compare('msgid',$this->msgid);

		$criteria->compare('entry_time',$this->entry_time);
		
		$criteria->with = array(
			'keyword'=>array('select'=>'name'),
			'group'=>array('select'=>'name'),
			'message'=>array('select'=>'content'),
		);
		
		return new CActiveDataProvider('Log', array(
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