<?php

namespace CommentClientService\Entity;

class Comment
{
    /**
     * @var int $id
     */
    private ?int $id;

    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var string $text
     */
    private string $text;

    /**
     * Comment constructor.
     *
     * @param array $comment
     */
    public function __construct(array $comment)
    {
        $this->id   = $comment['id'] ?? null;
        $this->name = $comment['name'];
        $this->text = $comment['text'];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}