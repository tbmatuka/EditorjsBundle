<?php

namespace Tbmatuka\EditorjsBundle\Editor;

class EditorConfig
{
    private $name = '';

    /**
     * @var bool|null
     */
    private $autofocus;

    /**
     * @var string|null
     */
    private $initialBlock;

    /**
     * @var string|null
     */
    private $placeholder;

    /**
     * @var array
     */
    private $sanitizer = [];

    /**
     * @var bool|null
     */
    private $hideToolbar;

    /**
     * @var Tool[]
     */
    private $tools = [];

    /**
     * @var int|null
     */
    private $minHeight;

    /**
     * @var string|null
     */
    private $onReady;

    /**
     * @var string|null
     */
    private $onChange;

    public function __construct(
        string $name,
        ?bool $autofocus = null,
        ?string $initialBlock = null,
        ?string $placeholder = null,
        ?array $sanitizer = [],
        ?bool $hideToolbar = null,
        ?array $tools = [],
        ?int $minHeight = null,
        ?string $onReady = null,
        ?string $onChange = null
    )
    {
        $this->name = $name;
        $this->autofocus = $autofocus;
        $this->initialBlock = $initialBlock;
        $this->placeholder = $placeholder;

        if (is_array($sanitizer)) {
            $this->sanitizer = $sanitizer;
        }

        $this->hideToolbar = $hideToolbar;

        if (is_array($tools)) {
            foreach ($tools as $tool) {
                if (!$tool instanceof Tool) {
                    throw new \InvalidArgumentException('Not an instance of Tool');
                }
            }

            $this->tools = $tools;
        }

        $this->minHeight = $minHeight;
        $this->onReady = $onReady;
        $this->onChange = $onChange;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAutofocus(): ?bool
    {
        return $this->autofocus;
    }

    public function getInitialBlock(): ?string
    {
        return $this->initialBlock;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function getSanitizer(): array
    {
        return $this->sanitizer;
    }

    public function getHideToolbar(): ?bool
    {
        return $this->hideToolbar;
    }

    /**
     * @return Tool[]
     */
    public function getTools(): array
    {
        return $this->tools;
    }

    public function getMinHeight(): ?int
    {
        return $this->minHeight;
    }

    public function getOnReady(): ?string
    {
        return $this->onReady;
    }

    public function getOnChange(): ?string
    {
        return $this->onChange;
    }
}
