<template>
  <div class="content">
    <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
      </v-overlay>
      <v-card>
        <v-card-title>
          Inventario de Articulos
          <div class="flex-grow-1"></div>
          <v-text-field v-model="search" label="Buscar Articulo" hide-details></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="hTBArticulos"
          :items="arrayArticulos"
          :footer-props="{
            'items-per-page-options': [5,10, 20, 30,40],
            'items-per-page-text' : 'Registros Por Página'
          }"
          :items-per-page="5"
          :search="search"
          multi-sort
          class="elevation-1"
        >
          <!-- Template Para Modal de Actualizar y Agregar articulos-->

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
                      <v-form ref="formArticulo" v-model="validForm" :lazy-validation="true">
                        <v-row>
                            <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="articulo.codigo"
                          label="Codigo"
                        ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="articulo.nombre"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Nombre Es Requerido']"
                          label="Nombre"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                      </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="6">
                        <v-textarea
                          label="Description"
                          no-resize
                          rows="1"
                          v-model="articulo.descripcion"
                          @keyup="errorsDescripcion = []"
                          :rules="[v => !!v || 'Descripcion Es Requerido']"
                          required
                          :error-messages="errorsNombre"
                        ></v-textarea>
                            </v-col>
                            <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="articulo.existencia"
                          label="Existencia"
                        ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="articulo.tipo"
                          label="Tipo"
                        ></v-text-field>
                            </v-col>
                        <v-col cols="12" md="6">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="articulo.precio"
                          label="Precio"                        
                        ></v-text-field>
                            </v-col>
                        </v-row>
                          
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="articulo.color_id"
                                    :items="arrayColores"
                                    label="seleccione una color"
                                    item-value="id"
                                    item-text="nombre"
                                    
                                ></v-select>
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="articulo.categoria_id"
                                    :items="arrayCategorias"
                                    label="seleccione una Categoria"
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
                      @click="saveArticulo()"
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
                  @click="deleteArticulo(item)"
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
      arrayArticulos: [],
      arrayColores: [],
      arrayCategorias: [],
      hTBArticulos: [
        { text: "Codigo", value: "codigo" },
        { text: "Nombre", value: "nombre" },
        { text: "Descripcion", value: "descripcion" },
        { text: "Tipo", value: "tipo" },
        { text: "Precio", value: "precio"||currency },
        { text: "Estado", value: "estado"},
        { text: "Existencia", value: "existencia" },
        { text: "Categoría", value: "categoria" },
        { text: "Color", value: "color" },
        { text: "Acciones", value: "action", sortable: false, align: "center" }
      ],
      loader: false,
      search: "",
      dialog: false,
      articulo: {
        id: null,
        codigo: "",
        nombre: "",
        descripcion: "",
        tipo: "",
        precio: "",
        existencia: "",
        estado: "",
        categoria_id: null,
        categoria: null,
        color_id: null,
        color: null
      },
      validForm: true,
      snackbar: false,
      msjSnackBar: "",
      errorsNombre: [],
      editedArticulo: -1
    };
  },
  computed: {
    formTitle() {
      return this.articulo.id === null
        ? "Agregar Articulo"
        : "Actualizar Articulo";
    },
    btnTitle() {
      return this.articulo.id === null ? "Guardar" : "Actualizar";
    }
  },
  methods: {

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
      
        //me.arrayCategorias = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
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
      
     //me.arrayCategorias = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
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
      
     //me.arrayCategorias = [{"id":"1","nombre":"Hardware"},{"id":"2","nombre":"Accesorios"}];
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
        me.articulo = {
          id: null,
        codigo: "",
        nombre: "",
        descripcion: "",
        tipo: "",
        precio: "",
        existencia: "",
        estado: "",
        categoria_id: null,
        categoria: null,
        color_id: null,
        color: null
        };
        me.resetValidation();
      }, 300);
    },
    resetValidation() {
      let me = this;
      me.errorsNombre = [];
      me.$refs.formArticulo.resetValidation();
    },
    showModalEditar(articulo) {
      console.log(articulo);
      let me = this;
      me.editedArticulo = me.arrayArticulos.indexOf(articulo);
      me.articulo = Object.assign({}, articulo);
      me.dialog = true;
    },
    saveArticulo() {
      let me = this;
      if (me.$refs.formArticulo.validate()) {
        let accion = me.articulo.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
          me.articulo.estado = "D";
           axios.post('articulos/save',me.articulo)
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
            axios.put(`articulos/update`,me.articulo)
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
    deleteArticulo(articulo) {
      let me = this;
      me.editedArticulo = me.arrayArticulos.indexOf(articulo);
      
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
        console.log(articulo);
        Vue.swal.fire({
        title: 'Eliminar Articulo',
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
            console.log(articulo);
            axios.post(`articulos/delete`,articulo)
            .then(function(response) {
              console.log(response.data);
              me.verificarAccionDato(response.data.data, response.status, "del");
              me.loader = false;
            })
          }
        });
    },
     verificarAccionDato(articulo, statusCode, accion) {
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
          //Agrego al array de categorias el objecto que devuelve el Backend
          //me.arrayCategorias.unshift(categoria);
          this.fetchArticulos(); 
          Toast.fire({
            icon: 'success',
            title: 'Articulo Registrado con Exito'
           });
          me.loader = false;
          break;
        case "upd":
          //Actualizo al array de categorias el objecto que devuelve el Backend ya con los datos actualizados
          //Object.assign(me.arrayCategorias[me.editedCategoria], categoria);
          this.fetchArticulos(); 
          Toast.fire({
            icon: 'success',
            title: 'Articulo Actualizado con Exito'
           }); 
            
          me.loader = false;
          break;
        case "del":
          if (statusCode == 200) {
            try {
              //Se elimina del array de Categorias Activos si todo esta bien en el backend
              me.arrayArticulos.splice(me.editedArticulo, 1);
              //Se Lanza mensaje Final
              Toast.fire({
                icon: 'success',
                title: 'Articulo Eliminado...!!!'
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
    me.fetchArticulos();
    me.fetchCategorias();
    me.fetchColores();
  }
};
</script>