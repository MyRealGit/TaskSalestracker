<?php
    namespace app\models;
   
    use Yii;
    use yii\base\Model;
    use app\models\UserIdentity;
   
    class PasswordForm extends Model{
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
       
        public function rules(){
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
        }
       
        public function findPasswords($attribute, $params){
            
            $user = UserIdentity::find()->where(['id_User'=>Yii::$app->user->identity->id_User])->one();
            $password = $user->password;
            
            if($password!=md5($this->oldpass))
                $this->addError($attribute,'Old password is incorrect');
        }
       
        public function attributeLabels(){
            return [
                'oldpass'=>'Old Password',
                'newpass'=>'New Password',
                'repeatnewpass'=>'Repeat New Password',
            ];
        }
    }
