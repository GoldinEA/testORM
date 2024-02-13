<?php
use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

class AuthorTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_authors'; // Имя таблицы в базе данных
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
                'title' => 'ID'
            )),
            new Entity\StringField('FIRST_NAME', array(
                'required' => true,
                'title' => 'Имя'
            )),
            new Entity\StringField('LAST_NAME', array(
                'required' => true,
                'title' => 'Фамилия'
            )),
            new Entity\StringField('SECOND_NAME', array(
                'title' => 'Отчество'
            )),
            new Entity\StringField('CITY', array(
                'title' => 'Город проживания'
            )),
            new Entity\ExpressionField(
                'AUTHORS_COUNT',
                'COUNT(DISTINCT %s)',
                'ID',
                ['data_type' => 'integer']
            ),
            (new ManyToMany('BOOKS', \BookTable::class))
                ->configureTableName('b_book_author')
                ->configureMediatorEntity('BookAuthor')
        );
    }
}