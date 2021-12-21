<?php

namespace Tbmatuka\EditorjsBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tbmatuka\EditorjsBundle\DependencyInjection\TbmatukaEditorjsExtension;

class TbmatukaEditorjsBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new TbmatukaEditorjsExtension();
    }
}
