<?php

/**
 * This is the model class for table "{{Category}}".
 *
 * The followings are the available columns in table '{{Category}}':
 * @property integer $id
 * @property string $name
 * @property string $property
 * @property integer $entry_id
 * @property integer $entry_time
 * @property integer $update_id
 * @property integer $update_time
 */
class WxCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
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
		return 'wx_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, property, entry_id, entry_time', 'required'),
			array('entry_id, entry_time, update_id, update_time', 'numerical', 'integerOnly'=>true),
			array('name, property', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, property, entry_id, entry_time, update_id, update_time', 'safe', 'on'=>'search'),
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
			'msgs' => array(self::HAS_MANY, 'MenuMsg', 'cate_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => '名称',
			'property' => 'Property',
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

		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider('WxCategory', array(
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