<?php
// Original inputs
$m3u8_url = 'http://8088y.site/P/X/X2/play.php?id=400201942&.m3u8';
$key_raw = '10384187458199';

// Convert to proper hex
$key_hex = str_pad(dechex($key_raw), 32, '0', STR_PAD_LEFT);
$key_id = $key_hex;
$key = $key_hex;

$output = 'stream';
$duration = 15000; // 4h10m

// STEP 1: Download and trim M3U8
echo "Downloading and converting M3U8...\n";
$cmd1 = "ffmpeg -y -i \"$m3u8_url\" -t $duration -c copy {$output}.mp4 2>&1";
echo shell_exec($cmd1);

// STEP 2: Convert to encrypted DASH MPD
echo "Generating MPD with encryption...\n";
$cmd2 = "MP4Box -dash 4000 -frag 4000 -rap -profile dashavc264:live " .
        "-out {$output}.mpd -encryption -key 1:$key_id:$key {$output}.mp4 2>&1";
echo shell_exec($cmd2);

echo "Done! Output files:\n";
echo "- {$output}.mp4\n";
echo "- {$output}.mpd and segments\n";
?>
