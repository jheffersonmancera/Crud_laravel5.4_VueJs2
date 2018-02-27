
new Vue({
	el: '#crud',
	created: function(){
		this.getKeeps();//*4
	},
	data: {
		keeps:[]//*1
	},
	methods:{
		getKeeps: function(){//*5
			var urlKeeps = 'tasks';//*2
			axios.get(urlKeeps).then(response =>{
				this.keeps = response.data//*6
			});//*3
		}
	}
});