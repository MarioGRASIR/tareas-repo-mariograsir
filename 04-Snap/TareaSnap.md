Mario GONZÁLEZ REYES 



# 1. Instalación de Wekan

	Actualizamos nuestro sistema:

		- sudo apt update && sudo apt upgrade -y

	Instalamos snap si no lo tenemos:

		- sudo apt install snapd -y

	Una vez instalado snap, lo utilizamos para instalar wekan

		- sudo snap install wekan



# 2. Fijar el puerto y la URL raíz

	El puerto que elegiremos tien que ser libre, ya que si elegimos uno que ya usamos nos generará conflicto, en nuestro caso elegiremos el 3001.

		- sudo snap set wekan port='3001'

		- sudo snap set wekan root-url='http://ciberkaos.synology.me:3001'



# 3. Reiniciar servicios del snap

	- sudo systemctl restart snap.wekan.mongodb

	- sudo systemctl restart snap.wekan.wekan



# 4. Configurar Firewall

	Comprobamos la configuracion del firewall:

		- sudo ufw status

	En caso de que nos muestre por pantalla 'Status: inactive', no configuramos nada más.

	En caso de que nos muestr por pantalla 'Status: active' comenzamos la configuración.

		- Lo primero que haremos será activar el puerto que le hemos dado a wekan, en este caso, 3001:

			sudo ufw allow 3001/tcp

		- Comprobamos que el puerto está habilitado:

			sudo ufw status

		- Por último, si todo está bien, reiniciamos el Firewall:

			sudo ufw reload



# 5. Comprobaciones rápidas

	Vemos el estado de los servicios que hemos instalado.

		- systemctl status snap.wekan.wekan --no-pager

		- systemctl status snap.wekan.mongodb --no-pager

		Comprobamos que estám activos si por pantalla nos muestran este mensaje: 

			Active: active (running)

	Por último, comprobamos que el puerto esté escuchando:

		- ss -tunelp | grep 3001



# 6. Acceso a la página

	- Si estamos usando un sistema sin entorno gráfico comprobamos que tenemos acceso a la pagina usando: 

		 curl -I http://ciberkaos.synology.me:3001

		Si todo está bien nos debería mostrar por pantalla:

			HTTP/1.1 200 OK

	- Si tenemos entorno gráfico accedemos desde nuestro navegador a la URL con la que hemos configurado wekan:

		http://ciberkaos.synology.me:3001

		Una vez en la página nos registramos y accedemos.
