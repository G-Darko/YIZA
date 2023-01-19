		window.onload = function(){
			reload('reload/r-pedidos.php');
		}

		function cancelar(id_ped){
			Swal.fire({
			  title: '¿Seguro de cancelar?',
			  text: "Esto no se podra revertir",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, cancelar',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('id_ped', id_ped);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Pedidos/cancelar.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Cancelado',
									  text: 'El producto se ha cancelado comunicate con el usuario',
									  background: mainC,
									  color: negro1,
									  toast: true,
									  position: 'top',
									  timer: 2000,
									  timerProgressBar: true
									});
									//window.location.reload();
								})( reload('reload/r-pedidos.php') );

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

		function proceso(id_ped){
			Swal.fire({
			  title: '¿Cambiar estado a En progreso?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, Cambiar',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('id_ped', id_ped);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Pedidos/progreso.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'En progreso',
									  text: 'El producto se ha procesado',
									  background: mainC,
									  color: negro1,
									  toast: true,
									  position: 'top',
									  timer: 2000,
									  timerProgressBar: true
									});
									//window.location.reload();
								})( reload('reload/r-pedidos.php') );

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

		function entregar(id_ped){
			Swal.fire({
			  title: '¿Producto entregado?',
			  text: "El producto ya llgo al cliente",
			  icon: 'info',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, ha sido entregado',
			  cancelButtonText: 'Cancelar',
			  background: mainC,
			  color: negro1
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('id_ped', id_ped);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Pedidos/entregado.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Entregado',
									  text: 'El producto se ha entregado',
									  background: mainC,
									  color: negro1,
									  toast: true,
									  position: 'top',
									  timer: 2000,
									  timerProgressBar: true
									});
									//window.location.reload();
								})( reload('reload/r-pedidos.php') );

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