<?php

/**
 * This is the model class for table "{{keyword}}".
 *
 * The followings are the available columns in table '{{keyword}}':
 * @property integer $id
 * @property string $name
 * @property integer $groupid
 * @property integer $count
 * @property integer $status
 * @property string $entry_id
 * @property integer $entry_time
 * @property string $update_id
 * @property integer $update_time
 */
class Keyword extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Keyword the static model class
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
		return 'wx_keyword';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, groupid, status, entry_id, entry_time', 'required'),
			array('groupid, count, status, entry_time, update_time', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('entry_id, update_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, groupid, count, status, entry_id, entry_time, update_id, update_time', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Group', 'groupid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'groupid' => 'Groupid',
			'count' => 'Count',
			'status' => 'Status',
			'entry_id' => 'Entry',
			'entry_time' => 'Entry Time',
			'update_id' => 'Update',
			'update_time' => 'Update Time',
		);
	}

	//获取当前关键字
	public static function getKeywordName($id)
	{
		if($id){
			$keywordName = Keyword::model()->findByPk($id);
		}
		return $keywordName->name;
	}
	
	public function getByKeyword($key){
		return Keyword::model()->find(array(
			'condition' => "(t.name = :key or INSTR(:key,t.name)) and t.status = 1",
			'params' => array(':key' => $key),
			'order' => 'count desc,t.id desc',
			'with' => array('group'=>array(
				'condition' => 'group.status = 1'
			)),
			
		));
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

		$criteria->compare('name',$this->name,true);

		$criteria->compare('groupid',$this->groupid);

		$criteria->compare('count',$this->count);

		$criteria->compare('status',$this->status);

		$criteria->compare('entry_id',$this->entry_id,true);

		$criteria->compare('entry_time',$this->entry_time);

		$criteria->compare('update_id',$this->update_id,true);

		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider('Keyword', array(
			'criteria'=>$criteria,
		));
	}
}