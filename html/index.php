<?php
session_start();

require_once("config.php");
require_once("sesvars.php");

$start_today = date('Y-m-d 00:00:00');
$end_today = date('Y-m-d 23:59:59');

$start_today_ts = return_timestamp($start_today);

$day = date('w', $start_today_ts);
$diff_to_monday = $start_today_ts - (($day - 1) * 86400);

$begin_week_monday = date('Y-m-d 00:00:00', $diff_to_monday);
$end_week_sunday = date('Y-m-d 23:59:59', ($diff_to_monday + (6 * 86400)));

$end_year = date('Y');

$begin_month = date('Y-m-01 00:00:00');
$begin_month_ts = return_timestamp($begin_month);
$end_month_ts = $begin_month_ts + (86400 * 32);

$end_past_month_ts = $begin_month_ts - 1;
$end_past_month = date('Y-m-d 23:59:59', $end_past_month_ts);
$begin_past_month = date('Y-m-01 00:00:00', $end_past_month_ts);

$begin_past_month_ts = return_timestamp($begin_past_month);
$end_past2_month_ts = $begin_past_month_ts - 1;
$end_past2_month = date('Y-m-d 23:59:59', $end_past2_month_ts);
$begin_past2_month = date('Y-m-01 00:00:00', $end_past2_month_ts);

for ($a = 4; $a > 0; $a--) {
    $day_number = date('d', $end_month_ts);
    if ($day_number == 1) {
        $a == 0;
    } else {
        $end_month_ts -= 86400;
    }
}
$end_month_ts -= 86400;

$end_month = date('Y-m-d', $end_month_ts);

$query = "SELECT queue FROM qname ORDER BY queue";
$res = $midb->consulta($query);
while ($row = $midb->fetch_row($res)) {
    $colas[] = $row[0];
}

