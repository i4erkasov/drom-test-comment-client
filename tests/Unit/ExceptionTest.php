<?php

namespace Test\Unit;

use Client\Entity\Comment;
use Client\Exception\ApiCommentException;
use Client\Provider\ApiCommentProvider;
use Client\Repository\CommentsRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testStatusCodeExceptionGetComments()
    {
        $handlerStack = HandlerStack::create(new MockHandler([new Response(404)]));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        $this->expectException(ApiCommentException::class);

        $repository->getComments();
    }

    public function testStatusCodeExceptionCreateComment()
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

    public function testStatusCodeExceptionUpdateComment()
    {
        $handlerStack = HandlerStack::create(new MockHandler([new Response(404)]));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        //$this->expectException(ApiCommentException::class);

        $repository->updateComment(new Comment([
            'id'   => 1,
            'name' => 'TestName',
            'text' => 'Text Test',
        ]));
    }
}