#!/bin/bash

while true; do
  clear
  echo "-------------------------------------"
  echo "-----Menu instalacion de servicios------"
  echo "-------------------------------------"
  echo
  echo "1) Instalar SSH"
  echo "2) Instalar APACHE2"
  echo "3) Instalar MYSQL."
  echo "4) Instalar PHP"
  echo "5) Instalar FTP"
  echo "6) Copia seguridad web"
  echo "7) Copia bases de datos"
  echo "8) Actualizar repo linux"
  echo "9) Instalar git"
  echo "10) Apagar equipo"
  echo "0) Salir del script"
  echo "-------------------------------------"
  #echo "dame una opcion" ESTO ES LO MISMO QUE LA SIGUIENTE LINEA
  #espera a lo q escriba el usuario, y ademas imprimimos un "enunciado"
  #opcion ->
  read -p "Elige una opcion [0-10]: " opcion

  case $opcion in
    1)
      echo "Instalando SSH..."
      sudo apt install ssh -y
      echo "Instalacion completa, pulse cualquier tecla para continuar"
      read
    ;;
    2)
      echo "Instalando APACHE2..."
      #aqui van los comandos de instalacion de apache
      sudo apt install apache2 -y
      echo "Instalacion completa, pulse cualquier tecla para continuar"
      read
    ;;
    3)
      echo "Instalando MYSQL..."
      sudo apt install mysql-server -y
      echo "Instalacion completa, pulse cualquier tecla para continuar"
      read
    ;;
    4)
      echo "Instalando PHP..."
      sudo apt install php -y
      echo "Instalacion completa, pulse cualquier tecla para continuar"
      read
    ;;
    5)
      echo "Instalando FTP..."
      sudo apt install vsftpd -y
      echo "Instalacion completa, pulse cualquier tecla para continuar"
      read
    ;;
    6)
      mkdir -p /home/"$USER"/backup_web
      sudo chown "$USER":"$USER" /home/"$USER"/backup_web
      sudo chmod 777 /home/"$USER"/backup_web
      origen="/var/www/html"
      fecha="$(date +%Y-%m-%d_%H:%M)"
      destino="/home/$USER/backup_web"
      nombre="backup_html_$fecha.tar.gz"
      sudo tar -czvf "$destino/$nombre" "$origen"
      if [ $? -eq 0 ]; then
        echo "Copia de seguridad realizada!!!!"
      else
        echo "Error al crear la copia de seguridad"
      fi
      read
    ;;
    7)
      clear
      DB_USER="root"
      echo "***********************************************"
      echo "**********COPIA DE SEGURIDAD BASES DE DATOS***********"
      echo "***********************************************"
      echo "1. Copia de seguridad de todas las bases de datos."
      echo "2. Copia de seguridad de una base de datos en especifico"
      echo "3. Crear carpeta de copia de seguridad (si no tienes)"
      echo "***********************************************"
      read -p "Elige una opción [1-3]: " opc
      case $opc in
        1)
          read -p "Introduce el nombre de la carpeta para la copia de seguridad " carpeta
          read -s -p "Introduce la contraseña de tu MySQL: " DB_PASS
          BACKUP_DIR="/home/$USER/$carpeta"
          FECHA="$(date +%Y-%m-%d_%H:%M:%S)"
          FILE_NAME="$BACKUP_DIR/alldatabases_$FECHA.sql"
          sudo mysqldump -u "$DB_USER" -p "$DB_PASS" --all-databases > "$FILE_NAME"
          echo "Copia de seguridad de todas las bases de datos realizada!!!"
          read
        ;;
        2)
          read -p "Introduce el nombre de la carpeta para la copia de seguridad: " carpeta
          read -p "Introduce el nombre de la base de datos: " DB_NAME
          read -s -p "Introduce la contraseña de tu MySQL: " DB_PASS
          BACKUP_DIR="/home/$USER/$carpeta"
          FECHA="$(date +%Y-%m-%d_%H:%M:%S)"
          FILE_NAME="$BACKUP_DIR/$DB_NAME-$FECHA.sql"
          sudo mysqldump -u"$DB_USER" -p"$DB_PASS" --databases "$DB_NAME" > "$FILE_NAME"
          echo "Copia de seguridad de la base de datos $DB_NAME realizada!!!"
          read
        ;;
        3)
          read -p "Nombre de la carpeta: " carpeta
          sudo mkdir -p /home/"$USER"/"$carpeta"
          sudo chown "$USER":"$USER" /home/"$USER"/"$carpeta"
          sudo chmod 777 /home/"$USER"/"$carpeta"
          echo "Carpeta creada con exito!!!"
          read
        ;;
        *)
          echo "Valor incorrecto!!!"
          read
        ;;
      esac
    ;;
    8)
      echo "Actualizando repositorios..."
      sudo apt update && sudo apt upgrade -y
      echo "Actualizacion completada, pulse cualquier tecla para continuar"
      read
    ;;
    9)
      echo "Instalando git..."
      sudo apt install git -y
      echo "Instalacion completa, pulse cualquier tecla para continuar"
      read
    ;;
    10)
      read -p "En cuantos minutos quieres que se apague? " min
      case $min in
        [0-9]*)
          echo "Se apagará en "$min"."
          sudo shutdown -h +$min;
          read -p "Para cancelar el apagado, pulsa cualquier numero, para continuar, pulsa cualquier otra tecla. " apagado
          case $apagado in
            [0-9]*)
              echo "Cancelando apagado, pulsa cualquier tecla para continuar"
              sudo shutdown -c
              read
            ;;
            *)
            ;;
          esac
        ;;
        *)
          echo "Valor incorrecto, volviendo al menú...."
        ;;
      esac
    ;;
    0)
      echo "Bye!!!"
      exit
    ;;
    *)
      echo "La opcion introducida no es correcta, pulsa cualquier tecla para continuar"
      read
    ;;
  esac

  clear
done