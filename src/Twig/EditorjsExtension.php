<?php

namespace Tbmatuka\EditorjsBundle\Twig;

use Tbmatuka\EditorjsBundle\Editor\EditorConfig;
use Tbmatuka\EditorjsBundle\Editor\EditorConfigCollection;
use Tbmatuka\EditorjsBundle\Editor\Editor;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EditorjsExtension extends AbstractExtension
{
    private $editorConfigCollection;

    public function __construct(EditorConfigCollection $editorConfigCollection)
    {
        $this->editorConfigCollection = $editorConfigCollection;

        $this->editorConfigCollection->setConfig(new EditorConfig(
            'default',
            true
        ));
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('editorjs', [$this, 'editorjs']),
            new TwigFunction('editorjs_serialize', [$this, 'editorjsSerialize'], ['is_safe' => ['js', 'html']]),
        ];
    }

    public function editorjs(string $handlerName, string $configName, array $data = []): Editor
    {
        $config = $this->editorConfigCollection->getConfig($configName);

        return new Editor(
            $handlerName,
            $config,
            $data
        );
    }

    public function editorjsSerialize(Editor $editor): string
    {
        $editorArray = (array)$editor;

        $cleanEditorArray = $this->cleanArray($editorArray);

        return json_encode($cleanEditorArray);
    }

    private function cleanArray(array $array): array
    {
        $cleanArray = [];

        foreach ($array as $key => $value) {
            if (is_object($value)) {
                $value = $this->cleanArray((array)$value);
            }

            if (
                $value === null ||
                (is_array($value) && \count($value) === 0)
            ) {
                continue;
            }

            $explodedKey = explode("\x00", $key);
            $cleanKey = end($explodedKey);

            $cleanArray[$cleanKey] = $value;
        }

        return $cleanArray;
    }
}
