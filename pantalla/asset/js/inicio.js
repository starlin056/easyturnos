// var socket = io('ws://localhost:3000');
var appinicio = new Vue({
    el: '#appinicio',
    data() {
        return {
            departamento: '',
          municipio: '',
          sede: '',
          departamentos: '',
          municipios: '',
          sedes: '',
            establecersede:true,
            verturnospantalla:false,
            anioymes: "",
            hora: "",
            listadoturnos: [],
            datosunicollamado:"",

        }
    },
    created() {
        if(localStorage.getItem("departamento") && localStorage.getItem("municipio") && localStorage.getItem("sede_usuario")){
            this.verturnospantalla =true;
              this.establecersede =false;
        }
        this.getdepartamentos();
        // socket.on('listaturnos', (msg) => {
        //     this.llamarturnotv();
        //     console.log(msg);
        // });
        // socket.on('llamarturno', (msg) => {
        //     this.datosunicollamado = msg[0][0];
        //     console.log(msg);
        //     this.verelturnoentv(this.datosunicollamado);
        // });
    },
    mounted() {
        setInterval(() => {
            this.fechayhoraactual();
          }, 1000);
          setInterval(() => {
            this.llamarturnotv();
          }, 2000);
    },
    methods: {
        llamarturnotv(){
            var ver ="sede";
            const datossede ={
                departamento:localStorage.getItem("departamento"),
                municipio:localStorage.getItem("municipio"),
                sede_usuario:localStorage.getItem("sede_usuario")
          }
          axios.post("http://localhost/apiphprelojito/public/pantallatv",ver,{headers:datossede})
            .then((respuesta) => {
                this.listadoturnos = respuesta.data;
                for (let i = 0; i < this.listadoturnos.length; i++) {
                  if(this.listadoturnos[i].turno_departamento == datossede.departamento && 
                    this.listadoturnos[i].turno_municipio == datossede.municipio && 
                    this.listadoturnos[i].turno_sede == datossede.sede_usuario && this.listadoturnos[i].llamado_turno == 1){
                      this.verelturnoentv(this.listadoturnos[i]);
                      this.terminarllamado(this.listadoturnos[i]);
                    }
                }
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
        verelturnoentv(datosunicoturno){
            if(datosunicoturno.turno_departamento == localStorage.getItem("departamento") &&
            datosunicoturno.turno_municipio == localStorage.getItem("municipio") &&
            datosunicoturno.turno_sede == localStorage.getItem("sede_usuario")){
                var ver ="sede";
                const datossede ={
                    departamento:localStorage.getItem("departamento"),
                    municipio:localStorage.getItem("municipio"),
                    sede_usuario:localStorage.getItem("sede_usuario")
              }
              axios.post("http://localhost/apiphprelojito/public/verelturnotv",ver,{headers:datossede})
                .then((respuesta) => {
                    var resultado = respuesta.data[0];
                    if(resultado.turno_departamento ==localStorage.getItem("departamento") &&
                    resultado.turno_municipio == localStorage.getItem("municipio") &&
                    resultado.turno_sede == localStorage.getItem("sede_usuario")){
                      // sonido al llamar
                         var audio = new Audio("/pantalla/asset/multimedia/timbre1.MP3" ); // Ruta del sonido
                         audio.play();
                           // voz al llamar seguir trabajando el error que no se pronuncia bien al tener numero, verificar variales y el responsivevoice
                          //var turnovoz =  'Turno '+ resultado.turno.toLowerCase()+'. '+resultado.clienteminusculas+'. Modulo'+ resultado.modulo
                          //this.audio(turnovoz);
                             Swal.fire({
                            showConfirmButton: false,
                            //manejo de ancho y tiempo de llamado en pantalla
                            width: 1250,
                            timer: 8000,
                            html: '<h3><table class="table table-bordered table-striped">'+
                '<tr>'+
                  '<th class="text-center"><h1 class="fw-bold text-underline tamanoletra">TURNO</h1></th>'+
                  '<th class="text-center"><h1 class="fw-bold text-underline tamanoletra">AFILIADO</h1></th>'+
                  '<th class="text-center"><h1 class="fw-bold text-underline tamanoletra">MODULO</h1></th>'+
                '</tr>'+
                '<tr class="movimiento">'+
                  '<td class="text-center"><h1 class="fw-bold text-white tamanoletra"><b>'+resultado.turno+'</b></h1></td>'+
                  '<td class="text-center"><h1 class="fw-bold text-white tamanoletra"><b>'+resultado.clientemayusculas+'</b></h1></td>'+
                  '<td class="text-center"><h1 class="fw-bold text-white tamanoletra"><b>'+resultado.modulo+'</b></h1></td>'+
                '</tr>'+
              '</table></h3>'
               // +
             // '<audio id="denied" autoplay controls="false" style="display:none"> <source src="/pantalla/asset/multimedia/timbre1.MP3" /> </audio>'
                          })
                    }
                }).catch((error) => {
                  if(error.response.status == 400){
                     Swal.fire(
                      "Ups!!",
                      "Token Invalido Cierre Session e Ingrese de Nuevo",
                      "error"
                    );
                  }
                });
            }

        },
        terminarllamado(datosturno){
          var turnoterminadollamado =datosturno.id;
          const datossede ={
              departamento:localStorage.getItem("departamento"),
              municipio:localStorage.getItem("municipio"),
              sede_usuario:localStorage.getItem("sede_usuario")
        }
        axios.post("http://localhost/apiphprelojito/public/terminarllamadopantalla",turnoterminadollamado,{headers:datossede})
          .then((respuesta) => {
              console.log(respuesta.data);
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
          verturnospantallasede(){
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
              this.verturnospantalla =true;
              this.establecersede =false;
            }
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
       /* },
           audio(textoaudio){
          const voices = speechSynthesis.getVoices();
       let speaking = false;

       const hablar = (textoaudio) => {
           if (speaking) return; // No permitir que se hable si ya está hablando
       
           const utterance = new SpeechSynthesisUtterance(textoaudio);
           utterance.voice = voices[2];
           utterance.lang = 'es-ES';
           utterance.pitch = 0.2;
           
           utterance.onstart = () => { speaking = true; };
           utterance.onend = () => { speaking = false; };
       
           speechSynthesis.speak(utterance);
       };
       hablar(textoaudio); */
            // const tokenpeticion = {
            //   text: texto,
            // };
            // axios.post("http://localhost:3000/synthesize",tokenpeticion,{
            //   responseType: 'arraybuffer'
            // })
            // .then((response) => {
            //   const audioBlob = new Blob([response.data], { type: 'audio/mp3' });
            //   const audioUrl = URL.createObjectURL(audioBlob);
            //   const audioElement = new Audio(audioUrl);
            //   audioElement.play().catch(error => {
            //     console.error('Error al reproducir el audio:', error);
            //   });
            //    }).catch((error) => {
            //       if(error.response.status == 400){
            //          Swal.fire(
            //           "Ups!!",
            //           "Token Invalido Cierre Session e Ingrese de Nuevo",
            //           "error"
            //         );
            //       }
            //     });
          }
    }
})