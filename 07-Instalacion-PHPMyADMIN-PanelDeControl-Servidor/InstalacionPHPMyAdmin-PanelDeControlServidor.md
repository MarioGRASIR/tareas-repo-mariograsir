
# Montando un Servidor Web con Ubuntu Por: Mario Gonzalez 
# Asignatura: Servicios de Red e Internet
# Docente: Antonio Otero Veiga


Este documento resume los pasos basicos para la instalacion y configuracion de un **servidor web en Ubuntu Server**, accediendo de forma remota via SSH.  

## Tecnologias a implementar  
- **SSH**  Acceso remoto al servidor  
- **Apache2**  Servidor web  
- **MySQL/MariaDB**  Sistema gestor de bases de datos  
- **FTP (vsftpd)**  Transferencia de archivos  
- **PHP**  Lenguaje para aplicaciones dinamicas  

Herramientas recomendadas para instalacion previa en el cliente:  
- **CMD / PowerShell**  conexion SSH  
- **Workbench**  gestion de bases de datos  
- **VS Code con extension SSH**  desarrollo en remoto  
- **FileZilla**  transferencia de archivos  

---

## Pasos de instalacion:

### Descargar ISO de Ubuntu server de la web oficial de ubuntu ->https://ubuntu.com/download/server/thank-you?version=24.04.3&architecture=amd64&lts=true

### Elegir un virtualizador como https://www.vmware.com/ u (https://www.virtualbox.org/), en nuestro caso elegimos VirtualBox por su mejor estabilidad y creamos la maquina virtual.

### 1. Conexion SSH  
```bash
sudo apt install ssh
ssh usuario@IP_del_servidor
```

### 2. Instalar Apache2  
```bash
sudo apt install apache2
```
- Responde en el puerto **80**.  
- Archivos web se alojan en: `/var/www/html/` , ruta desde la que puedes crear archivos html para visualizar documetos web desde cualquier explorador.

### 3. Instalar y configurar MySQL  
```bash
sudo apt install mysql-server
sudo mysql_secure_installation
```
- Configurar contrasenia de root.  (En nuestro caso, siempre usamos"Abcd1234")
- Eliminar usuarios anonimos.  
- Deshabilitar root remoto.  
- Eliminar base de datos de prueba.  

Editar archivo de configuracion para conexion remota:  
```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
# bind-address = 0.0.0.0
sudo systemctl restart mysql
```

#### Creacion de usuarios y permisos:
```sql
CREATE USER 'usuario'@'%' IDENTIFIED BY 'Contrasenia123@';
GRANT ALL PRIVILEGES ON *.* TO 'usuario'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```

#### Politicas de contrasenias  
- LOW = 0  
- MEDIUM = 1 (recomendada, nosotros elegimos esta)  
- STRONG = 2  

```sql
SET GLOBAL validate_password.policy=MEDIUM;
```

### 4. Instalar y configurar FTP (vsftpd)  
```bash
sudo apt install vsftpd
sudo cp /etc/vsftpd.conf /etc/vsftpd.conf_old
sudo nano /etc/vsftpd.conf
```

Despues copia la siguiente configuración en el archivo vsftpd.conf , guarda y cierra el archivo: 

Configuracion basica:
```
listen=NO
listen_ipv6=YES
anonymous_enable=NO
local_enable=YES
write_enable=YES
chroot_local_user=YES
pasv_enable=YES
pasv_min_port=10000
pasv_max_port=10100
```

Abrir puertos en firewall:
```bash
sudo ufw allow from any to any port 20,21,10000:10100 proto tcp
sudo systemctl restart vsftpd
```

Crear usuario FTP con acceso a la carpeta web:
```bash
sudo useradd -m ftpuser
sudo passwd ftpuser
sudo nano /etc/passwd   # cambiar carpeta home a /var/www/html
sudo chmod -R 775 /var/www/html
```

### 4.2 Acceso a la carpeta WEB de Apache2

Usaremos el modo mas sencillo que consiste en crear un usuario donde su carpeta personal sea la www de Apache2 y dar permisos a esta carpeta
````bash
sudo useradd -m ftpuser  #Creamos un usuario, por ejemplo uno llamado ftpuser
sudo passwd ftpuser      #Luego indicamos un password para el usuario.
sudo nano /etc/passwd    #<- Aqui cambiamos la carpeta del usuario. /Finalmente, podemos editar el archivo /etc/passwd para cambiar la carpeta
````

- Al terminar no te olvides de dar permisos a la carpeta de lectura y ejecucion para el resto de usuarios como el propio apache.

### 5. Instalar PHP  

- vamos a empezar por instalar el propio interprete y las librerias para mysql y para poder ejercutar script de php en termial de linux.

