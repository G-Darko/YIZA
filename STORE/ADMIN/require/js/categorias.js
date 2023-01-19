		window.onload = function(){
			reload('reload/r-categorias.php');
		}

		function updateCat(){
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
  					fd.append('id_cat',document.getElementById('id_cat').value);
					fd.append('nombre-e', document.getElementById('nombre-e').value);
					fd.append('des-e', document.getElementById('des-e').value);
					fd.append('tMeta-e', document.getElementById('tMeta-e').value);
					fd.append('desMeta-e', document.getElementById('desMeta-e').value);
					fd.append('clave-e', document.getElementById('clave-e').value);
					fd.append('status-e', document.getElementById('status-e').value);
					fd.append('padre-e', document.getElementById('padre-e').value);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Categorias/editCat.php', true);
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
									reload('reload/r-categorias.php'),
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
		function delateCat(id_cat){
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
					fd.append('id_cat',id_cat);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Categorias/delateCat.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'La categoría se ha eliminado',
									  background: mainC,
									  color: negro1,
									  toast: true,
									  position: 'top',
									  timer: 2000,
									  timerProgressBar: true
									});
									//window.location.reload();
								})( reload('reload/r-categorias.php') );

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
		function agregarCat(){
			let fd = new FormData();
			fd.append('nombre', document.getElementById('nombre').value);
			fd.append('des', document.getElementById('des').value);
			fd.append('tMeta', document.getElementById('tMeta').value);
			fd.append('desMeta', document.getElementById('desMeta').value);
			fd.append('clave', document.getElementById('clave').value);
			fd.append('status', document.getElementById('status').value);
			fd.append('padre', document.getElementById('padre').value);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Categorias/agregarCat.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Agregado',
							  text: 'La categoria se agregó correctamente',
							  background: mainC,
							  color: negro1,
							  toast: true,
							  position: 'top',
							  timer: 2000,
							  timerProgressBar: true
							});
							//window.location.reload();

						})(
							reload('reload/r-categorias.php'), 
							hideModal('modal-NCat'),
							document.getElementById('nombre').value = "",
							document.getElementById('des').value = "", 
							document.getElementById('tMeta').value = "",
							document.getElementById('desMeta').value = "",
							document.getElementById('clave').value = "",
							document.getElementById('status').value = 1,
							document.getElementById('padre').value = 0
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

		//Abre un modal con todos los datos
		function editCat(id_cat){
			let fd = new FormData();
			fd.append('id_cat', id_cat);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Categorias/get_Cat.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					document.getElementById("id_cat").value=id_cat;
					document.getElementById('nombre-e').value=response.cat.nombre;
					document.getElementById('des-e').value=response.cat.des;
					document.getElementById('tMeta-e').value=response.cat.tMeta;
					document.getElementById('desMeta-e').value=response.cat.desMeta;
					document.getElementById('clave-e').value=response.cat.clave;
					document.getElementById('status-e').value=response.cat.status;
					document.getElementById('padre-e').value=response.cat.padre;
					showModal('modal-Edit');
				}
			}
			request.send(fd);			
		}