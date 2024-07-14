<?php
session_start();
require_once("config.php");
include("sesvars.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['start'] = $_POST['start'];
    $_SESSION['end'] = $_POST['end'];
    $_SESSION['List_Queue'] = $_POST['List_Queue'];
    $_SESSION['List_Agent'] = $_POST['List_Agent'];
}

// Verifica se as variáveis de sessão estão definidas e usa-as
$start = isset($_SESSION['start']) ? $_SESSION['start'] : null;
$end = isset($_SESSION['end']) ? $_SESSION['end'] : null;
$queues = isset($_SESSION['List_Queue']) ? $_SESSION['List_Queue'] : [];
$agents = isset($_SESSION['List_Agent']) ? $_SESSION['List_Agent'] : [];

// Transform the arrays into comma-separated strings
$queue = implode(',', array_map(function($q) { return "'$q'"; }, $queues));
$agent = implode(',', array_map(function($a) { return "'$a'"; }, $agents));

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta charset="character_set">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
    <title>Relatorios	</title>
    
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/demo.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    

	<script type="text/javascript" src="js/prototype-1.4.0.js"></script>




    <script src="js/validmonth.js" type="text/javascript" language="javascript1.2"></script>
    <script src="js/sorttable.js"></script>
  <script src="js/Chart.min.js"></script>

    <style>
      * label{
          color:black;
      }
      .main-sidebar{
        color:#33697B;
        background-color:#33697B;
      }
     .navbar, .navbar-bg{
     	color:#33697B;
        background-color:#33697B;
     }
     i , span {
        color:#fff;
     }
     .navbar.active{
	color:#33697B;
        background-color:#33697B;
     }
     </style>
<?php

// This query shows the hangup cause, how many calls an
// agent hanged up, and a caller hanged up.
$query = "SELECT count(ev.event) AS num, ev.event AS action ";
$query.= "FROM queue_stats AS qs, qname AS q, qevent AS ev WHERE ";
$query.= "qs.qname = q.qname_id and qs.qevent = ev.event_id and qs.datetime >= '%s' and ";
$query.= "qs.datetime <= '%s' and q.queue IN ($queue) AND ";
$query.= "ev.event IN ('COMPLETECALLER', 'COMPLETEAGENT') ";
$query.= "GROUP BY ev.event ORDER BY ev.event";

$hangup_cause["COMPLETECALLER"]=0;
$hangup_cause["COMPLETEAGENT"]=0;
$res = $midb->consulta($query, array($start, $end));
while($row=$midb->fetch_row($res)) {
  $hangup_cause["$row[1]"]=$row[0];
  $total_hangup+=$row[0];
}

$query = "SELECT qs.datetime AS datetime, q.queue AS qname, ag.agent AS qagent, "; 
$query.= "ac.event AS qevent, qs.info1 AS info1, qs.info2 AS info2,  qs.info3 AS info3 ";
$query.= "FROM queue_stats AS qs, qname AS q, qagent AS ag, qevent AS ac WHERE ";
$query.= "qs.qname = q.qname_id AND qs.qagent = ag.agent_id AND qs.qevent = ac.event_id AND ";
$query.= "qs.datetime >= '%s' AND qs.datetime <= '%s' AND ";
$query.= "q.queue IN ($queue) AND ag.agent in ($agent) AND ac.event IN ('COMPLETECALLER', 'COMPLETEAGENT','TRANSFER','CONNECT') ORDER BY qs.datetime";

$answer["15"]=0;
$answer["30"]=0;
$answer["45"]=0;
$answer["60"]=0;
$answer["75"]=0;
$answer["90"]=0;
$answer["91+"]=0;

$abandoned         = 0;
$transferidas      = 0;
$totaltransfers    = 0;
$total_hangup      = 0;
$total_calls       = 0;
$total_calls2      = Array();
$total_duration    = 0;
$total_calls_queue = Array();

