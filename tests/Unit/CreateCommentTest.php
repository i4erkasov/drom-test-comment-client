<?php

namespace Test\Unit;

use Client\Entity\Comment;
use Client\Provider\ApiCommentProvider;
use Client\Repository\CommentsRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CreateCommentTest extends TestCase
{
    /**
     * @param array $data
     *
     * @throws \Exception
     *
     * @dataProvider createCommentsDataProvider
     */
    public function testCreateComments(array $data)
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(201),
        ]));

        $container = [];

        $handlerStack->push(Middleware::history($container));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        $repository->createComment(new Comment($data));

        foreach ($container as $transaction) {
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals(json_encode($data), (string)$transaction['request']->getBody());
        }
    }

    public function createCommentsDataProvider()
    {
        return [
            [
                [
                    'name' => 'CreateTestName',
                    'text' => 'Create Test text',
                ],
                [
                    'name' => 'CreateTestName_2',
                    'text' => 'Create Test text 2',
                ],
            ],

        ];
    }
}