<?php
error_reporting(0);
include "system/function.php";
if($_GET['id']) {
$share = json_decode(file_get_contents("base/data/main/share/$_GET[id].json"),true);
$setting = json_decode(file_get_contents("base/data/setting/config.json"),true);
$iklan = $setting['jw'];
if($setting['player'] == "enable"){
$judul = $share['file']['title'];
$sub = $share['file']['poster'];
$sub1 = "subtitle/$sub";
$source = secure_link($_GET['id']);
}
}
?>
<!doctype html>
<head>
<meta charset="utf-8" />
<script type="text/javascript" src="https://ssl.p.jwpcdn.com/player/v/8.3.3/jwplayer.js"></script>
<script type="text/javascript" src="https://syndication.exdynsrv.com/instream-tag.php?idzone=3659501"></script>
<style type="text/css">*{margin:0;padding:0}#myplayer{position:absolute;width:100%!important;height:100%!important}</style>
</head>

<body>
    <div id="myplayer"></div>
    <script type="text/JavaScript">
     jwplayer.key="XSuP4qMl+9tK17QNb+4+th2Pm9AWgMO/cYH8CI0HGGr7bdjo";
      jwplayer("myplayer").setup({
            "file": "<?php echo $source['link'] ?>",
            "type" : "mp4",
            "image" : "<?php echo $source['poster'] ?>",
            "title" : "<?php echo $judul ?>",
            "height": 360,
            "width": 640,
            "autostart": false,
            "nextupoffset": "-10",
            "hlsjsdefault" : true,
            "stretching" : "uniform",
            "renderCaptionsNatively" : false,
            "captions" : {
            "fontSize" : 15,
            "backgroundOpacity" : 15
            },
            "tracks" : [{ 
            "file" : "<?php echo $sub1 ?>", 
            "label" : "default",
            "default": true
            }],
            advertising: {
                client: "vast",
                schedule: {
                    "myAds": {
                        "offset":"pre",
                        "tag": "<?php echo $iklan?>",
                        "skipoffset": "5,"
                    },
                    "myAds1": {
                        "offset":"50%",
                        "tag": "<?php echo $iklan?>",
                        "skipoffset": "5,"
                    },
                    "myAds2": {
                        "offset":"post",
                        "tag": "<?php echo $iklan?>",
                        "skipoffset": "5,"
                    }
                }
            },
      });

    </script>
</body>
</html>
