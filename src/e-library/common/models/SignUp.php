<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 06.05.2018
 * Time: 17:33
 */

namespace common\models;


use yii\base\Model;
use common\models\User;
use yii\helpers\VarDumper;

class SignUp extends Model
{
    public $username;
    public $password;
    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['username','password'],'string'],
        ];
    }

    public function signUp(){
        if($this->validate()){
            $user=User::find()->where(['username'=>$this->username])->one();
            if(!$user) {
//                VarDumper::dump($this->password);
                $user = new User();
                $user->username=$this->username;
                $user->password=$this->password;
                $user->save();
                \Yii::$app->user->login($user);
                return true;
            }
            return false;
        }
        return false;
    }
}