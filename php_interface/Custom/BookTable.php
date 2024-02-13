<?php

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Entity;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

class BookTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_books'; // Имя таблицы в базе данных
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
            new Entity\IntegerField('YEAR', array(
                'title' => 'Год издания'
            )),
            new Entity\IntegerField('COPIES_CNT', array(
                'title' => 'Тираж'
            )),
            new Entity\ExpressionField(
                'BOOKS_COUNT',
                'COUNT(*)',
            ),

            new Entity\IntegerField('PUBLISHER_ID', ['title' => 'Издательство']),
            (new Reference(
                'PUBLISHER',
                PublisherTable::class,
                Join::on('this.PUBLISHER_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            (new ManyToMany('AUTHORS', \AuthorTable::class))
                ->configureTableName('b_book_author')
                ->configureMediatorEntity('BookAuthor'),

        );
    }

    /**
     * Получить количество книг одного автора с фамилией F, напечатанных в издательстве P.
     * @param array $authorsLastNames Фамилии авторов.
     * @param array $publisherNames   Наименования издательств.
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getCountFromPublishAuthor(array $authorsLastNames = [], array $publisherNames = []): array
    {
        $filter = [];

        if (!empty($authorsLastNames)) {
            $filter['=AUTHORS.LAST_NAME'] = $authorsLastNames;
        }

        if (!empty($publisherNames)) {
            $filter['=PUBLISHER.TITLE'] = $publisherNames;
        }

        $result = self::getList(
            [
                'select' => ['BOOKS_COUNT'],
                'filter' => $filter
            ]
        );

        return $result->fetch() ?? [];
    }

    /**
     * Получить гонорар соавторов A и B книги С.
     * @param int $bookId - ID книги.
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getProfitBook(int $bookId): array
    {

        $select = [

            'AUTHORS.AUTHORS_COUNT',
            'INDIVIDUAL_PROFIT',
            'TOTAL_PROFIT'
        ];

        $result = \BookTable::getList(
            [
                'select' => $select,
                'filter' => Entity\Query::filter()
                    ->where('ID', 1),
                'runtime' => [
                    new Entity\ExpressionField(
                        'INDIVIDUAL_PROFIT',
                        'IFNULL((%s / %s), 0)',
                        ['PUBLISHER.AUTHOR_PROFIT', 'AUTHORS.AUTHORS_COUNT']
                    ),
                    new Entity\ExpressionField(
                        'TOTAL_PROFIT',
                        'IFNULL((%s * %s), 0)',
                        ['INDIVIDUAL_PROFIT', 'BOOKS_COUNT']
                    )
                ]
            ]
        );

        return $result->fetchAll() ?? [];
    }


}