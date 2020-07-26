<?php

namespace CommentClientService\Repository;

use CommentClientService\Interfaces\CommentProviderInterface;
use CommentClientService\Entity\Comment;

class CommentsRepository
{
    protected CommentProviderInterface $provider;

    /**
     * CommentsRepository constructor.
     *
     * @param CommentProviderInterface $provider
     */
    public function __construct(CommentProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return Comment[]|array
     */
    public function getComments(): array
    {
        return $this->provider->getComments();
    }

    /**
     * @param int $id
     *
     * @return Comment|null
     */
    public function getComment(int $id): ?Comment
    {
        return $this->provider->getComment($id);
    }

    /**
     * @param Comment $comment
     */
    public function createComment(Comment $comment): void
    {
        $this->provider->createComment($comment);
    }

    /**
     * @param Comment $comment
     */
    public function updateComment(Comment $comment): void
    {
        $this->provider->updateComment($comment);
    }
}