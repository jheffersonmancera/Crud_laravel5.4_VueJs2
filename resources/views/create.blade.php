<form action="POST" v-on:submit.prevent="createKeep"><!--*9create.blade.php -->
<div class="modal fade" id="create"> 					<!-- *1create.blade.php -->
	<div class="modal-dialog"> 							<!-- *2create.blade.php -->
		<div class="modal-content"> 					<!-- *3create.blade.php -->
			<div class="modal-header">					<!-- *4create.blade.php -->
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<h4>Nueva Tarea</h4>
			</div>			
			<div class="modal-body">					<!-- *5create.blade.php -->
				<label for="keep">Crear Tarea</label>	<!-- *6create.blade.php -->
				<input type="text" name="keep" class="form-control" v-model="newKeep"><!--*7create.blade.php -->	
				<span v-for="error in errors" class="text-danger">@{{ error }}</span><!--*8create.blade.php -->	

			</div>				
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Guardar">
			</div>
		</div>
	</div>
</div> 
</form>
