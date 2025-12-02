README INSTALANDO DOCKER EN WINDOWS
ASIGNATURA SEGURIDAD Y ALTA DISPONIBILIDAD
MARIO GONZÁLEZ REYES 




# Guía de instalación y uso básico de Docker en Windows

## 1. Introducción

En este documento se describen **paso a paso** las tareas realizadas en clase para:

- Instalar Docker en Windows
- Entender qué es WSL y por qué Docker lo necesita
- Trabajar con imágenes y contenedores (Ubuntu y httpd)
- Crear volúmenes persistentes
- Instalar y usar la extensión **Portainer**
- Usar los comandos básicos de Docker desde la terminal

> ⚠️ Nota: Los ejemplos asumen **Windows 10/11** con permisos de administrador y el uso de **Docker Desktop**.

---

## 2. Instalación de Docker en Windows

### 2.1. Requisitos previos

1. Windows 10/11 (64 bits).
2. Virtualización habilitada en la BIOS (Intel VT-x / AMD-V).
3. Tener privilegios de administrador para instalar software.

### 2.2. Descargar Docker Desktop

1. Ir a la página oficial de Docker Desktop (Docker Hub).
2. Descargar el instalador para **Windows** (`Docker Desktop Installer.exe`).
3. Ejecutar el instalador con doble clic.

### 2.3. Pasos del instalador

1. Aceptar los términos de licencia.
2. Asegurarse de que está marcada la opción:
   - `Use WSL 2 instead of Hyper-V` (si aparece).
3. Continuar con **Next** hasta finalizar la instalación.
4. Al terminar, reiniciar el equipo si lo pide.

### 2.4. Primer inicio de Docker Desktop

1. Abrir **Docker Desktop** desde el menú de inicio.
2. La primera vez, Docker puede tardar un poco en inicializar.
3. Aceptar las configuraciones por defecto.
4. Comprobar que Docker está funcionando abriendo una **terminal** (PowerShell o CMD) y escribiendo:

```bash
docker version
```

---

## 3. ¿Qué es WSL y por qué lo necesita Docker en Windows?

### 3.1. ¿Qué es WSL?

**WSL (Windows Subsystem for Linux)** permite ejecutar un entorno Linux dentro de Windows, sin una máquina virtual completa.

### 3.2. ¿Por qué Docker lo necesita?

Docker requiere funciones del kernel de Linux, por lo que usa **WSL2** para ejecutarse en Windows.

---

## 4. Examinar el catálogo de imágenes en Docker

### 4.1. Desde Docker Desktop

Ir a **Images**, buscar por nombre (`ubuntu`, `httpd`, etc.).

### 4.2. Desde la terminal

```bash
docker search ubuntu
```

---

## 5. Crear un contenedor Ubuntu

```bash
docker run -it ubuntu
```

Salir con:

```bash
exit
```

---

## 6. Crear un contenedor Ubuntu con nombre

```bash
docker run -it --name mi-ubuntu ubuntu
```

---

## 7. Instalar la extensión Portainer

1. Abrir Docker Desktop.
2. Ir a **Extensions**.
3. Buscar **Portainer**.
4. Instalar.

---

## 8. Crear un volumen y usarlo con Ubuntu

### Crear el volumen

```bash
docker volume create mi-volumen
```

### Montarlo en un contenedor

```bash
docker run --name mi-ubuntu -it -v mi-volumen:/datos ubuntu
```

---

## 9. Crear un contenedor httpd en el puerto 8080

```bash
docker run -d --name mi-web -p 8080:80 httpd
```

Visitar en navegador:

```
http://localhost:8080
```

---

## 10. Instalar nano en el contenedor

```bash
docker exec -it mi-ubuntu bash
apt update
apt install -y nano
```

---

## 11. Cambiar el index del contenedor httpd

```bash
docker exec -it mi-web bash
nano /usr/local/apache2/htdocs/index.html
```

---

## 12. Comandos explicados

### Descargar imágenes

```bash
docker pull ubuntu
docker pull ubuntu:20.04
```

### Crear y ejecutar contenedores

```bash
docker run -it ubuntu
docker run -it --name mi-ubuntu ubuntu
docker run --name mi-ubuntu -it -v /datos-persistentes ubuntu
docker run --name mi-ubuntu -it -v mi-volumen:/datos ubuntu
docker run -it -v C:\ruta\local:/ruta/en/contenedor ubuntu
```

### Crear volúmenes

```bash
docker volume create mi-volumen
```

### Consultar información

```bash
docker ps
docker ps -a
docker images
```

### Imagen personalizada

```bash
docker commit mi-ubuntu mi-imagen-personalizada
```

### Operaciones con contenedores

```bash
docker start mi-ubuntu
docker exec -it mi-ubuntu bash
docker start -ai mi-ubuntu
docker rm mi-ubuntu
docker container prune
```

---

## 13. Conclusión

Este documento sirve como guía de referencia para aprender los fundamentos de Docker en Windows.
