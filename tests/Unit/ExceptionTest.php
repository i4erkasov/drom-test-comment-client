<?php

namespace Test\Unit;

use CommentClientService\Entity\Comment;
use CommentClientService\Exception\ApiCommentException;
use CommentClientService\Provider\ApiCommentProvider;
use CommentClientService\Repository\CommentsRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testApiCommentExceptionGetComments()
    {
        $handlerStack = HandlerStack::create(new MockHandler([new Response(404)]));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        $this->expectException(ApiCommentException::class);

        $repository->getComments();
    }

    public function testApiCommentExceptionCreateComment()
    {
        $handlerStack = HandlerStack::create(new MockHandler([new Response(404)]));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );;

        $this->expectException(ApiCommentException::class);

        $repository->createComment(new Comment([
            'name' => 'TestName',
            'text' => 'Text Test',
        ]));
    }

    public function testApiCommentExceptionUpdateComment()
    {
        $handlerStack = HandlerStack::create(new MockHandler([new Response(404)]));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        $this->expectException(ApiCommentException::class);

        $repository->updateComment(new Comment([
            'id'   => 1,
            'name' => 'TestName',
            'text' => 'Text Test',
        ]));
    }
}