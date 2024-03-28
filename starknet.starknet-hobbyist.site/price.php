<?php
include './admin/php/api.php';

class index extends _api
{
    /**
     * 根据ip设置时区
     * @return string
     */
    public function getUTCOffset_OOP($timezone)
    {
        $current   = timezone_open($timezone);
        $utcTime  = new \DateTime('now', new \DateTimeZone('UTC'));
        $offsetInSecs =  $current->getOffset($utcTime);
        $hoursAndSec = gmdate('H:i', abs($offsetInSecs));
        return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
    }

    //Procedural style
    public function getUTCOffset($timezone): string
    {
        $current   = timezone_open($timezone);
        $utcTime  = new \DateTime('now', new \DateTimeZone('UTC'));
        $offsetInSecs =  timezone_offset_get($current, $utcTime);
        $hoursAndSec = gmdate('H:i', abs($offsetInSecs));
        return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
    }
    public function setIpTimezone(): string
    {
        $ip = $this->ip;

        $cache = $this->redisGet($ip);

        //die($cache);

        //echo $cache;
        if ($cache) {
            date_default_timezone_set($cache);
            $utcTimeZone = date_default_timezone_get();
            return $cache;
        }

        $url = "http://ip-api.com/json/$ip";
        $data = $this->curl($url);


        if (!$data) {
            date_default_timezone_set('UTC');
        }

        $timezone = $data['timezone'];
        //die($num111);
        $this->redisSet($ip, $timezone);
        date_default_timezone_set($timezone);
        return $timezone;
    }

