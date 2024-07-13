<?php

require_once("config.php");
require_once("sesvars.php");

$start_today = date('Y-m-d 00:00:00');
$end_today = date('Y-m-d 23:59:59');

$start_today_ts = return_timestamp($start_today);

$day = date('w',$start_today_ts);
$diff_to_monday = $start_today_ts - (($day - 1) * 86400);

$begin_week_monday = date('Y-m-d 00:00:00',$diff_to_monday);
$end_week_sunday   = date('Y-m-d 23:59:59',($diff_to_monday + (6 * 86400)));

$end_year = date('Y');

$begin_month = date('Y-m-01 00:00:00');
$begin_month_ts = return_timestamp($begin_month);
$end_month_ts = $begin_month_ts + (86400 * 32);

$end_past_month_ts = $begin_month_ts - 1;
$end_past_month =  date('Y-m-d 23:59:59',$end_past_month_ts);
$begin_past_month = date('Y-m-01 00:00:00',$end_past_month_ts);

$begin_past_month_ts = return_timestamp($begin_past_month);
$end_past2_month_ts = $begin_past_month_ts - 1;
$end_past2_month =  date('Y-m-d 23:59:59',$end_past2_month_ts);
$begin_past2_month = date('Y-m-01 00:00:00',$end_past2_month_ts);

for ($a=4; $a>0; $a--) {
   $day_number = date('d',$end_month_ts);
   if($day_number == 1) {
      $a==0;
   } else {
      $end_month_ts -= 86400;
   }
}
$end_month_ts -= 86400;

$end_month = date('Y-m-d',$end_month_ts);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="character_set">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
    <title>Relatórios</title>

    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
 
    <link rel="stylesheet" href="assets/css/demo.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="js/validmonth.js" type="text/javascript" language="javascript1.2"></script>
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
     i , span{
        color:#fff;
     }

    </style>
 <script type="text/javascript">
