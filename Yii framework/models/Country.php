<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property string $id
 * @property string $name
 * @property string $phone_prefix
 */
class Country extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Country the static model class
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
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, phone_prefix', 'required'),
			array('name', 'length', 'max'=>80),
			array('phone_prefix', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, phone_prefix', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'phone_prefix' => 'Phone Prefix',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone_prefix',$this->phone_prefix,true);
		
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
		));
	}
	
	public function findByPhonePrefix( $phone_prefix )
	{
		$country = $this->find("phone_prefix='" . $phone_prefix . "'");
		
		return $country;
	}
	
	public function findByName( $name )
	{
		$country = $this->find("name='" . $name . "'");
		
		return $country;
	}
	
	public function addCountry( $country_info )
	{
		$find_country = $this->findByName( $country_info['name'] );
		if( $find_country !== null )
			return "Country name " . $country_info['name'] . " is already in use.";
			
		$find_country = $this->findByPhonePrefix( $country_info['phone_prefix'] );
		if( $find_country !== null )
			return "Phone prefix " . $country_info['phone_prefix'] . " is already in use.";

		$this->attributes=$country_info;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
	
	public function saveCountry( $country_info )
	{
		if( $country_info['name'] !== $this->name )
		{
			$find_country = $this->findByName( $country_info['name'] );
		
			if( $find_country !== null && $find_country->id !== $this->id )
				return "Country name " . $country_info['name'] . " is already in use.";
		}
		
		if( $country_info['phone_prefix'] !== $this->phone_prefix )
		{
			$find_country = $this->findByPhonePrefix( $country_info['phone_prefix'] );
			if( $find_country !== null && $find_country->id !== $this->id )
				return "Phone prefix " . $country_info['phone_prefix'] . " is already in use.";
		}

		$this->attributes=$country_info;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
}