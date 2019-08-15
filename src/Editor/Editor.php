<?php

namespace Tbmatuka\EditorjsBundle\Editor;

class Editor
{
    private $holder = '';

    /**
     * @var Config|null
     */
    private $config;

    private $data = [];

    public function __construct(
        $holder = '',
        $config = null,
        $data = []
    ) {
        $this->holder = $holder;
        $this->config = $config;
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

    public function getConfig(): ?Config
    {
        return $this->config;
    }

    public function setConfig(Config $config): Editor
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
