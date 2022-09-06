<?php

namespace App\Entities\DataTransferObjects\Configs;

use Illuminate\Contracts\Support\Arrayable;

class ConfigAttributeDTO implements Arrayable
{
    protected string $attr;
    protected string $name;
    protected string $value;

    /**
     * @param string $attr
     * @param string $name
     * @param string $value
     */
    public function __construct(string $attr, string $name, string $value)
    {
        $this->attr = $attr;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getAttr(): string
    {
        return $this->attr;
    }

    /**
     * @param string $attr
     */
    public function setAttr(string $attr): void
    {
        $this->attr = $attr;
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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            'attr' => $this->attr,
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
