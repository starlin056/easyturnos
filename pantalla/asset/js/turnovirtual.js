var turnovirtual = new Vue({
  el: '#turnovirtual',
  data() {
    return {
      departamentos:"",
      municipios:"",
      sedes:"",
      sede_departamento:"",
      sede_municipio:"",
      sede_sede:"",
      datosclientes: {
        documento: "",
        numero: "",
        pnombre: "",
        snombre: "",
        papellido: "",
        sapellido: "",
        celular: "",
        correo: ""
      },
      reservaagendada: "",
      deshabilitarcampo: 0,
      deshabilitarcampo2: 0,
      verdatosbusqueda: true,
      verdatocliente: false,
      versitienereserva: false,
      vercalendario: false,
      vercalendario1: false,
      verhoras: false,
      date: new Date(),
      // prueba:"A",
      datos: [],
      datoshoras: "",
      selectedDate: new Date(),
      attributes: "",
      documentoagendar: ""
    }
  },
  created() {
  },
  mounted() {
  },
  computed: {
  },
  methods: {
    getdepartamentos() {
      axios.post("https://apirelojito.grupof23.com/pantalladepartamentos")
        .then((response) => {
          this.departamentos = response.data.turno;
        }).catch((error) => {
          if (error.response.status == 400) {
            this.$swal.fire(
              "Ups!!",
              "Token Invalido Cierre Session e Ingrese de Nuevo",
              "error"
            );
          }
        });
    },
    getmunicipios() {
      const tokenpeticion = {
        id_departamento: this.sede_departamento,
      };
      axios.post("https://apirelojito.grupof23.com/pantallamunicipios", tokenpeticion)
        .then((response) => {
          this.municipios = response.data.turno;
        }).catch((error) => {
          if (error.response.status == 400) {
            this.$swal.fire(
              "Ups!!",
              "Token Invalido Cierre Session e Ingrese de Nuevo",
              "error"
            );
          }
        });
    },
    sedes_activas() {
      const peticion = {
        departamento: this.sede_departamento,
        municipio: this.sede_municipio
      };
      axios.post("https://apirelojito.grupof23.com/pantalla_sedes", peticion)
        .then((respuesta) => {
          this.sedes = respuesta.data.turno;
        }).catch((error) => {
          if (error.response.status == 400) {
            this.$swal.fire(
              "Ups!!",
              "Token Invalido Cierre Session e Ingrese de Nuevo",
              "error"
            );
          }
        });
    },

    formatDate(date) {
      var d = new Date(date);
      var dd = ('0' + d.getDate()).slice(-2);
      var mm = ('0' + (d.getMonth() + 1)).slice(-2);
      var yyyy = d.getFullYear();
      var hh = d.getHours();
      var mi = d.getMinutes();
      return dd + '/' + mm + '/' + yyyy; //+' '+hh+':'+mi+':00';
    },
    buscar_cliente() {
      if(this.datosclientes.documento == "" || this.datosclientes.documento == null || this.datosclientes.documento == undefined ||
      this.datosclientes.numero == "" || this.datosclientes.numero == null || this.datosclientes.numero == undefined) {
          Swal.fire({
            // position: 'top-end',
            icon: 'info',
            title: 'Por favor Diligencie los campos tipo documento y numero',
            showConfirmButton: false,
            timer: 1500
          })
      } else {
      const datos = {
        documento: this.datosclientes.numero
      }
      axios.post("https://apirelojito.grupof23.com/buscarautoafiliado", datos)
        .then((respuesta) => {
          if (respuesta.data.mensaje.length != 0) {
            this.datosclientes = respuesta.data.mensaje[0];
            this.verdatocliente = true;
            this.verdatosbusqueda = false;
            this.deshabilitarcampo = 1;
            Swal.fire(
              "Exito",
              "Persona encontrada",
              "success"
            );
          } else {
            this.verdatocliente = true;
            this.verdatosbusqueda = false;
            this.deshabilitarcampo = 0;
            this.deshabilitarcampo2 = 1;
            Swal.fire(
              "Ups!!",
              "Persona no encontrada por favor registrese",
              "info"
            );
          }
        }).catch((error) => {
          if (error.response.status == 400) {
            swal.fire(
              "Ups!!",
              "Token Invalido Cierre Session e Ingrese de Nuevo",
              "error"
            );
          }
        });
      }
    },
    agregaroconfirmarcliente(documento) {
      if(this.datosclientes.documento == "" || this.datosclientes.documento == null || this.datosclientes.documento == undefined ||
      this.datosclientes.numero == "" || this.datosclientes.numero == null || this.datosclientes.numero == undefined ||
      this.datosclientes.pnombre == "" || this.datosclientes.pnombre == null || this.datosclientes.pnombre == undefined ||
      this.datosclientes.papellido == "" || this.datosclientes.papellido == null || this.datosclientes.papellido == undefined ) {
          Swal.fire({
            icon: 'info',
            title: 'Por favor Diligencie los campos',
            showConfirmButton: false,
            timer: 1500
          })
      } else {
      this.documentoagendar = documento;
      axios.post("https://apirelojito.grupof23.com/confirmarcliente", this.datosclientes)
        .then((respuesta) => {
          if (respuesta.data.datos.id == 0) {
            // this.traerfechasdisponibles();
            this.getdepartamentos();
            this.verdatosbusqueda = false;
            this.verdatocliente = false;
            this.versitienereserva = false;
            this.vercalendario = true;
            this.vercalendario1 = false;
            this.verhoras = false;
            Swal.fire(
              "Exito",
              "Seleccionar fecha y Hora de Reserva",
              "success"
            );
          } else if (respuesta.data.datos.id == 1) {
            this.reservaagendada = respuesta.data.datos;
            this.verdatosbusqueda = false;
            this.verdatocliente = false;
            this.versitienereserva = true;
            this.vercalendario = false;
            this.vercalendario1 = false;
            this.verhoras = false;
            Swal.fire(
              "Ups!!",
              "Ya tiene una reserva Activa puede reagendar o cancelar la reserva",
              "info"
            );
          }
        }).catch((error) => {
          if (error.response.status == 400) {
            swal.fire(
              "Ups!!",
              "Token Invalido Cierre Session e Ingrese de Nuevo",
              "error"
            );
          }
        });
      }
    },

    reagendar(datoreserva) {
      // this.traerfechasdisponibles();
      this.getdepartamentos();
      this.verdatosbusqueda = false;
      this.verdatocliente = false;
      this.versitienereserva = false;
      this.vercalendario = true;
      this.vercalendario1 = false;
      this.verhoras = false;
    },

    traerfechasdisponibles() {
      const datos = {
        sede: this.sede_sede
      }
      axios.post("https://apirelojito.grupof23.com/traerfechas",datos)
        .then((respuesta) => {
          if (respuesta.data.mensaje.length != 0) {
            this.verdatosbusqueda = false;
            this.verdatocliente = false;
            this.versitienereserva = false;
            this.vercalendario = true;
            this.vercalendario1 = true;
            this.verhoras = false;

            const ultimoElemento = respuesta.data.mensaje[respuesta.data.mensaje.length - 1]
            this.ultimafechaactiva = ultimoElemento.id_fecha;

            this.datos = respuesta.data.mensaje.map(t => ({
              key: 'today',
              highlight: {
                color: t.cantidadpordia > 0 ? 'blue' : 'red',
                fillMode: 'solid',
                contentClass: 'italic',
              },
              dates: t.id_fecha //los meses van de 0 a 11
            }));
          } else {
            this.vercalendario1 = false;
            Swal.fire(
              "Ups!!",
              "No Hay fechas disponbles",
              "info"
            );
          }
        }).catch((error) => {
          if (error.response.status == 400) {
            swal.fire(
              "Ups!!",
              "Token Invalido Cierre Session e Ingrese de Nuevo",
              "error"
            );
          }
        });
    },
    seleccionar_fecha(fecha) {
      const datosenviar = {
        fecha: this.formatDate(fecha),
        sede:this.sede_sede
      }
      axios.post("https://apirelojito.grupof23.com/verhoras", datosenviar)
        .then((respuesta) => {
          if(respuesta.data.mensaje.length != 0) {
            this.verhoras = true;
            this.datoshoras = respuesta.data.mensaje;
          }else{
             this.verhoras = false;
           swal.fire("Ups!!", "No Hay Horas disponbles", "info");
          }
        }).catch((error) => {
          if (error.response.status == 400) {
            this.$swal.fire(
              "Ups!!",
              "Token Invalido Cierre Session e Ingrese de Nuevo",
              "error"
            );
          }
        });
    },
    seleccionarhora(idagenda) {
      const datosenviar = {
        id_reserva: idagenda.id_reserva,
        documento:this.documentoagendar
      }
      var fecha = this.formatDate(idagenda.id_fecha);
      swal.fire({
        title: "Agendar",
        text: "Esta seguro de Agendar Esta Reserva!",
        icon: "question",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Comfirmar",
        cancelButtonColor: '#d33',
         html: `<div class="col-md-12">
         <h4 class="display-4 mb-0">Esta seguro de reservar para la fecha ${fecha} y hora ${idagenda.id_hora_inicio}</h4>
                </div>`,
      })
      .then((result) => {
        if (result.isConfirmed) {
          axios.post("https://apirelojito.grupof23.com/agendarestafecha",datosenviar)
          .then((respuesta) => {
            console.log(respuesta.data);
            if (respuesta.data.mensaje.id == 0) {
              Swal.fire(
                "Exito",
                "Reservado Exitosamente",
                "success"
              );
              this.iratras(1);
            } else if (respuesta.data.mensaje.id == 1) {
              Swal.fire(
                "Ups!!",
                "Ya tiene una reserva Activa puede reagendar o cancelar la reserva",
                "info"
              );
            }
          }).catch((error) => {
            if (error.response.status == 400) {
              swal.fire(
                "Ups!!",
                "Token Invalido Cierre Session e Ingrese de Nuevo",
                "error"
              );
            }
          });
    }});
    },
    iratras(numero) {
      switch (numero) {
        case 1:
          this.verdatosbusqueda = true;
          this.verdatocliente = false;
          this.versitienereserva = false;
          this.vercalendario = false;
          this.vercalendario1 = false;
          this.verhoras = false;

          this.datosclientes.documento= "";
        this.datosclientes.numero= "";
        this.datosclientes.pnombre= "";
        this.datosclientes.snombre= "";
        this.datosclientes.papellido= "";
        this.datosclientes.sapellido= "";
        this.datosclientes.celular= "";
        this.datosclientes.correo= "";
          break;
        case 2:

          break;
      }
    }
  }
})