_uacct = "UA-93960-1";
urchinTracker();
</script>
	<script language="JavaScript">

	function List_move_around(direction, all, box) {

	    if (direction=="right") {
			if(box=="queues") {
        		box1 = "List_Queue_available";
	        	box2 = "List_Queue[]";
			} else {
    	    	box1 = "List_Agent_available";
	    	    box2 = "List_Agent[]";
			}
    	} else {
			if(box=="queues") {
    	    	box1 = "List_Queue[]";
	    	    box2 = "List_Queue_available" + "";
			} else {
    	    	box1 = "List_Agent[]";
	    	    box2 = "List_Agent_available" + "";
			}
    	}

	    for (var i=0;i<document.forms[0].elements[box1].length;i++) {
    	  	if ((document.forms[0].elements[box1][i].selected || all)) {
        	    document.forms[0].elements[box2].options[document.forms[0].elements[box2].length] =    new Option(document.forms[0].elements[box1].options[i].text, document.forms[0].elements[box1][i].value);
	            document.forms[0].elements[box1][i] = null;
    	        i--;
	        }
    	}
	return false;
	}

	function List_Queue_check_submit() {
       box = "List_Queue[]";
       if (document.forms[0].elements[box]) {
         for (var i=0;i<document.forms[0].elements[box].length;i++) {
            document.forms[0].elements[box][i].selected = true;
         }
       }
       box = "List_Agent[]";
       if (document.forms[0].elements[box]) {
         for (var i=0;i<document.forms[0].elements[box].length;i++) {
            document.forms[0].elements[box][i].selected = true;
         }
       }
      return true;
    }

	function envia() {

		List_Queue_check_submit();

 		box = "List_Queue[]";
       	if (document.forms[0].elements[box].length == 0) {
			alert("Please select at least one queue");
			return false;
		}
 		box = "List_Agent[]";
       	if (document.forms[0].elements[box].length == 0) {
			alert("Please select at least one Agent");
			return false;
		}

		month_start = parseInt(document.forms[0].month1.value) + 1;
		month_end   = parseInt(document.forms[0].month2.value) + 1;

		fecha_s  = document.forms[0].year1.value  + '-';
		if(String(month_start).length == 1) {
			fecha_s += "0";
		} 
        fecha_s += month_start + '-';
		if(String(document.forms[0].day1.value).length == 1) {
			fecha_s += "0";
		}
        fecha_s += document.forms[0].day1.value   + ' ';
		fecha_s += '00:00:00';

		fecha_check_s = document.forms[0].year1.value;
		if(String(month_start).length == 1) {
			fecha_check_s += "0";
		} 
		fecha_check_s += month_start;
		if(String(document.forms[0].day1.value).length == 1) {
			fecha_check_s += "0";
		}
		fecha_check_s += document.forms[0].day1.value;

		fecha_check_e = document.forms[0].year2.value;
		if(String(month_end).length == 1) {
			fecha_check_e += "0";
		} 
		fecha_check_e += month_end;
		if(String(document.forms[0].day2.value).length == 1) {
			fecha_check_e += "0";
		}
		fecha_check_e += document.forms[0].day2.value;

		fecha_e  = document.forms[0].year2.value  + '-';
		if(String(month_end).length == 1) {
			fecha_e += "0";
		} 
        fecha_e += month_end + '-';
		if(String(document.forms[0].day2.value).length == 1) {
			fecha_e += "0";
		}
        fecha_e += document.forms[0].day2.value   + ' ';
		fecha_e += '23:59:59';

		document.forms[0].start.value = fecha_s;
		document.forms[0].end.value   = fecha_e;

		if(fecha_check_e < fecha_check_s) {
			alert("<?php echo $lang["$language"]['invaliddate']?>");
		} else { 
		  document.forms[0].submit();
		}
		return false;
	}

	function setdates(start,end) {
		var start_year  = start.substr(0,4);
		var start_month = start.substr(5,2);
		var start_day   = start.substr(8,2);
	
		var end_year  = end.substr(0,4);
		var end_month = end.substr(5,2);
		var end_day   = end.substr(8,2);

		dstart = MWJ_findSelect( "day1" ), mstart = MWJ_findSelect( "month1" ), ystart = MWJ_findSelect( "year1" );
		dend   = MWJ_findSelect( "day2" ), mend   = MWJ_findSelect( "month2" ), yend   = MWJ_findSelect( "year2" );

		while( dstart.options.length ) { dstart.options[0] = null; }
		while( dend.options.length   ) { dend.options[0]   = null; }

		for( var x = 0; x < 31; x++  ) { dstart.options[x] = new Option( x + 1, x + 1 ); }
		for( var x = 0; x < 31; x++  ) { dend.options[x]   = new Option( x + 1, x + 1 ); }

		x = start_day - 1;
		y = end_day - 1;
	    dstart.options[x].selected = true;
	    dend.options[y].selected = true;
		
		x = start_month - 1;
		y = end_month - 1;
		mstart.options[x].selected = true;
		mend.options[y].selected   = true;

		for( var x = 0; x < ystart.options.length; x++ ) { 
			if( ystart.options[x].value == '' + start_year + '' ) { 
				ystart.options[x].selected = true; 
				if( window.opera && document.importNode ) { 
					window.setTimeout('MWJ_findSelect( \''+ystart.name+'\' ).options['+x+'].selected = true;',0); 
				} 
			} 
		}
		for( var x = 0; x < yend.options.length; x++ ) { 
			if( yend.options[x].value == '' + end_year + '' ) { 
				yend.options[x].selected = true; 
				if( window.opera && document.importNode ) { 
					window.setTimeout('MWJ_findSelect( \''+yend.name+'\' ).options['+x+'].selected = true;',0); 
				} 
			} 
		}

	}
	</script>
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
                            <img  class="img d-flex align-items-center justify-content-center" src="assets/img/bradial.png" alt="" style="width:200px;height: 40px;margin-top:10px;>
                        </div>
                        <div class="sidebar-user-details">
                            <div class="user-name"></div>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Menu</li>
                        <li class="">
                            <a href="#" class="has-dropdown"><i class="ion ion-ios-cart"></i><span>Dashboard</span></a>
                            <ul class="menu-dropdown" >
                                <li><a href="cardapio.php"><i class="ion ion-pizza"></i><span>Filtros</span></a></li>
                                <li class="active"><a href="listarCad.php"><i class="ion ion-ios-eye"></i><span>Consultar Relatorio</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="has-dropdown"><i class="ion ion-medkit"></i><span>Mudar</span></a>
                            <ul class="menu-dropdown">
                                <li><a href="inserir.php" class="active"><i class="ion ion-bag"></i><span>Mudar</span></a></li>
                                <li><a href="listarGastos.php"><i class="ion ion-ios-eye"></i><span>Mudar</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="listarAvaliar.php"><i class="ion ion-star"></i><span>Mudar</span></a>
                        </li>
                        <li >
                            <a href="relatorioVendas.php"><i class="ion ion-clipboard"></i><span>Mudar</span></a>
                        </li>
                        <div class="sidebar-user">
                          <div class="sidebar-user-picture">
                                  <!--<img  class="img d-flex align-items-center justify-content-center" src="assets/img/Logo.png" alt="" style="width:120px;height: 90px;margin-left:50px;margin-top:35px">
                                  LOGO BRADIAL-->
                                </div>
                        </div>
                </aside>
            </div>
            <div class="main-content">
                <section class="section">
                  <h1 class="section-header">
                        <div>Dashboard</div>
                  </h1>
                  <h1 class="section-header">
                    <div id="contents">
                        
                  </h1>
                  <div>
           </div>
            
            <div class="row mt-4">
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card card-sm-4">
                  <div class="card-icon bg-primary">
                    <i class="ion ion-android-bar"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Produtos</h4>
                    </div>
                    <div class="card-body">
                    <?php ?>
                    MUDAR 
                    <?php ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card card-sm-4">
                  <div class="card-icon bg-warning">
                    <i class="ion ion-ios-nutrition"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Categoria</h4>
                    </div>
                    <div class="card-body">
                      MUDAR 2
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card card-sm-4">
                  <div class="card-icon bg-success">
                    <i class="ion ion-cash"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Valor em produtos R$</h4>
                    </div>
                    <div class="card-body">
                        MUDAR 3
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
                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Produto</a>
                      </li>
                      <li class="nav-item ">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Categoria</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">

                        <!-- CADASTRAR PRODUTOS -->
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                      
                
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                <div class="card-header">
                                    <h4>Produtos</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Imagem</th>
                                        <th>Preço</th>
                                        <th>Categoria</th>
                                        <th>Ação</th>
                                        </tr>
                                      
                                            <tr>
                                            <td>NOME</td>
                                            <td>DESC</td>
                                            <td>IMG</td>
                                            <td>TESTE</td>
                                            <td>CATEGORIA</td>
                                            <td> 
                                                <button type="button" name="editar" class="btn btn-success" onclick="window.location.href='editarCad.php?id=<?php echo $row['id']; ?>'">
                                                    <span class="ion-edit"></span> Editar
                                                </button> 
                                                <button type="button" name="excluir" class="btn btn-danger" onclick="window.location.href='../../Model/Funcionario/excluirCad.php?id=<?php echo $row['id']; ?>'">
                                                    <span class="ion-trash-a"></span> Excluir
                                                </button>
                                            </td> 
                                            </tr> 
                                    </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>      
                        
                    </div>

                      <!-- CADASTRAR CATEGORIAS-->
                      <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <div class="row">
                            <div class="col-12">
                                <div class="card ">
                                <div class="card-header">
                                    <h4>Categorias</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Ação</th>
                                        </tr>

                                       <tr>
                                                <td></td>
                                                <td> 
                                                    <button type="button" name="excluir" class="btn btn-danger" onclick="window.location.href='../../Model/Funcionario/excluirCateg.php?id=<?php echo  $row['id']; ?>'">
                                                        <span class="ion-trash-a"></span> Excluir
                                                    </button>
                                                </td> 
                                            </tr>
                                        
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