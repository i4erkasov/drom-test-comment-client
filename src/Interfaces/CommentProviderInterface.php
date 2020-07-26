<?php

namespace CommentClientService\Interfaces;

use CommentClientService\Entity\Comment;

interface CommentProviderInterface
{
    /**
     * @return Comment[]
     */
    public function getComments(): array;

    /**
     * @param Comment $comment
     */
    public function createComment(Comment $comment): void;

    /**
     * @param Comment $comment
     */
    public function updateComment(Comment $comment): void;
}