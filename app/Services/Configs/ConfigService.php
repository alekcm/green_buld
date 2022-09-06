<?php

namespace App\Services\Configs;

use App\Entities\DataTransferObjects\Configs\ConfigAttributeDTO;
use App\Enums\ConfigEnum;
use App\Exceptions\BusinessLogicException;
use App\Models\Config;

class ConfigService
{
    /**
     * @param array $data
     * @return Config
     * @throws BusinessLogicException
     */
    public function update(array $data): Config
    {
        $config = $this->getConfig();

        if (!$config->update($data)) {
            throw new BusinessLogicException('exception.config.model.update');
        }

        return $config;
    }

    public function getAttribute(string $attr): array
    {
        $config = $this->getConfig();
        return (new ConfigAttributeDTO(
            $attr,
            ConfigEnum::toUpper($attr),
            $config->attributeToString(
                $config->getAttribute($attr)
            )
        ))->toArray();
    }

    public function getAllAttributes(): array
    {
        $items = [];

        foreach (ConfigEnum::CONFIGS as $attr => $name) {
            $items[] = $this->getAttribute($attr);
        }

        return $items;
    }

    public function getConfig(): Config
    {
        return Config::first();
    }
}
