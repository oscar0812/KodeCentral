<?php

use Base\Subscription as BaseSubscription;

/**
 * Skeleton subclass for representing a row from the 'subscription' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Subscription extends BaseSubscription
{
    public function setRandomKey()
    {
        //random 32 length string
        parent::setConfirmationKey(substr(str_shuffle(md5(time())), 0, 32));
    }
}
