<?php

namespace app\assets;

use yii\web\AssetBundle;

class SobakaAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/sobaka/dist';
    
    public $css = ['sobaka.css'];
    public $js  = [];
    
    public $publishOptions = ['forceCopy' => YII_ENV == YII_ENV_DEV];
}