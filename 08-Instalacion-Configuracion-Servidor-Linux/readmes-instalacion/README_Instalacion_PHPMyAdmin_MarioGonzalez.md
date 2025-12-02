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
