<?php
// M3U8 URL
$m3u8_url = 'http://8088y.site/P/X/X2/play.php?id=400201942&.m3u8';

// Temp filenames
$temp_file = 'output.ts';

// Get M3U8 content
$m3u8_content = file_get_contents($m3u8_url);
if (!$m3u8_content) {
    die("Failed to fetch M3U8.");
}

// Base URL for segment resolution
$parsed_url = parse_url($m3u8_url);
$base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . dirname($parsed_url['path']) . '/';

// Extract TS segments
preg_match_all('/^[^#].+\.ts$/m', $m3u8_content, $matches);
$segments = $matches[0];

// Download and merge TS segments
$fp = fopen($temp_file, 'w');
if (!$fp) {
    die("Cannot open output file.");
}

foreach ($segments as $seg) {
    $seg_url = (strpos($seg, 'http') === 0) ? $seg : $base_url . $seg;
    echo "Downloading: $seg_url<br>";

    $ts_data = @file_get_contents($seg_url);
    if ($ts_data) {
        fwrite($fp, $ts_data);
    } else {
        echo "Failed to download segment: $seg_url<br>";
    }
}

fclose($fp);
echo "Done! TS file saved as: $temp_file";
?>
