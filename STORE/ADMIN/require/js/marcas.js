		window.onload = function(){
			reload('reload/r-marcas.php');
		}

		function agregarMar(){

			let mainC = getComputedStyle(document.body).getPropertyValue('--mainC');
			let negro1 = getComputedStyle(document.body).getPropertyValue('--negro1');

			let fd = new FormData();
			fd.append('nombre', document.getElementById('nombre').value);
			fd.append('img', document.getElementById('img').files[0]);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Marcas/agregarMar.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Agregado',
							  text: 'Marca agregada correctamente',
							  background: mainC,
							  color: negro1,
							  toast: true,
							  position: 'top',
							  timer: 2000,
							  timerProgressBar: true
							});
							/*console.log(response.nom);
							console.log(response.img);*/
							//window.location.reload();
						})( 
							reload('reload/r-marcas.php'), 
							hideModal('modal-NMar'),
							document.getElementById('nombre').value = "",
							document.getElementById('cuadro').src = "img/logo3.png" 
						);

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
		function editMar(id_mar){

			let mainC = getComputedStyle(document.body).getPropertyValue('--mainC');
			let negro1 = getComputedStyle(document.body).getPropertyValue('--negro1');

			let fd = new FormData();
			fd.append('id_mar', id_mar);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Marcas/get_Mar.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					document.getElementById("id_mar").value=id_mar;
					document.getElementById('nombre-e').value=response.mar.nombre;
					document.getElementById('img-e').src=response.mar.img;
					showModal('modal-Edit');
				}
			}
			request.send(fd);			
		}
		function delateMar(id_mar){

			let mainC = getComputedStyle(document.body).getPropertyValue('--mainC');
			let negro1 = getComputedStyle(document.body).getPropertyValue('--negro1');

			Swal.fire({
			  title: '¿Seguro de eliminar?',
			  text: "Esto no se podra revertir, además eliminara las dependencias",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, eliminar',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('id_mar',id_mar);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Marcas/delateMar.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'La marca se ha eliminado',
									  background: mainC,
									  color: negro1,
									  toast: true,
									  position: 'top',
									  timer: 2000,
									  timerProgressBar: true
									});
									
									//window.location.reload();
								})( reload('reload/r-marcas.php') );

							}else{
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
			})	
		}
		function updateMar(){

			let mainC = getComputedStyle(document.body).getPropertyValue('--mainC');
			let negro1 = getComputedStyle(document.body).getPropertyValue('--negro1');
			
			Swal.fire({
			  title: 'Confirmar',
			  text: "Se van a actualizar los datos",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Actualizar',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
					let fd = new FormData();
  					fd.append('id_mar',document.getElementById('id_mar').value);
					fd.append('nombre-e', document.getElementById('nombre-e').value);
					fd.append('inputImg', document.getElementById('inputImg').files[0]);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Marcas/editMar.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Actualizo',
									  text: 'Lo datos se actualizaron correctamente',
									  background: mainC,
									  color: negro1,
									  toast: true,
									  position: 'top',
									  timer: 2000,
									  timerProgressBar: true
									});
									
									//window.location.reload();

								})( 
									reload('reload/r-marcas.php'),
									hideModal('modal-Edit') 
								);
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
			})
		}