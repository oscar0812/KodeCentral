<?php

use Base\Post as BasePost;

/**
 * Skeleton subclass for representing a row from the 'post' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
use Propel\Runtime\ActiveQuery\Criteria;

class Post extends BasePost
{
    public function getTextNoTags()
    {
        $text = parent::getText();
        // replace html tags with space
        return strip_tags(str_replace('<', ' <', $text));
    }

    // return background color for profile cards
    public function getBg()
    {
        $length = strlen($this->getTextNoTags());
        if ($length > 3000) {
            return "royal";
        } elseif ($length > 1500) {
            return "info";
        } elseif ($length > 500) {
            return "warning";
        } else {
            return "success";
        }
    }

    // set nulls when empty strings for validation
    public function setText($text)
    {
        if ($text == '') {
            $text = null;
        }
        parent::setText($text);
    }

    public function setTitle($text)
    {
        if ($text == '') {
            $text = null;
        }
        parent::setTitle($text);
    }

    public function setHyperlink($text)
    {
        if ($text == '') {
            $text = null;
        }
        parent::setHyperlink($text);
    }

    // the summary is just a short description
    public function getSummary($max_length = 60)
    {
        // post text has html tags, take them off before sub stringing
        $text = substr($this->getTextNoTags(), 0, $max_length);
        if (strlen($text) == $max_length) {
            return $text.'...';
        }
        return $text;
    }

    public function setUniqueHyperlink($link = null)
    {
        if ($link == null) {
            $link = $this->getTitle();
        }

        // lowercase the text and replace spaces with dashes
        $link = urlencode(preg_replace('/\s+/', '-', strtolower($link)));
        if ($this->getHyperlink() == "" || $this->getHyperlink() != $link) {
            // check if another post has this link
            $post = \PostQuery::create()->findOneByHyperlink($link);

            if ($post == null) {
                // no post with this hyperlink, set it
                $this->setHyperlink($link);
            } else {
                $extra = substr(md5(uniqid(mt_rand(), true)), 0, 8);
                $this->setUniqueHyperlink($link.'-'.$extra);
            }
        }
    }

    public static function fromPostRequest($data, $post = null)
    {
        if (!isset($post) || $post == null) {
            $post = new \Post();
        }

        $post->setText(preg_replace('/&nbsp;/', ' ', trim($data['text'])));
        $post->setPostedByUser(\User::current());
        $post->setPostedDate(getCurrentDate());

        // replace whitespace with 1 space
        $new_title = preg_replace('/\s+/', ' ', trim($data['title']));
        $old_title = $post->getTitle();

        $post->setTitle($new_title);

        if (strtolower($new_title) != strtolower($old_title)) {
            // title changed
            // hyperlink has to be unique
            $post->setUniqueHyperlink();
        }

        // set library and position
        $post->setLibraryId(1);
        $post->setLibraryIndex(0);

        if ($data['library_name'] != 'None') {
            // if here then trying to move position of post in a lib
            $lib = \LibraryQuery::create()->findOneByName($data['library_name']);

            if ($lib == null) {
                return $post;
            } else {
                $post->setLibrary($lib);
            }

            // get all posts from library, except for one trying to move
            $posts = \PostQuery::create()->
              filterByHyperlink($post->getHyperlink(), CRITERIA::NOT_EQUAL)->
              orderByLibraryIndex()->findByLibrary($lib);


            $index = 0;
            if ($data['library_index'] == '-1') {
                // trying to add to very beginning of library
                $post->setLibraryIndex(0);
                $index = 1;
            }

            // loop through the posts of this library and move them down
            foreach ($posts as $p) {
                $p->setLibraryIndex($index++);
                if ($p->getHyperlink() == $data['library_index']) {
                    // trying to put after this one
                    $post->setLibraryIndex($index++);
                }
            }
            $posts->save();
        }

        return $post;
    }
}
