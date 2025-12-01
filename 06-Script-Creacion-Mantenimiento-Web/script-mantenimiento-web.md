

- Comienzo la tarea ubicándome en el directorio en el quiero crear el Script, en mi caso tengo ya una carpeta dentro de mi ubuntu server con todos los scripts que creo cuya ruta es: /home/mario/scripts

- Una vez dentro de ese directorio, procedo con la creación del script mediante comando `sudo nano backup_web_db.sh`

- Dentro del nano, creo el script mediante: 

```#!/bin/bash
# backup_web_db.sh
# Script para hacer copia de seguridad de la carpeta html y de una base de datos MySQL/MariaDB

# 1) Variables de configuración
WEB_DIR="/var/www/html"             # Carpeta web que queremos copiar
BACKUP_DIR="/var/backups"           # Carpeta donde se guardarán las copias
DB_NAME="mibasedatos"               # Nombre de la base de datos
DB_USER="usuario"                   # Usuario de la base de datos
DB_PASS="contraseña_segura"         # Contraseña del usuario

# 2) Fecha para los nombres de los archivos de copia
DATE=$(date +%F_%H-%M-%S)

# 3) Crear carpetas destino si no existen
mkdir -p "$BACKUP_DIR/html"
mkdir -p "$BACKUP_DIR/db"

# 4) Copia de la carpeta web
tar -czf "$BACKUP_DIR/html/html_${DATE}.tar.gz" "$WEB_DIR"

# 5) Copia (dump) de la base de datos
mysqldump -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_DIR/db/${DB_NAME}_${DATE}.sql"

# 6) Comprimir el fichero SQL
gzip "$BACKUP_DIR/db/${DB_NAME}_${DATE}.sql"

# 7) (Opcional) Borrar copias de más de 7 días
# find "$BACKUP_DIR/html" -type f -mtime +7 -delete
# find "$BACKUP_DIR/db" -type f -mtime +7 -delete

```
#!/bin/bash

''''

- Acto seguido, guardo el script y salgo del nano. 

- El siguiente paso es dar permisos al script recién creado mediante comando: 
  `sudo chmod +x /home/mario/scripts/backup_web_db.sh
`
- Después hago una prueba con la ejecución del script manual estando en la ruta que contiene el script mediante comando: 
  `./backup_web_db.sh
`
- Y compruebo el resultado mediante comando: 
  `ls /var/backups/html
ls /var/backups/db
`
Obteniendo el resultado que adjunto en captura: 

![[Cap1.png]]

- Por último configuro el CRON para que el script se ejecute cada día a las 00:00 mediante la edición del crontab, para ello uso comando: 
  `crontab -e
`
(me ofrece varias opciones para abrir el archivo de edición, asique selección la nº1 que es nano, la más sencilla)


![[Cap2.png]]

- Guardo el nano con la modificación del archivo, tras añadir las siguientes notas a mi readme para entenderlo: 

 **0 0 * * *** → se ejecuta todos los días a las **00:00**
**/home/mario/scripts/backup_web_db.sh** → ruta del script
 **>> /home/mario/backup_web_db.log** → guarda el log en la carpeta del usuario
 
 
 Realizo un reseteo en el crontab para asegurarme de que los cambios surten efectos mediante sudo systemctl restart cron`y el ejercicio queda terminado. 
 
 Gracias por leer hasta aquí! 