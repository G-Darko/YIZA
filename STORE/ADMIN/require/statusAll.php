							<select id="status" required>
								<?php 
									$sql= "SELECT * from statusAll";
									$res=mysqli_query($conexion,$sql);
									while ($row=mysqli_fetch_assoc($res)){
								?>
								<option value="<?php echo $row['id_status']; ?>"><?php echo $row['status']; ?></option>
							<?php } ?>
							</select>