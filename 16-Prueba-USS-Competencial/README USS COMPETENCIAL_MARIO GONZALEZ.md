
INFORMACIÓN IMPORTANTE 
MISION_STARFLEET_OPS_PROTOCOL_47-A

1) Acceder a 192.168.1.30:8006 desde la URL de nuestro navegador. 
Logearse en proxmox

- Nombre usuario: alumno
- contraseña: Alumno1234 
  
Desde el menú de visualización de Proxmox, buscar en el listado de Máquinas Virtuales y acceder a la nuestra, (mario) mediante botón derecho > iniciar
Máquina virtual PROXMOX

- Login en >Consola de proxmox: 
  Mario login: mario
  Password: Abcd1234
  
- Entrar a mi maquina virtual desde PowerShell con SSH (por mayor comodidad de trabajo) con las credenciales: 
  ssh mario@192.168.1.50 password: Abcd1234
  
  contraseña: largavidayprosperidad (tras descifrar jeroglífico)
- Asignarle una IP estática, en mi caso defino la 192.168.1.50

En este punto hago un INCISO para explicar que he cambiado la contraseña (ya que la proporcionada es demasiado larga) La cambio DESDE ROOT (si no no aplica el cambio) mediante: 
'sudo mario passwd' 
escribo la nueva que es: Abcd1234 

Tras LogIn en el servidor, el MENSAJE DE LA FLOTA ESTELAR nos indica que la primera misión es la 47-A. 

Haciendo "ll" en mi /home descubro un archivo llamado: 
MISION_STARFLEET_OPS_PROTOCOL_47-A
 
 entro mediante "sudo nano  MISION_STARFLEET_OPS_PROTOCOL_47-A"
 
 Descubro la primera Misión 1: 
 🖖 1. Registro de Entrada — Personalización del Sistema
 Mediante "sudo nano /etc/motd" abro el archivo del mensaje de bienvenida y realizo cambios en él como: 
 
 - Nombre del cadete : CadeteMariete
 - ID del grupo YT1: (Coincidiendo con el de mi compañero de equipo Diego Huamanchumo Grupo1)
 - FECHA ESTELAR: CurDate
 - Entrando en un submódulo de ingeniería de la USS Enterprise NCC-1701-D...
   
   Adjunto captura del NUEVO MENSAJE DE BIENVENIDA: 
   
![[ArchivoDeBienvenida.png]]
Realizado esto, voy con la misión 2: 
🛠️ 2. Instalación del Núcleo de Servicios — Pila LAMP

Para que el nodo pueda comunicarse con otras estaciones de la Flota, debes instalar y activar: Apache, Mysql, PHP. 

Instalo **Apache** mediante: 
'sudo apt update && apt upgrade'
'sudo apt install apache2 -y'
compruebo si el servicio está activo mediante:
'sudo  systemctl status apache2'

Instalo **MySQL** mediante: 
'sudo apt install mysql-server -y'
compruebo si el servicio está activo mediante:
'sudo systemctl status mysql'

Instalo PHP mediante: 
'sudo apt install php -y'

Aprovecho para instalar los módulos más comunes de PHP mediante:
'sudo apt install php-mysql php-cli php-curl php-json php-cgi php-xml php-mbstring -y'

 Ya que lo vamos a correr sobre Apache, instalamos también el modulo mediante: 
 'sudo apt install libapache2-mod-php -y' 

Después reinicio Apache mediante: 
'sudo systemctl restart apache2'

Sigo con la misión3: 
🛡️ 3. Activación del Escudo Deflector — Firewall UFW

Solo deben permitirse:

- Canal de comunicaciones principal (SSH)
  Procedo a levantar el firewall para el puerto 22 mediante: 
  'sudo ufw allow 22'
- Canal web (HTTP / HTTPS) para los puertos 80 y 442 mediante: 
  'sudo ufw allow 80' y 'sudo ufw allow 443'

Mostrar en la web un panel con el “estado del escudo”, es decir, mostrar el estado de puertos abiertos mediante: 'sudo ufw status verbose'

Sigo con misión4: 
📡 4. Registro de Telemetría — JSON + HTML

Creo el archivo JSON vacío con el nombre "diagnóstico" mediante: 
'sudo nano /var/www/html/diagnostico.json'