$res = $midb->consulta($query, array($start, $end));
if($res) {
    while($row=$midb->fetch_row($res)) {
        if($row[3] <> "TRANSFER" && $row[3]<>"CONNECT") {
            $total_hold     += $row[4];
            $total_duration += $row[5];
            $total_calls++;
            $total_calls_queue["$row[1]"]++;
        } elseif($row[3]=="TRANSFER") {
            $transferidas++;
        }
        if($row[3]=="CONNECT") {

            if ($row[4] >=0 && $row[4] <= 15) {
                $answer["15"]++;
            }

            if ($row[4] >=16 && $row[4] <= 30) {
                $answer["30"]++;
            }

            if ($row[4] >=31 && $row[4] <= 45) {
              $answer["45"]++;
            }

            if ($row[4] >=46 && $row[4] <= 60) {
              $answer["60"]++;
            }

            if ($row[4] >=61 && $row[4] <= 75) {
              $answer["75"]++;
            }

            if ($row[4] >=76 && $row[4] <= 90) {
              $answer["90"]++;
            }

            if ($row[4] >=91) {
              $answer["91+"]++;
            }
        }
    }
} 

if($total_calls > 0) {
    ksort($answer);
    $average_hold     = $total_hold     / $total_calls;
    $average_duration = $total_duration / $total_calls;
    $average_hold     = number_format($average_hold     , 2);
    $average_duration = number_format($average_duration , 2);
} else {
    // There were no calls
    $average_hold = 0;
    $average_duration = 0;
}

$total_duration_print = seconds2minutes($total_duration);
// TRANSFERS
$query = "SELECT ag.agent AS agent, qs.info1 AS info1,  qs.info2 AS info2 ";
$query.= "FROM  queue_stats AS qs, qevent AS ac, qagent as ag, qname As q WHERE qs.qevent = ac.event_id ";
$query.= "AND qs.qname = q.qname_id AND ag.agent_id = qs.qagent AND qs.datetime >= '%s' ";
$query.= "AND qs.datetime <= '%s' AND  q.queue IN ($queue)  AND ag.agent in ($agent) AND  ac.event = 'TRANSFER'";

$res = $midb->consulta($query, array($start, $end));
if($res) {
    while($row=$midb->fetch_row($res)) {
        $keytra = "$row[0]^$row[1]@$row[2]";
        $transfers["$keytra"]++;
        $totaltransfers++;
    }
} else {
   $totaltransfers=0;
}

// ABANDONED CALLS
$query = "SELECT  ac.event AS action,  qs.info1 AS info1,  qs.info2 AS info2,  qs.info3 AS info3 ";
$query.= "FROM  queue_stats AS qs, qevent AS ac, qname As q, qagent as ag WHERE ";
$query.= "qs.qevent = ac.event_id AND qs.qname = q.qname_id AND qs.datetime >= '%s' AND ";
$query.= "qs.datetime <= '%s' AND  q.queue IN ($queue)  AND ag.agent in ($agent) AND  ac.event IN ('ABANDON', 'EXITWITHTIMEOUT', 'TRANSFER') ";
$query.= "ORDER BY  ac.event,  qs.info3";

$res = $midb->consulta($query, array($start, $end));

while($row=$midb->fetch_row($res)) {

    if($row[0]=="ABANDON") {
        $abandoned++;
        $abandon_end_pos+=$row[1];
        $abandon_start_pos+=$row[2];
        $total_hold_abandon+=$row[3];
    }
    if($row[0]=="EXITWITHTIMEOUT") {
        $timeout++;
        $timeout_end_pos+=$row[1];
        $timeout_start_pos+=$row[2];
        $total_hold_timeout+=$row[3];
    }
}

if($abandoned > 0) {
    $abandon_average_hold = $total_hold_abandon / $abandoned;
    $abandon_average_hold = number_format($abandon_average_hold,2);

    $abandon_average_start = floor($abandon_start_pos / $abandoned);
    $abandon_average_start = number_format($abandon_average_start,2);

    $abandon_average_end = floor($abandon_end_pos / $abandoned);
    $abandon_average_end = number_format($abandon_average_end,2);
} else {
    $abandoned = 0;
    $abandon_average_hold  = 0;
    $abandon_average_start = 0;
    $abandon_average_end   = 0;
}

// This query shows every call for agents, we collect into a named array the values of holdtime and calltime
$query = "SELECT qs.datetime AS datetime, q.queue AS qname, ag.agent AS qagent, ac.event AS qevent, ";
$query.= "qs.info1 AS info1, qs.info2 AS info2, qs.info3 AS info3  FROM queue_stats AS qs, qname AS q, ";
$query.= "qagent AS ag, qevent AS ac WHERE qs.qname = q.qname_id AND qs.qagent = ag.agent_id AND ";
$query.= "qs.qevent = ac.event_id AND qs.datetime >= '%s' AND qs.datetime <= '%s' AND ";
$query.= "q.queue IN ($queue) AND ag.agent in ($agent) AND ac.event IN ('COMPLETECALLER', 'COMPLETEAGENT') ORDER BY ag.agent";

