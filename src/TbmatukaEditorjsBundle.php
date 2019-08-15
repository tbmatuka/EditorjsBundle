<?php

namespace Tbmatuka\EditorjsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tbmatuka\EditorjsBundle\DependencyInjection\TbmatukaEditorjsExtension;

class TbmatukaEditorjsBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new TbmatukaEditorjsExtension();
    }
}
