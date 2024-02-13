<?php
use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class PublisherTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_publishers'; // Имя таблицы в базе данных
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
                'title' => 'ID'
            )),
            new Entity\StringField('TITLE', array(
                'required' => true,
                'title' => 'Название'
            )),
            new Entity\StringField('CITY', array(
                'title' => 'Город'
            )),
            new Entity\FloatField('AUTHOR_PROFIT', array(
                'title' => 'Гонорар автора за экземпляр'
            )),
            new Entity\IntegerField('BOOK_ID'),
            (new Entity\ReferenceField(
                'BOOK',
                BookTable::class,
                Join::on('this.BOOK_ID', 'ref.ID')
            ))->configureJoinType('inner')
        );
    }
}