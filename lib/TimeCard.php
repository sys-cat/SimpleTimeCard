<?php
/**
 * User: makoto
 * Date: 2013/10/22
 * Todo: Create Go to Work method adn Leaving Work method. and Users Class.
 * @group app
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
            $this->thisDates = date("t");
            $this->thisDay = date("d");
            $this->startTime = $configArr["startTime"];
            $this->endTime = $configArr["endTime"];
            $this->breakTime = $configArr["breakTime"];
            $this->outTimeLimit = $configArr["outTimeLimit"];
            $this->weekEndFlg = $configArr["weekEnd"];
            $this->outPutDir = __DIR__.DIRECTORY_SEPARATOR.$configArr["fileSetting"]["outputDir"];
            return true;
        }
    }

    public function debugJSON() {
        $file = file_get_contents($this->outPutDir);
        return $result = json_decode($file, true);
        return $result[$this->thisYear][$this->thisMonth];
    }

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
        if(count($outPathArr)>0) {
            if(!empty($outPathArr[$this->thisYear][$this->thisMonth])) {
                return true;
            } else {
                $month = $this->setThisMonth();
                try {
                    // ファイルを開いて空にして書き込む
                    $openJson = fopen($this->outPutDir, 'r+');
                    ftruncate($openJson, 0);
                    fseek($openJson, 0);
                    if(!empty($outPathArr[$this->thisYear])) {
                        $outPathArr[$this->thisYear][$this->thisMonth]=$month;
                    } else {
                        $outPathArr[] = $month;
                    }
                    $month = json_encode($outPathArr);
                    fwrite($openJson, $month);
                    fclose($openJson);
                    return true;
                } catch(\Exception $e) {
                    return false;
                }
            }
        } else {
            $month = $this->setThisMonth();
            try {
                // ファイルを開いて空にして書き込む
                $openJson = fopen($this->outPutDir, 'r+');
                ftruncate($openJson, 0);
                fseek($openJson, 0);
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
        $end = date("t");
        $days[$this->thisYear][$this->thisMonth]=array();
        $thisDate=array();
        for($i=1;$i<(int)$end+1;$i++) {
            $thisDate[$i] = array(
                "date"=>$i,
                "start"=>"",
                "end"=>""
            );
        }
        $days[$this->thisYear][$this->thisMonth]=$thisDate;
        return $days;
    }

    // Update TimeCard
    public function updateTime($params=array())
    {
        if(count($params)>0) {
            $json = file_get_contents($this->outPutDir);
            $jsonArr = json_decode($json, true);
            // 出勤時間確認
            if(!empty($params["start"])) {
                $params["start"] = $this->updateTodayStart($params["start"]);
            } elseif(!empty($jsonArr[$params["Year"]][$params["Month"]][$params["Date"]]["start"])) {
                $params["start"] = $jsonArr[$params["Year"]][$params["Month"]][$params["Date"]]["start"];
            } else {
                $params["start"] = "";

            }
            // 退勤時間確認
            if(!empty($params["end"])) {
                $params["end"] = $this->updateTodayEnd($params["end"]);
            } elseif(!empty($jsonArr[$params["Year"]][$params["Month"]][$params["Date"]]["end"])) {
                $params["end"] = $jsonArr[$params["Year"]][$params["Month"]][$params["Date"]]["end"];
            } else {
                $params["end"] = "";
            }
            $jsonArr[$params["Year"]][$params["Month"]][$params["Date"]] = array(
                "start" => $params["start"],
                "end" => $params["end"]
            );
            // ファイルを開いて空にして書き込む
            $openJson = fopen($this->outPutDir, 'r+');
            ftruncate($openJson, 0);
            fseek($openJson, 0);
            $json = json_encode($jsonArr);
            fwrite($openJson, $json);
            fclose($openJson);
            return true;
        } else {
            return false;
        }
    }

    // updateTodayStart
    private function updateTodayStart($startTime=null)
    {
        if(empty($startTime)) {
            $startTime = $this->startTime;
        }
        return $startTime;
    }

    // updateTodayEnd
    private function updateTodayEnd($endTime=null)
    {
        if(empty($endTime)) {
            $endTime = $this->endTime;
        }
        return $endTime;
    }

    // workingTime
    public function workingTime($start, $end)
    {
        if(empty($start)) {
            $start = $this->startTime;
        }
        if(empty($end)) {
            $end = $this->endTime;
        }
        return array($start, $end);
    }
}

