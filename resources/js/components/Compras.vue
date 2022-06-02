<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          {{titleList}}
          <div class="flex-grow-1"></div>
          
          <v-text-field v-model="search" label="Buscar" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBPedidos"
          :items="arrayPedidos"
          :footer-props="{
            'items-per-page-options': [10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="10"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar flat color="white">
                <v-checkbox v-model="mostrarPedidos" class="mx-6" label="Pedidos" >value="false"</v-checkbox>  
                <v-checkbox v-model="mostrarAnulados" class="mx-6" label="Anulados" >value="false"</v-checkbox>  
                <v-checkbox v-model="mostrarDevoluciones" class="mx-6" label="Devoluciones" >value="false"</v-checkbox>  
            <div class="flex-grow-1"></div>
              <!--<v-btn
                elevation="10"
                :to="{name: 'pedidos.form', params: { pedido:{}, action: 'add' } }"
                color="grey darken-3"
                dark
                class="mb-2 white--text"
              >
                Nueva Reserva&nbsp;
                <v-icon>library_add</v-icon>
              </v-btn>-->
            </v-toolbar>
          </template>

          <!-- template para las acciones -->
          <template v-slot:item.action="{item}">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn
                  elevation="10"
                  @click="mostrarDetalle(item)"
                  color="info"
                  class="white--text mx-1"
                  small
                  v-on="on"
                >
                <datepicker v-model="date" name="fecha" 
    @opened="datepickerAbierto" 
    @selected="fechaSeleccionada" 
    @closed="datepickerCerrado">
</datepicker>
// Nuestros métodos
methods: {
    datepickerAbierto: function() {
    console.log('El datepicker ha sido abierto');
    },
    fechaSeleccionada: function() {
        console.log('Una fecha ha sido seleccionada');
    },
    datepickerCerrado: function() {
        console.log('El datepicker ha sido cerrado');
    }
}
                  <v-icon>pageview</v-icon>
                </v-btn>
              </template>
              <span>Ver Articulos</span>
            </v-tooltip>
             <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn v-if="estado=='R'"
                  elevation="10"
                  color="success"
                  class="white--text"
                  small
                  @click="cambiarEstado(item,'P')"
                  v-on="on"
                >
                  <v-icon>check</v-icon>
                </v-btn>
              </template>
              <span>Realizar Pedido</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn v-if="estado=='R'"
                  color="red"
                  class="mx-1 white--text"
                  elevation="8"
                  small
                  v-on="on"
                  @click="cambiarEstado(item,'A')"
                >
                  <v-icon>close</v-icon>
                </v-btn>
              </template>
              <span>Anular Registro</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn v-if="estado=='P'"
                  color="deep-orange"
                  class="mx-1 white--text"
                  elevation="8"
                  small
                  v-on="on"
                  @click="cambiarEstado(item,'D')"
                >
                  <v-icon>mdi-cached</v-icon>
                </v-btn>
              </template>
              <span>Devolver Pedido</span>
            </v-tooltip>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>
<script>
export default {
  name: "ListadoReservas",
  data: () => ({
    arrayPedidos: [],
    hTBPedidos: [
      { text: "Nº Reserva", value: "correlativo" },
      { text: "Fecha Reserva", value: "fecha_reserva" },
      { text: "Fecha Pedido", value: "fecha_pedido" },
      { text: "Tipo de compra", value: "hora_inicio" },
      { text: "IVA", value: "hora_fin" },
      { text: "Total", value: "name" },
      { text: "Proveedor", value: "name" },
      
      { text: "Acciones", value: "action", sortable: false, align: "center" }
    ],
    loader: false,
    search: "",
    estado:"R",
    mostrarPedidos:false,
    mostrarAnulados:false,
    mostrarDevoluciones:false,
    mes: null,
    anio : null,
    titleList:"Listado de Reservas de Articulos"
  }),
  watch:{
       mostrarPedidos() {
        let me = this;
        if(me.mostrarPedidos) {
            me.estado = 'P';
            me.titleList = "Listado de Pedidos de Articulos";
        }else{
            me.estado = 'R';
            me.titleList = "Listado de Reservas de Articulos";
        }
        me.fetchPedidos(me.estado);
      },
      mostrarAnulados() {
        let me = this;
        if(me.mostrarAnulados) {
            me.estado = 'A';
            me.titleList = "Listado de Reservas Anuladas";
        }else{
            me.estado = 'R';
            me.titleList = "Listado de Reservas de Articulos";
        }
        me.fetchPedidos(me.estado);
      },
      mostrarDevoluciones() {
        let me = this;
        if(me.mostrarDevoluciones) {
            me.estado = 'D';
            me.titleList = "Listado de Devoluciones";
        }else{
            me.estado = 'R';
            me.titleList = "Listado de Reservas de Articulos";
        }
        me.fetchPedidos(me.estado);
      },
  },
  computed: {},
  methods: {
    fetchPedidos(estado) {
      let me = this, state = estado;
      me.loader = true;
      axios.get(`/pedidos/state?state=`+me.estado)
        .then(function(response) {
          if(Object.keys(response.data).length==0){
              me.arrayPedidos = [];
          }else{
              me.arrayPedidos = response.data;
          }
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
       me.loader = false;
    },
    contructFecha(){
      let me = this;
      if(me.mes != null && me.anio != null){
          let fecha = me.mes +"-"+ me.anio;
          return me.$moment(fecha, "DD-MM-YYYY").toDate();
      }else{
        return null;
      }
    },
    cambiarEstado(pedido,estado) {
      let me = this;
      pedido.estado = estado;
      const Toast = Vue.swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: true,
        timer: 8000
      });

      Vue.swal({
        title: "Esta Seguro/a de realiar esta acción?",
        text:
          "Una vez realizada la operación el registro desaparecerá de la tabla",
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Si",
        cancelButtonText: "No",
        reverseButtons: true,
        focusConfirm: false,
        focusCancel: true,
        showCloseButton: true
      }).then(result => {
        if (result.value) {
          me.loader = true;
          axios
            .put(`/pedidos/change`,pedido)
            .then(function(response) {
              me.loader = false;
              if (response.status == 200) {
                Vue.swal(
                  "Confirmado",
                  "La operación ha sido realizada con Exito",
                  "success"
                );
                let estado = "R";
                me.fetchPedidos(estado);   
              }
            })
            .catch(function(error) {
              console.log(error);  
              me.loader = false;
              Toast.fire({
                type: "error",
                title: "Ocurrio Un Error Intente Nuevamente"
              });
            });
        }
      });
    }
  },
  mounted() {
    let me = this;
    me.fetchPedidos(me.estado);
  }
};
</script>