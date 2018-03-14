@extends('app') <!-- *1 -->


@section('content') <!-- *2 -->

<div id="crud" class="row"> <!-- *5dashboard.blade.php -->

	<div class="col-xs-12">
		<h1 class="page-header">CRUD Laravel y VUEjs</h1>
	</div>
	<div class="col-sm-7"> <!-- *3dashboard.blade.php -->	
		<a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#create">Nueva Tarea</a><!-- *11dashboard.blade.php -->
		
	
	<table class="table table-hover table-striped">

		<thead>
			<tr>
				<th>ID</th>
				<th>Tarea</th>
				<th colspan="2">
					&nbsp;
				</th><!--*1-->				
			</tr>
		</thead>
		<tbody>
			<tr v-for="keep in keeps"> <!-- *7dashboard.blade.php  -->
			
				<td width="10px">@{{keep.id}}</td> <!-- *8dashboard.blade.php  -->
				<td>@{{keep.keep}}</td><!-- *9dashboard.blade.php  -->
				<td width="10px">
					<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editKeep(keep)">Editar</a><!-- *14dashboard.blade.php  -->
				</td>
				<td width="10px">
					<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="deleteKeep(keep)">Eliminar</a><!-- *10dashboard.blade.php  -->
				</td>

			</tr>
			
		</tbody>
		
	</table>
	<nav>
		<ul class="pagination"> <!-- *15 dashboard.blade.php  -->
			<li v-if="pagination.current_page>1"><!-- *16 dashboard.blade.php  -->
				<a href="#" @click.prevent="changePage(pagination.current_page - 1)"><!-- *18 dashboard.blade.php  -->
					<span>Atrás</span>
				</a>
			</li>

			<li v-for="page in pagesNumber" v-bind:class="[page == isActived ? 'active' : '']"><!-- *20 dashboard.blade.php  -->
				<a href="#" @click.prevent="changePage(page)">
					@{{page}}
				</a>
			</li>

			<li v-if="pagination.current_page < pagination.last_page"><!-- *17 dashboard.blade.php  -->
				<a href="#" @click.prevent="changePage(pagination.current_page + 1)"><!-- *19 dashboard.blade.php  -->
					<span>Siguiente</span>
				</a>
			</li>
		</ul>
	</nav>




	@include('create') <!-- *12dashboard.blade.php -->
	@include('edit') <!-- *13dashboard.blade.php -->

	</div>
	<div class="col-sm-5"> <!-- *4dashboard.blade.php -->
		<pre>	
			<br>
			<br>
			<br>
			<br>
			@{{ $data}} <!-- *2dashboard.blade.php -->
		</pre>		
	</div>
	
</div>


@endsection