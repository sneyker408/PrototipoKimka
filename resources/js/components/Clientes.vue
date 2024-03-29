<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Registro de Clientes
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar Cliente" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBClientes"
          :items="arrayClientes"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar Cliente -->

          <template v-slot:top>
            <v-toolbar flat color="info">
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
                      <v-form ref="formCliente" v-model="validForm" :lazy-validation="true">
                         <v-text-field
                          prepend-icon="mdi-account"
                          v-model="cliente.nombre"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Nombre Es Requerido']"
                          label="Nombre"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        <v-row>
                          <v-col cols="12" md="6">
                         <v-text-field    
                          v-model="cliente.telefono"
                          prepend-icon="mdi-cellphone-basic"                     
                          label="telefono"                                                 
                        ></v-text-field>
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
                      @click="saveCliente()"
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
                  color="#0dcaf0"
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
                  color="red"
                  class="mx-1"
                  elevation="8"
                  small
                  dark
                  :disabled="item.id < 0"
                  v-on="on"
                  @click="deleteCliente(item)"
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
      arrayClientes: [],
      hTBClientes: [
        { text: "Nombre", value: "nombre" },
        { text: "Telefono", value: "telefono" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      cliente: {
        id: null,
        nombre: "",
        telefono:""
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedCliente: -1
    };
  },
  computed: {
    formTitle() {
      return this.cliente.id === null
        ? "Agregar Cliente"
        : "Actualizar Cliente";
    },
    btnTitle() {
      return this.cliente.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {
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
        me.cliente = {
          id: null,
          nombre:"",
          telefono:""
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formCliente.resetValidation();
    },
    showModalEditar(cliente) {
      let me = this;
      me.editedCliente = me.arrayClientes.indexOf(cliente);
      me.cliente = Object.assign({}, cliente);
      me.dialog = true;
    },
    
    saveCliente() {
      let me = this;
      if (me.$refs.formCliente.validate()) {
        let accion = me.cliente.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            axios.post(`clientes/save`,me.cliente)
            .then(function(response) {
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
             })
            .catch(function(error){
                if(error.response.status == 409){
                   me.setMessageToSnackBar("El cliente  ya existe",true);
                   me.errorsNombre = ["Nombre de cliente ya existente", "error"];
                }else{
                   Vue.swal("Error", "Ocurrio un error intente de nuevo","error"); 
                }
            })
        }else{
            //para actualizar
                axios.put(`/clientes/update`,me.cliente)
               .then(function(response) {
                        me.verificarAccionDato(response.data, response.status, accion);
                        me.cerrarModal();
                    
                })
          .catch(function(error) {
            console.log(error);
            me.loader = false;
          });
        }
      
      }
    },
    deleteCliente(cliente) {
      let me = this;
      me.editedCliente = me.arrayClientes.indexOf(cliente);
      
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
        Vue.swal.fire({
        title: 'Eliminar Cliente',
        text: "Una vez realizada la acción no se podra revertir !",
        type: 'question',
        showCancelButton: true,
        confirmButtonCliente: '#3085d6',
        cancelButtonCliente: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: "No"
        }).then((result) => {
        if (result.value) {
            me.loader = true;
            axios.post(`/clientes/delete`, cliente)
            .then(function(response) {
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(cliente, statusCode, accion) {
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
          //Agrego al array de horarios el objecto que devuelve el Backend
          //me.arrayHorarios.unshift(horario);
          this.fetchClientes(); 
          Toast.fire({
            icon: 'success',
            title: 'Cliente registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de horarios el objecto que devuelve el Backend ya con los datos actualizados
          //Object.assign(me.arrayHorarios[me.editedHorario], horario);
          this.fetchClientes(); 
          Toast.fire({
            icon: 'success',
            title: 'Cliente Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Horarios Activos si todo esta bien en el backend
              me.arrayClientes.splice(me.editedCliente, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Cliente Eliminado!'
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
    me.fetchClientes();
  }
};
</script>