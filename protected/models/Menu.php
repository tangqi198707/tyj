<?php

/**
 * This is the model class for table "{{Menu}}".
 *
 * The followings are the available columns in table '{{Menu}}':
 * @property integer $id
 * @property string $name
 * @property integer $weight
 * @property integer $entry_id
 * @property integer $entry_time
 * @property integer $update_id
 * @property integer $update_time
 */
class Menu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Menu the static model class
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
		return 'wx_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, entry_id, entry_time,pid', 'required'),
			array(' weight, entry_id, entry_time, update_id, update_time,pid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name,  weight, entry_id, entry_time, update_id, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function getMenuJson(){
		$menus = Menu::model()->with('msg')->findAll(array(
			'condition' => 'status = 1',
			'order' => 'weight',
		));
		$arr = array();
		foreach($menus as $key => $model){
			$count = Menu::model()->count(array(
				'condition' => 'pid = '.$model->id.' and status = 1',
				'order' => 'weight',
			));
			if($count == 0){
				$arrMsg = array();
				if($model->msg->type != ''){
					$type = $model->msg->type;
					$arrMsg['id'] = $model->msg->id;
					$arrMsg['type'] = $type;
					$content = '';
					if($type == 'text'){
						$content = Message::showEmotions($model->msg->content);
					}else if($type == 'view'){
						$content = $model->msg->content;
					}else if($type == 'news'){
						$content = array();
						$content['title'] = $model->msg->title;
						$content['date'] = date('Y/m/d',$model->msg->entry_time);
						$content['imgurl'] = $model->msg->imgurl;
						$content['multiple'] = $model->msg->multiple;
						$content['body'] = $model->msg->multiple == 1 ? json_decode(strip_tags($model->msg->content,"<br>")) : str_replace(array("\r\n","\n"),array("<br>","<br>"),$model->msg->abstract ? $model->msg->abstract : strip_tags($model->msg->content,"<br>"));
					}
					$arrMsg['content'] = $content;
					$arr['menu_'.$model->id] = $arrMsg;
				}
			}
		}
		return json_encode($arr);
	}
	
	public function getWxMenuJson(){//生成微信自定义菜单 json
		$menus = Menu::model()->with('msg')->findAll(array(//一级菜单
			'condition' => 'pid = 0 and status = 1',
			'order' => 'weight',
		));
		if(count($menus) == 0){
			return 'null menu';//空菜单，不能同步
		}
		$arr = array();
		$arrBtn = array();
		foreach($menus as $key => $model){
			$subMenu = Menu::model()->with('msg')->findAll(array(//二级菜单
				'condition' => 'pid = '.$model->id.' and status = 1',
				'order' => 'weight',
			));
			if(count($subMenu) == 0 && $model->msg_id == 0){//一级菜单无子菜单无回复
				return 'no response';
			}
			$btn = array();
			if(count($subMenu) == 0){
				$type = $model->msg->type;
				$btn['name'] = urlencode($model->name);
				if($type == 'view'){
					$btn['type'] = $type;
					$btn['url'] = $model->msg->content;
				}else{
					$btn['type'] = 'click';
					$btn['key'] = 'msg_'.$model->msg->id;
				}
				$arrBtn[] = $btn;
			} else {
				$btn['name'] = urlencode($model->name);
				$bt = array();
				foreach($subMenu as $k => $v){
					$b = array();
					if($v->msg_id == 0){
						return 'no response';
					}
					$type = $v->msg->type;
					$b['name'] = urlencode($v->name);
					if($type == 'view'){
						$b['type'] = $type;
						$b['url'] = urlencode($v->msg->content);
					}else{
						$b['type'] = 'click';
						$b['key'] = 'msg_'.$v->msg->id;
					}
					$bt[] = $b;
				}
				$btn['sub_button'] = $bt;
				$arrBtn[] = $btn;
			}
		}
		$arr['button'] = $arrBtn;
		return urldecode(json_encode($arr));
	}
	
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'msg' => array(self::BELONGS_TO, 'MenuMsg', 'msg_id'),
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
			'weight' => 'Weight',
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

		$criteria->compare('id',$this->id);

		$criteria->compare('name',$this->name,true);


		$criteria->compare('weight',$this->weight);

		$criteria->compare('entry_id',$this->entry_id);

		$criteria->compare('entry_time',$this->entry_time);

		$criteria->compare('update_id',$this->update_id);

		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider('Menu', array(
			'criteria'=>$criteria,
		));
	}
}