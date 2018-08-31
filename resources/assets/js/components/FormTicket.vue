<template>
		<form
				v-show="form.active"
				class=""
				@submit.prevent="createTicket()"
				method="post"
				>
			Documento:
			<input
				type="text"
				name="cc"
				v-model="form.data.cc"
				:readonly="!form.editable"
				/>
			<br />
			Nombre:
			<input
				type="text"
				name="name"
				v-model="form.data.name"
				:readonly="!form.editable"
				/>
			<br />
			Género
			<select
				class=""
				name="gender"
				v-model="form.data.gender"
				:readonly="!form.editable"
				>
				<option value="male">Masculino</option>
				<option value="female">Femenino</option>
			</select>
			<br />
			Celular:
			<input
				type="text"
				name="phone"
				v-model="form.data.phone"
				:readonly="!form.editable"
				/>
			<br />
			Atención Preferencial
			<input
				type="checkbox"
				name="priority"
				v-model="form.data.priority"
				:readonly="!form.editable"
				/>
			<br />
			<button
				type="submit"
				name="button"
				>
					Pedir Turno
			</button>
			<button
				@click="resetForm()"
				type="button"
				name="button"
				>
					Regresar
			</button>

		</form> 
</template>

<script>
export default {
	props: [
		'inputs'
	],

	computed: {
		form: () => this.inputs 
	}
}
</script>
