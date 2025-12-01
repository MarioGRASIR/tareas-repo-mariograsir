<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario Práctica PHP</title>

    <script>

        function validarForm() {

            const formulario = document.form;
            let ok = true;

            //VALIDACIÓN NOMBRE

            let nombre = formulario.nombre;
            let caracteresNombre = /^[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s]+$/;

            if (nombre.value.trim() === "") {
                nombre.style.backgroundColor = "red";
                ok = false;
            }
            else if (nombre.value.length <= 50 && caracteresNombre.test(nombre.value)) {
                nombre.style.backgroundColor = "blue";
            }
            else {
                nombre.style.backgroundColor = "red";
                ok = false;
            }


            //VALIDACIÓN APELLIDO

            let apellidos = formulario.apellidos;
            let caracteresApellidos = /^[A-Za-zÁÉÍÓÚáéíóúÜüÑñ0-9\s]+$/;

            if (apellidos.value.trim() === "") {
                apellidos.style.backgroundColor = "red";
                ok = false;
            }
            else if (apellidos.value.length <= 50 && caracteresApellidos.test(apellidos.value)) {
                apellidos.style.backgroundColor = "blue";
            }
            else {
                apellidos.style.backgroundColor = "red";
                ok = false;
            }


            //VALIDACIÓN EDAD

            let edad = formulario.edad;

            if (edad.value.trim() === "") {
                edad.style.backgroundColor = "red";
                ok = false;
            }
            else if (!isNaN(edad.value) && edad.value >= 1 && edad.value <= 99){
                edad.style.backgroundColor = "blue";
            }
            else {
                edad.style.backgroundColor = "red";
                ok = false;
            }


            //VALIDACIÓN CORREO

            let correo = formulario.correo;
            let caracteresCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (correo.value.trim() === "") {
                correo.style.backgroundColor = "red";
                ok = false;
            }
            else if (caracteresCorreo.test(correo.value.trim())){
                correo.style.backgroundColor = "blue";
            }
            else {
                correo.style.backgroundColor = "red";
                ok = false;
            }


            //VALIDACIÓN PROVINCIA

            let provincia = formulario.provincia;

            if (provincia.value === "") {
                provincia.style.backgroundColor = "red";
                ok = false;
            }
            else {
                provincia.style.backgroundColor = "blue";
            }


            //VALIDACIÓN NACIMIENTO

            let fecha = formulario.fecha;
            let caracteresFecha = /^(0[1-9]|[12]\d|3[01])\/(0[1-9]|1[0-2])\/\d{2}$/;

            if (fecha.value.trim() === ""){
                fecha.style.backgroundColor = "red";
                ok = false;
            }
            else if (caracteresFecha.test(fecha.value.trim())){
                fecha.style.backgroundColor = "blue";
            }
            else {
                fecha.style.backgroundColor = "red";
                ok = false;
            }


            //VALIDACIÓN FIJO

            let telefonofijo = formulario.telefonofijo;
            let caracteresFijo = /^9\d{8}$/;

            if (telefonofijo.value.trim() !== ""){
                if (caracteresFijo.test(telefonofijo.value.trim())) {
                    telefonofijo.style.backgroundColor = "blue";
                }
                else {
                    telefonofijo.style.backgroundColor = "red";
                    ok = false;
                }
            }
            else {
                telefonofijo.style.backgroundColor = "";
            }


            //VALIDACIÓN MÓVIL

            let telefonomovil = formulario.telefonomovil;
            let caracteresMovil = /^6\d{8}$/;

            if (telefonomovil.value.trim() !== ""){
                if (caracteresMovil.test(telefonomovil.value.trim())) {
                    telefonomovil.style.backgroundColor = "blue";
                }
                else {
                    telefonomovil.style.backgroundColor = "red";
                    ok = false;
                }
            }
            else {
                telefonomovil.style.backgroundColor = "";
            }


            //VALIDACIÓN HIJOS

            let hijos = formulario.hijos;
            let hijoSeleccionado = false;

            for (let i = 0; i < hijos.length; i++) {
                if (hijos[i].checked) {
                    hijoSeleccionado = true;
                    hijos[i].parentElement.style.color = "blue";
                }
            }

            if (!hijoSeleccionado) {
                for (let i = 0; i < hijos.length; i++) {
                    hijos[i].parentElement.style.color = "red";
                }
                ok = false;
            }


            //VALIDACIÓN CONDICIONES

            let condiciones = formulario.condiciones;

            if (!condiciones.checked) {
                condiciones.parentElement.style.color = "red";
                ok = false;
            }
            else {
                condiciones.parentElement.style.color = "blue";
            }


            //VALIDACIÓN SUBMIT

            if (ok === true) {
                formulario.submit();
            } else {
                alert("Error: el formulario no se envió. Por favor, revisa los campos en rojo.");
            }
        }

    </script>
</head>
<body>
<div>

    <form name="form" method="post" action="CONTROLADOR/enviarbd.php" onsubmit="event.preventDefault(); validarForm();" novalidate>

        <ul>

            <li>Nombre: <input type="text" name="nombre" maxlength="50"></li>
            <li>Apellidos: <input type="text" name="apellidos" maxlength="50"></li>
            <li>Edad: <input type="text" name="edad" maxlength="2"></li>
            <li>Correo: <input type="text" name="correo"></li>
            <li>Provincia:

                <select name="provincia">

                    <option value="">Elige una opción</option>
                    <option value="madrid">Madrid</option>
                    <option value="barcelona">Barcelona</option>
                    <option value="zaragoza">Zaragoza</option>
                    <option value="valencia">Valencia</option>
                    <option value="sevilla">Sevilla</option>
                    <option value="zaragoza">Zaragoza</option>

                </select>

            </li>
            <li>Fecha de nacimiento: <input type="text" name="fecha" placeholder="DD/MM/AA"></li>
            <li>Teléfono fijo: <input type="text" name="telefonofijo" maxlength="9"></li>
            <li>Teléfono móvil: <input type="text" name="telefonomovil" maxlength="9"></li>
            <li>

                ¿Tienen hijos?:
                <label><input type="radio" name="hijos" value="si">Sí</label>
                <label><input type="radio" name="hijos" value="no">No</label>
            </li>
            <li><label>Acepto las condiciones: <input type="checkbox" name="condiciones"></label></li>
            <li><input type="submit" value="Aceptar"></li>

        </ul>

    </form>

</div>
</body>
</html>