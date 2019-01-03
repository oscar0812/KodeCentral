<?php
$base_url = 'https://kodecentral.com';

// basic xml header info
echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.
'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

foreach ($urls as $url) {
    echo '<url>' . PHP_EOL;
    echo '<loc>'.$base_url.$url.'</loc>' . PHP_EOL;
    echo '<changefreq>daily</changefreq>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
}

// posts
foreach ($posts as $post) {
    echo '<url>' . PHP_EOL;
    echo '<loc>'.$base_url.'/post/'. urlencode($post->getHyperlink()) .'</loc>' . PHP_EOL;
    echo '<changefreq>daily</changefreq>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
}

// users
foreach ($users as $user) {
    echo '<url>' . PHP_EOL;
    echo '<loc>'.$base_url.'/profile/'. urlencode($user->getUsername()) .'</loc>' . PHP_EOL;
    echo '<changefreq>daily</changefreq>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
}

// libraries
foreach ($libs as $lib) {
    echo '<url>' . PHP_EOL;
    echo '<loc>'.$base_url.'/lib/'. urlencode($lib->getName()) .'</loc>' . PHP_EOL;
    echo '<changefreq>daily</changefreq>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
}

// close tag
echo '</urlset>' . PHP_EOL;
