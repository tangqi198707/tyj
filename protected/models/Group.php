<?php

/**
 * This is the model class for table "{{group}}".
 *
 * The followings are the available columns in table '{{group}}':
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $status
 * @property string $entry_id
 * @property integer $entry_time
 * @property string $update_id
 * @property integer $update_time
 */
class Group extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Group the static model class
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
		return 'wx_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, entry_id, entry_time', 'required'),
			array('status, entry_time, update_time', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('type', 'length', 'max'=>16),
			array('entry_id, update_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type, status, entry_id, entry_time, update_id, update_time', 'safe', 'on'=>'search'),
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
			'keywords' => array(self::HAS_MANY, 'Keyword', 'groupid'),
			'messages' => array(self::HAS_MANY, 'Message', 'groupid'),
		);
	}

	//获取当前规则名
	public static function getGroupName($id)
	{
		if($id){
			$groupName = Group::model()->findByPk($id);
		}
		return $groupName->name;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'type' => 'Type',
			'status' => 'Status',
			'entry_id' => 'Entry',
			'entry_time' => 'Entry Time',
			'update_id' => 'Update',
			'update_time' => 'Update Time',
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

		$criteria->compare('t.name',trim($this->name),true);

		$criteria->compare('type',$this->type,true);

		$criteria->compare('status',$this->status);
		
		$criteria->with = array('keywords'=>array('order'=>'keywords.id'),'messages'=>array('order'=>'messages.id'));

		//按时间搜索
		$start = strtotime ( trim ( $_GET ['Group'] ['publish_start'] ) );
		$publish_end = strtotime ( trim ( $_GET ['Group'] ['publish_end'] ) );
		$end = $publish_end + 86400;
		//exit(date('Y-m-d H:i:s',$start).'***'.date('Y-m-d H:i:s',$end));
		if ($_GET ['Group'] ['publish_start'] && $_GET ['Group'] ['publish_end']) {
			$criteria->addCondition ( array ("t.entry_time > :start", "t.entry_time < :end" ) );
			$criteria->params [':start'] = $start;
			$criteria->params [':end'] = $end;
		} else if ($_GET ['Group'] ['publish_start']) {
			$criteria->addCondition ( "t.entry_time > :start" );
			$criteria->params [':start'] = $start;
		} else if ($_GET ['Group'] ['publish_end']) {
			$criteria->addCondition ( "t.entry_time < :end" );
			$criteria->params [':end'] = $end;
		}

		return new CActiveDataProvider('Group', array(
			'criteria'=>$criteria,
			'pagination'=>array(
       			 'pagesize'=>4,
    		),
    		'sort' => array(
				 //所以关于csort的设置都可以在这里进行
				 'defaultOrder' => 'id desc',
			)
		));
	}
}