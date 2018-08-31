<template>
    <div>
        <span><strong>Su ticket:</strong></span>
        <br />
        <span>{{ ticket.name }}</span>
        <br />
        <span>Turno: {{ ticket.num }}</span>
        <br />
        <span>En la agencia: {{ ticket.agency }}</span>
        <br />
        <button
            type="button"
            name="button"
            @click="$emit('closeTicket')">Aceptar
        </button>
    </div>
</template>

<script>
export default {
  props: [
      'ticket'
  ]
}
</script>

