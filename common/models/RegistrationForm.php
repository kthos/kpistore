<?php
/**NONT**/
/**Customized RegistrationForm Dektrium usernameLength **/
namespace common\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;

class RegistrationForm extends BaseRegistrationForm{
    public function rules() {
        $rules = parent::rules();
        $rules['usernameLength'] = ['username', 'string', 'min' => 6, 'max' => 255];
        return $rules;
    }
}