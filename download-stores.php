<?php

$stores = file('stores.csv');
$stores = array('1120studios','stikr4u','prettyinspirations','apeacefulstance');
$stores = array('1120studios');
foreach ($stores as $store) {
    $store = trim($store);
    $dir = sprintf('store_data/%s', $store);
    if (file_exists($dir)) {
        continue;
    }
    if (!mkdir($dir)) {
        throw Exception("could not create directory $dir");
    }
    $storeFile = sprintf('%s/store.json', $dir);
    $storeUrl = sprintf('http://api.bigcartel.com/%s/store.json', $store);
    file_put_contents($storeFile, file_get_contents($storeUrl));

    $productsFile = sprintf('%s/products.json', $dir);
    $productsUrl = sprintf('http://api.bigcartel.com/%s/products.json', $store);
    file_put_contents($productsFile, file_get_contents($productsUrl));
}
