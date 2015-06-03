<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\contact\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
  
    public $sourcePath = '@app/modules/contact';
  
	public $depends = [
        'yii\web\JqueryAsset',
    ];	
	 public function registerAssetFiles($view) {		
        $this->js[] = 'js/form.js';   
        parent::registerAssetFiles($view);
    }
}
