<?php

function _average_unit_to_order_point($var_orderpoint, $var_avgunit, $daysformin) {
    $result_array_avg_unit = array();
    if (($daysformin * $var_avgunit) <= $var_orderpoint) {
        $result_array_avg_unit['ISSUECOUNT'] = 0;
        $result_array_avg_unit['TEXT'] = 'No Issues';
    } else {
        $result_array_avg_unit['ISSUECOUNT'] = 1;
        $result_array_avg_unit['TEXT'] = 'Order point not sufficient for ship quantity average';
    }

    return $result_array_avg_unit;
}

function _daily_unit_to_order_point($var_orderpoint, $var_avgunit, $var_leadtime) {
    $result_array_daily_unit = array();
    if (($var_leadtime * $var_avgunit) <= $var_orderpoint) {
        $result_array_daily_unit['ISSUECOUNT'] = 0;
        $result_array_daily_unit['TEXT'] = 'No Issues';
    } else {
        $result_array_daily_unit['ISSUECOUNT'] = 1;
        $result_array_daily_unit['TEXT'] = 'Order point not sufficient for daily unit average';
    }

    return $result_array_daily_unit;
}

function _rollmonthyyddd() {
    $date = strtotime(date('Y-m-d H:i:s') . ' -30 days');

    $startyear = date('y', $date);
    $startday = date('z', $date) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval($startyear . $startday);
    return $datej;
}

function _rollmonthyyyymmdd() {
    $date = strtotime(date('Y-m-d H:i:s') . ' -30 days');
    $date2 = date("Ymd", $date);

    return $date2;
}

function _rollqtryyyymmdd() {
    $date = strtotime(date('Y-m-d H:i:s') . ' -90 days');
    $date2 = date("Ymd", $date);

    return $date2;
}

function _roll12yyyymmdd() {
    $date = strtotime(date('Y-m-d H:i:s') . ' -365 days');
    $date2 = date("Ymd", $date);

    return $date2;
}

function _currentquarteryyddd() {

    $current_month = date('m');
    if ($current_month <= 3) {
        $current_quarter_start = 1;
    } elseif ($current_month <= 6) {
        $current_quarter_start = 4;
    } elseif ($current_month <= 9) {
        $current_quarter_start = 7;
    } else {
        $current_quarter_start = 10;
    }


    $current_quarter_start_fiscal = date("Y-m-d", mktime(0, 0, 0, $current_quarter_start, 1, date('Y')));



    $startyear = date('y', strtotime($current_quarter_start_fiscal));
    $startday = date('z', strtotime($current_quarter_start_fiscal)) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval($startyear . $startday);
    return $datej;
}

function _rollquarteryyddd() {

    $date = strtotime(date('Y-m-d H:i:s') . ' -90 days');


    $startyear = date('y', $date);
    $startday = date('z', $date) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval($startyear . $startday);
    return $datej;
}

function _rolling12startyyddd() {
    $current_month = date('m');
    $prev_year = date("Y", strtotime("-1 year"));
    $rolling_12_start_fiscal = date("Y-m-d", mktime(0, 0, 0, $current_month, 1, $prev_year));


    $startyear = date('y', strtotime($rolling_12_start_fiscal));
    $startday = date('z', strtotime($rolling_12_start_fiscal)) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval($startyear . $startday);
    return $datej;
}

function _rollmonth1yyddd() {
    $date = strtotime(date('Y-m-d H:i:s') . ' -30 days');

    $startyear = date('y', $date);
    $startday = date('z', $date) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval('1' . $startyear . $startday);
    return $datej;
}

function _rollquarter1yyddd() {
    $date = strtotime(date('Y-m-d H:i:s') . ' -90 days');


    $startyear = date('y', $date);
    $startday = date('z', $date) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval('1' . $startyear . $startday);
    return $datej;
}

function _rolling12start1yyddd() {
    $current_month = date('m');
    $prev_year = date("Y", strtotime("-1 year"));
    $rolling_12_start_fiscal = date("Y-m-d", mktime(0, 0, 0, $current_month, 1, $prev_year));


    $startyear = date('y', strtotime($rolling_12_start_fiscal));
    $startday = date('z', strtotime($rolling_12_start_fiscal)) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval('1' . $startyear . $startday);
    return $datej;
}

function _yyyydddtogregdate($yyyyddd) {
    $year = substr($yyyyddd, 0, 4);
    $day = substr($yyyyddd, 4);
    
   
    
    $returndate = date("m/d/Y",   mktime(0, 0, 0, 1, $day, $year));
    return $returndate;
 
}

function _gregdateto1yyddd($convertdate) {
    $startyear = date('y', strtotime($convertdate));
    $startday = date('z', strtotime($convertdate)) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval('1' . $startyear . $startday);
    return $datej;
}

function _rolling12startfiscal() {
    $current_month = date('m');
    $prev_year = date("Y", strtotime("-1 year"));
    $rolling_12_start_fiscal = date("Ym", mktime(0, 0, 0, $current_month, 1, $prev_year));

    return $rolling_12_start_fiscal;
}

function _currentmonthfiscal() {

    $current_month_start_fiscal = date("Ym", mktime(0, 0, 0, date('m'), 1, date('Y')));

    return $current_month_start_fiscal;
}



function _1yydddtogregdate($date) {
    $a1 = substr($date, 3, 3);
    $a2 = substr($date, 1, 2);
    $converteddate = date("m/d/Y", mktime(0, 0, 0, 1, $a1, $a2));

    return $converteddate;
}

function _jdatetomysqldate($jdate) {
    $year = "20" . substr($jdate, 0, 2);
    $days = substr($jdate, 2, 3);

    $ts = mktime(0, 0, 0, 1, $days, $year);
    $mydate = date('Y-m-d', $ts);
    return $mydate;
}