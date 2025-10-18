Easyturnos

Sistema de gestión de turnos / filas para empresas y usuarios.  
Permite que los usuarios soliciten turnos, y los administradores o cajeros los gestionen desde un panel web.  

📋 Tabla de contenido

1. [Características](#-características)  
2. [Requisitos](#-requisitos)  
3. [Instalación](#-instalación)  
4. [Configuración](#-configuración)  
5. [Uso](#-uso)  
6. [Estructura del proyecto]
7. [Contribuciones](#-contribuciones)  
8. [Licencia](#-licencia)  

🔍 Características

- Registro e inicio de sesión de usuarios (administradores, cajeros).  
- Solicitud de turno por parte de usuarios.  
- Gestión de cajas / ventanillas (o puntos de atención).  
- Panel administrativo para ver, editar, asignar, eliminar turnos.  
- Visualización de turnos activos, pendientes, atendidos.  
- Interfaz web responsiva con HTML + CSS + JavaScript.  
- Persistencia de datos mediante base de datos MySQL.  
- API interna (por ejemplo en `apiphprelojito`) para manejar lógica de turno / reloj.

🛠️ Requisitos

Para ejecutar este proyecto necesitas:

- Servidor web compatible con PHP (versión >= **7.x**, verificar compatibilidad).  
- Extensión mysqli o PDO para conectarse a MySQL.  
- Servidor de base de datos MySQL / MariaDB.  
- Navegador moderno (Chrome, Firefox, Edge, etc.).  
- Opcional: permisos adecuados en carpetas para lectura / escritura si manejas uploads o logs.

 🚀 Instalación

Sigue estos pasos:

1. Clona el repositorio:

   ```bash
   git clone https://github.com/starlin056/easyturnos.git

2. Copia los archivos al directorio de tu servidor web (por ejemplo htdocs/, www/, public_html/, etc.).


3. Crea una base de datos en MySQL (por ejemplo easyturnos_db).


4. Importa el archivo COPIA.sql al esquema de la base de datos, para crear las tablas iniciales.


5. Configura la conexión a la base de datos.

host = "localhost";
username = "root";
password = "";
database = "easyturnos_db";


6. Asegúrate de que el servidor web tenga permisos adecuados para acceder a los archivos.


7. Accede al proyecto desde tu navegador apuntando al directorio raíz del proyecto (por ejemplo, http://localhost/easyturnos/index.php).

⚙️ Configuración adicional

Para pasar a producción actualiza las URLs (como en el directorio apiphprelojito/), asegúrate de que las URLs estén bien configuradas (por ejemplo, apuntando al dominio correcto, puerto, prefijos).

Si agrega archivos estáticos (imágenes, CSS, JS), comprueba que las rutas de inclusión sean correctas (relativas o absolutas según tu estructura).

Si necesitas SSL (https) para tu entorno productivo, configura tu servidor Apache / Nginx / etc. con certificado SSL.


🧭 Uso / Flujo de trabajo

1. El administrador / cajero inicia sesión.


2. Los usuarios pueden solicitar un turno, ingresando datos necesarios.


3. En el panel administrativo, los cajeros o responsables pueden ver la lista de turnos pendientes, activos y completados.


4. Pueden asignar o redirigir turnos a cajas / ventanillas.


5. Los usuarios pueden consultar el estado de su turno (esperando, en atención, atendido).


6. Se puede editar, eliminar o reprogramar turnos según sea necesario.


los módulos front-end JavaScript pueden hacer llamadas AJAX para actualizar listas de turnos en tiempo real.


📁 Estructura del proyecto (vista general)

Aquí algunos de los archivos y directorios más relevantes:

/apiphprelojito/        # Lógica API / endpoints relacionados con el reloj / turnos  
/easyturno/              # Parte principal de la aplicación  
/pantalla/                # Vistas o pantallas del sistema  
/COPIA.sql                # Archivo SQL con estructura / datos iniciales  
/.gitignore               # Archivos / carpetas ignorados por Git  
...                       # Otras carpetas / archivos CSS, JS, imágenes, etc.

Podrías tener además:

config.php o archivo similar con credenciales de BD.

index.php como punto de entrada.

Carpetas assets/ o public/ con CSS, JS, imágenes.

Archivos de plantilla (header, footer) para reutilización.

Scripts JS para manejo dinámico de la lista de turnos.


🤝 Contribuciones

Puedes contribuir al proyecto de la siguiente forma:

Reportando issues con errores, bugs o propuestas de mejora.

Enviando pull requests con nuevas funcionalidades, mejoras de seguridad, refactorización.

Mejorando la documentación (tutoriales, capturas, ejemplos de uso).

Escribiendo pruebas unitarias o de integración (si deseas agregarlas).


Por favor, sigue estas buenas prácticas:

Realiza tus cambios en una rama separada (no en main).

Asegúrate de que tu código esté bien documentado.

Verifica que no rompa funcionalidades existentes.

continuemos ampliando el sistemas.

📜 Licencia

Este proyecto puede licenciarse con la licencia que dese es. Una opción común es MIT License.

MIT License

Copyright (c) 2025 Pedro starlin ureña cruz.

Se concede permiso, sin cargo, a toda persona que obtenga una copia
de este software y los archivos de documentación asociados (el “Software”),
para usarlo, copiarlo, modificarlo, fusionarlo, publicarlo, distribuirlo,
sublicenciarlo y/o vender copias del Software, y permitir a las personas a quienes
se les proporcione el Software que lo hagan, sujeto a las siguientes condiciones:

El aviso de copyright y este permiso deberán incluirse en todas las copias
o partes sustanciales del Software.

EL SOFTWARE SE PROPORCIONA “TAL CUAL”, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA
O IMPLÍCITA, INCLUIDAS PERO NO LIMITADAS A LAS GARANTÍAS DE COMERCIALIZACIÓN,
IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO
LOS AUTORES O TITULARES DEL COPYRIGHT SERÁN RESPONSABLES POR RECLAMOS, DAÑOS
U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN DE CONTRATO, AGRAVIO
O DE OTRO TIPO, QUE SURJAN DE, FUERA O EN CONEXIÓN CON EL SOFTWARE
O EL USO U OTROS TRATOS EN EL SOFTWARE.


