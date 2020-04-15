<?php

namespace Tbmatuka\EditorjsBundle\Editor;

class ToolConfigCollection
{
    /**
     * @var ToolConfig[]
     */
    private $toolConfigs = [];

    /**
     * @param ToolConfig[] $toolConfigs
     */
    public function __construct(iterable $toolConfigs = [])
    {
        foreach ($toolConfigs as $toolConfig) {
            $this->toolConfigs[$toolConfig->getName()] = $toolConfig;
        }
    }

    public function setConfig(ToolConfig $toolConfig): void
    {
        $this->toolConfigs[$toolConfig->getName()] = $toolConfig;
    }

    public function getConfig(string $toolConfigName): ToolConfig
    {
        if (!isset($this->toolConfigs[$toolConfigName])) {
            throw new \InvalidArgumentException(sprintf('Tool config "%s" does not exist.', $toolConfigName));
        }

        return $this->toolConfigs[$toolConfigName];
    }

    public function hasConfig(string $toolConfigName): bool
    {
        return isset($this->toolConfigs[$toolConfigName]);
    }

    /**
     * @return ToolConfig[]
     */
    public function getAllConfigs(): array
    {
        return $this->toolConfigs;
    }
}
