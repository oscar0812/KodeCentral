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
    public function isConfirmed()
    {
        $key = $this->getConfirmationKey();
        return $key == null || $key == "";
    }

    public function confirm()
    {
        $this->setConfirmationkey('');
        $this->save();
    }

    public function setRandomConfirmKey()
    {
        //random 32 length string
        parent::setConfirmationKey(substr(str_shuffle(md5(time())), 0, 32));
    }

    public function hasResetKey()
    {
        $key = $this->getResetKey();
        return $key != null && $key != "";
    }

    public function setRandomResetKey()
    {
        //random 32 length string
        parent::setResetKey(substr(str_shuffle(md5(time())), 0, 32));
    }

    public function setPassword($password)
    {
        // hash password
        $options = ['cost' => 11];
        $password = password_hash($password, PASSWORD_BCRYPT, $options);

        // store the Hash
        parent::setPassword($password);
    }

    // returns true if $password => hashed($password)
    public function verifyPassword($password)
    {
        return password_verify($password, $this->getPassword());
    }

    public function hasPostInFavorites($post)
    {
        $row = \UserFavoriteQuery::create()->filterByFavoriteUser($this)->filterByFavoritePost($post);
        return $row->find()->count() > 0;
    }

    // log user in (save a session for it)
    public function logIn()
    {
        // only allow log in if email is confirmed
        if ($this->isConfirmed()) {
            session_start_safe();
            $_SESSION['user_id'] = $this->getId();
        }
    }

    // log user out (remove session)
    public static function logOut()
    {
        session_start_safe();
        unset($_SESSION['user_id']);
    }

    // return user that is currently logged in, null if no user logged in
    public static function current()
    {
        session_start_safe();
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

    public function getBio()
    {
        $bio = parent::getBio();
        if ($bio == '') {
            return 'Nothng about me...';
        }
        return $bio;
    }

    public function getBadge()
    {
        // if not a super user, no badge
        if (!$this->isSuper()) {
            return '';
        }

        $posts = $this->getPosts()->count();
        $color = 'info';
        $icon = 'code';
        if ($posts > 20) {
            $color = 'royal';
            $icon = '8tracks';
        } elseif ($posts > 5) {
            $color = 'danger';
            $icon = 'star';
        }

        return '<span class="badge-pill badge-pill-'.$color.' zmdi zmdi-'.$icon.'"></span>';
    }
}
