<?php
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
        echo "Missing 'id' parameter.";
            exit;
            }

            $url = "http://8088y.site/P/X/X2/play.php?id=" . urlencode($id);

            // Fetch the content
            $stream = @file_get_contents($url);

            if ($stream === FALSE) {
                http_response_code(502);
                    echo "Unable to fetch stream.";
                        exit;
                        }

                        // Set the header and output the stream
                        header("Content-Type: application/vnd.apple.mpegurl");
                        echo $stream;
                        ?>