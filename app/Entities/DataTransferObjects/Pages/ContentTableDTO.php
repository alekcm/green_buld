<?php

namespace App\Entities\DataTransferObjects\Pages;

use Illuminate\Contracts\Support\Arrayable;

class ContentTableDTO implements Arrayable
{
    protected string $name;
    protected string $id;
    /** @var ContentTableDTO[] $children */
    protected array $children;

    /**
     * @param string $name
     * @param string $id
     * @param ContentTableDTO[] $children
     */
    public function __construct(string $name, string $id, array $children)
    {
        $this->name = $name;
        $this->id = $id;
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return ContentTableDTO[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param ContentTableDTO[] $children
     */
    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

    /**
     * @param ContentTableDTO $contentTableDTO
     */
    public function addChild(ContentTableDTO $contentTableDTO): void
    {
        $this->children[] = $contentTableDTO;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'children' => array_map(function (ContentTableDTO $table) {
                return $table->toArray();
            }, $this->children),
        ];
    }
}
