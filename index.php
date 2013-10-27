<?php
require_once("./lib/TimeCard.php");

use \SimpleTimeCard\TimeCard as TCard;

$card = new TCard();
$setJson = $card->init();
var_dump($setJson);
var_dump($card);