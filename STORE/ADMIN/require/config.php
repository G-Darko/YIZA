		<div class="modal config" id="config" style="display: none;">
			<div class="productos">
			   	<div class="container perfil" id="opciones" style="display: block;">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<i class="i" style="color: var(--azul);">
			   						<ion-icon name="settings-outline"></ion-icon>
			   						Configuraciòn		
			   					</i>
			   					<span>
			   						<button class="cerrar" title="Cerrar" onclick="salir()">
			   							<ion-icon name="close-circle-outline"></ion-icon>
			   						</button>
			   					</span>
			   					&nbsp;	
			   				</td>
			   			</tr>	
			   			<tr title="General">
			   				<td class="hov" onclick="mostrar('general')">
			   					<ion-icon name="cog-outline"></ion-icon>
			   					General <span>></span>
			   				</td>
			   			</tr>
			   			<tr title="Administración">
			   				<td class="hov" onclick="mostrar('admin')">
			   					<ion-icon name="shield-outline"></ion-icon>
			   					Administración <span>></span>
			   				</td>
			   			</tr>
			   			<tr title="Tienda">
			   				<td class="hov" onclick="mostrar('tienda')">
			   					<ion-icon name="storefront-outline"></ion-icon>
			   					Tienda <span>></span>
			   				</td>
			   			</tr>
			   			<tr class="reset" title="Restablecer Configuración">
			   				<td class="hov" onclick="resetConfig('tienda')">
			   					<ion-icon name="sync-outline"></ion-icon>
			   					Restablecer Configuración <span>></span>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<button class="save data" onclick="saveConfig()" title="Guardar configuración">
			   						<ion-icon name="save-outline"></ion-icon>
				   					Guardar configuración
				   				</button>
			   				</td>
			   			</tr>

			   		</table>
			   	</div>
			   	<?php 
			   		$sqlConfig = "SELECT * FROM config WHERE id = 1";
			   		$resConfig = $conexion->query($sqlConfig);
					$config = $resConfig->fetch_assoc();
			   	?>
			   	<div class="container perfil datos" id="general" style="display: none;">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<ion-icon name="cog-outline"></ion-icon>
			   					<i>General</i>
			   					<span>
			   						<button title="Regresar" onclick="ocultar('general')">
			   							<ion-icon name="return-up-back-outline"></ion-icon>
			   						</button>
			   					</span>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input maxlength="30" title="Nombre del Comercio" class="in" type="text" required id="nomC" value="<?php echo $config['nomCom'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Nombre del Comercio
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input maxlength="30" title="Meta Tag Title" class="in" type="text" required id="metaTC" value="<?php echo $config['metaNom'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Meta Tag Title
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<textarea title="Meta Descripción" class="in" id="metaDesC" required><?php echo $config['metaDes'];?></textarea>
			   						<span class="sp">Meta Descripción</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<textarea title="Meta Clave" class="in" id="metaClaveC" required><?php echo $config['metaClave'];?></textarea>
			   						<span class="sp">Meta Clave</span>
			   					</div>
			   				</td>
			   			</tr>

			   		</table>
			   	</div>


			   	<div class="container perfil datos" id="admin" style="display: none;">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<ion-icon name="shield-outline"></ion-icon>
			   					<i>Administración</i>
			   					<span>
			   						<button title="Regresar" onclick="ocultar('admin')">
			   							<ion-icon name="return-up-back-outline"></ion-icon>
			   						</button>
			   					</span>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Propietario" class="in" type="text" required id="propietario" value="<?php echo $config['propietario'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Propietario
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<textarea title="Dirección" class="in" id="direccionC" required><?php echo $config['direccion'];?></textarea>
			   						<span class="sp">Dirección</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Correo" class="in" type="text" required id="correoC" value="<?php echo $config['correo'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Correo
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input maxlength="10" title="Telefono" class="in" type="txt" required id="telefonoC" value="<?php echo $config['telefono'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Telefono
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input min="1" maxlength="11" title="Cantida de itmes a mostrar por página en el panel de adminstración" class="in" type="number" required id="iAdmin" value="<?php echo $config['itemsAdmin'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Items por página en Adminstración
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   		</table>
			   	</div>

			   	<div class="container perfil datos" id="tienda" style="display: none;">
			   		<table>
			   			<tr class="head">
			   				<td></td>
			   			</tr>
			   			<tr style="border: none;">
			   				<td>
			   					<ion-icon name="storefront-outline"></ion-icon>
			   					<i>Tienda</i>
			   					<span>
			   						<button title="Regresar" onclick="ocultar('tienda')">
			   							<ion-icon name="return-up-back-outline"></ion-icon>
			   						</button>
			   					</span>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input min="1" maxlength="11" title="Cantida de itmes a mostrar por página en la tienda" class="in" type="number" required id="iStore" value="<?php echo $config['itemsStore'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Items por página en Tienda
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<select id="showStock" class="in" required>
			   							<option value="<?php echo $config['showStock'];?>"><?php echo $config['showStock'];?></option>
			   						<?php 
			   							$show = $config['showStock'];
			   							if ($show == 'SI') {
			   						?>
			   							<option value="NO">NO</option>
			   						<?php
			   							}else{
			   						?>
			   							<option value="SI">SI</option>
			   						<?php		
			   							}
			   						?>
			   						</select>
			   						<span class="sp">
			   							<b class="a">*</b>Mostrar Stock
			   						</span>
			   					</div>
			   				</td>
			   			</tr>

			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   						<input title="Leyenda cuando no haya Stock Disponible" class="in" type="text" required id="leyenda" value="<?php echo $config['leyendaStock'];?>">
			   						<span class="sp">
			   							<b class="a">*</b>Leyenda de Stock
			   						</span>
			   					</div>
			   				</td>
			   			</tr>
			   			<tr>
			   				<td>
			   					<div class="inputBox">
			   							
			   						
				   					<img title="Icono de la tienda" class="iconoS" id="iconoS" src="<?php echo $config['logo'];?>" alt="" onclick="subir('iconT')">
				   						
				   					<input class="in" type="file" required id="iconT" style="display: none;" accept="image/*" onchange="imagenChange('iconT', 'iconoS', '<?php echo $config['logo'];?>');">
			   						
				   					<span class="sp">
				   						Icono de la tienda
				   					</span>
			   							
			   					</div>
			   				</td>
			   			</tr>

			   		</table>
			   	</div>

			</div>
		</div>