<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm это класс модели для формы логина.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public bool $rememberMe = true;

    private bool|null|User $_user = false;


    /**
     * @return array правила валидации.
     */
    public function rules(): array
    {
        return [
            // username и password требуются оба
            [['username', 'password'], 'required'],
            // rememberMe должен быть типа boolean
            ['rememberMe', 'boolean'],
            // password проверяется validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Проверяет пароль.
     * Этот метод служит встроенной проверкой для пароля.
     *
     * @param string $attribute проверяемый атрибут
     */
    public function validatePassword(string $attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный username или password.');
            }
        }
    }

    /**
     * Логинит пользователя, используя переданные username и password.
     * @return bool успешно ли пользователь вошёл в систему
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Ищет пользователя по username.
     * @return User|null найденного пользователя либо null
     */
    public function getUser(): ?User
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['username' => $this->username]);
        }

        return $this->_user;
    }
}
