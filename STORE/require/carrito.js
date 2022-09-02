		function cartUpdate(id_prod, id_cart, stock){
			let fd = new FormData();
			let cantidad = document.getElementById('cantidad'+id_cart).value;
			fd.append('id_prod', id_prod);
			fd.append('id_cart', id_cart);
			fd.append('stock', stock);
			fd.append('cantidad', cantidad);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Cart/update_cart.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
							  icon: 'success',
							  title: 'Actualizado',
							  text: 'El carrito se actualizó correctamente',
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


		function deleteC(id_prod, id_cart){
			Swal.fire({
			  title: '¿Seguro de eliminar?',
			  text: "Esto no se podra revertir, además eliminara las dependencias",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, eliminar',
			  cancelButtonText: 'Cancelar',
			  background: '#232323',
			  color: '#fff'
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('id_cart',id_cart);
					fd.append('id_prod',id_prod);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Cart/delateCart.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Eliminado',
									  text: 'El producto se ha eliminado del carrito',
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

		function buy(num, total, dir){
			let b;
			let c;
			if (localStorage.getItem('darkMode')=== 'true'){
			 	b = '#232323';
			 	c = '#000';
			 }else{
			 	b = '#E4E9F0';
			 	c = '#fff';
			 }
			Swal.fire({
			  title: '<h3 style="color: var(--azul); font-style: italic;">¿Comprar ' + num + ' Productos?</h3>',
			  html: '<div class="productos">' +
			  			'<div class="container perfil datos" style="width: 100%;">' +
			  				'<table style="width: 100%;">'+
					   			

					   			'<tr>'+
					   				'<td>'+
					   					'<div class="inputBox">'+
					   						'<input title="Correo o Usuario" class="in" type="text" required id="swal-correo">'+
					   						'<span class="sp">'+
					   							'<b class="a">*</b>Correo o Usuario'+
					   						'</span>'+
					   					'</div>'+
					   				'</td>'+
					   			'</tr>'+

					   			'<tr>'+
					   				'<td>'+
					   					'<div class="inputBox">'+
					   						'<input title="Contraseña" class="in" type="password" required id="swal-pass">'+
					   						'<span class="sp">'+
					   							'<b class="a">*</b>Contraseña'+
					   						'</span>'+
					   					'</div>'+
					   				'</td>'+
					   			'</tr>'+

					   			'<tr>'+
					   				'<td>'+
					   					'<div class="inputBox">'+
					   						'<textarea style="resize: none; height: 250px; padding-top: 50px;" disabled title="Direccion a la que se envia" class="in" id="swal-dir" required>'+dir+'</textarea>'+
					   						'<span class="sp" style="background: var(--bloque);">'+
					   							'<b class="a">*</b>Dirección'+
					   						'</span>'+
					   					'</div>'+
					   				'</td>'+
					   			'</tr>'+

					   			'<tr>'+
					   				'<td>'+
					   					'<div class="inputBox">'+
					   						'<input title="Total a Pagar" class="in" type="number" required id="swal-pago" value="'+total+'" min="'+total+'" max="'+total+'">'+
					   						'<span class="sp">'+
					   							'<b class="a">*</b>Total a Pagar'+
					   						'</span>'+
					   					'</div>'+
					   				'</td>'+
					   			'</tr>'+

					   		'</table>'+
			  			'</div>' +
			  		'</div>',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Confirmar Compra',
			  cancelButtonText: 'Cancelar',
			  background: b,
			  color: c
			}).then((result) => {
			  	if (result.isConfirmed) {
				    let fd = new FormData();
					fd.append('total', total);
					fd.append('swal-correo', document.getElementById('swal-correo').value);
					fd.append('swal-pass', document.getElementById('swal-pass').value);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Cart/comprar.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								window.location.href = 'compras.php?r=c';
							}else{
								(async () =>{
									await Swal.fire({
										  icon: 'error',
										  title: 'Error',
										  text: (response.detail),
										  background: '#232323',
										  color: '#fff'
										});
									buy(num, total, dir);
								})();
							}
						}
					}
					request.send(fd);			  
			   	}
			})
		}

		function comprobar(num, total){
			let fd = new FormData();
			fd.append('total', total);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Cart/comprobarDir.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						buy(num, total, response.dir);
					}else{
						window.location.href= 'perfil.php?r=direccion';
					}
				}
			}
			request.send(fd);		
		}