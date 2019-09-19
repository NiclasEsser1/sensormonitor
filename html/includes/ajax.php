<?php
//____ AJAX-Request ____

require_once 'autoload.php';

// $action = "dashboardform";
$action = $_GET['action'];
switch($action){
    case 'dashboardform':
        /*
         * get users input from HTML-Form
         * @param object: $userIn
         */

        $userIn = new UserInput($_POST);
        $param 	= $userIn->getParam();
        $node 	= $userIn->getNode();
        $start 	= $userIn->getStartdate();
        $end 	= $userIn->getEnddate();
        // $result_array = array($param, $node, $start, $end);
        // echo json_encode($result_array);
        /*
         * calculate the data from database,
         * which the user wants to visualize
         * @param object: $dbh
         */

        try {
            $dbh = new Database(new PDO(Config::DB_DSN, Config::DB_USER, Config::DB_PASSWORD));
        }catch (PDOException $e) {
        	exit($e->getMessage());
        }
        $parsearray  = new ParseArray();

        $chartdata   = $dbh->getChartData($node, $start, $end);
        $chartdata   = $parsearray->minimizeArray($chartdata, 50, $param);
        $maxmindata  = $dbh->getMaxMin($node, $start, $end);
        $currentdata = $dbh->getCurrentData($node);
        $avgdata	 = $dbh->getAvgDay($node);

        // print_r($currentdata);
        // print_r($avgdata);

        $start = strtotime($start);
        $end = strtotime($end);
        $result = $end - $start;
        if($result < 3600){
            $dateformat = 'H:i:s';
        }
        elseif($result < 86400){
            $dateformat = 'H:i';
        }
        elseif($result < 86400){
            $dateformat = 'H:i';
        }
        elseif($result < 1209600){
            $dateformat = 'H:i-d.M';
        }
        elseif($result < 30000000){
            $dateformat = 'H:i-d.M';
        }
        $k=0;
        foreach ($chartdata['datetime'] as $date ){
            $date = new DateTime($date);
            $chartdata['datetime'][$k] = date_format($date, $dateformat);
            $k++;
        }

        /*
         * store every data-array in one JSON
         */

        $result_array = array(
        	'current_data' 	=> $currentdata,
        	'maxmin_data' 	=> $maxmindata,
        	'chart_data' 	=> $chartdata,
        	'avg_data' 		=> $avgdata
        );

        echo json_encode($result_array);
        break;
}
