<?php
require_once("./lib/TimeCard.php");

use \SimpleTimeCard\TimeCard as TCard;

$card = new TCard();
$setJson = $card->init();
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
        <td><a href="index.php?d=<?php echo $i ?>&t=s&d=<?php echo date("h:i") ?>">出勤</a></td>
        <td><a href="index.php?d=<?php echo $i ?>&t=e&d=<?php echo date("h:i") ?>">退勤</a></td>
    </tr>
    <?php endfor; ?>
</table>
</body>
</html>