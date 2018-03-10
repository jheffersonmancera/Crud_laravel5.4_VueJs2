
new Vue({
	el: '#crud',//*7app.js
	created: function(){
		this.getKeeps();//*4app.js
	},
	data: {
		fillKeep:{'id':'','keep':''},//*25app.js
		errors: [],
		newKeep: '',
		keeps: [],//*1app.js
		//*18app.js
		
	},
	methods:{
		getKeeps: function(){//*5app.js
			var urlKeeps = 'tasks';//*2
			axios.get(urlKeeps).then(response =>{
				this.keeps = response.data//*6
			});//*3app.js
		},
		editKeep: function(keep){//*26app.js:
			this.errors=[];//*39app.js:
			this.fillKeep.id = keep.id;//*27app.js:
			this.fillKeep.keep = keep.keep;//*28app.js:
			$('#edit').modal('show');	//*29app.js:
		},
		
		updateKeep: function(id){
			//alert('keep ha sido editado');
			var url ='tasks/' + id;//*30app.js:
			axios.put(url, this.fillKeep).then(response =>{//*31app.js:
				this.getKeeps();//*32app.js:
				this.fillKeep = {'id':'','keep':''};//*33app.js:
				this.errors   = [];//*34app.js:
				$('#edit').modal('hide');//*35app.js:
				toastr.success('Tarea actualizada con éxito');//*36app.js:
			}).catch(error =>{//*37app.js:
				this.errors = error.response.data//*38app.js:
			});
		},

		deleteKeep: function(keep){ //*8app.js *9app.js 
			//alert(keep.id);//prueba
				if (confirm("Seguro de eliminar esta tarea?")) {//*14app.js
					var url = 'tasks/'+keep.id;//*10app.js
					axios.delete(url).then(response=>{//*11app.js
					this.getKeeps();//*12app.js
					toastr.success('Se eliminó la tarea No.'+keep.id);//*13app.js
					});
				}return false;
			
		},

		createKeep: function(){
			var url = 'tasks';      //*15app.js
			axios.post(url,{        //*16app.js
				keep: this.newKeep  //*17app.js
			}).then(response =>{	
				this.getKeeps();	//*19app.js
				toastr.success(this.newKeep+' creado con éxito');//*23app.js
				this.newKeep='';	//*20app.js
				this.errors=[];		//*21app.js
				$('#create').modal('hide');//*22app.js
				
				
				}).catch(error =>{
				this.errors = error.response.data//*24app.js
				});


		}


	}
});