    /**
     * 查询图表数据
     * @return void
     */
    public function _echarts(): void
    {


        $utc = $this->is('utc');
        $type = intval($this->is('type', '1'));
        $query = match ($type) {
            1 => 'ROUND(AVG(zhuanzhang),4)',
            2 => 'ROUND(AVG(shangpin4),4)',
            3 => 'ROUND(AVG(gwei),0)',
            default => 'ROUND(AVG(zhuanzhang),4)/ROUND(AVG(shangpin4),4)',
        };

        $where = match ($type) {
            1 => 'zhuanzhang!=0',
            2 => 'shangpin4!=0',
            3 => '1=1',
            default => 'zhuanzhang!=0 AND shangpin4!=0',
        };

        $utc222 = 0;
        // 设置时区
        if ($utc === '') {
            $timezone = $this->setIpTimezone();


            //date_default_timezone_set('America/New_York');
            $utc555 =  date('Z') / 3600;
            $str111 = sprintf("%d", $utc555);
            $utc = $utc555;

            if ($utc == -1) {
                $utc = 21;
            }
            if ($utc == -2) {
                $utc = 22;
            }
            if ($utc == -3) {
                $utc = 23;
            }
            if ($utc == -4) {
                $utc = 24;
            }
            if ($utc == -5) {
                $utc = 25;
            }
            if ($utc == -6) {
                $utc = 26;
            }
            if ($utc == -7) {
                $utc = 27;
            }
            if ($utc == -8) {
                $utc = 28;
            }
            if ($utc == -9) {
                $utc = 29;
            }
            if ($utc == -10) {
                $utc = 30;
            }
            if ($utc == -11) {
                $utc = 31;
            }
            if ($utc == -12) {
                $utc = 32;
            }
            if ($utc < 18) {
                $timezone = 'Etc/GMT' . ($utc > 0 ? '-' : '') . $utc;
            } else {
                $utc222 = $utc;
                $utc = $utc - 20;


                $timezone = 'Etc/GMT' . ($utc > 0 ? '+' : '') . $utc;
            }

            date_default_timezone_set($timezone);
            // echo $str111;
            // echo "scriptalert";
            // exit ("1111111111");






        } else {
            if ($utc < 18) {
                $timezone = 'Etc/GMT' . ($utc > 0 ? '-' : '') . $utc;
            } else {
                $utc222 = $utc;
                $utc = $utc - 20;


                $timezone = 'Etc/GMT' . ($utc > 0 ? '+' : '') . $utc;
            }

            date_default_timezone_set($timezone);
        }

        $current_time = time();
        $start_time = date('Y-m-d 00:00:00', strtotime('-11 days', $current_time));
        $end_time = date('Y-m-d H:i:s', strtotime('+24 hour', $current_time));
        $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 0 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        if ($utc == 7) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 1 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 6) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 2 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 5) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 3 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 4) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 4 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 3) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 5 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 2) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 6 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 1) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 7 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 0) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 8 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }


        if ($utc == 8) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 0 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 9) {
            $sql = "SELECT DATE_FORMAT( DATE_ADD(time_moren, INTERVAL 1 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 10) {
            $sql = "SELECT DATE_FORMAT( DATE_ADD(time_moren, INTERVAL 2 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 11) {
            $sql = "SELECT DATE_FORMAT( DATE_ADD(time_moren, INTERVAL 3 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc == 12) {
            $sql = "SELECT DATE_FORMAT( DATE_ADD(time_moren, INTERVAL 4 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }


        if ($utc222 == 21) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 9 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 22) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 10 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 23) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 11 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 24) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 12 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 25) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 13 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 26) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 14 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 27) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 15 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 28) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 16 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 29) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 17 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 30) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 18 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 31) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 19 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 32) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 20 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }
        if ($utc222 == 33) {
            $sql = "SELECT DATE_FORMAT( DATE_SUB(time_moren, INTERVAL 21 hour),'%Y-%m-%d %H:00:00') AS hour,$query AS num FROM hangqing WHERE time_moren >= '$start_time' AND time_moren <= '$end_time' AND $where GROUP BY hour";
        }

        $result = $this->conn->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = date('Y-m-d', strtotime($row['hour']));
                $host = date('H', strtotime($row['hour']));
                $num = $row['num'];
                $data[] = [
                    $date,
                    intval($host),
                    $type === 0 ? number_format($num * 100, 3) : floatval($num)
                ];
            }
        }

        $start = date("Y-m-d", strtotime("-10 day"));
        $end = date("Y-m-d");
        $count = round((strtotime($end) - strtotime($start)) / 3600 / 24);
        $date = [];

        for ($i = $count; $i >= 0; $i--) {
            $day = date('Y-m-d', strtotime($end . " -" . $i . " day"));
            $date[] = $day;
        }

        $hour = [];
        for ($i = 0; $i < 24; $i++) {
            $hour[] = $i;
        }

        $this->res('ok', 1, [
            'date' => $date,
            'hour' => $hour,
            'data' => $data,
            'timezone' => $timezone
        ]);
    }

    public function _two(): void
    {
        $utc = $this->is('utc');

        // 设置时区
        if ($utc === '') {
            $timezone = $this->setIpTimezone();
        } else {
            if ($utc > 24) $utc = 24;
            $timezone = 'Etc/GMT' . ($utc > 0 ? '+' : '') . $utc;
            date_default_timezone_set($timezone);
        }

        $current_time = time();
        $start_time = date('Y-m-d 00:00:00', strtotime('-10 days', $current_time));
        $end_time = date('Y-m-d H:i:s', $current_time);

        $sql = "
SELECT
	DATE_FORMAT(
		time_moren,
		'%Y-%m-%d %H:00:00'
	) AS hour,
	ROUND(AVG(swap),3) AS swap
FROM
	hangqing
WHERE
	time_moren >= '$start_time'
AND time_moren <= '$end_time'
GROUP BY
	hour";
        $result = $this->conn->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = date('Y-m-d', strtotime($row['hour']));
                $host = date('H', strtotime($row['hour']));
                $data[] = [
                    $date,
                    intval($host),
                    floatval($row['swap'])
                ];
            }
        }

        $start = date("Y-m-d", strtotime("-10 day"));
        $end = date("Y-m-d");
        $count = round((strtotime($end) - strtotime($start)) / 3600 / 24);
        $date = [];

        for ($i = $count; $i >= 0; $i--) {
            $day = date('Y-m-d', strtotime($end . " -" . $i . " day"));
            $date[] = $day;
        }

        $hour = [];
        for ($i = 0; $i < 24; $i++) {
            $hour[] = $i;
        }

        $this->res('ok', 1, [
            'date' => $date,
            'hour' => $hour,
            'data' => $data,
            'timezone' => $timezone
        ]);
    }

    public function _card(): void
    {
        $utc = $this->is('utc');

        // 设置时区
        if ($utc === '') {
            $timezone = $this->setIpTimezone();
        } else {
            if ($utc < 18) {
                $timezone = 'Etc/GMT' . ($utc > 0 ? '-' : '') . $utc;
            } else {
                $utc = $utc - 20;
                $timezone = 'Etc/GMT' . ($utc > 0 ? '+' : '') . $utc;
            }

            date_default_timezone_set($timezone);
        }

        $date = date('Y-m-d H');
        $sql = "
SELECT
    ROUND(shangpin4,4) AS min_shangpin4,
    ROUND(zhuanzhang,4) AS min_zhuanzhang,
    ROUND(gwei,0) AS min_gwei
FROM
    hangqing
WHERE
     shangpin4!=0 AND zhuanzhang!=0 order by time_moren desc LIMIT 1";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result->num_rows == 0) {
            $this->res('ok', 1, $data);
        }

        $row = $result->fetch_assoc();
        $row['timezone'] = $timezone;
        $this->res('ok', 1, $row);
    }

    public function _line()
    {
        $utc = $this->is('utc');
        $type = intval($this->is('type', '1'));

        // 设置时区
        if ($utc === '') {
            $timezone = $this->setIpTimezone();
        } else {
            if ($utc < 18) {
                $timezone = 'Etc/GMT' . ($utc > 0 ? '-' : '') . $utc;
            } else {
                $utc = $utc - 20;
                $timezone = 'Etc/GMT' . ($utc > 0 ? '+' : '') . $utc;
            }

            date_default_timezone_set($timezone);
        }

        $zhuanzhang = $this->queryData('zhuanzhang');
        $shangpin4 = $this->queryData('shangpin4');
        $gwei = $this->queryData('gwei');

        $current_time = time();
        $start_time = strtotime(date('Y-m-d 00:00:00', strtotime('-30 days', $current_time)));
        $end_time = strtotime(date('Y-m-d H:i:s', strtotime('+0 days', $current_time)));
        $count = round(($end_time - $start_time) / 3600);
        $date = [];
        for ($i = 0; $i < $count; $i++) {
            $date[] = date('Y-m-d H', strtotime(date('Y-m-d H:00:00', $start_time) . " +$i hour"));
        }

        $data = [];

        function filter($item, $data)
        {
            foreach ($data as $value) {
                if ($value[0] === $item) {
                    return $value[1];
                }
            }
            return 0;
        }

        foreach ($date as $item) {

            $data[] = [filter($item, $zhuanzhang), filter($item, $shangpin4), filter($item, $gwei)];
        }

        $this->res('ok', 1, [
            'date' => $date,
            'data' => $data,
            'timezone' => $timezone
        ]);
    }

    public function queryData($type)
    {
        $current_time = time();
        $start_time = date('Y-m-d 00:00:00', strtotime('-30 days', $current_time));
        $end_time = date('Y-m-d H:i:s', strtotime('+0 days', $current_time));
        $index = $type == 'gwei' ? 0 : 4;
        $sql = "
SELECT
	DATE_FORMAT(
		time_moren,
		'%Y-%m-%d %H:00:00'
	) AS hour,
	ROUND(AVG($type),$index) AS num
FROM
	hangqing
WHERE
	time_moren >= '$start_time'
AND time_moren <= '$end_time'
AND $type != 0
GROUP BY
	hour
";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = date('Y-m-d H', strtotime($row['hour']));
                $num = $row['num'];
                $data[] = [
                    $date,
                    floatval($num)
                ];
            }
        }
        return $data;
    }
}

