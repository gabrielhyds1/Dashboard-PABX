
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
    <title>Dashboard Relatorio</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.jpg">

    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
 
    <link rel="stylesheet" href="assets/css/demo.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      * label{
          color:black;
      }

    </style>
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
                    <div class="sidebar-brand">
                        <a href="index.html">Bradial</a>
                    </div>
                    <div class="sidebar-user">
                        <div class="sidebar-user-picture">
                            <!--<img  class="img d-flex align-items-center justify-content-center" src="assets/img/Logo.png" alt="" style="width:120px;height: 90px;margin-left:50px;margin-top:35px">
                                  LOGO BRADIAL-->
                        </div>
                        <div class="sidebar-user-details">
                            <div class="user-name">MUDAR</div>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Opções</li>
                        <li class="active">
                            <a href="#" class="has-dropdown"><i class="ion ion-ios-cart"></i><span>Dashboard</span></a>
                            <ul class="menu-dropdown" >
                                <li><a href="cardapio.php"><i class="ion ion-pizza"></i>Filtros</a></li>
                                <li class="active"><a href="listarCad.php"><i class="ion ion-ios-eye"></i>Consultar Relatorio</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="has-dropdown"><i class="ion ion-medkit"></i><span>Mudar</span></a>
                            <ul class="menu-dropdown">
                                <li><a href="inserir.php" class="active"><i class="ion ion-bag"></i>Mudar</a></li>
                                <li><a href="listarGastos.php"><i class="ion ion-ios-eye"></i>Mudar</a></li>
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