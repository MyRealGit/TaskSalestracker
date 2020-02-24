<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id_User
 * @property string $username
 * @property string $firstname
 * @property string $surname
 * @property string $birthdate
 * @property string $email
 * @property string $authKey
 * @property string $accessToken
 * @property string $password
 * @property string $dateOnCreate
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'firstname', 'surname', 'birthdate', 'email', 'authKey', 'accessToken', 'password'], 'required'],
            [['birthdate', 'dateOnCreate'], 'safe'],
            [['username', 'firstname', 'surname', 'password'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 25],
            [['authKey', 'accessToken'], 'string', 'max' => 70],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_User' => 'Id User',
            'username' => 'Username',
            'firstname' => 'Firstname',
            'surname' => 'Surname',
            'birthdate' => 'Birthdate',
            'email' => 'E Mail',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'password' => 'Password',
            'dateOnCreate' => 'Date On Create',
        ];
    }
}