```bash
sudo apt install php libapache2-mod-php php-mysql php-cli   # NOTA SOLO A MARIO le da problemas la instalacion de esta version, y lo soluciona instalando con 'sudo apt install php8.2 cli'
php -v
```

Prueba de PHP:  
```bash
sudo nano /var/www/html/version.php
```
```php
<?php phpinfo(); ?>
```

Accede en el navegador:  
```
http://IP_DEL_SERVIDOR/version.php
```

### 6. Acceso por SSH desde un IDE como VisualStudioCode  
1. Instalar [Visual Studio Code](https://code.visualstudio.com/Download).  
2. Instalar extension **Remote - SSH**.  
3. Crear conexion:  
```
Host MiServidor
  HostName 192.168.1.75 (sustituir por tu IP)
  User ubuntu (sustituir por tu usuer, en mi caso "mario")
```

---
 Resultado final  
Tras completar todos los pasos:  
- El servidor podra **responder peticiones web (Apache2 + PHP)**.  
- Permite **gestionar bases de datos MySQL** de forma local y remota.  
- Dispone de **acceso FTP seguro** para transferencia de archivos.  
- Es posible administrar y desarrollar directamente desde **VS Code via SSH**.  


#### 7. Resolucion de problemas frecuentes (FAC) 

- si no puedo ver mi IP? >  Sudo apt install net-tools para instalar las herramientas que nos permiten hacer un "ifconfig" para ver cual es nuestra IP, etc...
- si lo anterior te da error por no disponer del comando, recuerda tener instalado el paquete con 'sudo apt install net-tools' 
- si no obtengo IP? > Puede ser porque estoy conectado en modo NAT en lugar de PUENTE, cambiar a puente, sino cambiar el adaptador de red.
- como puedo ver mi servidor desde mi navegador? > primero buscar la ip de nuestro Ubuntu server y despues copiar y pegarla en la URL de nuestro navegador. 
- como puedo ver el estado de mis puertos? > sudo ufw status
- si estas teniendo problemas al establecer tu contrasenia para Mysql recuerda que: 
      + debe tener al menos 8 caracteres.
      + el recuento de mayusculas y minusculas es 1 (al menos 1 de cada)
      + el recuento de numeros es 1
      + el numero minimo de caracteres especiales es 1
- 
   


#### 8. Actualizacion y mantenimiento
- sudo apt install net-toos para instalar las herramientas que nos permiten hacer un "ifconfig" para ver cual es nuestra IP, etc...
- sudo apt update && sudo apt upgrade para mantener nuestro servidor actualizado 

Para desinstalar completamente el servidor: 

```bash
sudo systemctl stop apache2
sudo apt remove --purge apache2 apache2-utils apache2-bin apache2.2-common -y
sudo apt autoremove -y
```

#### 9. Creditos y referencias
- Autores: Mario Gonzalez - Diego Huamanchumo - Pablo Sejas
- Fuentes Externas: Materiales asignatura Servicios de Red e Internet de la Universidad Europea, autor Antonio Otero Veiga. 


_____________________________________________________________________________________________________________________________________________________________________________________________



# Instalacion de PHPMyAdmin en Ubuntu

Guia paso a paso para instalar **PHPMyAdmin** en un servidor Ubuntu con **Apache2**, **MySQL** y **PHP** ya configurados.

---

## Requisitos previos

Asegurate de tener instalados:
- Apache2  
- MySQL  
- PHP  

---

## 1. Verificar politica de contrasenias en MySQL

PHPMyAdmin requiere que la politica de contrasenias de MySQL este configurada al menos en **MEDIUM**.

1. Accede al cliente MySQL desde la terminal:
   ```bash
   sudo mysql -u root -p
   ```
2. Comprueba la politica actual:
   ```sql
   SHOW VARIABLES LIKE 'validate_password%';
   ```
3. Si la politica no es MEDIUM, cambiala:
   ```sql
   SET GLOBAL validate_password.policy=MEDIUM;
   ```

---

## 2. Crear el usuario para PHPMyAdmin

Dentro de la consola de MySQL, ejecuta los siguientes comandos:

```sql
CREATE USER 'phpmyadmin'@'localhost' IDENTIFIED BY 'Mario_1234';
GRANT ALL PRIVILEGES ON *.* TO 'phpmyadmin'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```

**Notas:**
- El usuario solo debe conectarse desde `localhost` por seguridad.
- La contrasenia debe cumplir con la politica **MEDIUM**.
- Reinicia el servicio MySQL despues de crear el usuario:
  ```bash
  sudo service mysql restart
  ```

---

## 3. Actualizar paquetes del sistema

Antes de instalar PHPMyAdmin, actualiza el sistema y sus dependencias:

```bash
sudo apt update && sudo apt-get upgrade
```

---

## 4. Instalar PHPMyAdmin

Ejecuta el comando de instalacion:

```bash
sudo apt install phpmyadmin
```

Durante la instalacion:
1. Selecciona el servidor web: **apache2** (usa la tecla *espacio* para marcarlo).  
2. Acepta la configuracion por defecto.  
3. Introduce la contrasenia del usuario creado anteriormente (`Mario_1234`).

---

##  5. Acceder a PHPMyAdmin

Una vez completada la instalacion, accede desde tu navegador con:

```
http://<IP_del_servidor>/phpmyadmin
```

Ejemplo:
```
http://192.168.1.10/phpmyadmin
```

---

##  6. Aumentar la seguridad del servidor

Para reforzar la seguridad, puedes:

1. **Deshabilitar conexiones remotas**:
   ```bash
   sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
   ```
   Asegurate de tener:
   ```
   bind-address = 127.0.0.1
   ```

2. **Cerrar el puerto 3306** en el firewall:
   ```bash
   sudo ufw deny 3306
   ```

---

#### 7. Resolucion de problemas frecuentes (FAC) 

- Atendiendo a la linea 74 de este documento, el error de NO MARCAR la casilla **apache2** con LA TECLA ESPACIO ha sido recurrente, PON ATENCION o se abortara todo el proceso y tendras que empezar de nuevo. 
- Atendiendo a la linea 82 de este documento, es habitual que el navegador GoogleChrome produzca errores de acceso causados por politicas de seguridad y bloqueos propias del browser, si esto pasa probar con otro navegador, mozilla o edge no presentan problemas. 

#### 9. Creditos y referencias

- Autores: Mario Gonzalez - Diego Huamanchumo - Pablo Sejas
- Fuentes Externas: Materiales asignatura Servicios de Red e Internet de la Universidad Europea, autor Antonio Otero Veiga. 
Documento original: *Instalación de PHPMyAdmin en Ubuntu - Obsidian v1.6.7*

---

## Resultado final

PHPMyAdmin queda instalado y accesible en tu servidor Ubuntu localmente mediante:
```
http://localhost/phpmyadmin

```

___________________________________________________________________________________________________________________________________________

# README.md - Instalar WebMin en Ubuntu Server 

## Descripcion

Este documento contiene instrucciones para instalar y acceder a Webmin, un panel de control basado en web para administrar sistemas Linux desde un navegador.

## Requisitos

- Acceso SSH al servidor con privilegios de root o sudo.
- Conexion a internet desde el servidor.

## Pasos de instalacion

1. Acceder al servidor como root o usar sudo: (recomendado excepcionalmente para evitar errores de instalacion)

```bash
sudo su
```

2. Descargar el script de configuracion de repositorios de Webmin y ejecutarlo:

```bash
curl -o setup-repos.sh https://raw.githubusercontent.com/webmin/webmin/master/setup-repos.sh
sh setup-repos.sh
```

3. Instalar Webmin usando apt:

```bash
apt update
apt install webmin --install-recommends
```

> Nota: el script anterior configura las dependencias y el repositorio oficial, por lo que la instalacion por apt debe funcionar sin problemas.

## Acceso al panel

Una vez instalado, Webmin escucha por defecto en el puerto 10000. Accede desde un navegador usando la IP o dominio del servidor:

```
https://ip_servidor:10000/  (si usas Crhome puede decirte que la conexión no es segura, acepta los riesgos y continúa)

```

Para autenticarte, puedes usar el mismo usuario y contrasena que empleas para acceder al servidor Linux (por ejemplo el usuario root o un usuario con privilegios sudo, en mi caso mario | Abcd1234), salvo que la configuracion de Webmin indique otra cosa.

## Comprobacion

Tras iniciar sesion deberias poder ver el panel con los distintos modulos y la informacion del sistema.

## Recursos

- Pagina oficial de descargas y documentacion: https://webmin.com/download/

## 7. Resolucion de problemas frecuentes (FAC) 

- En ocasiones al hacer "cortar-pegar" sobre el bash de este readme, algunos caracteres se distorsionan y provocan error, para evitarlo, puedes "corta-pegar" directamente los comandos contenidos en la propia web de instrucciones de https://webmin.com/download/

## Actualizacion y mantenimiento
- sudo apt install net-toos para instalar las herramientas que nos permiten hacer un "ifconfig" para ver cual es nuestra IP, etc...
- sudo apt update && sudo apt upgrade para mantener nuestro servidor actualizado 


## Creditos y referencias
- Autores: Mario Gonzalez - Diego Huamanchumo - Pablo Sejas
- Fuentes Externas: Materiales asignatura Servicios de Red e Internet de la Universidad Europea, autor Antonio Otero Veiga. 

_______________________________________________________________________________________________________________________________________________________________________________


HASTA ESTE PUNTO TODOS LOS SERVICIOS INSTALADOS Y FUNCIONANDO PERFECTAMENTE !!!!!! 