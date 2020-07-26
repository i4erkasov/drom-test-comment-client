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

class UpdateCommentTest extends TestCase
{
    /**
     * @param array $data
     *
     * @throws \Exception
     *
     * @dataProvider updateCommentsDataProvider
     */
    public function testUpdateComments(array $data)
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(201),
        ]));

        $container = [];

        $handlerStack->push(Middleware::history($container));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        $repository->updateComment(new Comment($data));

        foreach ($container as $transaction) {
            $this->assertEquals('PUT', $transaction['request']->getMethod());
            $this->assertEquals(json_encode($data), (string)$transaction['request']->getBody());
        }
    }

    public function updateCommentsDataProvider()
    {
        return [
            [
                [
                    'id'   => 1,
                    'name' => 'UpdateTestName',
                    'text' => 'Update Test text',
                ],
                [
                    'id'   => 2,
                    'name' => 'UpdateTestName_2',
                    'text' => 'Update Test text 2',
                ],
            ],
        ];
    }
}