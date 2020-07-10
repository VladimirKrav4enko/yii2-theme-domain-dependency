<?php

namespace yii2packages\themedomaindependency;


use yii\base\Exception;
use yii\base\Theme as BaseTheme;
use Yii;

class Theme extends BaseTheme
{
    public $basePath;
    public $baseUrl;
    public $domainManifest;
    public $defaultTheme;
    public $domain;
    public $theme;

    public function init()
    {
        $this->domain = Yii::$app->request->getServerName();
        if (!empty($this->domainManifest)) {
            $this->theme = (isset($this->domainManifest[$this->domain])) ? $this->domainManifest[$this->domain] : $this->defaultTheme;
        }
        
        $this->replaceThemePlaceholder();
    }

    private function replaceThemePlaceholder()
    {
        foreach (array_keys(get_object_vars($this)) as $property) {
            $this->{$property} = $this->recursiveReplace($this->{$property});
        }
    }

    private function recursiveReplace($property)
    {
        if (is_string($property)) {
            if (preg_match("#\<theme\>#is", $property)) {
                if (empty($this->defaultTheme)) {
                    throw new Exception('DefaultTheme value is required');
                }

                $property = str_replace('<theme>', $this->theme, $property);
            }
        } elseif (is_array($property)) {
            foreach ($property as $key => $value) {
                $property[$key] = $this->recursiveReplace($value);
            }
        }

        return $property;
    }

}
