<?php

namespace Tbmatuka\EditorjsBundle\Twig;

use Tbmatuka\EditorjsBundle\Editor\Editor;
use Tbmatuka\EditorjsBundle\Editor\EditorConfig;
use Tbmatuka\EditorjsBundle\Editor\EditorConfigCollection;
use Tbmatuka\EditorjsBundle\Form\EditorjsTransformer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EditorjsExtension extends AbstractExtension
{
    /**
     * @var EditorConfigCollection
     */
    protected $editorConfigCollection;

    /**
     * @var EditorjsTransformer
     */
    protected $editorjsTransformer;

    public function __construct(
        EditorConfigCollection $editorConfigCollection,
        EditorjsTransformer $editorjsTransformer
    ) {
        $this->editorConfigCollection = $editorConfigCollection;
        $this->editorjsTransformer = $editorjsTransformer;
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

    /**
     * @param string|EditorConfig $config
     * @param string|array|null   $data
     */
    public function editorjs(string $holder, $config, $data = []): Editor
    {
        if (!$config instanceof EditorConfig) {
            $config = $this->editorConfigCollection->getConfig((string) $config);
        }

        if (is_array($data)) {
            $dataArray = $data;
        } else {
            if (is_string($data)) {
                $dataArray = $this->editorjsTransformer->reverseTransform($data);
            } else {
                $dataArray = [];
            }
        }

        return new Editor(
            $holder,
            $config,
            $dataArray
        );
    }

    public function editorjsSerialize(Editor $editor): string
    {
        $editorArray = (array) $editor;

        $cleanEditorArray = $this->cleanArray($editorArray);
        foreach ($cleanEditorArray as $key => $value) {
            if ($key !== 'config') {
                $cleanEditorArray['config'][$key] = $value;
            }
        }

        return (string) json_encode($cleanEditorArray['config']);
    }

    private function cleanArray(array $array): array
    {
        $cleanArray = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->cleanArray($value);
            }

            if (is_object($value)) {
                $value = $this->cleanArray((array) $value);
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
