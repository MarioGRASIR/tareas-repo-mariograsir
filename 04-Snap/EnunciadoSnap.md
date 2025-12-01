Snap es un sistema de empaquetado y distribución de software desarrollado por Canonical, la empresa detrás de Ubuntu.
Su propósito es simplificar la instalación de aplicaciones en Linux y hacer que funcionen igual en cualquier distribución.

¿Qué problema resuelve Snap?
Tradicionalmente, cada distribución Linux usa su propio sistema de paquetes:

Ubuntu/Debian usan .deb

Fedora usa .rpm

Arch usa pacman

Eso obliga a los desarrolladores a crear versiones distintas del mismo programa para cada sistema.
Snap elimina esa fragmentación: crea un paquete único y autocontenido, que funciona en cualquier distribución compatible con snapd.

¿Qué contiene un paquete snap?
Un snap no solo trae el programa principal, sino todas sus dependencias: bibliotecas, binarios y configuraciones necesarias para ejecutarlo.
En cierto modo, se comporta como un mini contenedor, aunque no es Docker: no usa el kernel aislado, pero sí espacios de nombres (namespaces) para mantenerlo separado del sistema principal.

3. ¿Cómo se instala y usa?
Primero se instala el servicio que gestiona los snaps:

sudo apt install snapd
Luego puedes instalar aplicaciones desde el Snap Store:

sudo snap install wekan sudo snap install nextcloud sudo snap install code --classic
Cada aplicación queda montada en un entorno aislado bajo /snap/ y se actualiza sola en segundo plano.

4. ¿Qué ventajas tiene?
Compatibilidad: mismo paquete en Ubuntu, Fedora, Arch, etc.

Aislamiento: cada app corre en un “sandbox”, más segura.

Actualizaciones automáticas: se actualizan sin intervención.

Fácil de revertir: puedes volver a una versión anterior.

Dónde vive todo esto
Servicio principal: snapd

Paquetes instalados: /snap/

Configuraciones: /var/snap/

Comandos útiles:

snap list # ver apps instaladas snap info wekan # detalles del paquete snap remove wekan snap refresh # actualizar todos
Snap tiene su propio “repositorio oficial” llamado Snap Store, y ahí hay cientos de aplicaciones empaquetadas.

Visita:
👉 https://snapcraft.io/store

Ahí verás todas las aplicaciones disponibles, clasificadas por categorías:

Servidor (Nextcloud, Wekan, Mosquitto, etc.)

Desarrollo (VS Code, Postman, Node, etc.)

Productividad (LibreOffice, Slack, etc.)

Multimedia (OBS Studio, Spotify, VLC, etc.)

Cada ficha tiene los comandos exactos para instalarla en Ubuntu u otras distribuciones compatibles.

Desde la terminal
Una vez instalado snapd, puedes explorar el catálogo directamente.

Buscar una aplicación concreta:
snap search wekan
O algo más genérico:

snap search editor snap search server snap search database
Te mostrará una tabla con:

Name Version Publisher Notes Summary wekan 7.15 x2visio✓ - The open-source Trello-like kanban
Ver las aplicaciones ya instaladas:
snap list
Información detallada de una app:
snap info wekan
TAREA
 

Inicia una maquina virtual Ubuntu Server  (Puedes crear una nueva o partir de una clonación que tengas con un server "Limpio").
Instala en el servidor Wekan utilizando Snap

sudo apt update && sudo apt -y upgrade
sudo apt -y install snapd


Wekan se distribuye como snap y se instala con un único comando. 

sudo snap install wekan

Ese comando descarga e instala Wekan (MongoDB viene gestionado por el propio snap). 


2) Fijar el puerto y la URL raíz

Elige un puerto libre (ej. 3001) y fija la ROOT_URL con la IP o dominio de tu servidor:


sudo snap set wekan port='3001'
sudo snap set wekan root_url="http://<IP-del-servidor>:3001"

Wekan necesita un puerto y una URL raíz para construir correctamente enlaces y callbacks. 


3) Reiniciar servicios del snap

sudo systemctl restart snap.wekan.mongodb
sudo systemctl restart snap.wekan.wekan


Wekan usa MongoDB bajo el capó en el snap; al cambiar ajustes conviene reiniciar ambos servicios. 


4) Abrir el firewall (si usas UFW)
sudo ufw allow 3001/tcp
sudo ufw reload

5) Comprobaciones rápidas
# Ver estado de los servicios
systemctl status snap.wekan.wekan --no-pager
systemctl status snap.wekan.mongodb --no-pager

# Comprobar que el puerto está escuchando
ss -tunelp | grep 3001

6) Primer acceso y creación de usuario

Entra desde un navegador:

http://<IP-del-servidor>:3001