MARIO GONZÁLEZ REYES - 2ºASIR - SEGURIDAD Y ALTA DISPONIBILIDAD 


## RETO 1: 
Creación y ejecución del contenedor ubuntu mediante: 
	`sudo docker run -it --name reto-ubuntu ubuntu:latest` 

Una vez dentro del contenedor:
- Actualizo sistema mediante: 
	`apt update && apt upgrade -y`
- Instalo Python mediante: 
	`apt install python3 -y`
- Instalo las librerías de python: 
	`apt install python3-pip -y`
	`apt install python3-requests -y`
- Instalo librerías de MySQL: 
	`apt install mysql-client -y`
	`apt install python3-mysql.connector -y`
	`apt install python3-mysqldb -y
-  Ahora creo una imagen personalizada, para ello definiré la carpeta en el contenedor a fin de poder asociarla después al hacer un Bind: 
		Desde dentro del contendor y desde la ruta "/home/ubuntu" creo la carpeta de nombre python mediante `mkdir python`
- Una vez creada, salgo de ella y salgo fuera del contenedor para crear la imagen personalizada con esta configuración mediante: 
  `docker commit reto-ubuntu mi-imagen-personalizada

Compruebo que este primer reto está bien creado mediante `sudo docker ps-a` y `sudo docker images` obteniendo los resultados que adjunto en la siguiente captura: 

![[TAREA MI VIDA EN UN CONTENEDOR/Cap1.png]]



## RETO 2

Procedo con la creación y ejecución del nuevo contenedor con la imagen recién creada mediante: 
`sudo docker run --name  reto_ubuntu_python -it -v /home/mario/volumenes/reto_ubuntu:/home/ubuntu/python mi-imagen-personalizada:latest` 


## RETO 3

- No necesito instalar git en mi ubuntu server, ya que ya lo tengo instalado, compruebo la versión mediante `git -v` viendo que ya corre la "git version 2.43.0". 

- Accedo al contenedor arrancándolo primero con `sudo docker start reto_ubuntu_python` y entrando después con `sudo docker exec -it reto_ubuntu_python /bin/bash`

- Me ubico en la ruta "cd /home/ubuntu/python" y desde ahí creo un documento como por ejemplo `touch archivo_comprobacion.txt` y escribo algo en él con `echo "Hola Mundo de Mariete" > archivo_comprobacion.txt`

- Sigo con la instalación y subida al repo de GitHub mediante: `apt git install -y`
	- Configuración de GIT: 
	  1. git config --global user.email "mariogr10789@gmail.com"
	  2. git config --global user.name  "MarioGRASIR"
	  3. git config --global --add safe.directory /home/ubuntu/python
	  4. git init
	  5. git add archivo_comprobacion.txt
	  6. git commit -m "crear archivo contenedor ubuntu"
	  7. git branch -M main
	  8.  git remote add origin https://github.com/MarioGRASIR/reto2_mi_vida_en_un_contenedor.git
	  9. git push -u origin main
  
  Adjunto captura del commit en mi repositorio, "Hola Mundo de Mariete" en el "archivo_comprobacion.txt": 
  ![[TAREA MI VIDA EN UN CONTENEDOR/Cap2.png]]



## RETO 4 


Salgo del contenedor anterior mediante `exit` para volver a mi terminal a fin de crear un nuevo contenedor mysql. 

- Creo y ejecuto el contenedor mediante: 
  `sudo docker run --name mysql_server -d \-e MYSQL_ROOT_PASSWORD=Abcd1234 \-e MYSQL_DATABASE=bdcoches \-p 3307:3306 \-v mysql_data:/var/lib/mysql \mysql:latest`

- Accedo al contenedor recién creado mediante: 
	- `sudo docker exec -it mysql_server bash`
	- `mysql -u root -p` | Abcd1234
	
	- Una vez dentro de mysql `use bdcoches` creo la tabla COCHES en mi DB (bdcoches) mediante: 
			CREATE TABLE coches(
						id INT PRIMARY KEY,
						 marca VARCHAR(20),
						 modelo VARCHAR(20),
						 color VARCHAR(15),
						 km INT,
						 precio INT);
	- Dentro de ella añado 10 registros en forma de coches a modo de muestra mediante:
			INSERT INTO coches (id, marca, modelo, color, km, precio) VALUES
						(1, 'Toyota', 'Corolla', 'Blanco', 50000, 15000),
						(2, 'Honda', 'Civic', 'Negro', 30000, 18000),
						(3, 'Ford', 'Focus', 'Azul', 40000, 14000),
						(4, 'Chevrolet', 'Cruze', 'Rojo', 60000, 13000),
						(5, 'Nissan', 'Sentra', 'Gris', 20000, 17000),
						(6, 'Volkswagen', 'Golf', 'Blanco', 45000, 16000),
						(7, 'Hyundai', 'Elantra', 'Azul', 35000, 15500),
						(8, 'Kia', 'Rio', 'Negro', 25000, 14500),
						(9, 'Renault', 'Megane', 'Rojo', 55000, 13500),
						(10, 'Mazda', '3', 'Gris', 30000, 16500);


- A modo de comprobación de la correcta inserción de los datos en la DB "bdcoches" realizo un `describe coches;` para ver los campos de la tabla y un `select * from coches;` para ver las tuplas, de las cuales adjunto captura de pantalla: 

![[TAREA MI VIDA EN UN CONTENEDOR/Cap3.png]]


## RETO 5

- A fin de que nuestros contenedores puedan verse, lo primero que hago es crear una red personalizada mediante: `sudo docker network create mi-red-app`
- Sigo con el lanzamiento de un contenedor MySQL conectándolo a la red mediante: 
  `sudo docker run -d \
                          --name mi-db-sql \
                          --network mi-red-app \
                          -e MYSQL_ROOT_PASSWORD=Abcd1234 \
                          -e MYSQL_DATABASE=bdcoches \
                          mysql:latest`
                          
- Accedo al contenedor recién creado mediante: 
	- `sudo docker exec -it mi-db-sql bash`
	- `mysql -u root -p` | Abcd1234

- Repito exactamente los pasos del Reto 4 para crear, dentro ya de MsQLS la tabla COCHES en mi DB (bdcoches) y la inserción de los 10 registros. (NOTA PARA MI, CREADOS YA)

- 




























# TITULO CON 1  
## TITULO CON 2 
### TITULO CON 3
#### TITULO CON 4

##### TITULO CON 5 


