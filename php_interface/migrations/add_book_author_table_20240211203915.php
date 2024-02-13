<?php

namespace Sprint\Migration;


use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\ORM\Fields\IntegerField;

class add_book_author_table_20240211203915 extends Version
{
    protected $description = "Связывающая таблица книг и авторов";

    protected $moduleVersion = "4.6.1";

    public function up()
    {
        $entity = Base::compileEntity(
            'BookAuthor',
            [
                new IntegerField('ID', [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => 'ID'
                ]),
                new IntegerField('BOOK_ID', [
                    'title' => 'BOOK',
                    'nullable' => true,

                ]),
                new IntegerField('AUTHOR_ID', [
                    'title' => 'AUTHOR',
                    'nullable' => true,

                ])
            ]
        );

        $entity->createDbTable();
    }

    public function down()
    {
        $connection = Application::getConnection();
        $connection->dropTable('b_book_author');
    }
}
