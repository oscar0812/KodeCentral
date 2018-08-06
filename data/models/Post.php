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
class Post extends BasePost
{
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

    public function categoriesString()
    {
        $str = "";
        foreach ($this->getCategories() as $category) {
            $str .= ('category-'.$category->getName(). ' ');
        }
        return rtrim($str, ' ');
    }

    // the summary is just a short description
    public function getSummary()
    {
        // post text has html tags, take them off before sub stringing
        $text = substr(strip_tags($this->getText()), 0, 60);
        if (strlen($text) == 60) {
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

        // add the categories
        $categories = \CategoryQuery::create()->filterByName($data['categories'])->find();

        $post->setCategories($categories);

        // TODO: set real library from input
        $post->setLibraryId(1);

        return $post;
    }
}
