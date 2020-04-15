<?php

namespace Tbmatuka\EditorjsBundle\Editor;

class Editor
{
    /**
     * @var string
     */
    private $holder = '';

    /**
     * @var EditorConfig|null
     */
    private $config;

    /**
     * @var ToolConfig[]
     */
    private $tools = [];

    /**
     * @var array
     */
    private $data = [];

    public function __construct(
        string $holder = '',
        ?EditorConfig $config = null,
        array $data = []
    ) {
        $this->holder = $holder;

        if (!$config) {
            $config = new EditorConfig('', new ToolConfigCollection());
        }
        $this->config = $config;
        $this->tools = $config->getTools();

        $this->data = $data;
    }

    public function getHolder(): string
    {
        return $this->holder;
    }

    public function setHolder(string $holder): Editor
    {
        $this->holder = $holder;

        return $this;
    }

    public function getConfig(): ?EditorConfig
    {
        return $this->config;
    }

    public function setConfig(EditorConfig $config): Editor
    {
        $this->config = $config;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): Editor
    {
        $this->data = $data;

        return $this;
    }
}
