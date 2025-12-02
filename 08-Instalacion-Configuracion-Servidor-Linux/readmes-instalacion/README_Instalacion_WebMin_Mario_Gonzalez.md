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