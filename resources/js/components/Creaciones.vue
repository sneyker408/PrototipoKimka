<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Inventario de Creaciones
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar Creacion" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBCreaciones"
          :items="arrayCreaciones"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar Creacion -->

          <template v-slot:top>
            <v-toolbar flat color="white">
              <div class="flex-grow-1"></div>
              <!-- <v-btn  small elevation="4" color="red" height="36" dark class="mb-2 botonpdf" href="/creaciones/pdf" target="_blank">
                     Generar PDF&nbsp;
                    <v-icon>file-document-box-multiple-outline</v-icon>
                  </v-btn>-->
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
                      <v-form ref="formCreacion" v-model="validForm" :lazy-validation="true">                      
                      <v-row>
                        <v-col cols="12" md="6">
                          <v-text-field
                          append-icon="mdi-checkbox-multiple-marked-circle"
                          v-model="creacion.codigo"
                          label="Estado"
                        ></v-text-field> 
                        </v-col>
                        <v-col cols="12" md="6">
                          <v-text-field
                          append-icon="mdi-key-outline"
                          v-model="creacion.codigo"
                          label="Código"
                        ></v-text-field> 
                        </v-col>
                          <v-col cols="12" md="6">
                            <v-select
                                v-model="creacion.articulo_id"
                                :items="arrayArticulos"
                                label="Seleccione Articulo"
                                item-value="id"
                                item-text="nombre"
                                @keyup="errorsArticulo = []"
                                :rules="[v => !!v || 'Articulo Es Requerida']"
                                required
                                :error-messages="errorsArticulo"   
                            ></v-select>
                          </v-col>
                          <v-col cols="12" md="6">
                            <v-select
                                v-model="creacion.color_id"
                                :items="arrayColores"
                                label="Seleccione Color"
                                item-value="id"
                                item-text="nombre"   
                            ></v-select>
                          </v-col>
                        </v-row>
                        <v-text-field     
                          append-icon="mdi-alpha-d-circle"                   
                          label="Descripción" 
                          no-resize
                          rows="2" 
                          v-model="creacion.descripcion" 
                          @keyup="errorsDescripcion = []"
                          :rules="[v => !!v || 'Descripcion Es Requerido']"
                          required
                          :error-messages="errorsDescripcion"                       
                        ></v-text-field>
                        <v-row>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-format-list-checks"
                          v-model="creacion.cantidad"
                          @keyup="errorsCantidad = []"
                          :rules="[v => !!v || 'Cantidad Es Requerida']"
                          label="Cantidad"
                          required
                          :error-messages="errorsCantidad"
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">                       
                         <v-text-field         
                         append-icon="mdi-sack"                 
                          label="Precio" 
                          no-resize
                          rows="2" 
                          v-model="creacion.precio" 
                          @keyup="errorsPrecio = []"
                          :rules="[v => !!v || 'Precio Es Requerido']"
                          required
                          :error-messages="errorsPrecio"                       
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
                      @click="saveCreacion()"
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
                  @click="deleteCreacion(item)"
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
      arrayCreaciones: [],
      arrayColores: [],
      arrayArticulos: [],
      hTBCreaciones: [
        { text: "Código", value: "codigo" },
        { text: "Estado", value: "estado" },
        { text: "Articulo", value: "articulo" },
        { text: "Talla", value: "talla" },
        { text: "Color", value: "color" },
        { text: "Descripción", value: "descripcion" },
        { text: "Cantidad", value: "cantidad" },
        { text: "Precio", value: "precio" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      creacion: {
        id: null,
        codigo: "",
        estado:"",
        nombre: "",
        descripcion: "",
        estado: "",
        color_id: null,
        color: null,
        articulo_id: null,
        articulo: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedCreacion: -1
    };
  },
  computed: {
    formTitle() {
      return this.creacion.id === null
        ? "Agregar Creacion"
        : "Actualizar Creacion";
    },
    btnTitle() {
      return this.creacion.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {
    fetchCreaciones() {
      let me = this;
      me.loader = true;
      axios.get(`/creaciones/all`)
        .then(function(response) {
          me.arrayCreaciones = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;
    },
      fetchArticulos() {
      let me = this;
      me.loader = true;
      axios.get(`/articulos/all`)
        .then(function(response) {
          me.arrayArticulos = response.data;
          me.loader = false;
        })
        .catch(function(error) {
          me.loader = false;
          console.log(error);
        });
     me.loader = false;
    },
    fetchColores() {
      let me = this;
      me.loader = true;
      axios.get(`/colores/all`)
        .then(function(response) {
          me.arrayColores = response.data;
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
        me.creacion = {
        id: null,
        codigo: "",
        estado:"",
        nombre: "",
        descripcion: "",
        estado: "",
        color: null,
        articulo: null
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formCreacion.resetValidation();
    },
    showModalEditar(creacion) {
      let me = this;
      me.editedCreacion = me.arrayCreaciones.indexOf(creacion);
      me.creacion = Object.assign({}, creacion);
      me.dialog = true;
    },
    
   saveCreacion() {
      let me = this;
      if (me.$refs.formCreacion.validate()) {
        let accion = me.creacion.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
            me.creacion.estado = "D";
            axios.post(`/creaciones/save`,me.creacion)
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
                axios.put(`/creaciones/update`,me.creacion)
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
    deleteCreacion(creacion) {
      let me = this;
      me.editedCreacion = me.arrayCreaciones.indexOf(creacion);
      
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
        title: 'Eliminar Creacion',
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
            axios.post(`/creaciones/delete`, creacion)
            .then(function(response) {
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(creacion, statusCode, accion) {
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
          this.fetchCreaciones(); 
          Toast.fire({
            icon: 'success',
            title: 'Creacion registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de horarios el objecto que devuelve el Backend ya con los datos actualizados
          //Object.assign(me.arrayHorarios[me.editedHorario], horario);
          this.fetchCreaciones(); 
          Toast.fire({
            icon: 'success',
            title: 'Creacion Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Horarios Activos si todo esta bien en el backend
              me.arrayCreaciones.splice(me.editedCreacion, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Creacion Eliminado!'
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
    me.fetchCreaciones();
    me.fetchArticulos();
    me.fetchColores();
  }
};
</script>
