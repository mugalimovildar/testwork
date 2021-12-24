<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use \Bitrix\Main\Entity\Query;
use \Imugalimov\Testwork\CitiesTable;
use \Imugalimov\Testwork\Helpers;

class tableOut extends CBitrixComponent 
{

    private function _checkModules() 
    {
        if (!Loader::includeModule('imugalimov.testwork')) {
            throw new \Exception('Не загружены модули необходимые для работы');
        }
        return true;
    }

    /**
     * На стороне БД не удалось оперативно сделать расчет мест в рейтингах. Поэтому 
     * в /local/modules/imugalimov.testwork/lib/helpers.php прописаны функции, которые просто сортируют полученные данные
     * по заданным параметрам, и возвращают отсортированные массивы. Решение довольно топорное, но хочу сегодня сдать
     * тестовое, а поэлегантнее пока ничего не выходит. Уверен, что через некоторое время найду толковый вариант, но пока вот так,
     * хотя бы работает :)
     **/
    public function executeComponent() 
    {

        if ($this->StartResultCache())
        {

            // Подключение необходимых модулей для работы
            $this->_checkModules();

            // Получение данных из БД
            $queryObject = new Query(CitiesTable::getEntity());
            $queryObject->setSelect(['id', 'name','population','income','expenses']);
            $queryObject->setOrder(['population' => 'DESC']);
            $queryResult = $queryObject->exec();
            $fetchedQueryResult = $queryResult->fetchAll();

            // Получение рейтингов
            $avgIncomeRating = Helpers::getAvgIncomeRating($fetchedQueryResult);
            $avgExpensesRating = Helpers::getAvgExpensesRating($fetchedQueryResult);
            $populationRating = Helpers::getPopulationRating($fetchedQueryResult);

            // Добавление в результирующий массив мест в рейтингах
            foreach ($fetchedQueryResult as $key => $curResult)
            {
                $fetchedQueryResult[$key]['avg_income_rating_place'] = array_search(
                    $curResult['id'], 
                    array_column($avgIncomeRating, 'id')
                ) + 1;
                
                $fetchedQueryResult[$key]['avg_expenses_rating_place'] = array_search(
                    $curResult['id'], 
                    array_column($avgExpensesRating, 'id')
                ) + 1;

                $fetchedQueryResult[$key]['population_rating_place'] = array_search(
                    $curResult['id'], 
                    array_column($populationRating, 'id')
                ) + 1;

            }

            $this->arResult['cities_data'] = $fetchedQueryResult;

            $this->includeComponentTemplate();

        }

    }

}
