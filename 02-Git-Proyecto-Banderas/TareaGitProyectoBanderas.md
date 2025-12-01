
PASOS PREVIOS...

Voy a realizar la tarea en mi Ubuntu Desktop virtualizado, y para ello instalo los elementos necesarios, que son Git y Docker Hub mediante los comandos: 
`sudo apt install git` primero y `sudo apt-get install ./docker-desktop-amd64.deb` después. 

- Ahora "importo" mi cuenta y correo de Git creada en Windows mediante comando:
   `git config --global user.name "MarioGRASIR"
git config --global user.email "mariogr10789@gmail.com"

Después compruebo que se han guardado bien con: 
`git config --list`

![[TAREA GIT PROYECTO BANDERAS/Cap1.png]]

- Después y MUY IMPORTANTE, para evitar el problema con los saltos de línea en Git que se presenta cuando trabajas indistintamente en archivos accesibles desde Windows y desde Linux, ejecuto el comando: 
  `git config --global core.autocrlf input`
- Reinicio mi Ubuntu para que todos los cambios surjan efecto, y comienzo con el ejercicio. 

- Cómo último requisito previo Instalo Gitk mediante comando: 
  `sudo apt install gitk -y` 

## **PARTE 1: Configuración inicial del entorno**

1. Como Apache2 ya está instalado en mi Ubunto, verifico su funcionamiento mediante: 
  `sudo systemctl status apache2`
![[TAREA GIT PROYECTO BANDERAS/Cap2.png]]

2. Configuro mi carpeta de trabajo cambiando el directorio donde apache almacena por defecto sus archivos mediante: 
   `cd /var/www/html` y después cambio los permisos `sudo chown -R $USER:$USER /var/www/html`
   
3. Inicializo un repo GIT en el directorio en el que estoy "/var/www/html" mediante `git init`
   
4. Creo el archivo HTML inicial dentro de  /var/www/html creando un archivo llamado index.html mediante `sudo nano index.html` y dentro de él meto el siguiente html ````
   ```   
<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Bandera</title>  
    <style>  
        body {  
            margin: 0;  
            padding: 0;  
        }  
        .franja {  
            height: 100px;  
            width: 100%;  
        }  
    </style>  
</head>  
<body>  
    <div class="franja" style="background-color: red;"></div>  
    <div class="franja" style="background-color: yellow;"></div>  
    <div class="franja" style="background-color: red;"></div>  
</body>  
</html>

![[Pasted image 20251127212451.png]]
   
5.  Hago mi primer commit añadiendo los cambios al área de preparación con `git add index.html` y luego realizo el commit con `git commit -m "Añade la bandera inicial (España)"` 

## **PARTE 2: Creación de banderas y commits**

1. Ahora voy a cambiar los colores para que representen la bandera de otro país, por ejemplo la italiana. 
   Lo hago modificando de nuevo el archivo index.html introduciendo `<div class="franja" style="background-color: green;"></div>
<div class="franja" style="background-color: white;"></div>
<div class="franja" style="background-color: red;"></div>

![[Cap4.png]]


Una vez comprobado el cambio de nuevo en localhost, guardo los cambios y hago un commit mediante `git add index.html`  y después  `git commit -m "Cambia los colores para la bandera de Italia"` 

2. Repito el proceso para hacerlo con dos países más, Francia y Alemania. 
   
   Como es un proceso repetitivo, voy listando los comandos introducidos: 
   - `sudo nano index.html`
   - ````<div class="franja" style="background-color: blue;"></div>  
<div class="franja" style="background-color: white;"></div>  
<div class="franja" style="background-color: red;"></div> ```
- `git add index.html`  y después  `git commit -m "Cambia los colores para la bandera de Francia"` 
-    `sudo nano index.html`
- ````<div class="franja" style="background-color: black;"></div>  
<div class="franja" style="background-color: red;"></div>  
<div class="franja" style="background-color: yellow;"></div>
-  `git add index.html`  y después  `git commit -m "Cambia los colores para la bandera de Alemania"` 
- 


![[Cap5.png]]

## **PARTE 3: Uso de ramas**

1. Ahora voy a crear una rama para bandera mediante `git checkout -b italia` y realizando cambios de nuevo en el index.html como se ve a continuación: 
   
![[Cap6.png]]

Seguido realizo un`git add index.html` y después el commit en esta rama mediante `git commit -m "Crea la bandera de Italia en la rama italia"`

- Sigo con la creación de ramas adicionales con 'git checkout -b italia' y `git checkout -b alemania` y practico el cambio entre ramas mediante los comandos 'git checkout italia' o `git checkout alemania`

2.  Realizado todo lo anterior, abro gitk desde el directorio del proyecto /var/www/html mediante `gitk --all` obtendiendo si siguiente visualización con todas las ramas y el historial de commits que he creado. 
   
   ![[Cap7.png]]


### **Parte 5: Publicación en GitHub**

1. Voy a https://github.com/  y creo un repo llamado "banderas_git"

2. Conecto mi repositorio local con GitHub desde la terminal de mi UbuntuDesktop virtualizado ejecutando los siguientes comandos: 
   - `git remote add origin https://github.com/MarioGRASIR/banderas_git`
   - `git branch -M main`
   - `git push -u origin italia`

![[Cap8.png]]

Y repito esos pasos para el resto de ramas creadas. 

NOTA IMPORTANTE, en la validación que pide git, tras introducir el último comando, hay que hacer LogIn con la cuenta github (MarioGRASIR) y luego introducir la Password QUE ES EL MALDITO TOKENNNNNn!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

