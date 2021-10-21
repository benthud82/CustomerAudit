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



    $returndate = date("m/d/Y", mktime(0, 0, 0, 1, $day, $year));
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

function _gregdatetoyyddd($convertdate) {
    $startyear = date('y', strtotime($convertdate));
    $startday = date('z', strtotime($convertdate)) + 1;
    if ($startday < 10) {
        $startday = '00' . $startday;
    } else if ($startday < 100) {
        $startday = '0' . $startday;
    }
    $datej = intval($startyear . $startday);
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

function _atrisk($inv_onhand, $inv_boq) {
    //determine if item is stlil at risk of fill rate issues
    //
    //opt1: Is item still on BO with 0 on hand?
    if ($inv_boq > 0 && $inv_onhand < $inv_boq) {
        $opt_atrisk = 1;
        return $opt_atrisk;
    }

    //opt2: nothing oh nothing on bo
    if ($inv_boq == 0 && $inv_onhand <= 0) {
        $opt_atrisk = 2;
        return $opt_atrisk;
    }

    //opt3: onhand is greater than boq, but quantity is still on boq. Should be cleared very soon
    if ($inv_boq > 0 && $inv_onhand > $inv_boq) {
        $opt_atrisk = 3;
        return $opt_atrisk;
    }

    //opt99: Item is not at risk going forward
    if ($inv_boq == 0 && $inv_onhand > 0) {
        $opt_atrisk = 0;
        return $opt_atrisk;
    }

    $opt_atrisk = 0;
    return $opt_atrisk;
}

function _atrisk_desc($atrisk_scenario, $AVG_DAILY_PICKS, $date_expected, $date_latest, $today, $PODATE) {
//    $atrisk_array = array();
    $holidays = array();
    switch ($atrisk_scenario) {
        case 1: //still on BO with 0 onhand
            //POStatus
            if ($today >= $date_latest) {
                $resolutiondays_latest = getWorkingDays($today, $date_latest, $holidays);
                $atrisk = 'At Risk | PO is late or delayed';
                $hits_exp = $AVG_DAILY_PICKS;
                $desc = 'Item is currently taking additional customer backorders.';
                $desc2 = '<strong>' . $hits_exp . '</strong> expected fill rate hits per day till received.';
            } else {
                $resolutiondays_exp = getWorkingDays($today, $date_expected, $holidays);
                $resolutiondays_latest = getWorkingDays($today, $date_latest, $holidays);
                $atrisk = 'At Risk';
                $hits_exp = $AVG_DAILY_PICKS;
                $desc = 'Item is currently taking additional customer backorders.';
                $desc2 = '<strong>' . $hits_exp . '</strong> expected fill rate hits per day till received.';
            }

            $hits_max = $resolutiondays_latest * $AVG_DAILY_PICKS;
            $backgroundcolor = '#fce3e7';
            $table_class = 'table-red';
            break;
        case 2: //0 onhand, 0 on BO
            $desc = 'Item has 0 units available, but currently not taking backorders.';
            $atrisk = 'At Risk';
            $resolutiondays_exp = getWorkingDays($today, $date_expected, $holidays);
            $resolutiondays_latest = getWorkingDays($today, $date_latest, $holidays);
            $hits_exp = $resolutiondays_exp * $AVG_DAILY_PICKS;
            $hits_max = $resolutiondays_latest * $AVG_DAILY_PICKS;
            $desc2 = '';
            $backgroundcolor = '#fce3e7';
            $table_class = 'table-red';
            break;
        case 3: //onhand is greater than boq, but quantity is still on boq. Should be cleared very soon
            $desc = 'Item is available.  Backorder quantity should be released soon.';
            $atrisk = 'Not At Risk';
            $desc2 = '';
            $hits_exp = 0;
            $hits_max = 0;
            $backgroundcolor = 'white';
            $table_class = ' ';
            break;
        case 99: //item is not at risk
            $desc = 'No longer on customer BO.';
            $atrisk = 'Not At Risk';
            $desc2 = '';
            $hits_exp = 0;
            $hits_max = 0;
            $backgroundcolor = 'white';
            $table_class = ' ';
            break;
        case 0: //did not meet a scenario (default)
            $desc = 'No longer on customer BO.';
            $atrisk = 'Not At Risk';
            $desc2 = '';
            $hits_exp = 0;
            $hits_max = 0;
            $backgroundcolor = 'white';
            $table_class = ' ';
            break;

        default:
            $desc = 'No longer on customer BO.';
            $atrisk = 'Not At Risk';
            $desc2 = '';
            $hits_exp = 0;
            $hits_max = 0;
            $backgroundcolor = 'white';
            $table_class = ' ';
            break;
    }

    //set progress bar color
    if ($date_expected <> 'N/A' && $date_latest <> 'N/A' && $PODATE <> 'N/A') {
        //percent days progress to latest date
        $date_PO_conv = DateTime::createFromFormat('Y-m-d H:i:s', ($PODATE));
        $date_latest_conv = DateTime::createFromFormat('Y-m-d', ($date_latest));
        $today_conv = DateTime::createFromFormat('Y-m-d', ($today));

        $should_days = intval($date_PO_conv->diff($date_latest_conv)->format('%r%a'));
        $daysremain = intval($today_conv->diff($date_latest_conv)->format('%r%a'));
        $perc_remain = intval((1 - ($daysremain / $should_days) ) * 100);
        if ($daysremain < 0) {
            $perc_remain = 100;
        }

        if ($today <= $date_expected) {
            $color_prgbar = 'bg-success';
        } elseif ($today <= $date_latest) {
            $color_prgbar = 'bg-warning';
        } else {
            $color_prgbar = 'bg-danger';
        }
    } else {
        $color_prgbar = ' ';
        $perc_remain = 0;
    }

    $atrisk_array = array($atrisk, $desc, $hits_exp, $hits_max, $color_prgbar, $perc_remain, $backgroundcolor, $table_class, $desc2);
    return $atrisk_array;
}

function linear_regression($x, $y) {
// calculate number points
    $n = count($x);
// ensure both arrays of points are the same size
    if ($n != count($y)) {
        trigger_error("linear_regression(): Number of elements in coordinate arrays do not match.", E_USER_ERROR);
    }
// calculate sums
    $x_sum = array_sum($x);
    $y_sum = array_sum($y);

    $xx_sum = 0;
    $xy_sum = 0;

    for ($i = 0; $i < $n; $i++) {

        $xy_sum += ($x[$i] * $y[$i]);
        $xx_sum += ($x[$i] * $x[$i]);
    }
    if ((($n * $xx_sum) - ($x_sum * $x_sum)) == 0) {
        return array("m" => 0, "b" => 0);
    } else {

// calculate slope
        $m = (($n * $xy_sum) - ($x_sum * $y_sum)) / (($n * $xx_sum) - ($x_sum * $x_sum));
// calculate intercept
        $b = ($y_sum - ($m * $x_sum)) / $n;
// return result
        return array("m" => $m, "b" => $b);
    }
}

function _primdc($DC) {
    switch ($DC) {
        case 2:
            $stringdc = 'Indy';
            break;
        case 3:
            $stringdc = 'Sparks';
            break;
        case 6:
            $stringdc = 'Denver';
            break;
        case 7:
            $stringdc = 'Dallas';
            break;
        case 9:
            $stringdc = 'Jax';
            break;
        case 11:
            $stringdc = 'NOTL';
            break;
        case 12:
            $stringdc = 'Vanc';
            break;
        case 16:
            $stringdc = 'Calgary';
            break;

        default:
            $stringdc = 'N/A';
            break;
    }
    return $stringdc;
}

//The function returns the no. of business days between two dates and it skips the holidays
function getWorkingDays($startDate, $endDate, $holidays) {

    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week)
            $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week)
            $no_remaining_days--;
    } else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)
        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        } else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
    $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0) {
        $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach ($holidays as $holiday) {
        $time_stamp = strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
            $workingDays--;
    }

    if ($workingDays < 0) {
        $workingDays = .01;
    }
    return $workingDays;


    ////Example:
//
//$holidays=array("2008-12-25","2008-12-26","2009-01-01");
//
//echo getWorkingDays("2008-12-22","2009-01-02",$holidays)
//// => will return 7
//
}

function _datetoyyyymmdd($convertdate) {
    $date = strtotime(date($convertdate));
    $date2 = date("Ymd", $date);

    return $date2;
}

function _YYYYMMDDtomysqldate($convertdate) {
    $year = substr($convertdate, 0, 4);
    $month = substr($convertdate, 4, 2);
    $day = substr($convertdate, 6, 4);

    $mysqldate = date('Y-m-d', strtotime("$year-$month-$day"));
    return $mysqldate;
}
