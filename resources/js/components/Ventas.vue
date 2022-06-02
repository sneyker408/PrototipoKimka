<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Inventario de Ventas
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar Venta" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBVentas"
          :items="arrayVentas"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar Venta -->

          <template v-slot:top>
            <v-toolbar flat color="white">
              <div class="flex-grow-1"></div>
              <v-btn  small elevation="4" color="red" height="36" dark class="mb-2 botonpdf" href="/ventas/pdf" target="_blank">
                     Generar PDF&nbsp;
                    <v-icon>file-document-box-multiple-outline</v-icon>
                  </v-btn>
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
                      <v-form ref="formVenta" v-model="validForm" :lazy-validation="true">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="venta.codigo"
                          label="Código"

                        ></v-text-field>
                         <v-text-field
                          append-icon="laptop"
                          v-model="venta.nombre"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Nombre Es Requerido']"
                          label="Nombre"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                         <v-textarea                          
                          label="Descripción" 
                          no-resize
                          rows="2" 
                          v-model="venta.descripcion" 
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Descripcion Es Requerido']"
                          required
                          :error-messages="errorsNombre"                       
                        ></v-textarea>
                        <v-row>
                          <v-col cols="12" md="6">
                            <v-select
                                v-model="venta.marca_id"
                                :items="arrayMarcas"
                                label="Seleccione Marca"
                                item-value="id"
                                item-text="nombre"
                                ></v-select>
                          </v-col>
                          <v-col cols="12" md="6">
                            <v-select
                                v-model="venta.categoria_id"
                                :items="arrayCategorias"
                                label="Seleccione Categoria"
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
                      @click="saveVenta()"
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
                  @click="deleteVenta(item)"
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
      arrayVentas: [],
      arrayMarcas: [],
      arrayCategorias: [],
      hTBVentas: [
        { text: "cliente", value: "color" },
        { text: "fecha", value: "nombre" },
        { text: "tipo venta", value: "talla" },
        { text: "total", value: "descripcion" },
        { text: "factura", value: "codigo" },
      ],
      loader: false,
      search: "",
      dialog: false,
      venta: {
        id: null,
        codigo: "",
        nombre: "",
        descripcion: "",
        estado: "",
        marca_id: null,
        marca: null,
        categoria_id: null,
        categoria: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedVenta: -1
    };
  },
  computed: {
    formTitle() {
      return this.venta.id === null
        ? "Agregar Venta"
        : "Actualizar Venta";
    },
    btnTitle() {
      return this.venta.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {
    fetchVentas() {
      let me = this;
      me.loader = true;
      axios.get(`/ventas/all`)
        .then(function(response) {
          me.arrayVentas = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;
    },
      fetchCategorias() {
      let me = this;
      me.loader = true;
      axios.get(`/categorias/all`)
        .then(function(response) {
          me.arrayCategorias = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;
    },
    fetchMarcas() {
      let me = this;
      me.loader = true;
      axios.get(`/marcas/all`)
        .then(function(response) {
          me.arrayMarcas = response.data;
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
        me.venta = {
          id: null,
          codigo: "",
          nombre: "",
          descripcion: "",
          marca: null,
          categoria: null
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formVenta.resetValidation();
    },
    showModalEditar(venta) {
      let me = this;
      me.editedVenta = me.arrayVentas.indexOf(venta);
      me.venta = Object.assign({}, venta);
      me.dialog = true;
    },
    
   saveVenta() {
      let me = this;
      if (me.$refs.formVenta.validate()) {
        let accion = me.venta.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            me.venta.estado = "D";
            axios.post(`/ventas/save`,me.venta)
            .then(function(response) {
             // console.log(response.status);
              if(response.status ==201){
                 me.verificarAccionDato(response.data, response.status, accion);
                 me.cerrarModal(); 
                 console.log(response.status);
              }else{
                Vue.swal("Error", "Ocurrio un error, intente de nuevo", "error");
                me.cerrarModal();
              }
            
            })
            .catch(function(error){
               Vue.swal("Error", "Ocurrio un error, intente de nuevo", "error");
            });
            me.loader = false;
        }else{
            //para actualizar
                axios.put(`/ventas/update`,me.venta)
               .then(function(response) {
                 if(response.status==202){
                    me.verificarAccionDato(response.data, response.status, accion);
                        me.cerrarModal();  
                 }else{
                    Vue.swal("Error", "Ocurrio un error, intente de nuevo", "error");
                     me.cerrarModal();
                 }
              })
          .catch(function(error) {
            console.log(error);
            me.loader = false;
          });
        }
      
      }
    },
    deleteVenta(venta) {
      let me = this;
      me.editedVenta = me.arrayVentas.indexOf(venta);
      
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
        title: 'Eliminar Venta',
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
            axios.post(`/ventas/delete`, venta)
            .then(function(response) {
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(venta, statusCode, accion) {
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
          this.fetchVentas(); 
          Toast.fire({
            icon: 'success',
            title: 'Venta registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de horarios el objecto que devuelve el Backend ya con los datos actualizados
          //Object.assign(me.arrayHorarios[me.editedHorario], horario);
          this.fetchVentas(); 
          Toast.fire({
            icon: 'success',
            title: 'Venta Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Horarios Activos si todo esta bien en el backend
              me.arrayVentas.splice(me.editedVenta, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Venta Eliminado!'
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
    me.fetchVentas();
    me.fetchCategorias();
    me.fetchMarcas();
  }
};
</script>