$res = $midb->consulta($query, array($start, $end));
while($row=$midb->fetch_row($res)) {
    $total_calls2["$row[2]"]++;
    $record["$row[2]"][]=$row[0]."|".$row[1]."|".$row[3]."|".$row[4];
    $total_hold2["$row[2]"]+=$row[4];
    $total_time2["$row[2]"]+=$row[5];
    $grandtotal_hold+=$row[4];
    $grandtotal_time+=$row[5];
    $grandtotal_calls++;
}

$start_parts = preg_split("/ /", $start);
$end_parts   = preg_split("/ /", $end);

$cover_pdf = $lang["$language"]['queue'].": ".$queue."\n";
$cover_pdf.= $lang["$language"]['start'].": ".$start_parts[0]."\n";
$cover_pdf.= $lang["$language"]['end'].": ".$end_parts[0]."\n";
$cover_pdf.= $lang["$language"]['period'].": ".$period." ".$lang["$language"]['days']."\n\n";
$cover_pdf.= $lang["$language"]['answered_calls'].": ".$total_calls." ".$lang["$language"]['calls']."\n";
$cover_pdf.= $lang["$language"]['avg_calltime'].": ".$average_duration." ".$lang["$language"]['secs']."\n";
$cover_pdf.= $lang["$language"]['total'].": ".$total_duration_print." ".$lang["$language"]['minutes']."\n";
$cover_pdf.= $lang["$language"]['avg_holdtime'].": ".$average_hold." ".$lang["$language"]['secs']."\n";

?>

</head>
<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="ion ion-navicon-round"></i></a></li>
                    </ul>
                </form>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-user">
                        <div class="sidebar">
                            <img  class="img d-flex align-items-center justify-content-center" src="assets/img/bradial.png" alt="" style="width:200px;height: 40px;margin-top:10px;">
                        </div>
                        <div class="sidebar-user-details">
                            <div class="user-name"></div>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header" style="color:#fff;">Menu</li>
                        <li >
                            <a href="answered.php"><i class="ion ion-android-call"></i><span>Chamadas Atendidas<span></a>
                        </li>
                         <li >
                            <a href="answered.php"><i class="ion ion"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7" width="18px" heigth="20px">
  <path fill-rule="evenodd" d="M15.22 3.22a.75.75 0 0 1 1.06 0L18 4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06L19.06 6l1.72 1.72a.75.75 0 0 1-1.06 1.06L18 7.06l-1.72 1.72a.75.75 0 1 1-1.06-1.06L16.94 6l-1.72-1.72a.75.75 0 0 1 0-1.06ZM1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
</svg>
</i><span>Chamadas Perdidas<span></a>
                        </li>
			<li>
                            <a href="distribution.php"><i class="ion ion"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7" width="18px" heigth="20px">
  <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.04 16.5.5-1.5h6.42l.5 1.5H8.29Zm7.46-12a.75.75 0 0 0-1.5 0v6a.75.75 0 0 0 1.5 0v-6Zm-3 2.25a.75.75 0 0 0-1.5 0v3.75a.75.75 0 0 0 1.5 0V9Zm-3 2.25a.75.75 0 0 0-1.5 0v1.5a.75.75 0 0 0 1.5 0v-1.5Z" clip-rule="evenodd" />
</svg>
</i><span>Estatisticas Diarias</span></a>
                        </li>
                        <li >
                            <a href="realtime.php"><i class="ion ion"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7" width="18px" heigth="20px">
  <path d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875Z" />
  <path d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 0 0 1.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 0 0 1.897 1.384C6.809 12.164 9.315 12.75 12 12.75Z" />
  <path d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 15.914 9.315 16.5 12 16.5Z" />
  <path d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 19.664 9.315 20.25 12 20.25Z" />
