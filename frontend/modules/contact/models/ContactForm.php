<?php

namespace app\modules\contact\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $phone;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, phone are required
            [['name', 'phone'], 'required', 'message'=>'Введите {attribute}.'],
			[['phone'], 'number'],
        ];
    }

     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [          
            'name' => Yii::t('app', 'Имя'),
			'phone' => Yii::t('app', 'Телефон'),
        ];
    }

   
    public function contact($email)
    {	
		$from=$email;
		
        return \Yii::$app->mailer->compose('html', [				
				'phone' => $this->phone,
				'name' => $this->name,
				])
				->setTo($email)
				->setFrom($from)
				->setSubject("Тестовая заявка")			
				->send();	
       
    }
}
