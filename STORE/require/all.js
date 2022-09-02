		function modal(id, nombre, img, stock){
			(async () => {

				const {value: cantidad} = await Swal.fire({
				  title: '¿Agregar al carrito '+nombre+'?',
				  text: "Ingresa la catntidad de productos a añadir",
				  html: '',
				  input: 'number',
				  imageUrl: 'ADMIN/'+img,
				  inputAttributes: {
				  	min: 1,
				  	max: stock
				  },
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Añadir',
				  cancelButtonText: 'Cancelar',
				  background: '#232323',
				  color: '#fff'
				})	
				if (cantidad) {
					let fd = new FormData();
					fd.append('id_prod', id);
					fd.append('stock', stock);
					fd.append('cantidad', cantidad);
					let request = new XMLHttpRequest();
					request.open('POST', 'api/Cart/carrito.php', true);
					request.onload=function(){
						if (request.readyState==4 && request.status==200) {
							let response=JSON.parse(request.responseText);
							//console.log(request);
							if (response.state) {
								(async () =>{
									await Swal.fire({
									  icon: 'success',
									  title: 'Producto agregado',
									  imageUrl: 'ADMIN/'+img,
									  text: 'El producto: '+ nombre +' se añadió al carrito.  Cantidad añadida: '+cantidad,
									  background: '#232323',
									  color: '#fff',
									  toast: true,
									  position: 'bottom-end',
									  timer: 5000,
									  timerProgressBar: true
									});
									//window.location.reload();
								})()	
							}else if (response.sesion) {
								 
								window.location.href = 'login.php';
								
							}else{
								Swal.fire({
									  icon: 'warning',
									  title: 'Error',
									  text: (response.detail),
									  background: '#232323',
									  color: '#fff',
									  toast: true,
									  position: 'bottom-end',
									  timer: 5000,
									  timerProgressBar: true
									});
							}
						}
					}
					request.send(fd);
				}			  
			})()
		}
		function cart(id_prod){
			let fd = new FormData();
			fd.append('id_prod', id_prod);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Cart/get_prod.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					let id = id_prod;
					let nombre = response.prod.nombre;
					let stock = response.prod.stock;
					let img = response.prod.img;
					modal(id, nombre, img, stock);
				}
			}
			request.send(fd);			
		}

		function fav(id_prod){
			let fd = new FormData();
			fd.append('id_prod', id_prod);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Cart/get_prod.php', true);
			request.onload = function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					let id = id_prod;
					let nombre = response.prod.nombre;
					let img = response.prod.img;
					modal_fav(id, nombre, img);
				}
			}
			request.send(fd);			
		}

		function modal_fav(id, nombre, img) {
			let fd = new FormData();
			fd.append('id_prod', id);
			let request = new XMLHttpRequest();
			request.open('POST', 'api/Cart/favoritos.php', true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					//console.log(request);
					if (response.state) {
						(async () =>{
							await Swal.fire({
								icon: 'success',
								title: 'Producto agregado',
								imageUrl: 'ADMIN/'+img,
								text: 'El producto: '+ nombre +' se añadió a Favoritos.',
								background: '#232323',
								color: '#fff',
					    		toast: true,
					    		position: 'bottom-end',
					    		timer: 5000,
					    		timerProgressBar: true
					    		});
					    		//window.location.reload();
					    })()	
					}else if (response.sesion) {
						
						window.location.href = 'login.php';
						
					}else{
						Swal.fire({
							icon: 'warning',
							title: 'Error',
							text: (response.detail),
							background: '#232323',
							color: '#fff',
							toast: true,
							position: 'bottom-end',
							timer: 5000,
							timerProgressBar: true
						});
					}
				}
			}
			request.send(fd);	
		}
		
		
		let search = document.getElementById("search");
		search.addEventListener("keydown", function (e) {
		    if (e.keyCode === 13) { 
		        buscar();
		    }
		});

		function buscar() {
			if (search.value != "") {
				localStorage.setItem('search', search.value);
		    	window.location.href = 'buscar.php?search=' + search.value;
			}
		}

		if (localStorage.getItem('search') != ''){
			search.value = localStorage.getItem('search');
		}
