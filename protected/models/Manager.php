<?php

/**
 * This is the model class for table "manager".
 *
 * The followings are the available columns in table 'manager':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property integer $entry_time
 * @property integer $update_time
 * @property string $entry_id
 * @property string $update_id
 * @property integer $status
 */
class Manager extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Manager the static model class
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
		return 'manager';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email,password, entry_time, entry_id, status, privileges', 'required'),
			array('entry_time, update_time, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('email', 'length', 'max'=>50),
			array('tel', 'length', 'max'=>20),
			array('entry_id, update_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, tel, entry_time, update_time, entry_id, update_id, status', 'safe', 'on'=>'search'),
		);
	}

	
	//获取当前用户名
	public static function getManagerName($id)
	{
		if($id){
			$managerName = Manager::model()->findByPk($id);
		}
		return $managerName->name;
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
			'id' => 'Id',
			'name' => '管理员',
			'email' => '邮箱',
			'entry_time' => '添加时间',
			'update_time' => '修改时间',
			'entry_id' => '添加人',
			'update_id' => '修改人',
			'tel'=>'联系电话',
			'privileges'=> '权限',
			'status' => '审核',
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

		$criteria->compare('name',trim($this->name),true);
		
		$criteria->compare('email',trim($this->email),true);
		
		$criteria->compare('tel',trim($this->tel),true);

		$criteria->compare('privileges',trim($this->privileges),true);

		return new CActiveDataProvider('Manager', array(
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

	public static function getPrivileges($id)
	{
		$manager = self::model()->findByPk($id);
		return $manager->privileges;
	}
}