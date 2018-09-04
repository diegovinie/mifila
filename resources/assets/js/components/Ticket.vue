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
        <div class="btn-group">
            <button
                type="button"
                class="btn btn-default"
                @click="$emit('closeTicket')">Aceptar
            </button>
            <button
                type="button"
                class="btn btn-danger"
                @click="$emit('cancelTicket')">Desistir
            </button>
        </div>
    </div>
</template>

<script>
export default {
  props: [
      'ticket'
  ]
}
</script>
