<?
namespace app\modules\contact\controllers;
 
use app\modules\contact\models\ContactForm;
use yii\web\Controller;
use Yii;
 
class ContactController extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
 
    public function actionIndex()
    {
      
    }
}