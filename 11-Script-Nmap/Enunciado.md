Hacer un script de Bash que reúna los comandos y opciones más útiles de nmap, organizado en funciones y con un menú para que practiquen if/else, funciones, lectura de parámetros y buenas prácticas.y

Completa el script, para ello se te propociona el menú y el conjunto de funciones utilizadas. Debes completarlo para que tenga un funcionamiento correcto

funciones_nmap.txtDownload funciones_nmap.txt

 

# Menú principal
main_menu() {

  while true; do
    clear
    echo "========================================"
    echo "       NMAP HELPER - MENÚ EDUCATIVO     "
    echo "========================================"
    echo "1) Ping scan (descubrir hosts vivos)"
    echo "2) TCP SYN top 100 (--top-ports 100 -sS)"
    echo "3) TCP connect scan y puertos personalizados (-sT -p)"
    echo "4) Detección de servicios y versiones (-sV -sC)"
    echo "5) Detección de SO (-O)"
    echo "6) Escaneo UDP (-sU)"
    echo "7) Escaneo agresivo (-A)"
    echo "8) NSE scripts (--script)"
    echo "9) Salida en formatos (-oN, -oX, -oG)"
    echo "10) Escaneo sin ping (-Pn)"
    echo "11) Crea tu propia opción para namp"
    echo "12) Salir"
    echo "========================================"
    read -p "Elige opción [1-12]: " opt

 

 

En todas las opciones al final debe dar el mensaje de legalidad de uso.

usage_note() {
  cat <<EOF

IMPORTANTE (ÉTICA Y LEGAL):
- Solo escanea equipos y redes que sean de tu propiedad o para los que tengas permiso explícito.
- El escaneo puede ser detectado por IDS/IPS y puede tener consecuencias en redes de producción.
- No uses estos comandos en redes públicas sin autorización.

EOF
}