$web = new index(1);
$web->method('');
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <title>
        Starknet Gas
    </title>
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="https://www.layuicdn.com/layui/css/layui.css?v=<?php echo $web->v; ?>" />
    <link rel="stylesheet" type="text/css" href="../css/style.css?v=<?php echo $web->v; ?>" />
    <link rel="stylesheet" type="text/css" href="./css/style.css?v=<?php echo $web->v; ?>" />
    <script src="https://www.layuicdn.com/layui/layui.js?v=<?php echo $web->v; ?>"></script>
    <style>
        .price>.title {
            font-size: 30px;
            font-weight: bold;
            margin-top: 50px;
            color: #ffffff;
        }

        .price>.desc {
            font-size: 16px;
            margin-top: 20px;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .chart {
            height: 600px;
            margin-top: 30px;
        }

        #chart2 {
            margin-bottom: 30px;
        }

        .current {
            color: #ffffff;
            text-align: center;
            margin-top: 30px;
            font-size: 30px;
            position: relative;
            height: 35px;
            line-height: 35px;
            font-weight: bold;
        }

        .tools {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .tools>div {
            position: relative;
        }

        .chart-type {
            width: max-content;
            background-color: #22244D;
            border-radius: 10px;
            padding: 5px 15px;
        }

        .layui-form-radio>* {
            color: rgb(160, 165, 204);
        }

        .layui-form-radio:hover>*,
        .layui-form-radioed,
        .layui-form-radioed>i {
            color: #3E5CD7 !important;
        }

        .layui-form-select .layui-input {
            background-color: #22244D;
            border: none;
            color: #ffffff;
        }

        .layui-form-select dl {
            background-color: #22244D;
            border: none;
            color: #ffffff;
        }

        .layui-form-select dl dd.layui-this {
            color: #3E5CD7 !important;
        }

        .layui-form-select dl dd:hover {
            color: #3E5CD7 !important;
        }

        .card {
            background-color: #22244D;
            border-radius: 10px;
            margin: 30px 0;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .card>.title {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
        }

        .card>.title>img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .card>.title>span {
            font-size: 20px;
            color: rgb(160, 165, 204);
        }

        .card>.price {
            font-size: 45px;
            color: #ffffff;
            text-align: center;
            margin-top: 20px;
        }

        .card>.desc {
            font-size: 12px;
            color: rgb(160, 165, 204);
            text-align: center;
            margin-top: 10px;
        }

        .speed {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 0;
            width: 100%;
            opacity: 0.1;
            background-color: aquamarine;
        }

        .ratio:after {
            content: '%';
        }

        .drag-tpis {
            position: absolute;
            left: 45px;
            top: -42px;
            color: rgb(160, 165, 204);
        }
        
        .gwei {
            color: #ffb800 !important;
        }
    </style>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="main layui-form">
        <div class="price">
            <div class="title">
                <span>Starknet Transfer Gas</span>
            </div>
            <div class="desc">
                <span>GAS consumed by Ethereum and starknet transfer, in USD</span>
            </div>
            <div class="layui-row layui-col-space30">
                <div class="layui-col-sm3">
                    <div class="card">
                        <div class="title">
                            <img src="./images/price-1.png?v=1" alt="">
                            <span>Ethereum</span>
                        </div>
                        <div class="price">
                            <span style="color: #ffb800;">0.0</span>
                        </div>
                        <div class="desc">
                            <span style="color:#ffb800;">0</span>
                            <span style="color:#ffb800;">Gwei</span>
                        </div>
                        <div class="speed"></div>
                    </div>
                </div>
                <div class="layui-col-sm3">
                    <div class="card">
                        <div class="title">
                            <img src="./images/price-2.png?v=1" alt="">
                            <span>Starknet(Use ETH)</span>
                        </div>
                        <div class="price">
                            <span style="color: #5BC43F;">0.0</span>
                        </div>
                        <div class="desc">
                            <span style="color:#5BC43F;">0</span>
                            <span style="color:#5BC43F;">Gwei</span>
                        </div>
                        <div class="speed"></div>
                    </div>
                </div>
                <div class="layui-col-sm3">
                    <div class="card">
                        <div class="title">
                            <img src="./images/price-6.png?v=1" alt="">
                            <span>Starknet(Use STRK)</span>
                        </div>
                        <div class="price">
                            <span style="color: #1e9fff;">0.0</span>
                        </div>
                        <div class="desc">
                            <span style="color:#1e9fff;">0</span>
                            <span style="color:#1e9fff;">Gwei</span>
                        </div>
                        <div class="speed"></div>
                    </div>
                </div>
                <div class="layui-col-sm3">
                    <div class="card">
                        <div class="title">
                            <img src="./images/ratio.png" alt="">
                            <span>Starknet / Ethereum</span>
                        </div>
                        <div class="price">
                            <span style="color: #966bff;" class="ratio">0.0</span>
                        </div>
                        <div class="desc">Compare</div>
                        <div class="speed"></div>
                    </div>
                </div>
            </div>
            <div class="tools">
                <div>
                    <div class="layui-inline">
                        <select name="utc" lay-filter="utc">
                            <option value="">Select UTC</option>
                            <option value="0">UTC+0</option>
                            <option value="1">UTC+1</option>
                            <option value="2">UTC+2</option>
                            <option value="3">UTC+3</option>
                            <option value="4">UTC+4</option>
                            <option value="5">UTC+5</option>
                            <option value="6">UTC+6</option>
                            <option value="7">UTC+7</option>
                            <option value="8">UTC+8</option>
                            <option value="9">UTC+9</option>
                            <option value="10">UTC+10</option>
                            <option value="11">UTC+11</option>
                            <option value="12">UTC+12</option>
                            <option value="21">UTC-1</option>
                            <option value="22">UTC-2</option>
                            <option value="23">UTC-3</option>
                            <option value="24">UTC-4</option>
                            <option value="25">UTC-5</option>
                            <option value="26">UTC-6</option>
                            <option value="27">UTC-7</option>
                            <option value="28">UTC-8</option>
                            <option value="29">UTC-9</option>
                            <option value="30">UTC-10</option>
                            <option value="31">UTC-11</option>
                            <option value="32">UTC-12</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="chart-type">
                        <input type="radio" name="type" value="3" title="ETH Gwei">
                        <input type="radio" name="type" value="1" title="Starknet" checked>
                        <input type="radio" name="type" value="2" title="Ethereum">
                        <input type="radio" name="type" value="0" title="Starknet / Ethereum">
                    </div>
                </div>
            </div>
            <div id="chart1" class="chart"></div>
            <div id="line" style="height: 300px;margin-top: 50px;"></div>
            <div class="desc" style="margin-bottom: 150px;text-align: center;color: #999999;position: relative">
                <span>You can click on Starknet or Gwei ↑↑↑ to display a separate candlestick chart.↑↑↑</span>
                <div class="drag-tpis">↑Pull here Can zoom in and out of range</div>
            </div>
            <div class="title">
                <span>Starknet Swap Token Gas</span>
            </div>
            <div class="desc">
                <span>Starknet Swap Token大概消耗的GAS，单位是美元，北京时间UTC+8（The approximate gas consumption of starknet swap Token GAS, in US dollars，The table time is UTC+8）。</span>
            </div>
            <div class="current">
                <span>Latest Swap Token gas :$</span>
                <span class="latest_price">0.0</span>
            </div>
            <div id="chart2" class="chart"></div>
        </div>
    </div>
    <?php include './footer.php'; ?>
</body>
<script type="text/javascript" src="https://cdn.staticfile.org/echarts/5.4.0/echarts.min.js"></script>
<script>
    const $ = layui.jquery;
    let data_1 = [];
    let data_2 = [];
    let data_3 = [];
    const char1 = {

        /**
         * 初始化
         * @return {void}
         */
        init() {
            const chart = window.echarts.init($('#chart1')[0]);

            this.chart = chart;
            this.get();
            $(window).resize(() => chart.resize());
        },

        /**
         * 获取数据
         * @param {string} type 类型 init | update
         * @return {void}
         */
        async get(type = 'init') {
            const utc = $('[name="utc"]').val();
            const _type = $('[name="type"]:checked').val();
            const query1 = () => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: 'price.php?method=echarts',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            utc,
                            type: 1
                        },
                        success: r => {
                            if (r.code !== 1) {
                                resolve();
                                return;
                            }

                            data_1 = r.data;
                            resolve();
                        },
                        error: (r) => layer.alert(r.responseText, {
                            icon: 2
                        })
                    });
                });
            };
            const query2 = () => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: 'price.php?method=echarts',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            utc,
                            type: 2
                        },
                        success: r => {
                            if (r.code !== 1) {
                                resolve();
                                return;
                            }

                            data_2 = r.data;
                            resolve();
                        },
                        error: (r) => layer.alert(r.responseText, {
                            icon: 2
                        })
                    });
                });
            };
            
            const query3 = () => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: 'price.php?method=echarts',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            utc,
                            type: 3
                        },
                        success: r => {
                            if (r.code !== 1) {
                                resolve();
                                return;
                            }

                            data_3 = r.data;
                            resolve();
                        },
                        error: (r) => layer.alert(r.responseText, {
                            icon: 2
                        })
                    });
                });
            };

            // 如果查询1就查询4的对比数据
            if (_type === '1') {
                await query2();
                await query3();
            }

            if (_type === '2') {
                await query1();
                await query3();
            }

            if (_type === '0') {
                await query1();
                await query2();
                await query3();
            }
            
            if (_type === '3') {
                await query1();
                await query2();
            }

            $.ajax({
                url: 'price.php?method=echarts',
                type: 'GET',
                dataType: 'json',
                data: {
                    utc,
                    type: _type
                },
                success: res => {
                    if (res.code !== 1) {
                        return layer.msg(res.msg, {
                            icon: res.code
                        });
                    }

                    this.set(res, type);
                },
                error: (res) => layer.alert(res.responseText, {
                    icon: 2
                })
            });
        },

        /**
         * 设置图表
         * @param {object} res 数据
         * @param {string} type 类型 init | update
         * @return {void}
         */
        set(res, type = 'init') {
            const pieces = () => {
                const type = $('[name="type"]:checked').val();
                const base = [{
                        min: 0,
                        max: 0.099,
                        color: '#C2D9FB'
                    },
                    {
                        min: 0.1,
                        max: 0.199,
                        color: '#CBFDC2'
                    },
                    {
                        min: 0.2,
                        max: 0.299,
                        color: '#CBFDC2'
                    }, {
                        min: 0.3,
                        max: 0.499,
                        color: '#F7EEAC'
                    }, {
                        min: 0.5,
                        max: 0.999,
                        color: '#F0AF9C'
                    },
                    {
                        min: 1.0,
                        max: 10,
                        color: '#EA6461'
                    }
                ];

                if (type === '1') {
                    return base;
                }

                if (type === '2') {
                    return [{
                            min: 0,
                            max: 0.49,
                            color: '#C2D9FB'
                        },
                        {
                            min: 0.5,
                            max: 0.99,
                            color: '#CBFDC2'
                        },
                        {
                            min: 1.00,
                            max: 1.49,
                            color: '#F7EEAC'
                        }, {
                            min: 1.5,
                            max: 2.99,
                            color: '#F0AF9C'
                        }, {
                            min: 3,
                            max: 4.9,
                            color: '#EA6461'
                        },
                        {
                            min: 5,
                            max: 100,
                            color: '#822925'
                        }
                    ];
                }
                
                if (type === '3') {
                    return [{
                            min: 0,
                            max: 4.99,
                            color: '#C2D9FB'
                        },
                        {
                            min: 5,
                            max: 19.99,
                            color: '#CBFDC2'
                        },
                        {
                            min: 20,
                            max: 49.99,
                            color: '#F7EEAC'
                        }, {
                            min: 50,
                            max: 99.99,
                            color: '#F0AF9C'
                        }, {
                            min:100,
                            max: 299.99,
                            color: '#EA6461'
                        },
                        {
                            min: 300,
                            max: 1000,
                            color: '#822925'
                        }
                    ];
                }
                
                return [{
                    min: 0,
                    max: 100,
                    color: '#CBFDC2'
                }];
            };
            const visualMapFormatter = (value) => {
                const type = $('[name="type"]:checked').val();
                let data = [];
                const map = [{
                        min: 0,
                        max: 0.09,
                        text: '< 0.1'
                    },
                    {
                        min: 0.1,
                        max: 0.19,
                        text: '< 0.2'
                    },
                    {
                        min: 0.2,
                        max: 0.29,
                        text: '< 0.3'
                    }, {
                        min: 0.3,
                        max: 0.49,
                        text: '< 0.5'
                    }, {
                        min: 0.5,
                        max: 0.79,
                        text: '< 0.8'
                    },
                    {
                        min: 0.8,
                        max: 100,
                        text: '>= 0.8'
                    }
                ];
                if (type === '1') {
                    data = map;
                }

                if (type === '2') {
                    data = [{
                            min: 0,
                            max: 0.49,
                            text: '< 0.50'
                        },
                        {
                            min: 0.5,
                            max: 0.99,
                            text: '< 1.00'
                        },
                        {
                            min: 1.00,
                            max: 1.49,
                            text: '< 1.50'
                        }, {
                            min: 1.5,
                            max: 2.99,
                            text: '< 3.00'
                        }, {
                            min: 3,
                            max: 4.9,
                            text: '< 5.00'
                        },
                        {
                            min: 5,
                            max: 100,
                            text: '>= 5.00'
                        }
                    ];
                }
                
                if (type === '3') {
                    data = [{
                            min: 0,
                            max: 4.99,
                            text: '< 5gwei'
                        },
                        {
                            min: 5,
                            max: 19.99,
                            text: '< 20gei'
                        },
                        {
                            min: 20,
                            max: 49.99,
                            text: '< 50gwei'
                        }, {
                            min: 50,
                            max: 99.99,
                            text: '< 100gwei'
                        }, {
                            min: 100,
                            max: 299.99,
                            text: '< 300gwei'
                        },
                        {
                            min: 300,
                            max: 1000,
                            text: '>= 300gwei'
                        }
                    ];
                }

                if (type === '0') {
                    data = [{
                        min: 0,
                        max: 100,
                        text: '>=0 <=100'
                    }];
                }

                for (let i = 0; i < data.length; i++) {
                    const item = data[i];
                    if (value >= item.min && value <= item.max) {
                        return item.text;
                    }
                }
            };
            const labelFormatter = (e) => {
                const type = $('[name="type"]:checked').val();
                const value = e.value[2];
                if (type === '0') {
                    return value + '%';
                }

                return value;
            };

            // 格式 时间+小时<br> 商品1价格<br> 商品4价格 <br> 价格对比
            const tooltipFormatter = (e) => {
                
                const type = $('[name="type"]:checked').val();
                const date = e.value[0];
                const hour = e.value[1];
                const value = e.value[2];
                
                const gwei = ()=>{
                    return data_3.data.find(item => {
                        return item[0] === date && item[1] === hour;
                    });
                };

                if (type === '1') {
                    const data = data_2.data.find(item => {
                        return item[0] === date && item[1] === hour;
                    });
                    let num = '0.00';
                    let contrast = '0.00';
                    if (data && data.length && data[2] !== 0) {
                        contrast = (value / data[2] * 100).toFixed(2);
                        num = data[2].toFixed(2);
                    }
                    return `<div><b>${date} ${hour}:00</b></div>
                            <div>Starknet：${value.toFixed(2)}$</div>
                            <div>Ethereum：${num}$</div>
                            <div>Gwei：${gwei()[2]}</div>
                            <div>Compare：${contrast}%</div>`;
                }

                if (type === '2') {
                    const data = data_1.data.find(item => {
                        return item[0] === date && item[1] === hour;
                    });
                    let num1 = '0.00';
                    let num2 = '0.00';
                    let contrast = '0.00';
                    if (data && data.length && data[2] !== 0) {
                        contrast = (data[2] / value * 100).toFixed(2);
                        num1 = data[2].toFixed(2);
                        num2 = value.toFixed(2);
                    }

                    return `<div><b>${date} ${hour}:00</b></div>
                            <div>Starknet：${num1}$</div>
                            <div>Ethereum：${num2}$</div>
                            <div>Gwei：${gwei()[2]}</div>
                            <div>Compare：${contrast}%</div>`;
                }
                
                 if (type === '3') {
                    const data1 = data_1.data.find(item => {
                        return item[0] === date && item[1] === hour;
                    });
                    const data2 = data_2.data.find(item => {
                        return item[0] === date && item[1] === hour;
                    });
                    let num1 = '0.00';
                    let num2 = '0.00';
                    let contrast = '0.00';
                    if (data1 && data1.length && data1[2] !== 0) {
                        contrast = (data1[2] / data2[2] * 100).toFixed(2);
                        num1 = data1[2].toFixed(2);
                        num2 = data2[2].toFixed(2);
                    }
                    

                    return `<div><b>${date} ${hour}:00</b></div>
                            <div>Starknet：${data1[2]}$</div>
                            <div>Ethereum：${data2[2]}$</div>
                            <div>Gwei：${gwei()[2]}</div>
                            <div>Compare：${contrast}%</div>`;
                }

                const data1 = data_1.data.find(item => {
                    return item[0] === date && item[1] === hour;
                });
                const data2 = data_2.data.find(item => {
                    return item[0] === date && item[1] === hour;
                });
                let contrast = '0.00';
                if (data2[2] !== 0) {
                    contrast = (data1[2] / data2[2] * 100).toFixed(2);
                }
                return `<div><b>${date} ${hour}:00</b></div>
                            <div>Starknet：${data1[2].toFixed(2)}$</div>
                            <div>Ethereum：${data2[2].toFixed(2)}$</div>
                            <div>Compare：${contrast}%</div>`;

            };
            if (type === 'init') {
                this.chart.clear();
                this.chart.setOption({
                    grid: {
                        left: 50,
                        top: 0,
                        right: 0,
                        bottom: 100
                    },
                    xAxis: {
                        type: "category",
                        data: res.data.date,
                        axisTick: {
                            show: !1
                        },
                        axisLine: {
                            show: !1
                        },
                        axisLabel: {
                            lineHeight: 16
                        }
                    },
                    yAxis: {
                        type: "category",
                        data: res.data.hour,
                        axisTick: {
                            show: !1
                        },
                        axisLine: {
                            show: !1
                        },
                        axisLabel: {
                            formatter: function(e) {
                                return e < 10 ? "0".concat(e, ":00") : "".concat(e, ":00")
                            }
                        }
                    },
                    visualMap: {
                        bottom: 0,
                        left: "center",
                        align: "top",
                        orient: "horizontal",
                        min: 0,
                        max: 1000,
                        pieces: pieces(),
                        textStyle: {
                            color: '#ffffff'
                        },
                        formatter: visualMapFormatter
                    },
                    tooltip: {
                        show: !0,
                        formatter: tooltipFormatter
                    },
                    series: [{
                        type: "heatmap",
                        data: res.data.data,
                        label: {
                            show: !0,
                            color: "#1F2533",
                            formatter: labelFormatter
                        },
                        itemStyle: {
                            borderColor: "#FFFFFF",
                            borderWidth: 1
                        },
                        animation: !res
                    }]
                });
            } else {
                this.chart.setOption({
                    xAxis: {
                        data: res.data.date
                    },
                    visualMap: {
                        pieces: pieces(),
                        formatter: visualMapFormatter
                    },
                    tooltip: {
                        formatter: tooltipFormatter
                    },
                    series: [{
                        data: res.data.data,
                        label: {
                            formatter: labelFormatter
                        }
                    }]
                });
            }
        }
    };
    const char2 = {
        init() {
            const c = window.echarts.init($('#chart2')[0]);
            const s = (r, i) => {
                if (!i) {
                    c.clear();
                    c.setOption({
                        grid: {
                            left: 50,
                            top: 0,
                            right: 0,
                            bottom: 100
                        },
                        xAxis: {
                            type: "category",
                            data: r.data.date,
                            axisTick: {
                                show: !1
                            },
                            axisLine: {
                                show: !1
                            },
                            axisLabel: {
                                lineHeight: 16
                            }
                        },
                        yAxis: {
                            type: "category",
                            data: r.data.hour,
                            axisTick: {
                                show: !1
                            },
                            axisLine: {
                                show: !1
                            },
                            axisLabel: {
                                formatter: function(e) {
                                    return e < 10 ? "0".concat(e, ":00") : "".concat(e, ":00")
                                }
                            }
                        },
                        visualMap: {
                            bottom: 0,
                            left: "center",
                            align: "top",
                            orient: "horizontal",
                            min: 0,
                            max: 1000,
                            pieces: [{
                                    min: 0,
                                    max: 0.29,
                                    color: '#C2D9FB'
                                },
                                {
                                    min: 0.3,
                                    max: 0.49,
                                    color: '#CBFDC2'
                                },
                                {
                                    min: 0.5,
                                    max: 0.79,
                                    color: '#F7EEAC'
                                }, {
                                    min: 0.8,
                                    max: 0.99,
                                    color: '#F0AF9C'
                                }, {
                                    min: 1,
                                    max: 1.99,
                                    color: '#EA6461'
                                },
                                {
                                    min: 2,
                                    max: 100,
                                    color: '#822925'
                                }
                            ],
                            textStyle: {
                                color: '#ffffff'
                            },
                            formatter: function(value) {
                                if (value < 0.3) {
                                    return '< 0.3';
                                }

                                if (value < 0.5) {
                                    return '< 0.5';
                                }

                                if (value < 0.8) {
                                    return '< 0.8';
                                }

                                if (value < 1) {
                                    return '< 1';
                                }

                                if (value < 2) {
                                    return '< 2';
                                }

                                return '>= 2';
                            }
                        },
                        tooltip: {
                            show: !0,
                            formatter: function(e) {
                                const date = e.value[0];
                                const hour = e.value[1];
                                const price = e.value[2];
                                return `<div><b>${date} ${hour}:00</b>  gas = ${price}$</div>`
                            }
                        },
                        series: [{
                            type: "heatmap",
                            data: r.data.data,
                            label: {
                                show: !0,
                                color: "#1F2533"
                            },
                            itemStyle: {
                                borderColor: "#FFFFFF",
                                borderWidth: 1
                            },
                            animation: !r
                        }]
                    });
                    // 获取最后一条数据
                    const last = r.data.data[r.data.data.length - 1];
                    $('.latest_price').eq(0).text(last[2]);
                } else {
                    c.setOption({
                        series: [{
                            data: r.data.data
                        }]
                    });
                }
            };
            const get = v => {
                $.ajax({
                    url: 'price.php?method=two',
                    type: 'GET',
                    dataType: 'json',
                    success: r => {
                        if (r.code !== 1) {
                            return layer.msg(r.msg, {
                                icon: r.code
                            });
                        }

                        s(r, v);
                    },
                    error: (r) => layer.alert(r.responseText, {
                        icon: 2
                    })
                });
            };
            get(0);
            $(window).resize(() => c.resize());
        }
    };
    const card = () => {
        const animate = (start, end, dom,floating=2) => {
            const speed = 50;
            const step = (end - start) / speed;
            let num = start;
            const timer = setInterval(() => {
                num += step;
                if (num >= end) {
                    num = end;
                    clearInterval(timer);
                }
                num = Number(num);
                dom.text(num.toFixed(floating));
            }, 10);
        };
        const get = () => {
            $.ajax({
                url: 'price.php?method=card',
                type: 'GET',
                dataType: 'json',
                success: r => {
                    if (r.code !== 1) {
                        return layer.msg(r.msg, {
                            icon: r.code
                        });
                    }

                    if (r.data.min_shangpin4 !== '0.000') {
                        animate(0, r.data.min_shangpin4, $('.card').eq(0).find('.price span').eq(0),2);
                    } else {
                        $('.card').eq(0).find('.price span').eq(0).text('0.00');
                    }
                    
                    if (r.data.min_gwei !== '0') {
                        animate(0, r.data.min_gwei, $('.card').eq(0).find('.desc span').eq(0),0);
                    } else {
                        $('.card').eq(0).find('.desc span').eq(0).text('0');
                    }

                    if (r.data.min_zhuanzhang !== '0.000') {
                        animate(0, r.data.min_zhuanzhang, $('.card').eq(1).find('.price span'),4);
                    } else {
                        $('.card').eq(1).find('.price span').text('0.000');
                    }
                    
                    // gwei 1
                    if (r.data.min_gwei !== '0') {
                        animate(0, r.data.min_zhuanzhang/r.data.min_shangpin4 * r.data.min_gwei, $('.card').eq(1).find('.desc span').eq(0),1);
                    } else {
                        $('.card').eq(1).find('.desc span').eq(0).text('0');
                    }

                    // 商品6
                    if (r.data.min_zhuanzhang !== '0.000') {
                        animate(0, r.data.min_zhuanzhang, $('.card').eq(2).find('.price span'),4);
                    } else {
                        $('.card').eq(2).find('.price span').text('0.000');
                    }
                    
                    if (r.data.min_gwei !== '0') {
                        animate(0, r.data.min_zhuanzhang/r.data.min_shangpin4 * r.data.min_gwei, $('.card').eq(2).find('.desc span').eq(0),1);
                    } else {
                        $('.card').eq(2).find('.desc span').eq(0).text('0');
                    }

                    if (r.data.min_shangpin4 === '0.00') {
                        $('.card').eq(3).find('.price span').text('0.00');
                    } else {
                        const ratio = (r.data.min_zhuanzhang / r.data.min_shangpin4 * 100).toFixed(2);
                        animate(0, ratio, $('.card').eq(3).find('.price span'));
                    }
                    
                    

                    $('.speed').animate({
                        height: '100%'
                    }, 10000, () => {
                        $('.speed').height(0);
                        get();
                    });
                },
                error: (r) => layer.alert(r.responseText, {
                    icon: 2
                })
            });
        };
        get();
    };
    char1.init();

    window.layui.form.on('select(utc)', () => {
        char1.get('update');
        line.get();
    });

    window.layui.form.on('radio', () => {
        char1.get('update');
    });
    char2.init();

    card();

    const line = {
        init() {
            const chart = window.echarts.init($('#line')[0]);

            this.chart = chart;
            this.get();
            $(window).resize(() => chart.resize());
        },

        get(type = 'init') {
            $.ajax({
                url: 'price.php?method=line',
                type: 'GET',
                dataType: 'json',
                data: {
                    utc: $('[name="utc"]').val()
                },
                success: res => {
                    if (res.code !== 1) {
                        return layer.msg(res.msg, {
                            icon: res.code
                        });
                    }

                    this.set(res, type);
                },
                error: (res) => layer.alert(res.responseText, {
                    icon: 2
                })
            });
        },

        set(res, type) {
            if (type === 'init') {
                this.chart.clear();
                this.chart.setOption({
                    'color': ['#FF8F1E', '#5485FD', '#00AB82', '#0077D1', '#F0B90B', '#FFEB3B', '#9DA6B9'],
                    title: {
                        text: '30 Day Historical Data',
                        textStyle: {
                            color: '#ffffff',
                            fontSize: 20,
                            fontWeight: 'normal'
                        },
                        left: 'center',
                        top: 0
                    },
                    'grid': {
                        'top': 50,
                        'left': 2,
                        'right': 2,
                        'bottom': 60,
                        'containLabel': true
                    },
                    'legend': {
                        'bottom': 0,
                        'padding': 0,
                        'icon': 'circle',
                        'itemGap': 16,
                        'itemWidth': 8,
                        'itemHeight': 8,
                        'itemStyle': {
                            'borderWidth': 0
                        },
                        selected: {  
                            'Gwei': false, 
                        },
                        'textStyle': {
                            'fontSize': 14,
                            'lineHeight': 16,
                            'color': '#ffffff'
                        },
                        'type': 'scroll'
                    },
                    'tooltip': {
                        'trigger': 'axis',
                        'extraCssText': 'z-index:1;border-radius:4px;',
                        'backgroundColor': 'rgba(255, 255, 255, 0.98)',
                        'confine': true,
                        'axisPointer': {
                            'snap': true
                        },
                        'borderRadius': 8,
                        'shadowColor': 'rgba(0,0,0,0)',
                        'shadowBlur': 0,
                        'borderColor': 'rgba(0,0,0,0)',
                        formatter: function(e) {
                            // 如果开启两个就显示对比 否则就显示数据
                            if (e.length === 1) {
                                const date = e[0].axisValue;
                                const data1 = e[0].data;
                                return `<div><b>${date}</b></div>
                                <div>${e[0].marker}${e[0].seriesName}：${data1.toFixed(2)}$</div>`;

                            } else {
                                const date = e[0].axisValue;
                                const data1 = e[0].data;
                                const data2 = e[1].data;
                                const seriesName = e[1].seriesName;
                                const gwei = ()=>{
                                    if(e.length === 3){
                                        return `<div>${e[2].marker}gwei：${e[2].data.toFixed(0)}</div>`;
                                    }
                                    
                                    return '';
                                };
                                
                                if(seriesName =='Ethereum'){
                                    let contrast = '0.00';
                                    if (data2 !== 0) {
                                        contrast = (data1 / data2 * 100).toFixed(2);
                                    }

                                    return `
                                    <div><b>${date}</b></div>
                                    <div>${e[0].marker}Starknet：${data1.toFixed(2)}$</div>
                                    <div>${e[1].marker}Ethereum：${data2.toFixed(2)}$</div>
                                    ${gwei()}
                                    <div>Compare：${contrast}%</div>`;
                                }
                                
                                return `
                                    <div><b>${date}</b></div>
                                    <div>${e[0].marker}Starknet：${data1.toFixed(2)}$</div>
                                    <div>${e[1].marker}Ethereum：${e[1].data.toFixed(0)}$</div>`;
                            }
                        }
                    },
                    'xAxis': {
                        'type': 'category',
                        'boundaryGap': false,
                        'data': res.data.date,
                        'axisLine': {
                            'lineStyle': {
                                'color': '#E9EBF2'
                            }
                        },
                        'axisLabel': {
                            'color': '#999999',
                            'rich': {
                                'time': {
                                    'align': 'center',
                                    'fontSize': 10
                                }
                            }
                        }
                    },
                    'yAxis': {
                        'type': 'value',
                        'splitNumber': 4,
                        'splitLine': {
                            'lineStyle': {
                                'type': 'dashed',
                                'color': '#171442'
                            }
                        },
                        'axisLabel': {
                            'color': '#999999',
                            'rich': {
                                'time': {
                                    'align': 'center',
                                    'fontSize': 10
                                }
                            }
                        }
                    },
                    'series': [{
                            'name': 'Starknet',
                            'type': 'line',
                            'symbol': 'none',
                            'data': res.data.data.map(item => {
                                return item[0];
                            }),
                            'color': '#5ECA4E',
                            'areaStyle': {
                                'color': {
                                    'type': 'linear',
                                    'x': 0,
                                    'y': 0,
                                    'x2': 0,
                                    'y2': 1,
                                    'colorStops': [{
                                        'offset': 0,
                                        'color': 'rgba(88, 59, 255, 0.1)'
                                    }, {
                                        'offset': 1,
                                        'color': 'rgba(88, 59, 255, 0)'
                                    }]
                                }
                            },
                            'itemStyle': {
                                'normal': {
                                    'lineStyle': {
                                        'width': 1
                                    }
                                }
                            }
                        },
                        {
                            'name': 'Ethereum',
                            'type': 'line',
                            'symbol': 'none',
                            'data': res.data.data.map(item => {
                                return item[1];
                            }),
                            'color': '#FFC327',
                            'areaStyle': {
                                'color': {
                                    'type': 'linear',
                                    'x': 0,
                                    'y': 0,
                                    'x2': 0,
                                    'y2': 1,
                                    'colorStops': [{
                                        'offset': 0,
                                        'color': 'rgba(255, 195, 39, 0.1)'
                                    }, {
                                        'offset': 1,
                                        'color': 'rgba(255, 195, 39, 0)'
                                    }]
                                }
                            },
                            'itemStyle': {
                                'normal': {
                                    'lineStyle': {
                                        'width': 1
                                    }
                                }
                            }
                        },
                        {
                            'name': 'Gwei',
                            'type': 'line',
                            'symbol': 'none',
                            'data': res.data.data.map(item => {
                                return item[2];
                            }),
                            'color': '#EA6461',
                            'areaStyle': {
                                'color': {
                                    'type': 'linear',
                                    'x': 0,
                                    'y': 0,
                                    'x2': 0,
                                    'y2': 1,
                                    'colorStops': [{
                                        'offset': 0,
                                        'color': 'rgba(255, 195, 39, 0.1)'
                                    }, {
                                        'offset': 1,
                                        'color': 'rgba(255, 195, 39, 0)'
                                    }]
                                }
                            },
                            'itemStyle': {
                                'normal': {
                                    'lineStyle': {
                                        'width': 1
                                    }
                                }
                            }
                        }
                    ],
                    'animation': true,
                    'dataZoom': {
                        'type': 'slider',
                        'filterMode': 'empty',
                        'start': 0,
                        'end': 100,
                        'bottom': 28,
                        'right': 4,
                        'left': 40,
                        'height': 24,
                        'borderColor': 'rgba(0,0,0,0)',
                        'backgroundColor': 'rgba(0,0,0,0)',
                        'fillerColor': 'rgba(67,44,202,0.1)',
                        'showDetail': false,
                        'handleSize': 24,
                        'handleStyle': {
                            'color': 'rgba(255,255,255,0.3)',
                            'borderWidth': 1,
                            'borderColor': '#2D60E0'
                        },
                        'moveHandleSize': 0
                    }
                });
                $(window).resize(() => this.chart.resize());
            } else {
                this.chart.setOption({
                    xAxis: {
                        data: res.data.date
                    },
                    series: [{
                            data: res.data.data.map(item => {
                                return item[0];
                            })
                        },
                        {
                            data: res.data.data.map(item => {
                                return item[1];
                            })
                        },
                        {
                            data: res.data.data.map(item => {
                                return item[2];
                            })
                        }
                    ]
                });
            }
        }
    };

    line.init();
</script>

</html>