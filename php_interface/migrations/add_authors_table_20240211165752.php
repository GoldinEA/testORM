<?php

namespace Sprint\Migration;

use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Entity\ScalarField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\ORM\Fields\IntegerField;

class add_authors_table_20240211165752 extends Version
{
    protected $description = "Таблица авторы";

    protected $moduleVersion = "4.6.1";

    public function up()
    {
        $connection = Application::getConnection();
        $entity = Base::compileEntity(
            'Authors',
            [
                new IntegerField('ID', [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => 'ID'
                ]),
                new StringField('FIRST_NAME', [
                    'required' => true,
                    'title' => 'Имя'
                ]),
                new StringField('LAST_NAME', [
                    'required' => true,
                    'title' => 'Фамилия'
                ]),
                new StringField('SECOND_NAME', [
                    'title' => 'Отчество'
                ]),
                new StringField('CITY', [
                    'title' => 'Город проживания'
                ])
            ]
        );

        $entity->createDbTable();
    }

    public function down()
    {
        $connection = Application::getConnection();
        $connection->dropTable('b_authors');
    }
}
