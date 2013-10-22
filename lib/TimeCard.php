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
            return true;
        }
    }

    // Get this Month
    // date("Y-m-01");date("Y-m-t");
    public function setThisMonth()
    {}
}

$card = new TimeCard();
var_dump($card);