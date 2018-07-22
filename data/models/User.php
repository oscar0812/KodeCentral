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
        $password = PHPassLib\Hash\BCrypt::hash(parent::getPassword());
        // store the Hash
        parent::setPassword($password);

        parent::save();
    }

    // returns true if $password => hashed($password)
    public function login($password)
    {
        return PHPassLib\Hash\BCrypt::verify($password, $this->getPassword());
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
}
