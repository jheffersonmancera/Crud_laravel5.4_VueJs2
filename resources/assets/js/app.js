
new Vue({
	el: '#crud',//*7app.js
	created: function(){
		this.getKeeps();//*4app.js
	},
	data: {
		keeps:[]//*1app.js
	},
	methods:{
		getKeeps: function(){//*5app.js
			var urlKeeps = 'tasks';//*2
			axios.get(urlKeeps).then(response =>{
				this.keeps = response.data//*6
			});//*3app.js
		},

		deleteKeep: function(keep){ //*8app.js *9app.js 
			//alert(keep.id);
			var url = 'tasks/'+keep.id;//*10app.js
			axios.delete(url).then(response=>{//*11app.js
				this.getKeeps();//*12app.js
			});
		}


	}
});