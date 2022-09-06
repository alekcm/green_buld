<?php

namespace App\Entities\DataTransferObjects\Pages;

use Illuminate\Contracts\Support\Arrayable;

class PageContentDTO implements Arrayable
{
    protected string $content;

    /** @var ContentTableDTO[] $contentTable */
    protected array $contentTable;

    /**
     * @param string $content
     * @param ContentTableDTO[] $contentTable
     */
    public function __construct(string $content, array $contentTable)
    {
        $this->content = $content;
        $this->contentTable = $contentTable;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return ContentTableDTO[]
     */
    public function getContentTable(): array
    {
        return $this->contentTable;
    }

    /**
     * @param ContentTableDTO[] $contentTable
     */
    public function setContentTable(array $contentTable): void
    {
        $this->contentTable = $contentTable;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'content_table' => array_map(function (ContentTableDTO $table) {
                return $table->toArray();
            }, $this->contentTable),
        ];
    }
}
