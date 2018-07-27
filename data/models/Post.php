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
        return substr(strip_tags($this->getText()), 0, 60).'...';
    }

    public function setUniqueHyperlink($link = null)
    {
        if ($link == null) {
            $link = $this->getTitle();
        }

        // lowercase the text and replace spaces with dashes
        $link = preg_replace('/\s+/', '-', strtolower($link));
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

        // replace whitespace with 1 space
        $post->setTitle(preg_replace('/\s+/', ' ', $data['title']));
        $post->setText(preg_replace('/&nbsp;/', ' ', $data['text']));
        $post->setUser(\User::current());
        $post->setPostedDate(getCurrentDate());
        $post->setUser(\User::current());

        // hyperlink has to be unique
        $post->setUniqueHyperlink();

        // add the categories
        $categories = \CategoryQuery::create()->filterByName($data['categories'])->find();

        $post->setCategories($categories);

        return $post;
    }
}
