<?php

use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class BookAuthorTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_book_author'; // Имя таблицы в базе данных
    }

    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
                'title' => 'ID'
            )),
            new IntegerField('BOOK_ID', array(
                'title' => 'ID книги'
            )),
            new IntegerField('AUTHOR_ID', array(
                'title' => 'ID автора'
            )),
            (new Reference('BOOK', BookTable::class,
                Join::on('this.BOOK_ID', 'ref.ID')))
                ->configureJoinType('inner'),
            (new Reference('AUTHOR', AuthorTable::class,
                Join::on('this.AUTHOR_ID', 'ref.ID')))
                ->configureJoinType('inner'),
        );
    }
}