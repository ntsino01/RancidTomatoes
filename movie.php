<!DOCTYPE html>
<?php 
$movie = $_GET["film"];
$movieInfo=explode("\n",file_get_contents($movie."/info.txt"));
$movieOverview=explode("\n",file_get_contents($movie."/overview.txt"));
$movieDir=scandir($movie);
$filesinDir=count($movieDir);
$revCount=$movieDir[$filesinDir-1];
$revCount=explode("review",explode(".",$revCount)[0])[1];
$movieDirSize=count($movieDir);
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title> Rancid Tomatoes</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="movie.css">
        <link rel="shortcut icon" type="image/gif" href="images/rotten.gif">
    </head>
    <body>
        <div id="banner" style="top:0%;"><img src="images/banner.png" style="width: 100%;max-height:100%;" alt="banner"></div>
		<div style = "top:0%; height:30px;"></div>
        <h1><?= $movieInfo[0] ?> (<?= $movieInfo[1]?>)</h1> 
        <div id="overall">
            <div id="Overview">
                <img src="<?= $movie."/" ?>overview.png" alt="overview">
                <dl class="OverViewdl">
					<?php 
					$toprint="";
					for($i =0; $i<count($movieOverview);$i++){
						$overviewParts=explode(":",$movieOverview[$i]);
						if(!strcmp($overviewParts[0],"STARRING"))printCast($overviewParts[1]);
						else
					$toprint= $toprint."<dt>".$overviewParts[0]."</dt><dd>".$overviewParts[1]."</dd>";
					} ?>
					<?= $toprint?>
                </dl>
            </div>
            <div id="reviews">
                <div id="reviewsbar">
				<?php if($movieInfo[2] < 60) $rottensrc= "images/rottenbig.png"; else  $rottensrc="images/fresh.jpg"; ?>
                   <img id="reviewsbarimg" src="<?= $rottensrc?>" alt="overview"> 
                   <div id="rate"><?= $movieInfo[2] ?><span style="color:white; font-size:small;">% (out of <?=$revCount?> reviews) </span></div>
                </div>
				<?php
				$toprint="";
				for($i = 1; $i<=$revCount; $i ++){
					if($i%ceil($revCount/2)==1){
						$toprint= $toprint."<div class=\"reviewcol\">";
					}
					$review=explode("\n",file_get_contents($movie."\\".$movieDir[$filesinDir-$revCount-1+$i]));
					$imgsrc="rotten.gif";
					if(!strcmp("FRESH",$review[1]))$imgsrc="fresh.gif";
					$toprint= $toprint."<div class=\"reviewquote\"><img class=\"likeimg\" src=\"images/".$imgsrc."\" alt=\"".explode(".",$imgsrc)[0]."\">".$review[0]."</div><div class=\"personalquote\"><img class=\"personimg\" src=\"images/critic.gif\" alt=\"critic\">".$review[2]."<br>".$review[3]."</div>";
					if($i%ceil($revCount/2)==0)
						$toprint= $toprint."</div>";
				}
				$toprint= $toprint."</div>";
				if($revCount%ceil($revCount/2)!=0)$toprint= $toprint."</div>";
				?>
				<?= $toprint?>
            <div id="bottombar">
                (1-<?= $revCount?>) of <?= $revCount?>
            </div>   
			
                <div id="reviewsbar">
				<?php if($movieInfo[2] < 60) $rottensrc= "images/rottenbig.png"; else  $rottensrc="images/fresh.jpg"; ?>
                   <img id="reviewsbarimg" src="<?= $rottensrc?>" alt="overview"> 
                   <div id="rate"><?= $movieInfo[2] ?><span style="color:white; font-size:small;">% (out of <?=$revCount?> reviews) </span></div>
				</div>
			
			</div>
        </div>
        <div id="w3ccheck">
            <a href="http://validator.w3.org/check/referer"><img src="images/w3c-html.png" alt="Valid HTML5"></a> <br>
            <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="images/w3c-css.png" alt="Valid CSS"></a>
	</div>
	<div style = "bottom:0px; height:60px;"></div>
	<div id="banner" style="bottom:0%;"><img src="images/banner.png" style="width: 100%;max-height:100%;" alt="banner"></div>
<?php 
function printCast($movieOverview){ ?>
	<dt>STARRING</dt>
                    <dd>
                        <ul>
							<?php 
							$cast = explode(", ",$movieOverview);
							$castP="";
							for($i=0;$i<count($cast);$i++){
								$castP= $castP."<li>".$cast[$i]."</li>";
							} ?>
							<?=$castP?>
                        </ul> 
                    </dd><?php
}
?>
</body></html>