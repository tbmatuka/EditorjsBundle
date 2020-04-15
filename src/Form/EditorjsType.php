<?php

namespace Tbmatuka\EditorjsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tbmatuka\EditorjsBundle\Editor\EditorConfig;
use Tbmatuka\EditorjsBundle\Editor\EditorConfigCollection;

class EditorjsType extends AbstractType
{
    /**
     * @var EditorjsTransformer
     */
    protected $transformer;

    /**
     * @var EditorConfigCollection
     */
    protected $configCollection;

    public function __construct(
        EditorjsTransformer $transformer,
        EditorConfigCollection $configCollection
    ) {
        $this->transformer = clone $transformer;
        $this->configCollection = $configCollection;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->transformer);

        $builder->setAttribute('config_name', $options['config_name']);
        $builder->setAttribute('config', $this->resolveConfig($options));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'config_name' => EditorConfigCollection::DEFAULT_CONFIG,
                'config' => null,
                'compound' => false,
            ])
            ->addAllowedTypes('config_name', ['string', 'null'])
            ->addAllowedTypes('config', [EditorConfig::class, 'null'])
        ;
    }

    private function resolveConfig(array $options): EditorConfig
    {
        if ($options['config'] instanceof EditorConfig) {
            $config = $options['config'];
        } else {
            $config = $this->configCollection->getConfig($options['config_name']);
        }

        $this->transformer->setConfig($config);

        return $config;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $config = $form->getConfig();

        $view->vars['config'] = $config->getAttribute('config');
        $view->vars['config_name'] = $config->getAttribute('config_name');
    }
}
