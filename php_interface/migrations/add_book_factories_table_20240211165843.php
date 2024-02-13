<?php

namespace Sprint\Migration;

use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Entity\FloatField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\TextField;
use Bitrix\Main\ORM\Fields\IntegerField;

class add_book_factories_table_20240211165843 extends Version
{
    protected $description = "Таблица издательства";

    protected $moduleVersion = "4.6.1";

    public function up()
    {
        $entity = Base::compileEntity(
            'Publishers',
            [
                new IntegerField('ID', [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => 'ID'
                ]),
                new StringField('TITLE', [
                    'required' => true,
                    'title' => 'Название'
                ]),
                new StringField('CITY', [
                    'title' => 'Город'
                ]),
                new FloatField('AUTHOR_PROFIT', [
                    'title' => 'Гонорар автора за экземпляр'
                ]),
                new IntegerField('BOOK_ID', [
                    'title' => 'ID Книги',
                    'nullable' => true,
                ])
            ]
        );

        $entity->createDbTable();
    }

    public function down()
    {
        $connection = Application::getConnection();
        $connection->dropTable('b_publishers');
    }
}
