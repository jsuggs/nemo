<?php

$f = fopen('stores.csv', 'w');
$pages = glob('store_pages/*');
foreach ($pages as $page) {
    $html = file_get_contents($page);
    preg_match_all('#http://([^\.]+)\.bigcartel\.com#', $html, $names);
    fwrite($f, implode("\n", $names[1]));
}
fclose($f);
