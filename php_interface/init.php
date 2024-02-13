<?php

use Bitrix\Main\Loader;
Loader::registerAutoLoadClasses(null, [
    'AuthorTable' => '/local/php_interface/Custom/AuthorTable.php',
    'BookTable' => '/local/php_interface/Custom/BookTable.php',
    'PublisherTable' => '/local/php_interface/Custom/PublisherTable.php',
    'BookAuthorTable' => '/local/php_interface/Custom/BookAuthorTable.php'

]);