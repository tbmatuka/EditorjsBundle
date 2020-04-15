<?php

namespace Tbmatuka\EditorjsBundle\Editor;

class EditorConfigCollection
{
    public const DEFAULT_CONFIG = 'default';

    /**
     * @var EditorConfig[]
     */
    private $editorConfigs = [];

    public function __construct(iterable $editorConfigs)
    {
        foreach ($editorConfigs as $editorConfig) {
            $this->editorConfigs[$editorConfig->getName()] = $editorConfig;
        }
    }

    public function setConfig(EditorConfig $editorConfig): void
    {
        $this->editorConfigs[$editorConfig->getName()] = $editorConfig;
    }

    public function getConfig(?string $editorConfigName = null): EditorConfig
    {
        if ($editorConfigName === null) {
            $editorConfigName = self::DEFAULT_CONFIG;
        }

        if (!isset($this->editorConfigs[$editorConfigName])) {
            throw new \InvalidArgumentException(sprintf('Config "%s" does not exist.', $editorConfigName));
        }

        return $this->editorConfigs[$editorConfigName];
    }

    /**
     * @return EditorConfig[]
     */
    public function getAllEditorConfigs(): array
    {
        return $this->editorConfigs;
    }
}
