<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\IO\Directory;

use Imugalimov\Testwork\CitiesTable;

class imugalimov_testwork extends CModule
{
    public function __construct ()
    {
	    $this->MODULE_VERSION = '1.0.0';
	    $this->MODULE_VERSION_DATE = '2021-12-24';
        $this->MODULE_ID = 'imugalimov.testwork';
        $this->MODULE_NAME = 'Тестовое задание';
        $this->MODULE_DESCRIPTION = 'Тестовое задание (Мугалимов И.Р.)';
        $this->PARTNER_NAME = 'Мугалимов И.Р.';
        $this->PARTNER_URI = 'https://imugalimov.ru';
    }

    public function DoInstall ()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->InstallDB();
        $this->InstallFiles();
    }

    public function DoUninstall ()
    {
        $this->UninstallDB();
        $this->UninstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function InstallDB ()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            CitiesTable::getEntity()->createDbTable();
            $this->fillDatabase();
        }
    }

    public function UninstallDB ()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            if (Application::getConnection()->isTableExists(Base::getInstance('Imugalimov\Testwork\CitiesTable')->getDBTableName())) {
                $connection = Application::getInstance()->getConnection();
                $connection->dropTable(CitiesTable::getTableName());
            }
        }
    }

    /*
    * Поскольку в условиях задачи указано, что данные будут поступать извне, я заполню таблицу тестовыми данными при установке
    */
    protected function fillDatabase ()
    {

        $testData = [
            [
                "name" => "Орел",
                "population" => 800000,
                "income" => 30000000,
                "expenses" => 10000000,
            ],
            [
                "name" => "Екатеринбург",
                "population" => 400000,
                "income" => 20000000,
                "expenses" => 15000000,
            ],
            [
                "name" => "Нальчик",
                "population" => 1200000,
                "income" => 10000000,
                "expenses" => 6000000,
            ],
            [
                "name" => "Курск",
                "population" => 200000,
                "income" => 35000000,
                "expenses" => 800000,
            ],
            [
                "name" => "Белогвардейск",
                "population" => 500000,
                "income" => 25000000,
                "expenses" => 500000,
            ],
            [
                "name" => "Полярный",
                "population" => 700000,
                "income" => 15000000,
                "expenses" => 28000000,
            ],
            [
                "name" => "Брянск",
                "population" => 900000,
                "income" => 38000000,
                "expenses" => 15000000,
            ],
            [
                "name" => "Севастополь",
                "population" => 1800000,
                "income" => 28000000,
                "expenses" => 17000000,
            ],
            [
                "name" => "Симферополь",
                "population" => 8000000,
                "income" => 18000000,
                "expenses" => 27000000,
            ],
            [
                "name" => "Оймякон",
                "population" => 300000,
                "income" => 10000000,
                "expenses" => 25000000,
            ],
        ];

        foreach ($testData as $testDataItem) {
            CitiesTable::add($testDataItem);
        }

    }

    public function InstallFiles()
    {

        $localPath = str_replace(Application::getDocumentRoot(),'',__DIR__);
        $localPathExploded = explode(DIRECTORY_SEPARATOR,$localPath);

        if ($localPathExploded[1] == 'local') {
            $compoPath = Application::getDocumentRoot().'/local/components/'.$this->MODULE_ID.'/';
        } else {
            $compoPath = Application::getDocumentRoot().'/bitrix/components/'.$this->MODULE_ID.'/';
        }

        CopyDirFiles(
            __DIR__.'/components',
            $compoPath,
            true,
            true
        );
    }

    public function UninstallFiles ()
    {

        $localPath = str_replace(Application::getDocumentRoot(),'',__DIR__);
        $localPathExploded = explode(DIRECTORY_SEPARATOR,$localPath);

        if ($localPathExploded[1] == 'local') {
            $compoPath = Application::getDocumentRoot().'/local/components/'.$this->MODULE_ID;
        } else {
            $compoPath = Application::getDocumentRoot().'/bitrix/components/'.$this->MODULE_ID;
        }

        Directory::deleteDirectory($compoPath);
        
    }

}