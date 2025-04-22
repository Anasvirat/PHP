<?php
header("Content-Type: application/vnd.apple.mpegurl");
header("Cache-Control: no-cache");

$base_url = "http://tv365.me:80/live/5794770199/3978448607/";

echo "#EXTM3U\n";
echo "#EXT-X-VERSION:3\n";
echo "#EXT-X-TARGETDURATION:10\n";
echo "#EXT-X-MEDIA-SEQUENCE:0\n";

// Example: Simulate a live playlist with one or more segments
for ($i = 0; $i < 5; $i++) {
    echo "#EXTINF:10.0,\n";
    echo $base_url . "187263.ts\n";
}
?>