<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property string $type
 * @property string $content
 * @property integer $groupid
 * @property integer $status
 * @property string $entry_id
 * @property integer $entry_time
 * @property string $update_id
 * @property integer $update_time
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Message the static model class
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
		return 'wx_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, groupid, entry_id, entry_time', 'required'),
			array('groupid, status, entry_time, update_time', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>16),
			array('entry_id, update_id', 'length', 'max'=>10),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type,  content,   groupid, status, entry_id, entry_time, update_id, update_time', 'safe', 'on'=>'search'),
		);
	}
	
	public static function showEmotions($content){
		$emotionsArr= new EmotionsArr;
		$divContent = str_replace($emotionsArr->emotionsCodeArr,$emotionsArr->emotionsImgArr,$content);
		return str_replace("\r\n","<br>",$divContent);
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

	public function getMsgCount($msgs,$type=1){
		$text = $func = $news = 0;
		foreach($msgs as $key => $val){
			switch($val->type){
				case 'text' : $text++;break;
				case 'func' : $func++;break;
				case 'news' : $news++;break;
			}
		}
		if($type == 1)
			return "（{$text}条文字，{$func}个函数，{$news}条图文）";
		else if($type == 2)
			return "<span>文字（<label id='textCount'>{$text}</label>）</span><span>函数（<label id='funcCount'>{$func}</label>）</span><span>图文（<label id='newsCount'>{$news}</label>）</span>";
	}
	
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'type' => '类型',
			'content' => '内容',
			'groupid' => 'Groupid',
			'status' => 'Status',
			'entry_id' => 'Entry',
			'entry_time' => 'Entry Time',
			'update_id' => 'Update',
			'update_time' => 'Update Time',
		);
	}
	
	//获取当前消息
	public static function getMessageCon($id)
	{
		if($id){
			$messageCon = Message::model()->findByPk($id);
		}
		return $messageCon->content;
	}

	
	public function getMessageByGroup($id,$type){
		$message = '';
		/*if($type == 'all'){
			return Message::model()->findAll(array(
				'condition' => "groupid = {$id} and status = 1",
			));
		}else */
		if($type == 'random'){
			/*SELECT *
				FROM `wx_message` AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `wx_message`)-(SELECT MIN(id) FROM `wx_message`))+(SELECT MIN(id) FROM `wx_message`)) AS id) AS t2
				WHERE t1.groupid = {$id} and t1.status = 1 and t1.id >= t2.id
				ORDER BY t1.id LIMIT 1*/
			$messages = Message::model()->findAll(array(
				'condition' => "groupid = {$id} and status = 1",
			));
			$count = count($messages);
			$rand = mt_rand(0,$count-1);
			//print($count.'***'.$rand.'***'.$messages[$rand]->content);echo "<br/>";
			$message = $messages[$rand];
		}else{
			$message = Message::model()->find(array(
				'condition' => "groupid = {$id} and status = 1",
				'order' => 'id desc'
			));
		}
		return $message;
	}
	
	public function getTextTpl($type,$imgurl=false,$id){
		$tpl = '';
		switch ($type){
			case 'text' : $tpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
						break;
			case 'news' : $tpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							 <ArticleCount>1</ArticleCount>
							 <Articles>
							 <item>
							 <Title><![CDATA[%s]]></Title> 
							 <Description><![CDATA[%s]]></Description>
							 <PicUrl><![CDATA[".$imgurl."]]></PicUrl>
							 <Url><![CDATA[http://".$_SERVER['HTTP_HOST'].'/site/msgDetail/id/'.$id."]]></Url></item>
							 </Articles>
							 <FuncFlag>1</FuncFlag>
							 </xml>";
						break;
		}
		return $tpl;
	}
	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($gid)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if($gid == 'default')
			$criteria->addCondition('groupid = -1');
		
		$criteria->compare('content',trim($this->content),true);

		return new CActiveDataProvider('Message', array(
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