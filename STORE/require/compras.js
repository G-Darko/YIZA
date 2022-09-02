		function cancelar(id_ped){
			Swal.fire({
			  title: '¿Seguro de cancelar?',
			  text: "Esto no se podra revertir, además eliminara las dependencias",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, cancelar',
			  cancelButtonText: 'Cancelar',
			  background: '#232323',
			  color: '#fff'
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('id_ped', id_ped);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Compras/cancelar.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Cancelado',
									  text: 'El producto se ha cancelado pronto nos comunicaremos contigo',
									  background: '#232323',
									  color: '#fff',
									  toast: true,
									  position: 'bottom-end',
									  timer: 3000,
									  timerProgressBar: true
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
			})	
		}