<?php   
$conexion=mysqli_connect('localhost','root','','gilbertm_prueba');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="../logo.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />  
    <title>PRODUCCION</title>    
    <style>
        .excel {
            position: absolute !important;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">


    <!-- FA ICONS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" 
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        .terminado {
            background-color: #00E700;
        }
        .por-terminar{
            background-color: #fcba03;
        }
        .pendiente {
            background-color: #FF0000;
        }
        .proceso {
            background-color: #FFFF00;
        }
        .todo{
            background-color: white;
        }
        .page-item.active .page-link {
            background-color: #f8f9fa !important;
            border: 1px solid black;
            color: black !important;
        }
        .page-link {
            background-color: #212529 !important;
            color: white !important;
        }

        .dataTables_length select {
            background-color: #212529;
        }
        .dataTables_filter input {
            background-color: #212529;
        }
    </style>
</head>  
<body class="bg-dark text-light"> 
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Grupo <span class="text-danger">G</span>ilbert&#174;</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto flex-nowrap">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../areas.php">MENÚ ÁREAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../index.php">MENÚ MÓDULOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../../logout.php">CERRAR SESIÓN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header align="center">
        <h4 class="text-light">P R O D U C C I Ó N</h4>
        <div class="row d-flex justify-content-center">
            <div class="col-md-3">
                <h5 class="text-light"><kbd class="bg-light text-dark">OTA:</kbd> 3299-E2</h5>
            </div>
            <div class="col-md-3">
                <h5 class="text-light"><kbd class="bg-light text-dark">PROYECTO:</kbd> MÓDULO E2</h5>
            </div>
        </div>      
    </header>
    <hr>      
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-60 bg-transparent border-warning">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">PESO TOTAL</div>
                                <?php
                                $sql="SELECT FORMAT(SUM(peso_unitario),2) from tabla WHERE ota LIKE '%E2%' AND cancelados is null";
                                $result=mysqli_query($conexion,$sql);
                                while($mostrar=mysqli_fetch_array($result)){
                                    ?>
                                    <div class="h5 mb-0 font-weight-bold text-light"><?php echo $mostrar['FORMAT(SUM(peso_unitario),2)'] ?> Kg.</div>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-weight fa-3x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-60 bg-transparent border-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">PESO TOTAL LIBERADO</div>
                                <?php
                                $sql2="SELECT IFNULL(FORMAT(SUM(peso_unitario),2),0) AS peso_liberado from tabla WHERE status_produccion = 'TERMINADO' AND ota LIKE '%E2%' AND cancelados is null";          
                                $result2=mysqli_query($conexion,$sql2);
                                while($mostrar2=mysqli_fetch_array($result2)){
                                    ?>
                                    <div class="h5 mb-0 font-weight-bold text-light"><?php echo $mostrar2['peso_liberado'] ?> Kg.</div>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck-loading fa-3x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-60 bg-transparent border-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">PORCENTAJE</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <?php                                
                                        $sql3="SELECT IFNULL(FORMAT(SUM(peso_unitario)/(SELECT SUM(peso_unitario) FROM tabla WHERE ota LIKE '%E2%' AND cancelados is null)*100,2),0) AS PORCENTAJE FROM tabla WHERE ota LIKE '%E2%' AND status_produccion = 'TERMINADO' AND cancelados is null";                                    
                                        $result3=mysqli_query($conexion,$sql3);
                                        while($mostrar3=mysqli_fetch_array($result3)){
                                            ?>
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-light"><?php echo $mostrar3['PORCENTAJE'] ?>%</div>
                                        <?php } ?>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <?php 
                                            $sql3="SELECT IFNULL(FORMAT(SUM(peso_unitario)/(SELECT SUM(peso_unitario) FROM tabla WHERE ota LIKE '%E2%' AND cancelados is null)*100,2),0) AS PORCENTAJE FROM tabla WHERE ota LIKE '%E2%' AND status_produccion = 'TERMINADO' AND cancelados is null";                                    
                                            $result3=mysqli_query($conexion,$sql3);
                                            while($mostrar3=mysqli_fetch_array($result3)){
                                                ?>
                                                <div class="progress-bar bg-info" role="progressbar" style="width:<?php echo $mostrar3['PORCENTAJE'] ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percentage fa-3x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark">            
        <center>
            <p id="table-filter">
                Filtrar: 
                <select id="color_me" class="btn btn-dark">
                    <option class="btn btn-dark" value="">TODO</option>                                
                    <option class="btn terminado" value="TERMINADO">TERMINADO</option>            
                    <option class="btn por-terminar" value="MATERIALES">MATERIALES</option>             
                    <option class="btn proceso" value="PROCESO">PROCESO</option>  
                    <option class="btn pendiente text-white" value="PENDIENTE">PENDIENTE</option>      
                </select>
            </p>
        </center>
        <div class="table-responsive">
            <table id="tablaUsuarios" class="table table-dark table-sm table-borderless table-striped" style="width:100%">
                <thead class="thead-dark text-center">
                    <tr>
                        <th class="table-dark">#</th>
                        <th class="table-dark">TALLER</th>
                        <th class="table-dark">REV</th>
                        <th class="table-dark">MARCA</th>
                        <th class="table-dark">TIPO</th>
                        <th class="table-dark">CAN</th>
                        <th class="table-dark">NOMBRE</th>
                        <th class="table-dark">P.U.</th>                                
                        <th class="table-dark">CONTRATISTA</th>
                        <th class="table-dark">FECHA</th>
                        <th class="table-dark">STATUS</th>                        
                        <th class="table-dark">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="text-center">                           
                </tbody>
                <tfoot>
                    <tr>              
                        <td></td> 
                        <td></td>                         
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>   
        </div>
    </div> 
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formUsuarios">    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label d-flex justify-content-center">ID:</label>
                                    <input type="text" class="form-control text-center" id="id_tabla" disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">TALLER:</label>
                                    <input type="text" class="form-control" id="taller" disabled="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">REVISIÓN:</label>
                                    <input type="text" class="form-control" id="revision" disabled="">
                                </div> 
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">MARCA:</label>
                                    <input type="text" class="form-control" id="marca" disabled="">                    
                                </div>               
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">CANTIDAD:</label>
                                    <input type="text" class="form-control" id="cantidad" disabled="">
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">NOMBRE:</label>
                                    <input type="text" class="form-control" id="nombre" disabled="">
                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">PESO UNITARIO:</label>
                                    <input type="text" class="form-control" id="peso_unitario" disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="">TIPO:</label>
                                    <select name="" id="folio" class="form-control" required="">
                                        <option selected>Selecciona opción</option>        
                                        <?php 
                                        $sql4="SELECT * FROM tipo";                                    
                                        $result4=mysqli_query($conexion,$sql4);
                                        while($mostrar4=mysqli_fetch_array($result4)){
                                            ?>
                                            <option value="<?php echo $mostrar4['tipo'] ?>"><?php echo $mostrar4['precio'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="">CONTRATISTA:</label>
                                    <select name="" id="contratista" class="form-control" required="">
                                        <option selected>Selecciona opción</option>            
                                        <?php 
                                        $sql5="SELECT * FROM contratista";                                    
                                        $result5=mysqli_query($conexion,$sql5);
                                        while($mostrar5=mysqli_fetch_array($result5)){
                                            ?>
                                            <option value="<?php echo $mostrar5['nombre'] ?>"><?php echo $mostrar5['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label">FECHA DE ENTREGA:</label>
                                    <input type="date" class="form-control" id="fecha_produccion">
                                </div>
                            </div>  
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>  


    <!-- scripts para botones de exportar datos 
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>    
    -->
    <script type="text/javascript" src="main.js"></script>
</body>
</html>
