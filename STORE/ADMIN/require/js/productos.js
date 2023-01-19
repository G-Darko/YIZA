		window.onload = function(){
			reload('reload/r-productos.php');
		}

		function agregarProd(){
			let fd = new FormData();
			fd.append('nombre', document.getElementById('nombre').value);
			fd.append('des', document.getElementById('des').value);
			fd.append('tMeta', document.getElementById('tMeta').value);
			fd.append('desMeta', document.getElementById('desMeta').value);
			fd.append('clave', document.getElementById('clave').value);
			fd.append('modelo', document.getElementById('modelo').value);
			fd.append('sku', document.getElementById('sku').value);
			fd.append('precio', document.getElementById('precio').value);
			fd.append('stock', document.getElementById('stock').value);
			fd.append('status', document.getElementById('status').value);
			fd.append('id_mar', document.getElementById('id_mar').value);
			fd.append('id_cat', document.getElementById('id_cat').value);
			fd.append('img', document.getElementById('img').files[0]);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Productos/agregarProd.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Agregado',
							  text: 'Producto agregado correctamente',
							  background: mainC,
							  color: negro1,
							  toast: true,
							  position: 'top',
							  timer: 2000,
							  timerProgressBar: true
							});
							//window.location.reload();
						})(
							reload('reload/r-productos.php'), 
							hideModal('modal-NProd'),
							document.getElementById('nombre').value = "",
							document.getElementById('des').value = "", 
							document.getElementById('tMeta').value = "",
							document.getElementById('desMeta').value = "",
							document.getElementById('clave').value = "",
							document.getElementById('modelo').value = "",
							document.getElementById('sku').value = "",
							document.getElementById('precio').value = "",
							document.getElementById('stock').value = "",
							document.getElementById('status').value = 1,
							document.getElementById('id_mar').value = 0,
							document.getElementById('id_cat').value = 0,
							document.getElementById('img').src = "img/logo.jpg"
						);

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
		function editProd(id_prod){
			let fd = new FormData();
			fd.append('id_prod', id_prod);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Productos/get_Prod.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					document.getElementById("id_prod").value=id_prod;
					document.getElementById('nombre-e').value=response.prod.nombre;
					document.getElementById('des-e').value=response.prod.des;
					document.getElementById('tMeta-e').value=response.prod.tMeta;
					document.getElementById('desMeta-e').value=response.prod.desMeta;
					document.getElementById('clave-e').value=response.prod.clave;
					document.getElementById('modelo-e').value=response.prod.modelo;
					document.getElementById('sku-e').value=response.prod.sku;
					document.getElementById('precio-e').value=response.prod.precio;
					document.getElementById('stock-e').value=response.prod.stock;
					document.getElementById('status-e').value=response.prod.status;
					document.getElementById('id_mar-e').value=response.prod.id_mar;
					document.getElementById('id_cat-e').value=response.prod.id_cat;
					document.getElementById('img-e').src=response.prod.img;
					showModal('modal-Edit');
				}
			}
			request.send(fd);			
		}
		function delateProd(id_prod){
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
					fd.append('id_prod',id_prod);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Productos/delateProd.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'El producto se ha eliminado',
									  background: mainC,
									  color: negro1,
									  toast: true,
									  position: 'top',
									  timer: 2000,
									  timerProgressBar: true
									});
									//window.location.reload();
								})( reload('reload/r-productos.php') );

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
		function updateProd(){
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
  					fd.append('id_prod',document.getElementById('id_prod').value);
					fd.append('nombre-e', document.getElementById('nombre-e').value);
					fd.append('des-e', document.getElementById('des-e').value);
					fd.append('tMeta-e', document.getElementById('tMeta-e').value);
					fd.append('desMeta-e', document.getElementById('desMeta-e').value);
					fd.append('clave-e', document.getElementById('clave-e').value);
					fd.append('modelo-e', document.getElementById('modelo-e').value);
					fd.append('sku-e', document.getElementById('sku-e').value);
					fd.append('precio-e', document.getElementById('precio-e').value);
					fd.append('stock-e', document.getElementById('stock-e').value);
					fd.append('status-e', document.getElementById('status-e').value);
					fd.append('id_mar-e', document.getElementById('id_mar-e').value);
					fd.append('id_cat-e', document.getElementById('id_cat-e').value);
					fd.append('inputImg', document.getElementById('inputImg').files[0]);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Productos/editProd.php', true);
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
									reload('reload/r-productos.php'),
									hideModal('modal-Edit') 
								);
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