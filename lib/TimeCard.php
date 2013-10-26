<?php
/**
 * User: makoto
 * Date: 2013/10/22
 * Todo: Create Go to Work method adn Leaving Work method. and Users Class.
 */

namespace SimpleTimeCard;


class TimeCard
{
    // Set Config Parameter
    public function __construct()
    {
        // Get Config File
        $configObj = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'config.json');
        $configArr = json_decode($configObj, true);
        // Set config parameter
        if($configArr==null){
            return false;
        } else {
            $this->startTime = $configArr["startTime"];
            $this->endTime = $configArr["endTime"];
            $this->breakTime = $configArr["breakTime"];
            $this->outTimeLimit = $configArr["outTimeLimit"];
            $this->weekEndFlg = $configArr["weekEnd"];
            $this->outPutDir = __DIR__.DIRECTORY_SEPARATOR.$configArr["fileSetting"]["outputDir"];
            return true;
        }
    }

    // Get this Month
    public function setThisMonth()
    {
        $thisYear = date("Y");
        $thisMonth = date("m");
        $end = date("t");
        $days[$thisYear][$thisMonth]=[];
        $thisDate=[];
        for($i=1;$i<(int)$end+1;$i++) {
            $thisDate[$i] = $i;
        }
        $days[$thisYear][$thisMonth]=$thisDate;
        return $days;
    }
}

$card = new TimeCard();
$cal = $card->setThisMonth();
var_dump($cal);
var_dump($card);