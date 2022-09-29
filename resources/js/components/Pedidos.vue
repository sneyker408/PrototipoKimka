<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Inventario de Pedidos
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar Pedido" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBPedidos"
          :items="arrayPedidos"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar pedidos-->

          <template v-slot:top>
            <v-toolbar flat color="white">
              <div class="flex-grow-1"></div>
              <v-dialog v-model="dialog" persistent max-width="700px">
                <template v-slot:activator="{ on }">
                  <v-btn elevation="10" color="grey darken-3" dark class="mb-2" v-on="on">
                    Agregar&nbsp;
                    <v-icon>mdi-plus-box-multiple-outline</v-icon>
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="headline grey lighten-2" primary-titles>
                    <span class="headline" v-text="formTitle"></span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-form ref="formPedido" v-model="validForm" :lazy-validation="true">
                        <v-row>
                            <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="pedido.nombre"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Nombre Es Requerido']"
                          label="Nombre"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-textarea
                          label="Descripcion"
                          no-resize
                          rows="1"
                          v-model="pedido.descripcion"
                          @keyup="errorsDescripcion = []"
                          :rules="[v => !!v || 'Descripcion Es Requerido']"
                          required
                          :error-messages="errorsNombre"
                        ></v-textarea>
                            </v-col>
                        </v-row>                   
                        <v-row>
                          <v-col cols="12" md="6">
                                 <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="date"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                  >
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field	
                                        v-model="date"
                                        label="Fecha de pedido"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker
                                      v-model="date"
                                      no-title
                                      scrollable
                                    >
                                      <v-spacer></v-spacer>
                                      <v-btn
                                        text
                                        color="red"
                                        @click="menu = false"
                                      >
                                        Cancel
                                      </v-btn>
                                      <v-btn
                                        text
                                        color="primary"
                                        @click="$refs.menu.save(date)"
                                      >
                                        OK
                                      </v-btn>
                                    </v-date-picker>
                                  </v-menu>
                          </v-col>
                          <v-col>
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="date"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                  >
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field	
                                        v-model="date"
                                        label="Fecha de entrega"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker
                                      v-model="date"
                                      no-title
                                      scrollable
                                    >
                                      <v-spacer></v-spacer>
                                      <v-btn
                                        text
                                        color="red"
                                        @click="menu = false"
                                      >
                                        Cancel
                                      </v-btn>
                                      <v-btn
                                        text
                                        color="primary"
                                        @click="$refs.menu.save(date)"
                                      >
                                        OK
                                      </v-btn>
                                    </v-date-picker>
                                  </v-menu>
                          </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="pedido.user_id"
                                    :items="arrayUsers"
                                    label="seleccione un usuario"
                                    item-value="id"
                                    item-text="nombre"
                                    
                                ></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="pedido.cliente_id"
                                    :items="arrayClientes"
                                    label="seleccione una Cliente"
                                    item-value="id"
                                    item-text="nombre"
                                ></v-select>
                            </v-col>
                        </v-row>
                        
                      </v-form>
                    </v-container>
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="red darken-1" text @click="cerrarModal">Cerrar</v-btn>
                    <v-btn
                      color="info darken-1"
                      :disabled="!validForm"
                      @click="savePedido()"
                      text
                      v-text="btnTitle"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
         
          <!-- Template que va en la tabla en la columna de Acciones (Editar,Desactivar) -->
        
          <template v-slot:item.action="{item}" v-slot:activator="{ on }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn
                  color="success"
                  elevation="8"
                  small
                  dark
                  :disabled="item.id < 0"
                  v-on="on"
                  @click="showModalEditar(item)"
                >
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
              </template>
              <span>Actualizar Datos</span>
            </v-tooltip>
            <v-tooltip top >
              <template v-slot:activator="{ on }" >
                <v-btn
                  color="info"
                  class="mx-1"
                  elevation="8"
                  small
                  dark
                  :disabled="item.id < 0"
                  v-on="on"
                  @click="deletePedido(item)"
                >
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </template>
              <span>Eliminar Registro</span>
            </v-tooltip>
          </template>
        </v-data-table>
        <v-snackbar v-model="snackbar">
          {{ msjSnackBar }}
          <v-btn color="red" text @click="snackbar = false">Cerrar</v-btn>
        </v-snackbar>
      </v-card>
    </div>
  </div>
