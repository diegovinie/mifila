<template>
  <div class="panel panel-info" >
	  <div class="panel-heading">
		  <h3 class="panel-title">Configuraciones</h3>
	  </div>
	  <div class="panel-body">
		  <div class="form-group">
			<label for="acc">Acceleración:</label>
			<select 
				class="form-input"
				id="acc"
				name="acc" 
				v-model="newAcc" 
				@change="updateAcc()" 
				>
				<template v-for="acc in accs" >
					<option :value="acc.id" :key="acc.id" >{{ acc.name }} </option>
				</template>
			</select>
		  </div>
		  <div class="form-group">
			<label for="clients_rate">Promedio de Clientes:</label>	
			<select
				class="form-input"
				id="clients_rate" 
				v-model="newClientsRate" 
				name="clients_rate" 
				@change="updateClientsRate()"
				>
				<template v-for="rate in clientsRates">
					<option :key="rate.id" :value="rate.id">{{ rate.name }}</option>
				</template>
			</select>
		  </div>
		<br />
		
		<br />	
	  </div>
  </div>
</template>

<script>
export default {
	data: () => ({
		newAcc: null,
		newClientsRate: null,
		accs: [],
		clientsRates: []
	}),

	methods: {
		fetchConfigs () {
			axios.get('configs')
				.then(({data}) => {
					data.forEach(config => {
						console.log(config.name)
						if (config.name === 'acc') {
							this.newAcc = config.current.id 
							
							// {
							// 	id: config.current.id,
							// 	name: config.current.name,
							// 	description: config.current.description
							// }
						}
						if (config.name === 'clients_rate') {
							this.newClientsRate = config.current.id
						}
					})

					this.configs = data
				})
				.catch(err => {
					console.log('Error ', err)
				})
		},

		fetchAccs () {
			axios.get('configs/2/items')
				.then(({data}) => {
					this.accs = data
				})
				.catch(err => {
					console.log('Error fetchAccs ', err)
				})
		},

		fetchClientsRates () {
			axios.get('configs/1/items')
				.then(({data}) => {
					this.clientsRates = data
				})
				.catch(err => {
					console.log('Error fetchClientsRates ', err)
				})
		},

		updateAcc () {
			axios.put('configs/2', {item: this.newAcc})
			.then(({data}) => {
				console.log(data)
			})
			.catch(err => {
				console.log('Error updateAcc ', err)
			})
		},

		updateClientsRate () {
			axios.put('configs/1',{item: this.newClientsRate})
				.then(({data}) => {
					console.log(data)
				})
				.catch(err => {
					console.log('Error updateClientsRate ', err)
				})
		}
	},

	created () {
		this.fetchConfigs()
		this.fetchAccs()
		this.fetchClientsRates()
	}
}
</script>
