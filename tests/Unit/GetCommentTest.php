<?php

namespace Test\Unit;

use CommentClientService\Entity\Comment;
use CommentClientService\Provider\ApiCommentProvider;
use CommentClientService\Repository\CommentsRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetCommentTest extends TestCase
{
    /**
     * @param array $data
     * @param array $expected
     *
     * @throws \Exception
     *
     * @dataProvider getCommentsDataProvider
     */
    public function testGetComments(array $data, array $expected)
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json',
            ], json_encode($data)),
        ]));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        $this->assertEquals($expected, $repository->getComments());
    }

    /**
     * @param int   $id
     * @param array $data
     * @param Comment $comment
     *
     * @throws \Exception
     *
     * @dataProvider getCommentDataProvider
     */
    public function testGetComment(int $id, array $data, Comment $comment)
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json',
            ], json_encode($data)),
        ]));

        $repository = new  CommentsRepository(
            new ApiCommentProvider(new Client(['handler' => $handlerStack]))
        );

        $this->assertEquals($comment, $repository->getComment($id));
    }

    public function getCommentsDataProvider()
    {
        return [
            [
                [
                    'status' => 'success',
                    'data'   => null,
                ],
                [],
            ],
            [
                [
                    'status' => 'success',
                    'data'   => [
                        ['id' => 1, 'name' => 'TestName', 'text' => 'Test text'],
                        ['id' => 2, 'name' => 'TestName_2', 'text' => 'Test text 2'],
                        ['id' => 3, 'name' => 'TestName_3', 'text' => 'Test text 3'],
                    ],
                ],
                [
                    new Comment(['id' => 1, 'name' => 'TestName', 'text' => 'Test text']),
                    new Comment(['id' => 2, 'name' => 'TestName_2', 'text' => 'Test text 2']),
                    new Comment(['id' => 3, 'name' => 'TestName_3', 'text' => 'Test text 3']),
                ],
            ],
        ];
    }

    public function getCommentDataProvider()
    {
        return [
            [
                11,
                [
                    'status' => 'success',
                    'data'   => ['id' => 11, 'name' => 'TestName', 'text' => 'Test text'],
                ],
                new Comment(['id' => 11, 'name' => 'TestName', 'text' => 'Test text']),
            ],
        ];
    }
}