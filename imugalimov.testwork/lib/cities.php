<?php

namespace Imugalimov\Testwork;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;

class CitiesTable extends DataManager {

    public static function getTableName() 
    {
        return 'testwork_cities';
    }

    public static function getMap() 
    {

    	return ([
    		
    		new IntegerField ('id',[
                'autocomplete' => true,
                'primary' => true
    		]),

    		new StringField ('name',[
    			'required' => true,
    			'title' => 'Название города',
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                }
    		]),

    		new IntegerField ('population',[
    			'required' => true,
    			'title' => 'Количество жителей'
    		]),

    		new IntegerField ('income',[
    			'required' => true,
    			'title' => 'Доходы общие'
    		]),

    		new IntegerField ('expenses',[
    			'required' => true,
    			'title' => 'Расходы общие'
    		]),

    	]);

    }

}
