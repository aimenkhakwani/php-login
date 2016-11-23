<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/User.php";

    $server = 'mysql:host=localhost:8889;dbname=php_login_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            User::deleteAll();
        }

        function test_getUsername()
        {
            $username = "aimenk";
            $password = "akio";
            $id = null;
            $new_user = new User($username, $password, $id);

            $result = $new_user->getUsername();

            $this->assertEquals($username, $result);
        }

        function test_getPassword()
        {
            $username = "aimenk";
            $password = "akio";
            $id = null;
            $new_user = new User($username, $password, $id);

            $result = $new_user->getPassword();

            $this->assertEquals($password, $result);
        }

        function test_getId()
        {
            $username = "aimenk";
            $password = "akio";
            $id = 2;
            $new_user = new User($username, $password, $id);

            $result = $new_user->getId();

            $this->assertEquals($id, $result);
        }

        function test_setUsername()
        {
            $username = "aimenk";
            $password = "akio";
            $id = 2;
            $new_user = new User($username, $password, $id);

            $new_username = "akio19320";
            $new_user->setUsername($new_username);
            $result = $new_user->getUsername();

            $this->assertEquals($new_username, $result);
        }

        function test_setPassword()
        {
            $username = "aimenk";
            $password = "akio";
            $id = 2;
            $new_user = new User($username, $password, $id);

            $new_password = "akio19320";
            $new_user->setPassword($new_password);
            $result = $new_user->getPassword();

            $this->assertEquals($new_password, $result);
        }

        function test_save()
        {
            $username = "aimenk";
            $password = "akio";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            $result = User::getAll();

            $this->assertEquals([$new_user], $result);
        }

        function test_saveDuplicates()
        {
            $username = "aimenk";
            $password = "akio";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();
            $new_user->save();

            $result = User::getAll();

            $this->assertEquals([$new_user], $result);
        }

        function test_getAll()
        {
            $username = "aimenk";
            $password = "akio";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            $username2 = "jenna67y";
            $password2 = "fsdfwew";
            $new_user2 = new User($username2, $password2, $id);
            $new_user2->save();

            $result = User::getAll();

            $this->assertEquals([$new_user, $new_user2], $result);
        }

        function test_deleteAll()
        {
            $username = "aimenk";
            $password = "akio";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            $username2 = "jenna67y";
            $password2 = "fsdfwew";
            $new_user2 = new User($username2, $password2, $id);
            $new_user2->save();

            User::deleteAll();
            $result = User::getAll();

            $this->assertEquals([], $result);
        }

        function test_update()
        {
            $username = "aimenk";
            $password = "akio";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            $new_username = "ak100";
            $new_user->update($new_username);

            $result = $new_user->getUsername();

            $this->assertEquals($new_username, $result);
        }

        function test_delete()
        {
            $username = "jenjen20";
            $password = "skyfall";
            $new_user = new User($username, $password);
            $new_user->save();

            $username2 = "blah blah";
            $password2 = "whatev";
            $new_user2 = new User($username2, $password2);
            $new_user2->save();

            $new_user2->delete();
            $result = User::getAll();

            $this->assertEquals([$new_user], $result);
        }
    }
?>
