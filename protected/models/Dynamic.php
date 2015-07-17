<?php

/**
 * This is the model class for table "{{dynamic}}".
 *
 * The followings are the available columns in table '{{dynamic}}':
 * @property integer $id
 * @property string $title
 * @property string $info_img
 * @property string $content
 * @property integer $status
 * @property integer $entry_id
 * @property integer $entry_time
 * @property integer $update_id
 * @property integer $update_time
 */
class Dynamic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wx_dynamic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, entry_id, entry_time, update_id, update_time', 'numerical', 'integerOnly'=>true),
			array('title, info_img', 'length', 'max'=>200),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, info_img, content, status, entry_id, entry_time, update_id, update_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'info_img' => 'Info Img',
			'content' => 'Content',
			'status' => 'Status',
			'entry_id' => 'Entry',
			'entry_time' => 'Entry Time',
			'update_id' => 'Update',
			'update_time' => 'Update Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('info_img',$this->info_img,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('entry_id',$this->entry_id);
		$criteria->compare('entry_time',$this->entry_time);
		$criteria->compare('update_id',$this->update_id);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
       			 'pagesize'=>20,
    		),
			'sort' => array(
				 //所以关于csort的设置都可以在这里进行
				 'defaultOrder' => 'id desc',
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dynamic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
