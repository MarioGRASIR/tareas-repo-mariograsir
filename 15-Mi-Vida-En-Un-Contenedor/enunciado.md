AYUDAS: https://miro.com/app/board/uXjVLppKz3E=/?share_link_id=829182590924Links to an external site.

 

 

Reto1

- Crear un contenedor docker de ubuntu.
- Instalar python, la libreria request y de mysql
- Crear una imgane personalizada con el contenedor

Reto 2

Crear un contenedor nuevo con la imagen personalizada  de docker
Este contenedor tendra un volumen con una ruta en el disco del anfitrión (Bind)
Reto 3

Crear un repositorio git en la carpeta del anfitrión y unirlo con un repositorio en Github
Reto 4

Crear un contenedor mysql.
Crear una base de datos, para almacenar Coches. Los campos seran id, marca, modelo, color, km y precio
añadir almenos 10 coches a modo de contenido de muestra.
Reto 5 

Crear en el repositorio Local un programa en python que se conecte a la base de datos y obtenga los registros de la mase de datos.
- El programa debe listar los datos de los coches guardados en la base de datos de forma estetica.
 

ID    MARCA          MODELO         COLOR     KM        PRECIO    
------------------------------------------------------------------------
1     Toyota             Corolla              Blanco    20000     15000     
2     Honda              Civic                Rojo        30000     17000     
3     Ford                  Focus               Azul       25000     16000     

 

Reto 6

Almacenar los datos de conexion a la base de datos en un archivo JSON y que el programa Python los lea de dicho archivo. 
* crear un nuevo archivo para la modificación.
* Realiza un commit en cada paso
crear el .gitignore para que no suba el archivo con los datos de conexión.
Reto 7

Formatear la tabla para que quede mas estetica con la libreria 

+----+--------+---------+-------+-------------+--------+
| ID | Marca  | Modelo  | Color | Kilometraje  | Precio |
+----+--------+---------+-------+-------------+--------+
| 1  | Toyota | Corolla | Rojo  | 25000        | 15000  |
| 2  | Honda  | Civic   | Azul  | 30000        | 18000  |
| 3  | Ford   | Focus   | Blanco| 40000        | 17000  |
+----+--------+---------+-------+-------------+--------+

 

Reto 8

Crear un conetenedor Mongo y conectarse desde la terminal y utilizando MongoDB
Crea la una bd e inserta en una colecci'on coches con el criterio de de campos del reto anterior
Crear un Script de Python  para leer los datos de colecciones de MongoDB y los imprima en una tabla.

 

Reto 9

Subir una imagen personaliza de nuestro contenedor mongodb al  hub de Docker.
En el Linux Parrot montar un contenedor con la imagen subida al hub.