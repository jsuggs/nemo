<?php

$startPage = readline('Enter Start Page: ');
$endPage = readline('Enter End Page: ');
$delay = readline('Delay Request (ms): ');
$baseUrl = 'http://directory.bigcartel.com/stores';
for ($page=$startPage;$page<=$endPage;$page++) {
  $url = sprintf('%s%s', $baseUrl, $page > 1 ? "?page=$page" : '');
  echo "$url\n";
  file_put_contents(sprintf('store_pages/%d', $page), file_get_contents($url));
  usleep($delay);
}
