<?php
// models/ChangePasswordForm.php

class ChangePasswordForm extends CFormModel
{
    /**
     * @var string
     */
    public $currentPassword;

    /**
     * @var string
     */
    public $newPassword;

    /**
     * @var string
     */
    public $newPasswordRepeat;

    /**
     * Validation rules for this form.
     *
     * @return array
     */
    public function rules()
    {
        return array(
            array('currentPassword, newPassword, newPasswordRepeat', 'required'),
            array('currentPassword', 'validateCurrentPassword', 'message'=>'This is not your password.'),
            array('newPassword', 'compare', 'compareAttribute'=>'validateNewPassword'),
            array('newPassword', 'match', 'pattern'=>'/^[a-z0-9_\-]{5,}/i', 'message'=>'Your password does not meet our password complexity policy.'),
        );
    }

    /**
     * I don't know your hashing policy, so I assume it's simple MD5 hashing method.
     * 
     * @return string Hashed password
     */
    protected function createPasswordHash($password)
    {
        return md5($password);
    }

    /**
     * I don't know how you access user's password as well.
     *
     * @return string
     */
    protected function getUserPassword()
    {
        return Yii::app()->user->password;
    }

    /**
     * Saves the new password.
     */
    public function saveNewPassword()
    {
        $user = UserModel::findByPk(Yii::app()->user->username);
        $user->password = $this->createPasswordHash($this->newPassword);
        $user->update();
    }

    /**
     * Validates current password.
     *
     * @return bool Is password valid
     */
    public function validateCurrentPassword()
    {
        return $this->createPasswordHash($this->currentPassword) == $this->getUserPassword();
    }
}