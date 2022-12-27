<?php

namespace tests\unit\models;

use app\models\User;
use Codeception\Test\Unit;

class UserTest extends Unit
{
    public function testFindUserById()
    {
        verify($user = User::findIdentity(2))->notEmpty();
        verify($user->username)->equals('admin');

        verify(User::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = User::findIdentityByAccessToken('GUcsbSgFjnwldu_gm1fKwrgPMbWg3Jf5'))->notEmpty();
        verify($user->username)->equals('admin');

        verify(User::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = User::findOne(['username' => 'admin']))->notEmpty();
        verify(User::findOne(['username' => 'not-admin']))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findOne(['username' => 'admin']);
        verify($user->validateAuthKey('GngkYGw0ReBDolg3-wivOOVuzU3lqNSj'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('demo'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();
    }

}