</svg>
</i><span>Dados em tempo real<span></a>
                        </li>
			<li >
                            <a href="index.php"><i class="ion ion-android-arrow-back"></i><span>Voltar<span></a>
                        </li>

            </aside>
            </div>
            <div class="main-content">
                <section class="section">
                  <h1 class="section-header">
                        <div>Chamadas Atendidas</div>
                  </h1>
                  <div>
           </div>
            
            <div class="row mt-4">
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card card-sm-4">
                  <div class="card-icon bg-primary">
                    <i class="icon ion-android-call"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Atendidas</h4>
                    </div>
                    <div class="card-body">
                    <?php echo $total_calls; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card card-sm-4">
                  <div class="card-icon bg-warning">
                    <i class="icon ion-ios-fastforward-outline"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Transferidas</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $transferidas; ?>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card card-sm-4">
                  <div class="card-icon bg-success">
                    <i class="icon ion-android-calendar"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Periodo</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $period." ".$lang["$language"]['days']?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-12">
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Seleciona o tipo para listar</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Chamadas atendidas por agentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Nivel de Servico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Chamadas atendidas por fila</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Causa da desconecxao</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <!-- LISTAR CHAMADAS POR AGENTES -->
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Acompanhe as metricas da sua equipe.</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Agente</th>
                                                    <th>Chamadas</th>
                                                    <th>Tempo Total</th>
                                                    <th>Tempo Médio</th>
                                                </tr>
                                                <?php
                                                $countrow = 0;
                                                $partial_total = 0;
                                                $query1 = "";
                                                $query2 = "";
                                                $data_pdf = array();
                                                if ($total_calls2 > 0) {
                                                    foreach ($total_calls2 as $agent => $val) {
                                                        $contavar = $countrow + 1;
                                                        $query1 .= "val$contavar=" . $total_time2["$agent"] . "&var$contavar=$agent&";
                                                        $query2 .= "val$contavar=" . $val . "&var$contavar=$agent&";
                                                        $time_print = seconds2minutes($total_time2["$agent"]);
                                                        $avg_time = $total_time2["$agent"] / $val;
                                                        $avg_time = round($avg_time, 2);
                                                        $avg_print = seconds2minutes($avg_time);
                                                        echo "<tr>";
                                                        echo "<td>$agent</td>";
                                                        echo "<td>$val</td>";
                                                        echo "<td>$time_print</td>";
                                                        echo "<td>$avg_print</td>";
                                                        echo "</tr>";
                                                        $linea_pdf = array($agent, $val, $total_time2["$agent"], $avg_time);
                                                        $data_pdf[] = $linea_pdf;
                                                        $countrow++;
                                                    }
                                                    $query1 .= "title=" . $lang["$language"]['total_time_agent'];
                                                    $query2 .= "title=" . $lang["$language"]['no_calls_agent'];
                                                }
                                                ?>
                                            </table>
                                            <?php 
                                            if($total_calls2>0) {
                                                print_exports($header_pdf, $data_pdf, $width_pdf, $title_pdf, $cover_pdf);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>

                    <!-- NÍVEL DE SERVIÇO -->
                    <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Nivel de Servico</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr> 
                                                        <th><?php echo $lang["$language"]['answer']?></th>
                                                        <th><?php echo $lang["$language"]['count']?></th>
                                                        <th><?php echo $lang["$language"]['delta']?></th>
                                                        <th><?php echo $lang["$language"]['percent']?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $countrow = 0;
                                                    $partial_total = 0;
                                                    $query2 = "";
                                                    $total_y_transfer = $answer['15'] + $answer['30'] + $answer['45'] + $answer['60'] + $answer['75'] + $answer['90'] + $answer['91+'];

                                                    foreach ($answer as $key => $val) {
                                                        $newcont = $countrow + 1;
                                                        $query2 .= "val$newcont=$val&var$newcont=$key%20" . $lang["$language"]['secs'] . "&";
                                                        $cual = ($countrow % 2);
                                                        if ($cual > 0) {
                                                            $odd = " class='odd' ";
                                                        } else {
                                                            $odd = "";
                                                        }
                                                        echo "<tr $odd>\n";
                                                        echo "<td>" . $lang["$language"]['within'] . "$key " . $lang["$language"]['secs'] . "</td>\n";
                                                        $delta = $val;
                                                        if ($delta > 0) {
                                                            $delta = "+" . $delta;
                                                        }
                                                        $partial_total += $val;
                                                        if ($total_y_transfer > 0) {
                                                            $percent = $partial_total * 100 / $total_y_transfer;
                                                        } else {
                                                            $percent = 0;
                                                        }
                                                        $percent = number_format($percent, 2);
                                                        if ($countrow == 0) {
                                                            $delta = "";
                                                        }
                                                        echo "<td>$partial_total " . $lang["$language"]['calls'] . "</td>\n";
                                                        echo "<td>$delta</td>\n";
                                                        echo "<td>$percent " . $lang["$language"]['percent'] . "</td>\n";
                                                        echo "</tr>\n";
                                                        $countrow++;
                                                    }
                                                    $query2 .= "title=" . $lang["$language"]['call_response'];
                                                    ?>
                                                </tbody>
                                            </table>
                                            <td style="width: 50%; vertical-align: top; background-color: #fffdf3;">
                                                <?php
                                                swf_bar($query2, 364, 220, "chart3", 0);
                                                ?>
                                            </td>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CHAMADAS ATENDIDAS POR FILA -->
                   <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Chamadas atendidas por fila</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr> 
                                    <th><?php echo $lang["$language"]['queue']?></th>
                                    <th><?php echo $lang["$language"]['count']?></th>
                                    <th><?php echo $lang["$language"]['percent']?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $countrow = 0;
                                $query2 = "";
                                if (count($total_calls_queue) == 0) {
                                    $total_calls_queue[""] = 0;
                                }
                                asort($total_calls_queue);
                                foreach ($total_calls_queue as $key => $val) {
                                    $cual = $countrow % 2;
                                    $odd = ($cual > 0) ? " class='odd' " : "";
                                    $percent = ($total_calls > 0) ? number_format($val * 100 / $total_calls, 2) : 0;
                                    echo "<tr $odd><td>$key</td><td>$val " . $lang["$language"]['calls'] . "</td><td>$percent %</td></tr>\n";
                                    $countrow++;
                                    $query2 .= "var$countrow=$key&val$countrow=$val&";
                                }
                                $query2 .= "title=" . addslashes($lang[$language]['answered_calls_by_queue']);
                                ?>
                            </tbody>
                        </table>
                        <?php 
                        if ($total_calls_by_queue > 0) {
                            print_exports($header_pdf, $data_pdf, $width_pdf, $title_pdf, $cover_pdf);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
<!-- CAUSA DA DESCONEXÃO -->
<div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Causa da Desconexão</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo $lang["$language"]['cause']; ?></th>
                                    <th><?php echo $lang["$language"]['count']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr> 
                                    <td><?php echo $lang["$language"]['agent_hungup']; ?>:</td>
                                    <td><?php echo $hangup_cause["COMPLETEAGENT"]; ?> <?php echo $lang["$language"]['calls']; ?></td>
                                </tr>
                                <tr> 
                                    <td><?php echo $lang["$language"]['caller_hungup']; ?>:</td>
                                    <td><?php echo $hangup_cause['COMPLETECALLER']; ?> <?php echo $lang["$language"]['calls']; ?></td>
                                </tr>
                                <?php
                                foreach ($disconnect_causes as $cause => $count) {
                                    echo "<tr>";
                                    echo "<td>$cause</td>";
                                    echo "<td>$count</td>";
                                    echo "<td>";
                                    if ($total_hangup > 0) {
                                        $percent = $count * 100 / $total_hangup;
                                    } else {
                                        $percent = 0;
                                    }
                                    $percent = number_format($percent, 2);
                                    echo $percent;
                                    echo " %</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
                </div>
            </div>
        </div>
    </div>
</div>              
          </div>  
        </div>
      </div>

    </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left" style="color:black;">
                    COPYRIGHT &copy; 2022
                    <div class="bullet"></div> Todos os direitos reservados a Gran-Food <div class="bullet"></div> Versão 2.0</a>
                </div>
                <div class="footer-right"></div>
            </footer>
        </div>
    </div>


  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
  <script src="assets/js/sa-functions.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="http://maps.google.com/maps/api/js?key=YOUR_API_KEY&amp;sensor=true"></script>
  <script src="assets/modules/gmaps.js"></script>
  <script src="../Modal/sweetalert2.min.js"></script>
  <script>
    // init map
    var simple_map = new GMaps({
      div: '#simple-map',
      lat: -6.5637928,
      lng: 106.7535061
    })
  </script>
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
  
  <script src="assets/js/cepFunc.js"></script>
  <script src="assets/js/modal.js"></script>

</body>

</html>