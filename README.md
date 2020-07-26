drom-test-client

Задание:
Необходимо реализовать клиент для абстрактного (вымышленного) сервиса комментариев "example.com". Проект должен представлять класс или набор классов, который будет делать http запросы к серверу. 
На выходе должна получиться библиотека, который можно будет подключить через composer к любому другому проекту.
У этого сервиса есть 3 метода:
GET http://example.com/comments - возвращает список комментариев
POST http://example.com/comment - добавить комментарий.
PUT http://example.com/comment/{id} - по идентификатору комментария обновляет поля, которые были в в запросе

Объект comment содержит поля:
id - тип int. Не нужно указывать при добавлении.
name - тип string.
text - тип string.

Написать phpunit тесты, на которых будет проверяться работоспособность клиента.
Сервер example.com писать не надо! Только библиотеку для работы с ним.

___
Для запуска тестов: 

установить зависимости: composer install
запустить тесты: make run-tests
___
Для установки в проект:

composer require maksmaggot/drom-test-client

Сценарий использования: 
```php

<?php

require 'vendor/autoload.php';

use CommentClientService\ApiCommentClient;
use CommentClientService\Entity\Comment;

$client = new ApiCommentClient();

// Получаем список комментариев
$comments = $client->getComments();

//создать коментарий 
$comments = new Comment([
    'name' => 'name',
    'text' => 'text',
]);

$client->createComment($comments);

// обновить комментарий по id
$comment = $client->getComment(12);

if ($comment) {
    $comments->setName('new name');
    $comments->setText('new text');

    $client->updateComment($comments);
}
```