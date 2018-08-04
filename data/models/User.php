<?php

use Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */

use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Map\TableMap;

class User extends BaseUser
{
    // hash the password before saving
    public function save(ConnectionInterface $con = null)
    {
        // hash password
        $options = ['cost' => 11];
        $password = password_hash($this->getPassword(), PASSWORD_BCRYPT, $options);

        // store the Hash
        parent::setPassword(substr($password, 0, 60));

        parent::save();
    }

    // returns true if $password => hashed($password)
    public function verifyPassword($password)
    {
        return password_verify($password, substr((string)$this->getPassword(), 0, 60));
    }

    // log user in (save a session for it)
    public function logIn()
    {
        \App\Utils\SessionManager::sessionStart();
        $_SESSION['user_id'] = $this->getId();
    }

    // log user out (remove session)
    public static function logOut()
    {
        \App\Utils\SessionManager::sessionStart();
        unset($_SESSION['user_id']);
    }

    // return user that is currently logged in, null if no user logged in
    public static function current()
    {
        \App\Utils\SessionManager::sessionStart();
        if (isset($_SESSION['user_id'])) {
            return UserQuery::create()->findPk($_SESSION['user_id']);
        }
        return null;
    }

    // for validation purposes, validation seems to fail with empty strings,
    // so if empty string, replace with null, and schema.xml validate
    // knows how to check for nulls
    public function setByName($name, $str, $type = TableMap::TYPE_PHPNAME)
    {
        if ($str == '') {
            $str = null;
        }
        return parent::setByName($name, $str, $type);
    }

    public function getPfp($home)
    {
        $pfp = $this->getProfilePicture();
        if ($pfp == "") {
            return $home."assets/img/default_pfp.png";
        }
        return $pfp;
    }

    public function getBadge()
    {
        // if not a super user, no badge
        if(!$this->isSuper()){
          return '';
        }

        $posts = $this->getPosts()->count();
        $color = 'info';
        $icon = 'code';
        if($posts > 100){
          $color = 'royal';
          $icon = '8tracks';
        } elseif($posts > 50){
          $color = 'danger';
          $icon = 'star';
        }

        return '<span class="badge-pill badge-pill-'.$color.' zmdi zmdi-'.$icon.'"></span>';
    }
}
