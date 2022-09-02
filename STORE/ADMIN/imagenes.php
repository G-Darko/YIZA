<?php 
    require('require/conexion.php');
    require 'require/session_start.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagenes | YIZA</title>
<?php require('require/nav_admin.php') ?>

                <div class="caja">
                    <div class="container">
                        <div class="header">
                            <h2>
                                <ion-icon name="list-outline"></ion-icon>   
                                Productos 
                            </h2>
                                <div class="plus" title="Agregar" onclick="showModal('modal-NProd')">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                        </div>
                        <?php
                            $folder_path = 'img/marcas/'; //image's folder path

                            $num_files = glob($folder_path . "*.{JPG,jpg,gif,png,jpeg}", GLOB_BRACE);

                            $folder = opendir($folder_path);
                             
                            if($num_files > 0)
                            {
                             while(false !== ($file = readdir($folder))) 
                             {
                              $file_path = $folder_path.$file;
                              $extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
                              if($extension=='jpg' || $extension =='png' || $extension == 'gif' || $extension == 'jpeg') 
                              {
                               ?>     
                                     
                                        <a href="<?php echo $file_path;?>">
                                            <img src="<?php echo $file_path; ?>" width="150px" style="background: var(--azulH);">
                                        </a>
                                        <input id="path" type="hidden" value="<?php echo $file_path;?>">
                                        <button onclick="elimnar()">Eliminar</button>
                             
                                    
                                        <?php
                              }
                             }
                            }
                            else
                            {
                             echo "the folder was empty !";
                            }
                            closedir($folder);
                            ?>

                    </div>
                   <!--  <div class="paginador">
                        <ul>
                    <?php 
                        if ($page != 1) {
                    ?>
                            <li><a href="?page=1">|<</a></li>
                            <li><a href="?page=<?php echo $page-1;?>"><<</a></li>
                    <?php 
                        }
                                for ($i=1; $i <= $tPags; $i++) { 
                                    if ($i == $page) {
                                        echo '<li class="pageSelect">'.$i.'</li>';
                                    }else{
                                        echo '<li><a href="?page='.$i.'">'.$i.'</a></li>';
                                    }
                                }
                        if ($page != $tPags && $tPags > 0) {
                    ?>
                            <li><a href="?page=<?php echo $page+1;?>">>></a></li>
                            <li><a href="?page=<?php echo $tPags;?>">>|</a></li>
                    <?php 
                        }
                    ?>
                        </ul>
                    </div> -->
                </div>

            <?php 
                require 'require/footer.php'; 
            ?>
            </div>
        </div>
    </div>

</script>   
    <?php require('require/scriptsJS.php') ?>}
    <script>
      function elimnar() {
        let fd = new FormData();
          fd.append('path', document.getElementById('path').value);
          let request = new XMLHttpRequest();
          request.open('POST', 'api/img/img.php', true);
          request.onload=function(){
            if (request.readyState==4 && request.status==200) {
              let response=JSON.parse(request.responseText);
              console.log(request);
              if (response.state) {
                (async () =>{
                  await Swal.fire({
                    icon: 'success',
                    title: 'Agregado',
                    text: 'La categoria se agregó correctamente',
                    background: mainC,
                    color: negro1
                  });
                  window.location.reload();

                })();
              }else{
                //alert(response.detail);
                //Swal.fire(response.detail);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: (response.detail),
                    background: mainC,
                    color: negro1
                  });
              }
            }
          }
          request.send(fd);
      }
    </script>
</body>
</html>


