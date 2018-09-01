<template>
  <div class="panel panel-info" >
	  <div class="panel-heading">
		  <h3 class="panel-title">Controles Simulador</h3>
	  </div>
	  <div class="panel-body">
      <ul class="nav nav-tabs">
        <li role="presentation" class="active">
          <a href="#globals" data-toggle="tab">Conf. globales</a>
        </li>
        <li role="presentation">
          <a href="#agencies" data-toggle="tab">Agencias</a>
        </li>
      </ul>
      <div class="tab-content">
        <GlobalConfig
          :simActive="globals.simActive"
          class="tab-pane active"
          id="globals" />

        <div class="tab-pane" id="agencies">
          <div class="panel-group" id="accordion">
            <template v-for="agency in globals.agencies" >
              <Agency
                :key="agency.id"
                :agency="agency"
                class="panel panel-primary"/>
            </template>
          </div>
        </div>
      </div>
	  </div>
  </div>
</template>

<script>
import GlobalConfig from './GlobalConfig'
import Agency from './Agency'

export default {
	data: () => ({

	}),

  props: ['globals'],

  components: {
    GlobalConfig,
    Agency
  },

	methods: {

	}


}
</script>
