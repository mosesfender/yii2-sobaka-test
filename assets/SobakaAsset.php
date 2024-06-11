<?php

namespace app\assets;

use yii\web\AssetBundle;

class SobakaAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/sobaka/dist';
    
    public $css = ['sobaka.css', 'sobaka-icons.css'];
    public $js  = ['cookie.js', 'dompurify.js', 'tmpl.min.js', 'sobaka.js'];
    
    public $publishOptions = ['forceCopy' => YII_ENV == YII_ENV_DEV];
}