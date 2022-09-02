<?php require 'ADMIN/require/conexion.php';
    require 'ADMIN/require/_config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesion o Registrate</title>
    <meta name="description" content="Inicia Sesión o Registrate en "<?php echo $comercio;?>>
    <link rel="stylesheet" href="css/style_Sesion.css">
</head>
<body>
    <?php require 'require/topbar.php'; 
        if (isset($_SESSION['id_c'])) {
            header ('Location: ./');
        }
    ?>
            <div onclick="p()">
                <main>
                    <div class="contenedor__todo">

                        <div class="caja__trasera">
                            <div class="caja__trasera-login">
                                <h3>¿Ya tienes una cuenta?</h3>
                                <p>Inicia sesión para realizar compras</p>
                                <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                            </div>

                            <div class="caja__trasera-register">
                                <h3>¿Aún no tienes una cuenta?</h3>
                                <p>Regístrate para que puedas iniciar sesión</p>
                                <button id="btn__registrarse">Regístrarse</button>
                            </div>
                        </div>

                        <div class="login-register">

                            <div class="formulario__login">
                                <h2>Iniciar Sesión</h2>

                                
                                <input type="text" id="IniUser" placeholder="Correo Electronico o Usuario" required>
                                
                                <label class="contra">
                                    <input type="password" id="IniPass" placeholder="Contraseña" required autocomplete="off">
                                </label>
                                <span class="pass">
                                    <span class="iconic btnIniPass" title="Mostrar Contraseña">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </span>
                                </span>

                                <button onclick="iniciar()">Ingresar</button>
                            </div>

                            <div class="formulario__register">
                                <h2>Regístrarse</h2>
                                <input type="text" id="nombres" placeholder="*Nombre(s)" required>
                                <input type="text" id="ap1" placeholder="*Primer Apellido" required>
                                <input type="text" id="ap2" placeholder="Segundo Apellido" required>
                                <input type="text" id="email" placeholder="*Correo Electronico" required>
                                <input type="text"  id="user" placeholder="*Usuario" required>

                                <label class="RegContra">
                                    <input type="password" id="pass" placeholder="*Contraseña" required autocomplete="off">
                                </label>
                                <span class="RegPass">
                                    <span class="iconic btnPass" title="Mostrar Contraseña">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </span>
                                </span>
                                
                                <button onclick="registrar()">Regístrarse</button>
                            </div>
                        </div>
                    </div>
                </main>

            </div>

        </div>
    </div>
    <?php require 'require/JS.php'; ?>
    <script src="require/sesion.js"></script>
    <script>
        if (localStorage.getItem('search') != ''){
            search.value = '';
            localStorage.setItem('search', '');
        }
        Swal.fire({
           icon: 'info',
           title: 'Inicia sesión o Registrate',
           text: ('Inicia Sesión para poder agregar productos en el carrito'),
           background: '#232323',
           color: '#fff',
           toast: true,
           position: 'bottom-end',
           timer: 5000,
           timerProgressBar: true,
           showConfirmButton: false
         });
    </script>
</body>
</html>
