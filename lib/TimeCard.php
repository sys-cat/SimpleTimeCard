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
            $this->thisYear = date("Y");
            $this->thisMonth = date("m");
            $this->startTime = $configArr["startTime"];
            $this->endTime = $configArr["endTime"];
            $this->breakTime = $configArr["breakTime"];
            $this->outTimeLimit = $configArr["outTimeLimit"];
            $this->weekEndFlg = $configArr["weekEnd"];
            $this->outPutDir = __DIR__.DIRECTORY_SEPARATOR.$configArr["fileSetting"]["outputDir"];
            return true;
        }
    }

    /*
     * Init TimeCard
     *
     */
    // Init TimeCard
    public function init()
    {
        if($this->jsonSetting()) {
            $file = file_get_contents($this->outPutDir);
            $result = json_decode($file,true);
            return $result[$this->thisYear][$this->thisMonth];
        } else {
            return false;
        }
    }

    // Output JSON Setting
    private function jsonSetting()
    {
        $outPath = file_get_contents($this->outPutDir);
        $outPathArr = json_decode($outPath, true);
        $thisYear = date("Y");
        $thisMonth = date("m");
        if(count($outPathArr)>0) {
            if(!empty($outPathArr[$thisYear][$thisMonth])) {
                return true;
            } else {
                $month = $this->setThisMonth();
                try {
                    $openJson = fopen($this->outPutDir, 'a+');
                    //$month = json_encode($month);
                    if(!empty($outPathArr[$thisYear])) {
                        $outPathArr[$thisYear]=$month[$thisYear][$thisMonth];
                        $month = json_encode($outPathArr);
                        fwrite($openJson, $month);
                    } else {
                        $outPathArr[] = $month;
                        $month = json_encode($outPathArr);
                        fwrite($openJson, $month);
                    }
                    fclose($openJson);
                    return true;
                } catch(\Exception $e) {
                    return false;
                }
            }
        } else {
            $month = $this->setThisMonth();
            try {
                $openJson = fopen($this->outPutDir, 'a+');
                $month = json_encode($month);
                fwrite($openJson, $month);
                fclose($openJson);
                return true;
            } catch(\Exception $e) {
                return false;
            }
        }
    }

    // Get this Month
    private function setThisMonth()
    {
        $thisYear = date("Y");
        $thisMonth = date("m");
        $end = date("t");
        $days[$thisYear][$thisMonth]=[];
        $thisDate=[];
        for($i=1;$i<(int)$end+1;$i++) {
            $thisDate[$i] = [
                "date"=>$i,
                "start"=>"",
                "end"=>""
            ];
        }
        $days[$thisYear][$thisMonth]=$thisDate;
        return $days;
    }

    /*
     * Update TimeCard
     */
    // Update TimeCard
    public function updateTime($params=array())
    {
        if(count($params)>0) {
            return true;
        } else {
            return false;
        }
    }

    private function updateTodayStart()
    {}

    private function updateTodayEnd()
    {}

    /*
     * Tools
     */
    public function workingTime($start, $end)
    {
        if(empty($start)) {
            $start = $this->startTime;
        }
        if(empty($end)) {
            $end = $this->endTime;
        }
        return true;
    }
}