$query = "SELECT agent FROM qagent ORDER BY agent";
$res = $midb->consulta($query);
while ($row = $midb->fetch_row($res)) {
    $agentes[] = $row[0];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/demo.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="js/validmonth.js" type="text/javascript" language="javascript1.2"></script>
    <script>
        function envia() {
            let month_start = parseInt(document.forms[0].month1.value) + 1;
            let month_end = parseInt(document.forms[0].month2.value) + 1;

            let fecha_s = document.forms[0].year1.value + '-';
            if (String(month_start).length == 1) {
                fecha_s += "0";
            }
            fecha_s += month_start + '-';
            if (String(document.forms[0].day1.value).length == 1) {
                fecha_s += "0";
            }
            fecha_s += document.forms[0].day1.value + ' ';
            fecha_s += '00:00:00';

            let fecha_check_s = document.forms[0].year1.value;
            if (String(month_start).length == 1) {
                fecha_check_s += "0";
            }
            fecha_check_s += month_start;
            if (String(document.forms[0].day1.value).length == 1) {
                fecha_check_s += "0";
            }
            fecha_check_s += document.forms[0].day1.value;

            let fecha_check_e = document.forms[0].year2.value;
            if (String(month_end).length == 1) {
                fecha_check_e += "0";
            }
            fecha_check_e += month_end;
            if (String(document.forms[0].day2.value).length == 1) {
                fecha_check_e += "0";
            }
            fecha_check_e += document.forms[0].day2.value;

            let fecha_e = document.forms[0].year2.value + '-';
            if (String(month_end).length == 1) {
                fecha_e += "0";
            }
            fecha_e += month_end + '-';
            if (String(document.forms[0].day2.value).length == 1) {
                fecha_e += "0";
            }
            fecha_e += document.forms[0].day2.value + ' ';
            fecha_e += '23:59:59';

            document.forms[0].start.value = fecha_s;
            document.forms[0].end.value = fecha_e;

            if (fecha_check_e < fecha_check_s) {
                alert("<?php echo $lang["$language"]['invaliddate']?>");
            } else {
                document.forms[0].submit();
            }
            return false;
        }

        function setdates(start, end) {
            var start_year = start.substr(0, 4);
            var start_month = start.substr(5, 2);
            var start_day = start.substr(8, 2);

            var end_year = end.substr(0, 4);
            var end_month = end.substr(5, 2);
            var end_day = end.substr(8, 2);

            dstart = MWJ_findSelect("day1"), mstart = MWJ_findSelect("month1"), ystart = MWJ_findSelect("year1");
            dend = MWJ_findSelect("day2"), mend = MWJ_findSelect("month2"), yend = MWJ_findSelect("year2");

            while (dstart.options.length) { dstart.options[0] = null; }
            while (dend.options.length) { dend.options[0] = null; }

            for (var x = 0; x < 31; x++) { dstart.options[x] = new Option(x + 1, x + 1); }
            for (var x = 0; x < 31; x++) { dend.options[x] = new Option(x + 1, x + 1); }

            x = start_day - 1;
            y = end_day - 1;
            dstart.options[x].selected = true;
            dend.options[y].selected = true;

            x = start_month - 1;
            y = end_month - 1;
            mstart.options[x].selected = true;
            mend.options[y].selected = true;

            for (var x = 0; x < ystart.options.length; x++) {
                if (ystart.options[x].value == '' + start_year + '') {
                    ystart.options[x].selected = true;
                    if (window.opera && document.importNode) {
                        window.setTimeout('MWJ_findSelect( \'' + ystart.name + '\' ).options[' + x + '].selected = true;', 0);
                    }
                }
            }
            for (var x = 0; x < yend.options.length; x++) {
                if (yend.options[x].value == '' + end_year + '') {
                    yend.options[x].selected = true;
                    if (window.opera && document.importNode) {
                        window.setTimeout('MWJ_findSelect( \'' + yend.name + '\' ).options[' + x + '].selected = true;', 0);
                    }
                }
            }
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Selecione uma data para gerar o relatório:</h2>
        <hr>
        <h4>Utilize esses filtros se desejar</h4>
        <div class="mb-3">
            <?php
            echo "<a href=\"javascript:setdates('$start_today', '$end_today')\" class=\"btn btn-primary\">" . $lang["$language"]['today'] . "</a> ";
            echo "<a href=\"javascript:setdates('$begin_week_monday', '$end_week_sunday')\" class=\"btn btn-secondary\">" . $lang["$language"]['this_week'] . "</a> ";
            echo "<a href=\"javascript:setdates('$begin_month', '$end_month')\" class=\"btn btn-success\">" . $lang["$language"]['this_month'] . "</a> ";
            echo "<a href=\"javascript:setdates('$begin_past2_month', '$end_month')\" class=\"btn btn-info\">" . $lang["$language"]['last_three_months'] . "</a>";
            ?>
        </div>
        <form method="POST" action="answered.php" onsubmit="return envia();">
            <input type="hidden" name="start">
            <input type="hidden" name="end">

            <!-- Campos ocultos para filas e agentes -->
            <?php
            foreach ($colas as $queueel) {
                if ($queueel <> "NONE") {
                    echo "<input type='hidden' name='List_Queue[]' value=\"$queueel\" selected>\n";
                }
            }
            foreach ($agentes as $agentel) {
                if ($agentel <> "NONE") {
                    echo "<input type='hidden' name='List_Agent[]' value=\"$agentel\" selected>\n";
                }
            }
            ?>

            <div class="row">
                <div class="col-md-6">
                    <h4><?php echo $lang["$language"]['start'] ?></h4>
                    <div class="form-group">
                        <select name="day1" class="form-control">
                            <?php
                            for ($a = 1; $a < 32; $a++) {
                                echo "<option value='$a' ";
                                if ($fstart_day == $a) {
                                    echo " selected ";
                                }
                                echo ">$a</option>\n";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="month1" class="form-control" onchange="dateChange('day1','month1','year1');">
                            <?php
                            for ($a = 0; $a < 12; $a++) {
                                $amonth = $a + 1;
                                echo "<option value='$a' ";
                                if ($fstart_month == $amonth) {
                                    echo "selected ";
                                }
                                echo ">$yearp[$a]</option>\n";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="year1" class="form-control" onchange="checkMore(this, <?php echo $start_year; ?>, <?php echo $end_year; ?>, <?php echo $super_start_year; ?>, <?php echo $super_end_year; ?>); dateChange('day1','month1','year1');">
                            <option value="MWJ_DOWN"><?php echo $lang["$language"]['lower'] ?></option>
                            <?php
                            for ($a = $start_year; $a <= $end_year; $a++) {
                                echo "<option value='$a' ";
                                if ($fstart_year == $a) {
                                    echo "selected ";
                                }
                                echo ">$a</option>\n";
                            }
                            ?>
                            <option value="MWJ_UP"><?php echo $lang["$language"]['higher'] ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4><?php echo $lang["$language"]['end'] ?></h4>
                    <div class="form-group">
                        <select name="day2" class="form-control">
                            <?php
                            for ($a = 1; $a < 32; $a++) {
                                echo "<option value='$a' ";
                                if ($fend_day == $a) {
                                    echo " selected ";
                                }
                                echo ">$a</option>\n";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="month2" class="form-control" onchange="dateChange('day2','month2','year2');">
                            <?php
                            for ($a = 0; $a < 12; $a++) {
                                $amonth = $a + 1;
                                echo "<option value='$a' ";
                                if ($fend_month == $amonth) {
                                    echo "selected ";
                                }
                                echo ">$yearp[$a]</option>\n";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="year2" class="form-control" onchange="checkMore(this, <?php echo $start_year; ?>, <?php echo $end_year; ?>, <?php echo $super_start_year; ?>, <?php echo $super_end_year; ?>); dateChange('day2','month2','year2');">
                            <option value="MWJ_DOWN"><?php echo $lang["$language"]['lower'] ?></option>
                            <?php
                            for ($a = $start_year; $a <= $end_year; $a++) {
                                echo "<option value='$a' ";
                                if ($fend_year == $a) {
                                    echo "selected ";
                                }
                                echo ">$a</option>\n";
                            }
                            ?>
                            <option value="MWJ_UP"><?php echo $lang["$language"]['higher'] ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $lang["$language"]['display_report'] ?></button>
        </form>
    </div>

    <script src="assets/modules/jquery.min.js"></script>
    <script src="assets/modules/popper.js"></script>
    <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="assets/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
    <script src="assets/js/sa-functions.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
