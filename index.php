<?php
require_once("./lib/TimeCard.php");

use \SimpleTimeCard\TimeCard as TCard;

$card = new TCard();

if(!empty($_GET["d"])) {
    $param=[
        "Year"=>$_GET["y"],
        "Month"=>$_GET["m"],
        "Date"=>$_GET["d"]
    ];
    if($_GET["t"]=="s") {
        $param["start"]=$_GET["time"];
    }else{
        $param["end"]=$_GET["time"];
    }
    if($card->updateTime($param)) {
        $setJson = $card->init();
    }
} else {
    $setJson = $card->init();
}
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Example for SimpleTimeCard</title>
</head>
<body>
<table>
    <h3><?php echo $card->thisYear."年".$card->thisMonth."月" ?></h3>
    <?php for($i=1;$i<$card->thisDates+1;$i++): ?>
    <tr>
        <th><?php echo $i ?>日</th>
        <td>
            <?php if(!empty($setJson[$i]["start"])): ?>
                <?php echo $setJson[$i]["start"] ?>
            <?php else: ?>
            <a href="index.php?y=<?php echo $card->thisYear ?>&m=<?php echo $card->thisMonth ?>&d=<?php echo $i ?>&t=s&time=<?php echo date("H:i") ?>">出勤</a>
            <?php endif; ?>
        </td>
        <td>
            <?php if(!empty($setJson[$i]["end"])): ?>
                <?php echo $setJson[$i]["end"] ?>
            <?php else: ?>
            <a href="index.php?y=<?php echo $card->thisYear ?>&m=<?php echo $card->thisMonth ?>&d=<?php echo $i ?>&t=e&time=<?php echo date("H:i") ?>">退勤</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endfor; ?>
</table>
</body>
</html>

