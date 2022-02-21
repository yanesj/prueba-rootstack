<?php
session_start();
include('../params/params.php');
if(!isset($_SESSION['user_authorized'])) header("Location: loginAdmin.php");
?>
<!DOCTYPE html>
<html lang="en">
  <?php
    require_once '../src/head.php';
  ?>
  <body>
    <?php
      require_once '../src/nav.php';
    ?>
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid">
            <h1 class="mt-4">Ver Anuncios</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">Ver Anuncios</li>
            </ol>
            <!-- Listado de categorías -->
            <div class="card mb-4">
              <div class="card-header">
                <i class="fas fa-user-cog"></i>
                Listado de Categorías
              </div>
              <div class="card-body">
                <div class="table-responsive" id="datosPOS">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                    <tbody id="contentTable">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- Listado de subcategorías -->
            <div class="card mb-4">
              <div class="card-header">
                <i class="fas fa-user-cog"></i>
                Listado de Anuncios por Categoría
              </div>
              <div class="card-body">
                <div class="table-responsive" id="datosPOS2">
                  <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                      </tr>
                    </tfoot>
                    <tbody id="contentTable2">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

        </div>
        </main>
        <?php
          require_once '../src/footer.php';
        ?>
      </div>
    </div>
    <?php
      require_once '../src/scripts.php';
    ?>
    <script type="text/javascript">


      //Funcion para obtener las categorías
      function getCategories(){
         recargarTabla2();
         $.ajax({
          type: "get",
          url: '../functions/getCategories.php',
          beforeSend: function()
          {
          },
          success: function (msg) 
          {
            r=JSON.parse(msg);
            $.each(r, function(item){
              var link ='';
              link = r[item].searchlink.split('/');
              link= "'"+link[1]+"'";
            $("#contentTable").append('<tr><td>'+r[item].id_categoria+'</td><td>'+r[item].descripcion+'</td><td><a style="color:blue;cursor:pointer" onclick="getAnuncios('+link+')">Ver Anuncios</a></td></tr>');
            });
            jQuery('#dataTable').DataTable({
              rowReorder: {
                selector: 'td:nth-child(2)'
              },

              responsive: true,
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
              },
              "paging": true,
              "processing": true,
              'serverMethod': 'post',
              //"ajax": "data.php",
              dom: 'lBfrtip',
              buttons: [
                'excel', 'csv', 'pdf', 'print', 'copy',
              ],
              "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
              "aaSorting":[[0,"desc"]]
            });
          }
        });
      }
      //Fin funcion para obtener las categorías


       //Funcion para obtener las categorías
      function getAnuncios(id){
         if(confirm('¿Está seguro que desea ver los anuncios de esta categoría?')){
          recargarTabla();
            $.ajax({
          type: "get",
          url: '../functions/getClasificados.php?id='+id,
          beforeSend: function()
          {
          },
          success: function (msg) 
          {
            r=JSON.parse(msg);
            $.each(r, function(item){
            $("#contentTable2").append('<tr><td>'+r[item].titulo+'</td><td>'+r[item].descripcion+'</td></tr>');
            });
            jQuery('#dataTable2').DataTable({
              rowReorder: {
                selector: 'td:nth-child(2)'
              },

              responsive: true,
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
              },
              "paging": true,
              "processing": true,
              'serverMethod': 'post',
              //"ajax": "data.php",
              dom: 'lBfrtip',
              buttons: [
                'excel', 'csv', 'pdf', 'print', 'copy',
              ],
              "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
              "aaSorting":[[0,"desc"]]
            });
          }
        });
         }
      }
      //Fin funcion para obtener las categorías

      //Funcion para recargar grilla
      function recargarTabla(){
        $("#datosPOS2").empty();
        $("#datosPOS2").append('<table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0"><thead><tr><th>Título</th><th>Descripción</th></tr></thead><tfoot><tr><th>Título</th><th>Descripción</th></tr></tfoot><tbody id="contentTable2"></tbody></table>');
      }
      //Fin funcion para recargar grilla

      function recargarTabla2(){
        $("#datosPOS").empty();
        $("#datosPOS").append('<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"><thead><tr><th>ID</th><th>Categoría</th><th>Acciones</th></tr></thead><tfoot><tr><th>ID</th><th>Categoría</th><th>Acciones</th></tr></tfoot><tbody id="contentTable"></tbody></table>');
      }

      //Funcion para poblar la tabla haciendo web scraping.
      function webScrap(){
        if (confirm("¿Esta seguro que desea poblar la base de datos?")) {
          
          $.ajax({
            url: '../functions/llenarBD.php',
            type: 'post',
            beforeSend: function()
            {
              // setting a timeout
            },
            success: function(msg) {
             alert(msg);         
             
            }
          });
        }
      }
      //Fin función para poblar la tabla haciendo webscraping

   

      $(document).ready(function(){
        getCategories();


      });
    </script>
  </body>
</html>