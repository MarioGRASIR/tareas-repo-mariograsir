
# REQUISITOS:

	1- Comenzamos reseteando la tarjeta MicroSD de nuestra RaspBy
	2- Mediante la interfaaz gráfica de RaspBerryImager hemos renombrado las Raspi          con el nombre "dictadorg1".
	3- Asignamos la IP fija 192.168.1.177


## 1. Instalar Docker.

	- Actualizamos e instalamos Docker
		sudo apt update && sudo apt upgrade -y
		curl -sSL https://get.docker.com | sh
		sudo usermod -aG docker $USER
	- Reiniciamos
		sudo reboot
	- Comprobacion del funcionamiento de Docker
		sudo docker run hello-world
## 2. Crear volúmenes y red para Pi-hole.


		docker volume create pihole_etc
		docker volume create pihole_dnsmasq
		


## 3. Ejecutar Pi-hole con Docker. (Opción 1)

	- Creamos el contenedor con un solo comando.
		docker run -d \
		    --name pihole \
		    --restart=unless-stopped \
		    -e TZ="Europe/Madrid" \
		    -e WEBPASSWORD="tu_contraseña_segura" \
		    -e DNSMASQ_LISTENING=all \
		    -v pihole_etc:/etc/pihole \
		    -v pihole_dnsmasq:/etc/dnsmasq.d \
		    -p 53:53/tcp -p 53:53/udp \
		    -p 80:80/tcp \
		    --hostname pi-hole \
		    --dns=127.0.0.1 --dns=1.1.1.1 \
		    pihole/pihole:latest

## 4. Usar Docker Compose. (Opción 2)
	- Crear el contenedor creando un archivo docker-compose.yml en /home/pi/pihole
	- Dentro de docker-compose.yml escribimos esto:
			version: "3"
			services:
			  pihole:
			    container_name: pihole
			    image: pihole/pihole:latest
			    restart: unless-stopped
				#network_mode: "host" >>>> Simplifica el uso de los puerto 53 y 80                  para evitar conflictos con el firewall de Docker
			    network_mode: "host"
			    environment:
				      TZ: 'Europe/Madrid'
				      WEBPASSWORD: 'tu_contraseña_segura'
			    volumes:
				      - ./etc-pihole:/etc/pihole
				      - ./etc-dnsmasq.d:/etc/dnsmasq.d
	
	- Lo lanzamos con el comando:
			docker compose up -d 

## 5. Configurar IP estática
	- Modificamos el archivo dhcpd.conf, para ello:
			sudo nano /etc/dhcpd.conf
		Añadimos esto en la ultima línea:
			interface eth0 static ip_address=<IP que deseas>/24 staticrouters=192.168.0.1 static domain_name_servers=1.1.1.1

## 6. Pruebas

	- Las pruebas que hemos llevado a cabo, son ver como cambiaban los valores             entrando a http://<IP_de_tu_Raspberry>/admin.
	  
![[Captura de pantalla 2025-11-07 111519.png]]	 
	- Hemos probado desde dos PCs, uno al que le asignamos como DNS primaria la IP de nuestra raspberry con Pi-Hole configurado, y a la otra le hemos dejado las DNS de Google. Al entrar en www.speedtest.net, al primer pc no le aparecían anuncios, en cambio, al segundo PC le aparecían los anuncios.


![[Captura de pantalla 2025-11-07 130055.png]]
### **Preguntas de ejemplo para reflexionar (añadir al Readme.me)**

1. ¿Qué diferencia hay entre cambiar el DNS en un solo dispositivo y hacerlo en el router?
    La principal diferencia reside en que cambiar el DNS en un solo dispositivo solo afecta a ese  equipo, sin embargo hacerlo en el router aplica ese cambio en todos los dispositivos conectados a esa red. 
    Al configurar el router centralizamos la gestión y evitamos las configuraciones individuales,  limitando el control específico por dispositivo. 
    
2. ¿Por qué es importante que la Raspberry tenga una IP fija?
	 Porque la fija garantiza que otros dispositivos encuentren siempre a la Raspy en la misma dirección dentro de la misma red. Si se cambia la IP (por DHCP por ejemplo) los servicios que dependen de ella (como Pi-Hole) dejarían de funcionar correctamente hasta nueva dirección. 
    
3. ¿Qué ventajas de privacidad aporta Pi-hole frente a usar DNS públicos?
	 Gracias a Pi-hole bloqueamos las solicitudes que van hacia dominios de rastreo y publi, antes de que salgan de nuestra red, evitando así que se envíen datos a terceros. Además, al resolver los DNS de forma local, se reduce la cantidad de información que se comparte con proveedores externos de DNS como Google, Cloudflare, etc...
    
4. ¿Qué limitaciones podría tener Pi-hole en una red grande?
	 Implementado en una red grande con muchos dispositivos o mucho tráfico, puede convertirse en un cuello de botella si la Raspy, NAS, o disositivo en el que esté instalado no tiene suficiente capacidad de procesamiento o memoria. 
	 También se requiere una buena configuración respecto a las listas de mantenimiento para evitar falsos bloqueos o caídas de servicio. 


**Cómo apunte positivos que hemos encontrado a la hora de añadir listas de bloqueo, observamos que cada vez que el Holi-Pi bloquea publicidad, agrega las urls al listado de direcciones con una casilla pendiente de marcar, ofreciéndonos la posibilidad de agregarlas de forma rápida y sencilla de forma permanente a listado de bloqueadas. 

 Implementado y elaborado por el Grupo1 
 07/11/2025