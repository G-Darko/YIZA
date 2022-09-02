        let pass = document.querySelector('.pass');
        let btnIniPass = document.querySelector('.btnIniPass');
        let contra = document.querySelector('.contra');
        btnIniPass.onclick = function (){
            if(contra.firstElementChild.type === 'password'){
                contra.firstElementChild.type = 'text';
                this.firstElementChild.name = 'eye-off-outline';
                pass.firstElementChild.title = 'Ocultar Contraseña';
            }else{
                contra.firstElementChild.type = 'password';
                this.firstElementChild.name = 'eye-outline';
                pass.firstElementChild.title = 'Mostrar Contraseña';
            }
            
        }

        let regpass = document.querySelector('.RegPass');
        let btnPass = document.querySelector('.btnPass');
        let regcontra = document.querySelector('.RegContra');
        btnPass.onclick = function (){
            if(regcontra.firstElementChild.type === 'password'){
                regcontra.firstElementChild.type = 'text';
                this.firstElementChild.name = 'eye-off-outline';
                regpass.firstElementChild.title = 'Ocultar Contraseña';
            }else{
                regcontra.firstElementChild.type = 'password';
                this.firstElementChild.name = 'eye-outline';
                regpass.firstElementChild.title = 'Mostrar Contraseña';
            }
            
        }

        function iniciar(){
            let fd = new FormData();
            fd.append('IniUser', document.getElementById('IniUser').value);
            fd.append('IniPass', document.getElementById('IniPass').value);
            let request = new XMLHttpRequest();
            request.open('POST', 'api/sesion.php', true);
            request.onload=function(){
                if (request.readyState==4 && request.status==200) {
                    let response=JSON.parse(request.responseText);
                    //console.log(request);
                    if (response.state) {
                        window.location.href="./"
                    }else{
                        Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: (response.detail),
                              background: '#232323',
                              color: '#fff'
                            });
                    }
                }
            }
            request.send(fd);
        }

        function registrar(){
            let fd = new FormData();
            fd.append('nombres', document.getElementById('nombres').value);
            fd.append('ap1', document.getElementById('ap1').value);
            fd.append('ap2', document.getElementById('ap2').value);
            fd.append('email', document.getElementById('email').value);
            fd.append('user', document.getElementById('user').value);
            fd.append('pass', document.getElementById('pass').value);
            let request = new XMLHttpRequest();
            request.open('POST', 'api/registro.php', true);
            request.onload=function(){
                if (request.readyState==4 && request.status==200) {
                    let response=JSON.parse(request.responseText);
                    //console.log(request);
                    if (response.state) {
                        (async () =>{
                            await Swal.fire({
                                icon: 'success',
                                title: 'Registro exitoso',
                                text: 'Ahora puedes iniciar sesión',
                                background: '#232323',
                                color: '#fff'
                                });
                            window.location.reload();

                            })();
                    }else{
                        Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: (response.detail),
                              background: '#232323',
                              color: '#fff'
                            });
                    }
                }
            }
            request.send(fd);
        }


        let usuario = document.getElementById("IniUser");
        usuario.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) { 
                document.getElementById('IniPass').focus();
            }
        });
        let contra_pass = document.getElementById("IniPass");
        contra_pass.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) { 
                iniciar();
            }
        });

        let reg_pass = document.getElementById("pass");
        reg_pass.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) { 
                registrar();
            }
        });






    document.getElementById("btn__iniciar-sesion").addEventListener("click", Sesion);
    document.getElementById("btn__registrarse").addEventListener("click", Registro);
    window.addEventListener("resize", anchoPage);

    let formulario_login = document.querySelector(".formulario__login");
    let formulario_register = document.querySelector(".formulario__register");
    let login_register = document.querySelector(".login-register");
    let caja_trasera_login = document.querySelector(".caja__trasera-login");
    let caja_trasera_register = document.querySelector(".caja__trasera-register");

    function anchoPage(){

        if (window.innerWidth > 850){
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "block";
        }else{
            caja_trasera_register.style.display = "block";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.display = "none";
            formulario_login.style.display = "block";
            login_register.style.left = "0px";
            formulario_register.style.display = "none";   
        }
    }

    anchoPage();


        function Sesion(){
            if (window.innerWidth > 850){
                formulario_login.style.display = "block";
                login_register.style.left = "10px";
                formulario_register.style.display = "none";
                caja_trasera_register.style.opacity = "1";
                caja_trasera_login.style.opacity = "0";
            }else{
                formulario_login.style.display = "block";
                login_register.style.left = "0px";
                formulario_register.style.display = "none";
                caja_trasera_register.style.display = "block";
                caja_trasera_login.style.display = "none";
            }
        }

        function Registro(){
            if (window.innerWidth > 850){
                formulario_register.style.display = "block";
                login_register.style.left = "410px";
                formulario_login.style.display = "none";
                caja_trasera_register.style.opacity = "0";
                caja_trasera_login.style.opacity = "1";
            }else{
                formulario_register.style.display = "block";
                login_register.style.left = "0px";
                formulario_login.style.display = "none";
                caja_trasera_register.style.display = "none";
                caja_trasera_login.style.display = "block";
                caja_trasera_login.style.opacity = "1";
            }
    }