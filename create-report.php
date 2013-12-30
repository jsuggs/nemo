<?php

$stores = file('stores.csv');
$report = fopen('report.csv', 'w');
$invalid = fopen('invalid.csv', 'w');
fputcsv($report, array('name', 'slug', 'url', 'currency', 'country', '# products', 'categories', 'pages'));

foreach ($stores as $store) {
    $store = trim($store);
    $dir = sprintf('store_data/%s', $store);
    if (!file_exists($dir)) {
        continue;
    }
    echo "Reporting $store\n";
    $storeFile = sprintf('%s/store.json', $dir);

    $storeData = json_decode(file_get_contents($storeFile), true);
    if (!$storeData || is_null($storeData)) {
        fwrite($invalid, "$store\n");
        continue;
    }
    $categories = array_map(function($cat) { return $cat['name']; }, $storeData['categories']);
    $pages = array_map(function($page) use ($storeData) {
        return sprintf('%s => %s/%s', $page['name'], $storeData['url'], $page['permalink']);
    }, $storeData['pages']);
    fputcsv($report, array(
        $storeData['name'],
        "$store",
        $storeData['url'],
        $storeData['currency']['code'],
        $storeData['country']['code'],
        $storeData['products_count'],
        implode(',', $categories),
        implode(',', $pages),
    ));
}
fclose($report);
