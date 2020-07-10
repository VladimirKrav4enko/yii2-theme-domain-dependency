<?php

namespace yii2packages\themedomaindependency;


use yii\base\Theme as BaseTheme;

class Theme extends BaseTheme
{
    public $domainManifest;
    public $defaultTheme;

    public function init()
    {
    }

    private function replaceThemePlaceholder()
    {
        var_dump(get_object_vars($this)); die;
    }

}