Una vez abierto el nano, introduzco los campos: 
'{
  "apache_status": "",
  "mysql_status": "",
  "php_version": "",
  "docker_version": "",
  "kernel_version": "",
  "uptime": ""
}'

Compruebo la creación correcta mediante: 
'cat /var/www/html/diagnostico.json'

Ahora debo crear una interface HTML de estilo LCARS que:
- Lea el JSON mediante JavaScript
- Muestre los datos como paneles de la consola de mando
- Sea accesible desde la web principal del host
- Este será el “Panel de Diagnóstico de Ingeniería”.

Procedo creando el archivo index.html en la ruta correcta mediante:
'sudo nano /var/www/html/index.html'

Dentro del sudo introduzco el siguiente código: 

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Diagnóstico de Ingeniería</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Arial, sans-serif;
      background: #000000;
      color: #ffffff;
    }

    .lcars-container {
      padding: 20px;
      background: #000000;
      min-height: 100vh;
      box-sizing: border-box;
    }

    .lcars-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .lcars-title {
      font-size: 28px;
      letter-spacing: 2px;
      text-transform: uppercase;
      padding: 10px 20px;
      background: #ff9966;
      border-radius: 0 25px 25px 0;
    }

    .lcars-subtitle {
      font-size: 14px;
      text-align: right;
      color: #ffcc66;
    }

    .lcars-bar {
      height: 20px;
      background: linear-gradient(to right, #ff9966 0%, #cc66ff 40%, #6699ff 70%, #66ffcc 100%);
      border-radius: 20px;
      margin-bottom: 20px;
    }

    .lcars-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 15px;
    }

    .lcars-panel {
      background: #111111;
      border-radius: 25px;
      padding: 15px;
      position: relative;
      overflow: hidden;
      border: 2px solid #ff9966;
    }

    .lcars-panel::before {
      content: "";
      position: absolute;
      top: -40px;
      right: -40px;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(255, 153, 102, 0.25);
    }

    .lcars-panel-header {
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 10px;
      color: #ffcc66;
    }

    .lcars-panel-value {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .lcars-panel-label {
      font-size: 12px;
      color: #cccccc;
    }

    .status-ok {
      color: #66ff99;
    }

    .status-bad {
      color: #ff6666;
    }

    .status-unknown {
      color: #cccccc;
    }

    .lcars-footer {
      margin-top: 25px;
      font-size: 12px;
      color: #888888;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .lcars-refresh {
      cursor: pointer;
      padding: 5px 12px;
      border-radius: 15px;
      border: 1px solid #ff9966;
      background: #331111;
      color: #ffcc66;
      font-size: 12px;
    }

    .lcars-refresh:hover {
      background: #552222;
    }

    @media (max-width: 600px) {
      .lcars-title {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="lcars-container">
    <div class="lcars-header">
      <div class="lcars-title">
        Panel de Diagnóstico de Ingeniería
      </div>
      <div class="lcars-subtitle">
        USS Servidor Ubuntu<br>
        <span id="last-update">Cargando...</span><br>
        <button class="lcars-refresh" onclick="loadData(true)">Actualizar ahora</button>
      </div>
    </div>

    <div class="lcars-bar"></div>

    <div class="lcars-grid">
      <div class="lcars-panel">
        <div class="lcars-panel-header">Apache</div>
        <div id="apache-status" class="lcars-panel-value status-unknown">---</div>
        <div class="lcars-panel-label">Estado del servicio web (apache2)</div>
      </div>

      <div class="lcars-panel">
        <div class="lcars-panel-header">MySQL</div>
        <div id="mysql-status" class="lcars-panel-value status-unknown">---</div>
        <div class="lcars-panel-label">Estado del servicio de base de datos</div>
      </div>

      <div class="lcars-panel">
        <div class="lcars-panel-header">PHP</div>
        <div id="php-version" class="lcars-panel-value">---</div>
        <div class="lcars-panel-label">Versión de intérprete PHP</div>
      </div>

      <div class="lcars-panel">
        <div class="lcars-panel-header">Docker</div>
        <div id="docker-version" class="lcars-panel-value">---</div>
        <div class="lcars-panel-label">Versión del motor de contenedores</div>
      </div>

      <div class="lcars-panel">
        <div class="lcars-panel-header">Kernel</div>
        <div id="kernel-version" class="lcars-panel-value">---</div>
        <div class="lcars-panel-label">Versión del núcleo del sistema</div>
      </div>

      <div class="lcars-panel">
        <div class="lcars-panel-header">Uptime</div>
        <div id="uptime" class="lcars-panel-value">---</div>
        <div class="lcars-panel-label">Tiempo activo del servidor</div>
      </div>
    </div>

    <div class="lcars-footer">
      <div>
        Panel LCARS simulado para diagnóstico de servidor.<br>
        Datos leídos desde <code>diagnostico.json</code>.
      </div>
      <div>
        Actualización automática cada 30 segundos.
      </div>
    </div>
  </div>

  <script>
    function setStatus(elementId, status) {
      const el = document.getElementById(elementId);
      if (!el) return;

      el.classList.remove("status-ok", "status-bad", "status-unknown");

      const normalized = (status || "").toLowerCase();

      if (normalized === "active" || normalized === "running") {
        el.classList.add("status-ok");
        el.textContent = "ACTIVO";
      } else if (normalized === "inactive" || normalized === "failed") {
        el.classList.add("status-bad");
        el.textContent = "INACTIVO";
      } else if (normalized) {
        el.classList.add("status-unknown");
        el.textContent = status.toUpperCase();
      } else {
        el.classList.add("status-unknown");
        el.textContent = "---";
      }
    }

    async function loadData(manual = false) {
      try {
        const response = await fetch('diagnostico.json?cacheBust=' + Date.now());
        if (!response.ok) {
          throw new Error('No se pudo leer diagnostico.json');
        }

        const data = await response.json();

        // Estados de servicios
        setStatus('apache-status', data.apache_status);
        setStatus('mysql-status', data.mysql_status);

        // Versiones y uptime
        document.getElementById('php-version').textContent =
          data.php_version || 'Desconocido';

        document.getElementById('docker-version').textContent =
          data.docker_version || 'Desconocido';

        document.getElementById('kernel-version').textContent =
          data.kernel_version || 'Desconocido';

        document.getElementById('uptime').textContent =
          data.uptime || 'Desconocido';

        const now = new Date();
        document.getElementById('last-update').textContent =
          'Última actualización: ' + now.toLocaleString();

      } catch (error) {
        console.error(error);
        document.getElementById('last-update').textContent =
          'Error al cargar diagnostico.json';
      }
    }

    // Cargar al entrar
    loadData();

    // Actualizar automáticamente cada 30 segundos
    setInterval(loadData, 30000);
  </script>
</body>
</html>

Compruebo la visualización del flamante PANEL LCARS y adjunto captura de pantalla: 
![[Panel_LCARS_simulado.png]]



🚀 5. Registro Estelar — Repositorio GitHub (esta parte la haré al final de todas las misiones)

Cada cadete debe abrir un repositorio con nombre:
- starfleet-prueba-competencial-NOMBRE
- El repositorio deberá incluir:
- JSON
- Scripts
- HTML estilo LCARS
- Configuraciones
- Capturas del trabajo
- Un README claro, profesional y con formato de informe técnico de la Flota
- Estelar, incluyendo:
- Objetivos de la misión
- Procedimientos ejecutados
- Capturas
- Manual de despliegue
- Conclusiones del cadete


MENSAJE DE LA FLOTA: EL NOMBRE DE LA SIGUIENTE MISION LO TIENES en
mensaje_starfleet_A43

Para encontrar el archivo uso el comando: 
'sudo find / -iname "mensaje_starfleet_A43"' para que me devuelva la ruta del archivo, que se encuentra en: 
'/opt/enterprise/mensaje_starfleet_A43'

Es un archivo de texto, asique lo abro con el comando: 
'sudo nano mensaje_starfleet_A43'

Recibo la siguiente indicación con el texto: 'El codigo de la siguiente mision es:
MD_4353.mis'

Para encontrar el archivo uso el comando: 
'sudo find / -iname "MD_4353.mis"' para que me devuelva la ruta del archivo, que se encuentra en: 
'/etc/MD_4353.mis'

Es un archivo de texto, asique lo abro con el comando: 
'sudo nano MD_4353.mis'

---------------------------------------

ENCUENTRO EL SIGUIENTE MENSAJE: 

##Activación del Módulo de Simulación — Docker
La Flota trabaja con contenedores para pruebas en espacio profundo.
Debes:
- Instalar Docker
- Levantar contenedores básicos (Apache, MariaDB, Alpine…)
- Desplegar un WordPress que funcionará como si fuera un panel de registro de misión (El sistema esta lleno de secretos)
- Crear un contenedor personalizado (puede ser un simple servidor web con un HTML estilo Starfleet)
- Luego debes construir tu propia imagen con Dockerfile y subirla a:
👉 Docker Hub — como si fuera un “Módulo de Ingeniería aprobado por Starfleet”.


------------------

Sigo con la instalación de docker en la carpeta "mario@Mario:/home/secreto/wp/bd" mediante comando:

'sudo apt update sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin -y' 

Una vez instalado busco el directorio "secreto" encontrándolo en "mario@Mario:/home/secreto$"
En ese directorio encuentro dos archivos, uno se llama "dokerfile.db " y el otro es el "README.ME"

Lo primero que hago es cambiar el nombre del archivo "dokerfile.db" a "Dockerfile.db" para que se asemeje al contenido en el readme mediante comando: "sudo mv dokerfile.db Dockerfile.db"

Una vez el archivo del readme se llama igual que el archivo de la carpeta, sigo las instrucciones del readme mediante comando: "sudo docker build -f Dockerfile.db -t mi-mariadb-wp:1.0 ." ejecutado directamente desde la carpeta "mario@Mario:/home/secreto/wp/bd$"

Una vez instalado el contenedor, lo ejecuto siguiendo instrucciones del README.ME mediante: 
"docker network create wp-net" y después 
"sudo docker run -d \
  --name wp-db \
  --network wp-net \
  mi-mariadb-wp:1.0"



Sigo con la instalación de docker en la carpeta "mario@Mario:/home/secreto/wp/web" mediante comando: 

Lo primero que hago es cambiar el nombre del archivo "dokerfile.db" a "Dockerfile.db" para que se asemeje al contenido en el readme mediante comando: "sudo mv dokerfile.db Dockerfile.db"

Una vez el archivo del readme se llama igual que el archivo de la carpeta, sigo las instrucciones del readme mediante comando: "sudo docker build -f Dockerfile.db -t mi-mariadb-wp:1.0 ." ejecutado directamente desde la carpeta "mario@Mario:/home/secreto/wp/web$"

Una vez instalado el contenedor, lo construyo siguiendo instrucciones del README.ME mediante: 
"sudo docker network create wp-net"

Una vez **construido** el contenedor lo **ejecuto** siguiendo las instrucciones del readme.me mediante: 
'sudo docker run -d \
  --name wp \
  --network wp-net \
  -e WORDPRESS_DB_HOST=wp-db:3306 \
  -e WORDPRESS_DB_USER=wpuser \
  -e WORDPRESS_DB_PASSWORD=wppass \
  -e WORDPRESS_DB_NAME=wordpress \
  -p 8080:80 \
  -v wp-html:/var/www/html \
  mi-wordpress:1.0'

Vuelo al índice de la misión mediante 'cat MD_4353.mis' para retomar el punto: 

- Crear un contenedor personalizado (puede ser un simple servidor web con un HTML estilo Starfleet)
  
Procedo mediante: 

1- Creo la carpeta del proyecto y entra en ella mediante: 
'sudo mkdir starfleet-web-module
cd starfleet-web-module'

1.2- Creo un index.html con estilo Starfleet mediante: 
 'nano index.html'

Dentro de ella creo el contenido con estilo "trekkie", guardo el archivo y salgo. 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Starfleet Engineering Console</title>
  <style>
    body {
      margin: 0;
      font-family: system-ui, sans-serif;
      background: radial-gradient(circle at top, #05101f 0%, #000000 60%);
      color: #e0e6ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .console {
      border: 2px solid #00c6ff;
      border-radius: 12px;
      padding: 24px 32px;
      box-shadow: 0 0 25px rgba(0, 198, 255, 0.5);
      max-width: 600px;
      text-align: center;
    }
    h1 {
      margin-top: 0;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      font-size: 1.4rem;
      color: #00c6ff;
    }
    .badge {
      display: inline-block;
      margin-top: 8px;
      padding: 4px 10px;
      border-radius: 999px;
      border: 1px solid #ffc400;
      color: #ffc400;
      font-size: 0.8rem;
      letter-spacing: 0.1em;
    }
    p {
      margin: 16px 0;
      line-height: 1.6;
    }
    .status-ok {
      color: #3cff7c;
      font-weight: bold;
    }
    .indicator {
      margin-top: 16px;
      font-family: monospace;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="console">
    <h1>Starfleet Engineering</h1>
    <div class="badge">APPROVED MODULE</div>
    <p>
      Módulo de Ingeniería Web operativo.<br />
      Estado del núcleo warp: <span class="status-ok">ESTABLE</span>.
    </p>
    <div class="indicator">
      > ROUTE: /starfleet/engineering/module<br />
      > STATUS: ONLINE<br />
      > PROTOCOL: DOCK-01
    </div>
  </div>
</body>
</html>
 

2- Creo el Dockerfile para mi contenedor y lo guardo mediante: 
'nano Dockerfile' y dentro de él introduzco el siguiente contenido: 

Imagen base ligera con Nginx
FROM nginx:alpine

Etiquetas opcionales (estilo “módulo aprobado por Starfleet”)
LABEL maintainer="tu-nombre-o-nick"
LABEL starfleet.module="Engineering Web Console"
LABEL starfleet.status="Approved"

Copiamos nuestro HTML Starfleet al directorio público de Nginx
COPY index.html /usr/share/nginx/html/index.html

Exponer el puerto 80 (donde escucha Nginx)
EXPOSE 80

Comando por defecto (ya viene en la imagen, pero lo dejamos explícito)
CMD ["nginx", "-g", "daemon off;"]
"

3- Construyo la imagen Docker localmente: 

Estando en la carpeta del proyecto "mario@Mario:/starfleet-web-module$ "mediante: 
'sudo docker build -t starfleet-web-module:local .'

Una vez la ha construido, lo compruebo mediante comando: 
'sudo docker images | grep starfleet'

4 - Prueba el contenido localmente: 

Lanzo el contenedor mediante 'sudo docker run -d -p 8080:85 --name starfleet-web starfleet-web-module:local' (He cambiado el puerto al 85 en lugar del 80 porque genera conflicto al estar el puerto 80 asignado a Wordpress)

Lo abro en mi navegador introduciendo en la URL de mi navegador "http://192.168.1.50:8085/" (la IP con la que accedo a través de PoweShell)

Con el siguiente resultado exitoso del cual adjunto captura!!! 

![[Pasted image 20251121104254.png]]


5- Preparo el nombre de la imagen para DockerHub desde la web con los siguientes pasos: 

- Entra en tu cuenta.  
- Voy a **Repositories**. 
- Clic en **Create repository**. 
- Nombre: `starfleet-engineering-module` 
- Visibilidad: pública  
- Crea el repo.

6- Taggeo la imagen para Docker Hub renombrando/taggeando mi imagen local con el formato correcto:
'sudo docker tag starfleet-web-module:local mariograsir/st
arfleet-engineering-module:1.0.0'

7- Login en Docker Hub desde la terminal mediante: 'sudo docker login', después me pide que haga click en  https://login.docker.com/activate mediante un código de confirmación temporal que es "CWSB-SSPK", lo introduzco y ya estoy dentro! 
![[Pasted image 20251121105906.png]]

8-  Subo el “Módulo de Ingeniería aprobado por Starfleet” a Docker Hub "empujando" la imagen mediante: 
' sudo docker push mariograsir/starfleet-engineering-module
:1.0.0'

![[Pasted image 20251121110447.png]]

Habiendo finalizado esta misión de Activación del Módulo de Simulación (Dockers)

Nos han enviado un estraño archivo con la extensión sh.
mision_oculta.sh##

MENSAJE DE LA FLOTA ESTELAR:

Para encontrar el archivo uso el comando: 
'sudo find / -iname "mision_oculta.sh"' para que me devuelva la ruta del archivo, que se encuentra en: 
'/usr/local/bin/mision_oculta.sh'

Es un archivo de texto, asique lo abro con el comando: 
'sudo nano mision_oculta.sh'

	Recibo el siguiente mensaje: 
========================================================
        M I S I Ó N   O C U L T A   D E   I N G E N I E R Í A
========================================================

Has encontrado un script oculto en el sistema.
Esto significa que te comportas como un verdadero/a admin:
exploras, miras rutas raras y no te quedas solo con lo obvio.

Completa los siguientes pasos y anota las respuestas
en tu informe (README o documento final):

1) SERVICIOS CRÍTICOS
   - Lista el estado de los servicios: apache2, mysql y ufw.
   - Anota si están activos o inactivos y en qué runlevel se inician.
   - Comando sugerido (no obligatorio): systemctl status NOMBRE_SERVICIO

2) TELEMETRÍA DEL SISTEMA
   - Obtén:
       * la versión del kernel
       * el tiempo que lleva encendido el sistema (uptime)
       * el uso actual de memoria
   - Anota en tu informe los comandos que has usado.

3) DOCKER BAJO ESCÁNER
   - Lista todos los contenedores, incluso los detenidos.
   - Identifica cuál es el contenedor de WordPress y cuál el de la base de datos.
   - Indica:
       * nombre de la imagen
       * estado
       * puertos mapeados (si los hay)

4) EXPLORACIÓN DE ARCHIVOS
   - Busca en el sistema un archivo cuyo nombre contenga la palabra "starfleet".
   - Visualiza su contenido y SIGUE LAS INTRUCCIONES INDICADAS.
   - Anota su ruta completa en el informe.
   - Pista: puedes usar el comando 'grep'.


En este momento hago un punto y aparte en la misión, para subir todo lo realizado hasta ahora a mi GitHub



































































-------------- 
 MISION_STARFLEET_OPS_PROTOCOL_47-A
 
Academia de la Flota Estelar — División de Ingeniería

La Academia te asigna una última misión antes de graduarte.
Has recibido acceso a una unidad de entrenamiento holodeck dentro de un Servidor Ubuntu Server en un entorno Proxmox.

Tu objetivo es convertir esta unidad en un nodo operativo de la Flota Estelar, siguiendo los protocolos técnicos reales de los ingenieros de naves clase Galaxy.

Cada alumno actuará como Ingeniero Jefe de su propio módulo.


🖖 1. Registro de Entrada — Personalización del Sistema

Al iniciar tu terminal, la Flota quiere saber quién eres.

Debes modificar el mensaje de bienvenida (MOTD) para que muestre:
(sudo nano /etc/motd)

Nombre del cadete

ID del grupo (ej. YT3)

Un mensaje de alerta o saludo en estilo LCARS

Fecha estelar generada dinámicamente (puede ser la fecha normal)

Cuando la VM arranque, deberá parecer que el sistema está entrando en un submódulo de ingeniería de la USS Enterprise NCC-1701-D.




🛠️ 2. Instalación del Núcleo de Servicios — Pila LAMP

Para que el nodo pueda comunicarse con otras estaciones de la Flota, debes instalar y activar:

Apache (Servidor principal)

MySQL / MariaDB (Base de datos del registro estelar)

PHP (Interfaz de análisis)

La configuración debe quedar estable y los servicios operativos como si fuesen módulos LCARS.

🛡️ 3. Activación del Escudo Deflector — Firewall UFW

Antes de que el nodo quede operativo, debes levantar los escudos.

Protocolos mínimos:

Solo deben permitirse:

Canal de comunicaciones principal (SSH)

Canal web (HTTP / HTTPS)

Todo lo demás queda bloqueado

Mostrar en la web un panel con el “estado del escudo”



📡 4. Registro de Telemetría — JSON + HTML

Cada estación de la Flota debe emitir telemetría.

Debes generar un archivo JSON que incluya:

Estado de Apache

Estado de MySQL

Versión de PHP

Versión de Docker

Versión del kernel (núcleo del sistema)

Tiempo activo del servidor (Uptime)

Debes crear una interfaz HTML de estilo LCARS que:

Lea el JSON mediante JavaScript

Muestre los datos como paneles de la consola de mando

Sea accesible desde la web principal del host

Este será el “Panel de Diagnóstico de Ingeniería”.
 
🚀 5. Registro Estelar — Repositorio GitHub

Cada cadete debe abrir un repositorio con nombre:

starfleet-prueba-competencial-NOMBRE

El repositorio deberá incluir:

JSON

Scripts

HTML estilo LCARS

Configuraciones

Capturas del trabajo

Un README claro, profesional y con formato de informe técnico de la Flota Estelar, incluyendo:

Objetivos de la misión

Procedimientos ejecutados

Capturas

Manual de despliegue

Conclusiones del cadete

------------------------------------------

MENSAJE DE LA FLOTA: EL NOMBRE DE LA SIGUIENTE MISION LO TIENES en
mensaje_starfleet_A43


FIN DEL MENSAJEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
