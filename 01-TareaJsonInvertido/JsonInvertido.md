## README TAREA JASON INVERTIDO MARIO GONZALEZ REYES 

Una vez ya tenemos descargado y arrancado XAMPP, podemos comenzar con el ejercicio. En este caso, se requiere crear un archivo `.json` que nos muestre la información solicitada.

1. **Descargar y descomprimir** el archivo `.zip`.

2. **Copiar archivos a `htdocs`**:
    - Para visualizar todo en el navegador, es necesario copiar los archivos a `htdocs`. 
    - Primero, determinamos la ruta de `htdocs` utilizando el siguiente comando:

   ```bash
      sudo find / -name htdocs
	  Esto devolverá una ruta similar a: `/opt/lamp/htdocs`.
	  ```

3. **Mover archivos a `htdocs`**:

    - Una vez que hemos encontrado la ruta, trasladamos todos los archivos descargados en el `.zip` a `htdocs` con el siguiente comando:

   ```bash
      sudo cd /home/mario/Downloads/archivosEje1/* /opt/lampp/htdocs/
 ```

4. **Eliminar el archivo `index.php` creado automáticamente**:

    - En mi caso, eliminé el archivo utilizando el comando:

   ```bash
      sudo rm -rf index.php
      ```

5. **Visualizar en el navegador**:

    - Ahora, al poner `localhost` en el navegador, comenzaremos a visualizar el `index.html` que hemos adjuntado.

## Creación del archivo JSON

Para mostrar una lista de productos, creamos un archivo llamado `productos.json`. Ésta es la estructura que he usado:

```json
[
  {
    "nombre": "Tarta de Chocolate",
    "precio": 15,
    "stock": 10
  },
  {
    "nombre": "Cheesecake",
    "precio": 12,
    "stock": 5
  },
  {
    "nombre": "Brownie",
    "precio": 12,
    "stock": 7
  }
]
```

Para continuar con el siguiente apartado he renombrado todo lo usado haciendo:

```shell

	sudo mv index.html indexEj1.html
	sudo mv styles.css stylesEj1.css
	sudo mv script.js scriptEj1.js
	sudo mv producto.json productoEj1.json

```

# EJERCICIO 2

Ahora hacemos exactamente los mismos pasos que hemos visto antes, y una vez hechos. *Ten en cuenta que cuando copies los archivos de una carpeta a otra, el nombre cambia*.

Una vez visualizamos el index.html en el navegador vemos "Pedidos", entonces analizamos el JavaScript como nos dice el ejercicio:

```bash
	sudo nano script.js
```

Con la primera linea del Script podemos ver como se llama el .json que tenemos que hacer:

```js
	fetch('pedidos.json')
```

Por lo que hacemos un:

```bash
	sudo nano productos.json
``` 

Una vez creado hay que coger un papel y un boli, y realizar un esquema de la estructura.

Cuando lo hayas terminado te ha tenido que salir algo así:
```json
[
{
        "cliente":{
                "nombre":"Francisco Pancho",
                "email":"franciscopancho@gmail.com",
                "direccion":"Avenida Carmelo, 12"
        },
        "productos":[
        {
                "nombre":"PC",
                "cantidad":1,
                "precio":1700.00
        },{
                "nombre":"Teclado",
                "cantidad":1,
                "precio":46.00
        }
        ]
},
{
       "cliente":{
                "nombre":"Mario Gonzalez",[
{
        "cliente":{
                "nombre":"Paco Gómez",
                "email":"pacogomez@gmail.com",
                "direccion":"Avenida Carmelo, 12"
        },
        "productos":[
        {
                "nombre":"PC",
                "cantidad":1,
                "precio":1700.00
        },{
                "nombre":"Teclado",
                "cantidad":1,
                "precio":46.00
        }
        ]
},
{
       "cliente":{
                "nombre":"Mario Gonzalez",
                "email":"mariogonzalez@gmail.com",
                "direccion":"Calle Gloria Fuertes, 2"
        },
        "productos":[ 
        {
                "nombre":"Espejo Inteligente",
                "cantidad":1,
                "precio":169.00
        },{
                "nombre":"Tarjeta SIMS",
                "cantidad":1,
                "precio":50.00
        }
        ]
}
]


                "email":"mariogonzalez@gmail.com",
                "direccion":"Calle Gloria Fuertes, 2"
        },
        "productos":[ 
        {
                "nombre":"Espejo Inteligente",
                "cantidad":1,
                "precio":169.00
        },{
                "nombre":"Tarjeta SIMS",
                "cantidad":1,
                "precio":50.00
        }
        ]
}
]
```

Ahora solo quedaría guardarlo y tendremos la visualización perfecta en el navegador poniendo:

```
	localhost
```

Ahora volvemos a cambiar de nombres, copiamos los archivos a dos carpetas creadas, y entregamos.