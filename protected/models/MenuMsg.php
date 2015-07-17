<?php

/**
 * This is the model class for table "{{Menu_msg}}".
 *
 * The followings are the available columns in table '{{Menu_msg}}':
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property string $imgurl
 * @property string $link
 * @property integer $entry_id
 * @property integer $entry_time
 * @property integer $update_id
 * @property integer $update_time
 */
class MenuMsg extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Menu_msg the static model class
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
		return 'wx_menu_msg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' type, content, entry_id, entry_time,cate_id', 'required'),
			array('  entry_id, entry_time, update_id, update_time,cate_id,multiple,fid,show,show_cover', 'numerical', 'integerOnly'=>true),
			array('title, imgurl, link,author', 'length', 'max'=>200),
			array('abstract', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('', 'safe', 'on'=>'search'),
		);
	}

	public function getMultipleNewsContent($arr){
		$array = array();
		for($i=0; $i<count($arr['title']); $i++){
			$array[$i]['title'] = $arr['title'][$i];
			$array[$i]['author'] = $arr['author'][$i];
			$array[$i]['show_cover'] = $arr['show_cover'][$i];
			$array[$i]['imgurl'] = $arr['imgurl'][$i];
			$array[$i]['content'] = CHtml::decode($arr['content'][$i]);
			$array[$i]['link'] = $arr['link'][$i];
		}
		return json_encode($array);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cate' => array(self::BELONGS_TO, 'WxCategory', 'cate_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'type' => 'Type',
			'title' => '标题',
			'content' => 'Content',
			'imgurl' => 'Imgurl',
			'link' => 'Link',
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

		$criteria->compare('type','news');
		
		$criteria->compare('cate_id',$this->cate_id);

		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider('MenuMsg', array(
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
	
	public function getNewsList($messages,$fromUsername, $toUsername, $time, $msgType,$multipleId=false){
		$count = count($messages);
		if($multipleId){
			$children = MenuMsg::model()->findAll('fid = '.$multipleId);
		}
		$rs = "<xml>
				<ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
				<FromUserName><![CDATA[".$toUsername."]]></FromUserName>
				<CreateTime>".$time."</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>".$count."</ArticleCount>
				<Articles>";
			foreach($messages as $key => $msg){
				$imgurl = "http://".$_SERVER['HTTP_HOST'].$msg->imgurl;
				$str = "<item>
				<Title><![CDATA[".$msg->title."]]></Title> 
				<Description><![CDATA[".strip_tags($msg->content,"<br><p>")."]]></Description>
				<PicUrl><![CDATA[".$imgurl."]]></PicUrl>
				<Url><![CDATA[http://".$_SERVER['HTTP_HOST'].'/site/msgDetail/id/'.$children[$key]->id."]]></Url>
				</item>";
				$rs .= $str;
			}
		$rs .= "</Articles></xml>";
		return $rs;
	}
	
	
	
	public function newsList()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('type','news');
		
		$criteria->compare('cate_id',$this->cate_id);

		$criteria->compare('title',$this->title,true);
		
		$criteria->compare('fid',0);

		return new CActiveDataProvider('MenuMsg', array(
			'criteria'=>$criteria,
			'pagination'=>array(
       			 'pagesize'=>10,
    		),
    		'sort' => array(
				 //所以关于csort的设置都可以在这里进行
				 'defaultOrder' => 't.id desc',
			)
		));
	}
}