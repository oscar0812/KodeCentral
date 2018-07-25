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

    private static function uniqueLink($link)
    {
        $link = preg_replace('/\s+/', '-', strtolower($link));

        if (\PostQuery::create()->findOneByHyperlink($link) != null) {
            // not unique hyperlink, try again
            // random string 8 in length
            $extra = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            return $link.'-'.$extra;
        }
        return $link;
    }

    public static function fromPostRequest($data, $post = null)
    {
        if ($post == null) {
            $post = new \Post();
        }
        // replace whitespace with 1 space
        $post->setTitle(preg_replace('/\s+/', ' ', $data['title']));
        $post->setText($data['text']);
        $post->setUser(\User::current());
        $post->setPostedDate(getCurrentDate());
        $post->setUser(\User::current());

        if ($post->getHyperlink() == "") {
            // hyperlink has to be unique
            $post->setHyperlink(\Post::uniqueLink($post->getTitle()));
        }

        // add the categories
        $categories = \CategoryQuery::create()->filterByName($data['categories'])->find();

        $post->setCategories($categories);

        return $post;
    }
}
