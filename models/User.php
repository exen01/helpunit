<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Это класс модели для таблицы user.
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $role_id
 * @property string $auth_key
 * @property string $access_token
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * @return array правила валидации для аттрибутов класса.
     */
    public function rules(): array
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['role_id'], 'integer'],
            [['username', 'password', 'email'], 'string', 'max' => 128],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @return string[] названия аттрибутов класса для отображения.
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * Получение роли пользователя
     *
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Находит пользователя по заданному id.
     *
     * @param int $id искомый id
     * @return IdentityInterface|null пользователь, соответствующий данному id
     */
    public static function findIdentity($id): ?IdentityInterface
    {
        return static::findOne($id);
    }

    /**
     * Находит пользователя по заданному access token.
     *
     * @param string $token искомый token
     * @return IdentityInterface|null пользователь, соответствующий данному token
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int id пользователя
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string auth key пользователя
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Проверяет указанный ключ авторизации.
     *
     * @param string $authKey ключ авторизации
     * @return bool результат проверки
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Проверяет указанный пароль.
     *
     * @param string $password пароль, который нужно проверить
     * @return bool результат проверки
     */
    public function validatePassword(string $password): bool
    {
        $hash = $this->password;
        return Yii::$app->getSecurity()->validatePassword($password, $hash);
    }

    /**
     * Этот метод вызывается перед сохранением модели в базу данных.
     * Если это новая запись, то auth key и access token будут сгенерированы случайным образом.
     *
     * @param bool $insert Вызывался ли этот метод при вставке записи. Если false, это означает, что метод вызывается при обновлении записи.
     * @return bool Результат сохранения записи. Если false, вставка записи или обновление будут отменены.
     * @throws Exception
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->access_token = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}
