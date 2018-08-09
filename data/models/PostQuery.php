<?php

use Base\PostQuery as BasePostQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'post' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
use Propel\Runtime\ActiveQuery\Criteria;

class PostQuery extends BasePostQuery
{
    public function search($text)
    {
        if (trim($text) != "") {
            $this->filterByTitle("%".$text."%", Criteria::LIKE)->
            _or()->filterByText("%".$text."%", Criteria::LIKE);
        }
        return $this;
    }
}
