<?php

namespace Sprint\Migration;

use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\TextField;
use Bitrix\Main\ORM\Fields\IntegerField;

class add_books_table_20240211165810 extends Version
{
    protected $description = "Таблица книги";

    protected $moduleVersion = "4.6.1";

    public function up()
    {
        $entity = Base::compileEntity(
            'Books',
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
                new IntegerField('YEAR', [
                    'title' => 'Год издания'
                ]),
                new IntegerField('COPIES_CNT', [
                    'title' => 'Тираж'
                ]),
                new IntegerField('PUBLISHER_ID', [
                    'title' => 'Издательство',
                    'nullable' => true,
                ]),

            ]
        );

        $entity->createDbTable();
    }

    public function down()
    {
        $connection = Application::getConnection();
        $connection->dropTable('b_books');
    }
}
