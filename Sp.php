<?php
// SETTINGS
$m3u8_url = 'https://example.com/stream.m3u8'; // Replace with your M3U8
$output_name = 'output';
$duration = 15000; // 4 hours 10 minutes in seconds
$key_id = '1234567890abcdef1234567890abcdef';
$key = 'abcdef1234567890abcdef1234567890';

// STEP 1: Download and trim M3U8
shell_exec("ffmpeg -i \"$m3u8_url\" -t $duration -c copy {$output_name}.mp4");

// STEP 2: Convert to MPD with encryption
$pssh = '00000038706...'; // Optional base64 PSSH if using DRM like Widevine
shell_exec("MP4Box -dash 4000 -frag 4000 -rap -profile dashavc264:live -out {$output_name}.mpd -encryption -key 1:$key_id:$key {$output_name}.mp4");

// STEP 3: Output MPD video via Dash.js
echo <<<EOD
<!DOCTYPE html>
<html>
<head><title>DASH Player</title><script src="https://cdn.dashjs.org/latest/dash.all.min.js"></script></head>
<body>
<video id="videoPlayer" controls autoplay width="640" height="360"></video>
<script>
    var player = dashjs.MediaPlayer().create();
    player.initialize(document.querySelector("#videoPlayer"), "{$output_name}.mpd", true);
</script>
</body>
</html>
EOD;
?>
