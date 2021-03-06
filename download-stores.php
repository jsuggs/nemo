<?php

$numStores = readline('Stores to download: ');
$reverse = readline('Reverse the array [yN]: ');
$storesImported = 0;
$stores = file('stores.csv');
if (strtolower($reverse) == 'y') {
    $stores = array_reverse($stores);
}
foreach ($stores as $store) {
    $storesImported++;
    $store = trim($store);
    $dir = sprintf('store_data/%s', $store);
    if (file_exists($dir)) {
        continue;
    }
    if (!mkdir($dir)) {
        throw Exception("could not create directory $dir");
    }
    echo "Downloading $store\n";
    $storeFile = sprintf('%s/store.json', $dir);
    $storeUrl = sprintf('http://api.bigcartel.com/%s/store.json', $store);
    file_put_contents($storeFile, file_get_contents($storeUrl));

    $productsFile = sprintf('%s/products.json', $dir);
    $productsUrl = sprintf('http://api.bigcartel.com/%s/products.json', $store);
    file_put_contents($productsFile, file_get_contents($productsUrl));

    if ($storesImported == $numStores) {
        break;
    }
}
