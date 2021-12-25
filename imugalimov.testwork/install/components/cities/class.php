<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use \Bitrix\Main\Entity\Query;
use \Imugalimov\Testwork\CitiesTable;

class tableOut extends CBitrixComponent 
{

    private function _checkModules() 
    {
        if (!Loader::includeModule('imugalimov.testwork')) {
            throw new \Exception('Не загружены модули необходимые для работы');
        }
        return true;
    }

    private function getData()
    {

            // Подключение необходимых модулей для работы
            
            $this->_checkModules();

            // Получение данных из БД

            $queryObject = new Query(CitiesTable::getEntity());

            $queryObject->registerRuntimeField('exrat',[
                'data_type' => 'integer',
                'expression' => ['ROW_NUMBER() over (ORDER BY (expenses / population) DESC)']
            ]);

            $queryObject->registerRuntimeField('inrat',[
                'data_type' => 'integer',
                'expression' => ['ROW_NUMBER() over (ORDER BY (income / population) DESC)']
            ]);

            $queryObject->registerRuntimeField('poprat',[
                'data_type' => 'integer',
                'expression' => ['ROW_NUMBER() over (ORDER BY population DESC)']
            ]);

            $queryObject->setSelect([
                'name',
                'population',
                'income',
                'expenses',
                'exrat',
                'inrat',
                'poprat'
            ]);

            $queryObject->setOrder(['population' => 'DESC']);

            $queryResult = $queryObject->exec();

            return ($queryResult->fetchAll());

    }

    public function executeComponent() 
    {

        if ($this->StartResultCache())
        {

            $this->arResult['cities_data'] = $this->getData();

            $this->includeComponentTemplate();

        }

    }

}
