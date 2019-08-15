<?php

namespace Tbmatuka\EditorjsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Tbmatuka\EditorjsBundle\Editor\EditorConfig;
use Tbmatuka\EditorjsBundle\Editor\EditorConfigCollection;
use Tbmatuka\EditorjsBundle\Editor\ToolConfig;
use Tbmatuka\EditorjsBundle\Editor\ToolConfigCollection;

class TbmatukaEditorjsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yaml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['tools'])) {
            $factories = [];

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
                $definition->addTag('kernel.reset', ['method'=>'reset']);
                $container->setDefinition($toolServiceId, $definition);
                $factories[$toolName] = new Reference($toolServiceId);
            }

            $container->getDefinition(ToolConfigCollection::class)
                ->setArgument(0, ServiceLocatorTagPass::register($container, $factories));
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
