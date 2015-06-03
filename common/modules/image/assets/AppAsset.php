<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\modules\image\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
  
	public $sourcePath = '@common/modules/image';
   
    
    public $js = [
		'js/jquery.Jcrop.min.js',
		'js/setting.js',
    ];
	
	 public $depends = [
        'yii\web\JqueryAsset',
    ];
	
	 public function registerAssetFiles($view) {
        $this->css[] = 'css/jcrop.min.css';  
		$this->css[] = 'css/image.css';	
        parent::registerAssetFiles($view);
    }
	
	
   
}
