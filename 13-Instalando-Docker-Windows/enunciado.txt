En este ejercicio vamos a crear un documento donde documetaremos todos los pasos para la instalaci'on de Docker en Windows y el uso de los contenedores. 

El profesor ira realizando las diferentes tareas y tu deberar replicarlos y documentarlos en el documento.

Tareas a documentar (Puedes combinar el uso de la interfaz y la linea de comandos)

Instalacion de docker en windows
Que es el WSL y porque lo necesita docker en windows
Examinar elCatalogo de imagenes en docker
Crear un contenedor Ubuntu
Crear un contenedor Ubuntu poniendole un nombre especifico
Intalar la extension Portainer
Crear un volumen y asignarselo a un contenedor ubuntu para que sea persistente.
Crear un contenedor htpd en el puerto 8080
Instalar nano en el contenedor
Cambiar el index del contenedor web creado
Indica los comandos o el modo de realizar las siguientes acciones desde la terminal y pon un ejemplo de uso y describe lo que hace:

Descargar imagenes:

Ejemplos: 
docker pull ubuntu
docker pull ubuntu:20.04


Crear y ejecutar contenedores
docker run -it ubuntu
docker run -it --name mi-ubuntu ubuntu
docker run --name mi-ubuntu -it -v /datos-persistentes ubuntu
docker run --name mi-ubuntu -it -v mi-volumen:/datos ubuntu
docker run -it -v C:\ruta\local:/ruta/en/contenedor ubuntu

Crear Volumenes
docker volume create mi-volumen

Consultar informacion
docker ps
docker ps -a
docker images

Imagen personalizadas
docker commit mi-ubuntu mi-imagen-personalizada

Operaciones con contendores
docker start mi-ubuntu
docker exec -it mi-ubuntu bash
docker start -ai mi-ubuntu
docker rm mi-ubuntu
docker container prune

 