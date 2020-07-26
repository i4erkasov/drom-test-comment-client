<?php

namespace CommentClientService;

use CommentClientService\Provider\ApiCommentProvider;
use CommentClientService\Entity\Comment;
use CommentClientService\Repository\CommentsRepository;
use GuzzleHttp\Client;

class ApiCommentClient
{
    const API_BASE_URL = 'http://exemple.com';

    /**
     * @var CommentsRepository $repository
     */
    protected CommentsRepository $repository;

    public function __construct()
    {
        $this->repository = new CommentsRepository(
            new ApiCommentProvider(
                new Client([
                    'base_uri' => self::API_BASE_URL,
                    'defaults' => [
                        'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
                    ],
                ])
            )
        );
    }

    /**
     * @return Comment[]|array
     */
    public function getComments(): array
    {
        return $this->repository->getComments();
    }

    /**
     * @param int $id
     *
     * @return Comment|null
     */
    public function getComment(int $id): ?Comment
    {
        return $this->repository->getComment($id);
    }

    /**
     * @param Comment $comment
     */
    public function createComment(Comment $comment): void
    {
        $this->repository->createComment($comment);
    }

    /**
     * @param Comment $comment
     */
    public function updateComment(Comment $comment): void
    {
        $this->repository->updateComment($comment);
    }
}