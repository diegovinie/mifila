<template>
	<ul class="list-group list">
    <template v-for="ticket in tickets" >
			<li :key="ticket.id" class="list-group-item">
				{{ ticket.client.name }}
				<span :class="['label', ticket.noti ? 'label-danger' : 'label-info']">
				{{ ticket.num }}
				</span>
			</li>
    </template>
	</ul>
</template>

<script>
export default {
	props: ['tickets']
}
</script>

<style media="screen" scoped>
	.list {
		max-height: 300px;
		overflow-y: auto;
	}
</style>
