<?php

namespace CommentClientService\Provider;

use CommentClientService\Entity\Comment;
use CommentClientService\Exception\ApiCommentException;
use CommentClientService\Interfaces\CommentProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class ApiCommentProvider implements CommentProviderInterface
{
    /**
     * @var Client $client
     */
    private Client $client;

    /**
     * ApiCommentProvider constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws ApiCommentException
     *
     * @return Comment[]
     */
    public function getComments(): array
    {
        try {
            $response = $this->client->get('/comments');

            $comments = \GuzzleHttp\json_decode($response->getBody()->getContents(), true)['data'] ?? [];

            foreach ($comments as $comment) {
                $result[] = new Comment($comment);
            }

            return $result ?? [];
        } catch (GuzzleException $ex) {
            throw new ApiCommentException("Error: " . $ex->getMessage(), 0, $ex);
        }
    }

    public function getComment(int $id): ?Comment
    {
        try {
            $response = $this->client->get("/comment/{$id}");

            $comment = \GuzzleHttp\json_decode($response->getBody()->getContents(), true)['data'] ?? null;

            if($comment){
                $comment = new Comment($comment);
            }

            return $comment ?? null;
        } catch (GuzzleException $ex) {
            throw new ApiCommentException("Error: " . $ex->getMessage(), 0, $ex);
        }
    }

    /**
     * @param Comment $comment
     *
     * @throws ApiCommentException
     */
    public function createComment(Comment $comment): void
    {
        try {
            $this->client->post(
                '/comment',
                [
                    RequestOptions::JSON => [
                        "name" => $comment->getName(),
                        "text" => $comment->getText(),
                    ],
                ]
            );
        } catch (GuzzleException $ex) {
            throw new ApiCommentException("Error: " . $ex->getMessage(), 0, $ex);
        }
    }

    /**
     * @param Comment $comment
     *
     * @throws ApiCommentException
     */
    public function updateComment(Comment $comment): void
    {
        try {
            $this->client->put(
                "/comment/{$comment->getId()}",
                [
                    RequestOptions::JSON => [
                        'id'   => $comment->getId(),
                        "name" => $comment->getName(),
                        "text" => $comment->getText(),
                    ],
                ]
            );
        } catch (GuzzleException $ex) {
            throw new ApiCommentException("Error: " . $ex->getMessage(), 0, $ex);
        }
    }
}