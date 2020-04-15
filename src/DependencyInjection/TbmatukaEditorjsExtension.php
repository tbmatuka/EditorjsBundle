<?php

namespace Tbmatuka\EditorjsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Tbmatuka\EditorjsBundle\Editor\EditorConfig;
use Tbmatuka\EditorjsBundle\Editor\ToolConfig;
use Tbmatuka\EditorjsBundle\Editor\ToolConfigCollection;

class TbmatukaEditorjsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yaml');

        $configuration = $this->getConfiguration($configs, $container);

        if (!$configuration) {
            throw new \RuntimeException('Unable to find Configuration class');
        }

        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['tools'])) {
            $toolReferences = [];

            $argumentNames = [
                'className',
                'asset',
                'shortcut',
                'inlineToolbar',
                'toolbox',
                'config',
            ];

            foreach ($config['tools'] as $toolName => $toolConfig) {
                $toolServiceId = $this->getToolServiceId($toolName);

                $arguments = [
                    $toolName,
                ];

                foreach ($argumentNames as $argumentName) {
                    if (isset($toolConfig[$argumentName])) {
                        $arguments[] = $toolConfig[$argumentName];
                    } else {
                        $arguments[] = null;
                    }
                }

                $definition = new Definition(ToolConfig::class, $arguments);
                $definition->addTag('editorjs.tool_config');
                $container->setDefinition($toolServiceId, $definition);
                $toolReferences[$toolName] = new Reference($toolServiceId);
            }
        }

        if (isset($config['configs'])) {
            $configReferences = [];

            $argumentNames = [
                'autofocus',
                'initialBlock',
                'placeholder',
                'sanitizer',
                'hideToolbar',
                'tools',
                'minHeight',
                'onReady',
                'onChange',
                'logLevel',
            ];

            foreach ($config['configs'] as $configName => $configConfig) {
                $toolConfigCollection = new Reference(ToolConfigCollection::class);

                $configServiceId = $this->getConfigServiceId($configName);

                $arguments = [
                    $configName,
                    $toolConfigCollection,
                ];

                foreach ($argumentNames as $argumentName) {
                    if (isset($configConfig[$argumentName])) {
                        $arguments[] = $configConfig[$argumentName];
                    } else {
                        $arguments[] = null;
                    }
                }

                $definition = new Definition(EditorConfig::class, $arguments);
                $definition->addTag('editorjs.editor_config');
                $container->setDefinition($configServiceId, $definition);
                $configReferences[$configName] = new Reference($configServiceId);
            }
        }
    }

    public function getAlias()
    {
        return 'editorjs';
    }

    private function getToolServiceId(string $name): string
    {
        return sprintf('editorjs.tool[%s]', $name);
    }

    private function getConfigServiceId(string $name): string
    {
        return sprintf('editorjs.config[%s]', $name);
    }
}