</template>
<script>
export default {
  data() {
     return {
      arrayPedidos: [],
      arrayUsers: [],
      arrayClientes: [],
      hTBPedidos: [
        { text: "Nombre", value: "nombre" },
        { text: "Descripcion", value: "descripcion" },
        { text: "Estado", value: "estado" },
        { text: "Fecha Pedido", value: "fecha_pedido"},
        { text: "Fecha entrega", value: "fecha_entrega" },
        { text: "Cliente", value: "cliente" },
        { text: "User", value: "user" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      pedido: {
        id: null,
        nombre: "",
        descripcion: "",
        estado: "",
        fecha_pedido: "",
        fecha_entrega: "",
        cliente_id: null,
        cliente: null,
        user_id: null,
        user: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedPedido: -1
    };
  },
  computed: {
    formTitle() {
      return this.pedido.id === null
        ? "Agregar Pedido"
        : "Actualizar Pedido";
    },
    btnTitle() {
      return this.pedido.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {

    fetchPedidos() {
      let me = this;
      me.loader = true;
      axios.get(`/pedidos/all`)
        .then(function(response) {
          me.arrayPedidos = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
      
        //me.arrayClientes = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
        me.loader = false;
    },
    
    fetchClientes() {
      let me = this;
      me.loader = true;
      axios.get(`/clientes/all`)
        .then(function(response) {
          me.arrayClientes = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
      
     //me.arrayClientes = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
     me.loader = false;
    },

      fetchUsers() {
      let me = this;
      me.loader = true;
      axios.get(`/users/all`)
        .then(function(response) {
          me.arrayUsers = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
      
     //me.arrayClientes = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
     me.loader = false;
    },
    
    
    setMessageToSnackBar(msj, estado) {
      let me = this;
      me.snackbar = estado;
      me.msjSnackBar = msj;
    },
    cerrarModal() {
      let me = this;
      me.dialog = false;
      setTimeout(() => {
        me.pedido = {
          id: null,
        nombre: "",
        descripcion: "",
        estado: "",
        fecha_pedido: "",
        fecha_entrega: "",
        cliente_id: null,
        cliente: null,
        user_id: null,
        user: null
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formPedido.resetValidation();
    },
    showModalEditar(pedido) {
      console.log(pedido);
      let me = this;
      me.editedPedido = me.arrayPedidos.indexOf(pedido);
      me.pedido = Object.assign({}, pedido);
      me.dialog = true;
    },
    savePedido() {
      let me = this;
      if (me.$refs.formPedido.validate()) {
        let accion = me.pedido.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
          me.pedido.estado = "D";
           axios.post('pedidos/save',me.pedido)
            .then(function (response) {
             // console.log(response.statusText);
              if(response.status==201){
              me.verificarAccionDato(response.data, response.status, accion);
              me.cerrarModal();
              }
            })
            .catch(function(error){
              Vue.swal("Error", "Ocurrio Un Error Intente Nuevamente", "error");
            });
            me.loader = false;
        }else{
            //para actualizar
            axios.put(`pedidos/update`,me.pedido)
               .then(function(response) {
              if(response.status==202){
              me.verificarAccionDato(response.data, response.status, accion);
              me.cerrarModal();
              }
            })
            .catch(function(error){
              Vue.swal("Error", "Ocurrio Un Error Intente Nuevamente", "error");
            });
            me.loader = false;
        }
      
      }
    },
    deletePedido(pedido) {
      let me = this;
      me.editedPedido = me.arrayPedidos.indexOf(pedido);
      
      const Toast = Vue.swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        });
        //personalizando nueva confirmacion
        console.log(pedido);
        Vue.swal.fire({
        title: 'Eliminar Pedido',
        text: "Una vez realizada la acción no se podra revertir !",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: "No"
        
        }).then((result) => {
        if (result.value) {
            me.loader = true;
            console.log(pedido);
            axios.post(`pedidos/delete`,pedido)
            .then(function(response) {
              console.log(response.data);
              me.verificarAccionDato(response.data.data, response.status, "del");
              me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(pedido, statusCode, accion) {
      let me = this;
      
      const Toast = Vue.swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        }); 
      switch (accion) {
        case "add":
          //Agrego al array de clientes el objecto que devuelve el Backend
          //me.arrayClientes.unshift(cliente);
          this.fetchPedidos(); 
          Toast.fire({
            icon: 'success',
            title: 'Pedido Registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de clientes el objecto que devuelve el Backend ya con los datos actualizados
          //Object.assign(me.arrayClientes[me.editedCliente], cliente);
          this.fetchPedidos(); 
          Toast.fire({
            icon: 'success',
            title: 'Pedido Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Clientes Activos si todo esta bien en el backend
              me.arrayPedidos.splice(me.editedPedido, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Pedido Eliminado...!!!'
              });
            } catch (error) {
              console.log(error);
            }
          } else {
             Toast.fire({
                icon: 'error',
                title: 'Ocurrió un error, intente de nuevo'
              });
          }
          break;
      }
    }
  },
  mounted() {
    let me = this;
    me.fetchPedidos();
    me.fetchClientes();
    me.fetchUsers();
  }
};
</script>




<