var appautoturno = new Vue({
    el: '#appautoturno',
    data() {
        return {
          validarinput:true,
          verdatoscliente:false,
          verteclado:false,
          pnombre:"",
          papellido:"",
          deshabilitarinput:false,
          registrarcliente:0,
          departamento: '',
          municipio: '',
          sede: '',
          departamentos: '',
          municipios: '',
          sedes: '',
            establecersede:true,
            escribirdocumento:false,
            anioymes: "",
            hora: "",
            tipodocumento: "",
            documentoafiliado: "",
            numeroturno: "",
            servicios: "",

        }
    },
    created() {
        this.servicios_activos();
        if(localStorage.getItem("departamento") && localStorage.getItem("municipio") && localStorage.getItem("sede_usuario")){
            this.escribirdocumento =true;
            this.establecersede =false;
        }
        this.getdepartamentos();
    },
    mounted() {
        this.$refs.documentoafi.focus();
        setInterval(() => {
            this.fechayhoraactual();
        }, 1000);
    },
    methods: {
llenareste(cual){
if(cual == 1){
    this.validarinput = true;
}else{
    this.validarinput = false;
}
},
llenarnombres(nombre){
    if(this.validarinput == true){
        this.pnombre += nombre;
    }else{
        this.papellido += nombre;
    }
},
limpiarnombre() {
  if (this.validarinput == true) {
      this.pnombre = this.pnombre.slice(0, -1); // Borra el último carácter
  } else {
      this.papellido = this.papellido.slice(0, -1); // Borra el último carácter
  }
},

/* limpiarnombre(){
    if(this.validarinput == true){
       var texto = this.pnombre;
       texto = texto.substring(0, texto.length - 1);
    }else{
        var texto1 = this.papellido;
        texto1 = texto1.substring(0, texto1.length - 1);
    }
},*/
        servicios_activos() {
            var ver ="sede";
            const datossede ={
                departamento:localStorage.getItem("departamento"),
                municipio:localStorage.getItem("municipio"),
                sede_usuario:localStorage.getItem("sede_usuario")
          }
            axios.post("http://localhost/apiphprelojito/public/servicios_por_sede",ver,{headers:datossede})
              .then((respuesta) => {
                this.servicios = respuesta.data;
              }).catch((error) => {
                if(error.response.status == 400){
                   this.$swal.fire(
                    "Ups!!",
                    "Token Invalido Cierre Session e Ingrese de Nuevo",
                    "error"
                  );
                }
              });
        },
      sedes_activas() {
        setTimeout(() => {
          const peticion = {
               departamento:this.departamento,
               municipio:this.municipio
             };
             axios.post("http://localhost/apiphprelojito/public/pantalla_sedes",peticion)
               .then((respuesta) => {
                 this.sedes = respuesta.data;
               }).catch((error) => {
                 if(error.response.status == 400){
                    Swal.fire(
                     "Ups!!",
                     "Token Invalido Cierre Session e Ingrese de Nuevo",
                     "error"
                   );
                 }
               });
       }, 2000);
      },
        getdepartamentos() {
        axios.post("http://localhost/apiphprelojito/public/pantalladepartamentos")
        .then((response) => {
            this.departamentos = response.data;
         }).catch((error) => {
              if(error.response.status == 400){
                 Swal.fire(
                  "Ups!!",
                  "Token Invalido Cierre Session e Ingrese de Nuevo",
                  "error"
                );
              }
            });
      },
      getmunicipios(){
        const tokenpeticion = {
          id_departamento: this.departamento,
        };
        axios.post("http://localhost/apiphprelojito/public/pantallamunicipios",tokenpeticion )
        .then((response) => {
            this.municipios = response.data;
           }).catch((error) => {
              if(error.response.status == 400){
                 Swal.fire(
                  "Ups!!",
                  "Token Invalido Cierre Session e Ingrese de Nuevo",
                  "error"
                );
              }
            });
      },
      generar_turno_sede(){
        if(this.departamento =="" || this.departamento == null || this.departamento == undefined ||
        this.municipio =="" || this.municipio == null || this.municipio == undefined ||
        this.sede =="" || this.sede == null || this.sede == undefined){
          Swal.fire(
            "Intentar de nuevo",
            "Por favor Seleccionar la sede",
            "info"
          );
        } else {
            localStorage.setItem("departamento", this.departamento);
            localStorage.setItem("municipio", this.municipio);
            localStorage.setItem("sede_usuario", this.sede);
          this.escribirdocumento =true;
          this.establecersede =false;
        }
      },
        llenardocumento(numero) {
            this.documentoafiliado += numero;
        },
        limpiar() {
            this.documentoafiliado = "";
            this.$refs.documentoafi.focus();
        },
        fechayhoraactual() {
            let fecha, horas, minutos, segundos, diaSemana, dia, mes, anio;
            fecha = new Date();
            horas = fecha.getHours();
            minutos = fecha.getMinutes();
            segundos = fecha.getSeconds();
            diaSemana = fecha.getDay();
            dia = fecha.getDate();
            mes = fecha.getMonth();
            anio = fecha.getFullYear();
            let semana = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
            let diasemana = semana[diaSemana];
            let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            let mesnombre = meses[mes];
            this.anioymes = diasemana + ' ' + dia + ' ' + 'de' + ' ' + mesnombre + ' ' + 'del' + ' ' + anio;
            let ampm;
            if (horas >= 12) {
                horas = horas - 12;
                ampm = "PM"
            } else {
                ampm = "AM";
            }
            if (horas == 0) { horas = 12; }
            if (minutos < 10) { minutos = "0" + minutos; }
            if (segundos < 10) { segundos = "0" + segundos; }
            this.hora = horas + ' : ' + minutos + ' : ' + segundos + ' ' + ampm;
        },
        buscarCedula(documento) {
            if (documento == "" || documento == undefined || documento == null) {
              Swal.fire(
                "Intentar de nuevo",
                "Por favor Especificar un numero de documento",
                "info"
              );
            } else if (documento != "" || documento != undefined || documento != null) {
              axios.post("http://localhost/apiphprelojito/public/buscarautoafiliado",{documento:documento})
                .then((respuesta) => {
                  this.verdatoscliente = true;
                  this.escribirdocumento=false;
                  if(respuesta.data.codigo == 0) {
                    this.deshabilitarinput = true;
                    this.registrarcliente = 0;
                    this.datoasistente = JSON.parse(respuesta.data.datos);
                    this.verteclado = false;
                    this.pnombre = this.datoasistente.pnombre;
                    this.papellido = this.datoasistente.papellido;
                  } else {
                    this.deshabilitarinput = false;
                    this.registrarcliente = 1;
                    this.verteclado = true;
                    // this.$refs.documentoafi.focus();
                    Swal.fire(
                        "Intentar de nuevo",
                        "No se Encontraron datos con este documento",
                        "info"
                      );
                  }
                }).catch((error) => {
                  console.log(error)
                });
            }
          },
        generarturno(numerocedula, tipotramite,inicial,color) {
            if (this.tipodocumento == "" || this.tipodocumento == undefined || this.tipodocumento == null ||
              numerocedula == "" || numerocedula == undefined || numerocedula == null ||
              this.pnombre == "" || this.pnombre == undefined || this.pnombre == null ||
              this.papellido == "" || this.papellido == undefined || this.papellido == null) {
              Swal.fire(
                "Intentar de nuevo",
                "Por favor Especificar un nombre y apellido",
                "info"
              );
            } else if (numerocedula != "" || numerocedula != undefined || numerocedula != null

            ) {
              const tokenpeticion = {
                registrarcliente:this.registrarcliente,
                pnombre:this.pnombre,
                papellido:this.papellido,
                tipodocumento:this.tipodocumento,
                numero_doc: numerocedula,
                tipotramite: tipotramite,
                letrainicial: inicial,
              };
              const datossede ={
                    departamento:localStorage.getItem("departamento"),
                    municipio:localStorage.getItem("municipio"),
                    sede_usuario:localStorage.getItem("sede_usuario")
              }
              axios.post("http://localhost/apiphprelojito/public/generarautoturno", tokenpeticion,{headers:datossede})
                .then((respuesta) => {
                  this.limpiardatos();
                  if (respuesta.data.codigo == 0) {
                    this.$refs.documentoafi.focus();
                    this.numeroturno=respuesta.data.turno;
                    Swal.fire({
                      icon: 'success',
                            showCancelButton: true,
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok Para Imprimir',
                            cancelButtonText: 'No Imprimir',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                                cancelButton: 'btn btn-danger'
                              },
                              title: ' Su Numero De Turno:',
                              html: '<div class="btn '+color+'">' +
                                  '<span><h1 style="color:white;font-size: 3rem;">' + respuesta.data.turno + '</h1></span>' +
                                  '</div>',
                        showConfirmButton: true,
                        allowOutsideClick: false
                  }).then((result) => {
                    if (result.isConfirmed) {
                        this.imprimirturno(respuesta.data);
                      } else if (result.isDenied) {

                      }
                })
              } else {
                    Swal.fire(
                      "Ups!!",
                      "No se Logro Generar el turno",
                      "info"
                    );
                  }
                }).catch((error) => {
                 console.log(error);
                });
            }
          },
          imprimirturno(data){
            var fechaparaenviar = new Date();
            var hour = fechaparaenviar.getHours();
            var formattedHour = (hour % 12 === 0) ? 12 : hour % 12;
            var ampm = hour >= 12 ? 'PM' : 'AM';
            var formattedDateTime = `${fechaparaenviar.toLocaleDateString()} ${formattedHour}:${fechaparaenviar.getMinutes().toString().padStart(2, '0')}:${fechaparaenviar.getSeconds().toString().padStart(2, '0')} ${ampm}`;
          var mywindow = window.open('', 'imprimir turno', 'height=400,width=600,scrollbars=NO');
          mywindow.document.write('<html><head><title>Su Turno Es</title>');
          mywindow.document.write('</head><body >');
          mywindow.document.write('<h3 style="text-align: center;align-content: center;">' + 'Su Numero de turno es' + '</h3>');
          mywindow.document.write('<h1 style="text-align: center;align-content: center;">' + data.turno + '</h1>');
          mywindow.document.write('<h5 style="text-align: center;align-content: center;">' + formattedDateTime + '</h5>');
          mywindow.document.write('</body></html>');
          mywindow.document.close(); 
          mywindow.focus(); 
          mywindow.print();
          mywindow.close();
          setTimeout(() => {
              $('button > .print').click(function(e){
                  alert('print');
                  })
                  
          }, 5000);
          },
          limpiardatos(){
            this.escribirdocumento=true;
            this.documentoafiliado = "";
            this.registrarcliente = 0;
            this.pnombre="";
            this.papellido= "";
            this.tipodocumento= "";
            this.verdatoscliente = false;
            this.verteclado = false;
          }
    }
})