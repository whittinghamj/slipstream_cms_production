<?php

$stream_url = base64_decode($_GET['stream_url']);

if(!isset($_GET['stream_url']) || empty($_GET['stream_url'])) {
    die('stream_url is missing.');
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Web Player</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="https://releases.flowplayer.org/7.0.4/flowplayer.min.js"></script>
    <script type="text/javascript" src="https://releases.flowplayer.org/hlsjs/flowplayer.hlsjs.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://releases.flowplayer.org/7.0.4/skin/skin.css">

    <style type="text/css">
    </style>

    <script type="text/javascript">
      window.onload=function(){
          var player = flowplayer("#player", {
              clip: {
                  sources: [{
                      type: "application/x-mpegurl",
                      src: "<?php echo $stream_url; ?>"
                  }]
              }
          });
      }
    </script>

</head>
<body>
    Video Loading.
    <div id="player"></div>
</body>
</html>
