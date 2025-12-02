#!/bin/bash
# NMAP HELPER - Menú educativo basado en funciones proporcionadas
# Muestra nota legal/ética al inicio y después de cada opción.

usage_note() {
  cat <<EOF

IMPORTANTE (ÉTICA Y LEGAL):
- Solo escanea equipos y redes que sean de tu propiedad o para los que tengas permiso explícito.
- El escaneo puede ser detectado por IDS/IPS y puede tener consecuencias en redes de producción.
- No uses estos comandos en redes públicas sin autorización.

EOF
}

# Comprueba si nmap está instalado
check_nmap() {
  if ! command -v nmap >/dev/null 2>&1; then
    echo "nmap no está instalado. Instala con: sudo apt update && sudo apt install -y nmap"
    exit 1
  fi
}

# Comprueba permisos (algunas opciones requieren sudo)
check_sudo() {
  if [ "$(id -u)" -ne 0 ]; then
    echo "AVISO: Algunas opciones (p.ej. -sS, -O) funcionan mejor con sudo."
    echo "Puedes ejecutar este script con sudo o introducir la contraseña cuando se solicite."
  fi
}

# Helper para leer target y directorio de salida
read_target_and_outdir() {
  read -p "Introduce objetivo (IP o hostname): " TARGET
  if [ -z "$TARGET" ]; then
    echo "Objetivo no especificado. Abortando."
    return 1
  fi
  read -p "Directorio para resultados (por defecto ./nmap_results): " OUTDIR
  OUTDIR=${OUTDIR:-./nmap_results}
  mkdir -p "$OUTDIR"
  TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
  return 0
}

# 1) Ping scan (descubrir hosts vivos)
ping_scan() {
  read_target_and_outdir || return
  OUTFILE="$OUTDIR/ping_${TARGET}_${TIMESTAMP}.txt"
  echo "Ejecutando ping scan (ICMP + ARP) a $TARGET..."
  nmap -sn "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 2) TCP SYN scan (stealth) + puertos top 100
tcp_syn_top() {
  read_target_and_outdir || return
  OUTFILE="$OUTDIR/syn_top_${TARGET}_${TIMESTAMP}.txt"
  echo "Ejecutando TCP SYN scan (--top-ports 100 -sS -T4) a $TARGET..."
  sudo nmap -sS --top-ports 100 -T4 -v "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 3) TCP connect (sin privilegios) y escaneo de puertos específicos
tcp_connect_ports() {
  read_target_and_outdir || return
  read -p "Introduce puertos (p.ej. 22,80,443 o 1-1024): " PORTS
  PORTS=${PORTS:-1-1024}
  OUTFILE="$OUTDIR/connect_${TARGET}_${TIMESTAMP}.txt"
  echo "Ejecutando TCP connect scan (-sT -p $PORTS) a $TARGET..."
  nmap -sT -p "$PORTS" -v "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 4) Detección de servicios y versiones
service_version() {
  read_target_and_outdir || return
  OUTFILE="$OUTDIR/service_${TARGET}_${TIMESTAMP}.txt"
  echo "Ejecutando -sV (detección de servicios) y -sC (scripts por defecto) a $TARGET..."
  sudo nmap -sV -sC -p- -T4 "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 5) OS detection (detección del sistema operativo)
os_detection() {
  read_target_and_outdir || return
  OUTFILE="$OUTDIR/os_${TARGET}_${TIMESTAMP}.txt"
  echo "Ejecutando -O (detectar sistema operativo) a $TARGET..."
  sudo nmap -O -v "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 6) Escaneo UDP (recomendado hacerlo con permiso y tiempo)
udp_scan() {
  read_target_and_outdir || return
  OUTFILE="$OUTDIR/udp_${TARGET}_${TIMESTAMP}.txt"
  echo "Escaneo UDP (lento). Se recomienda usar solo en entornos de laboratorio..."
  sudo nmap -sU -p- -T3 "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 7) Escaneo agresivo (equivalente a -A)
aggressive_scan() {
  read_target_and_outdir || return
  OUTFILE="$OUTDIR/aggressive_${TARGET}_${TIMESTAMP}.txt"
  echo "Escaneo agresivo (-A) a $TARGET (combinado: OS, versiones, scripts, traceroute)..."
  sudo nmap -A -p- -T4 "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 8) Uso de NSE scripts (p.ej. vulnerabilidades)
nse_vuln_scan() {
  read_target_and_outdir || return
  read -p "Introduce categoría o script (p.ej. vuln,safe,auth,http-vuln*): " NSE
  NSE=${NSE:-vuln}
  OUTFILE="$OUTDIR/nse_${NSE}_${TARGET}_${TIMESTAMP}.txt"
  echo "Ejecutando NSE scripts --script $NSE a $TARGET..."
  sudo nmap --script="$NSE" -p- -T4 "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 9) Salida en formatos (normal, xml, grepable)
example_output_formats() {
  read_target_and_outdir || return
  OUTPREFIX="$OUTDIR/output_${TARGET}_${TIMESTAMP}"
  echo "Ejecutando ejemplo con -oN (normal), -oX (xml) y -oG (grepable)..."
  nmap -sV --top-ports 50 "$TARGET" -oN "${OUTPREFIX}.nmap" -oX "${OUTPREFIX}.xml" -oG "${OUTPREFIX}.gnmap"
  echo "Resultados: ${OUTPREFIX}.nmap, ${OUTPREFIX}.xml, ${OUTPREFIX}.gnmap"
}

# 10) Escaneo sin ping (útil para hosts que filtran ICMP)
no_ping_scan() {
  read_target_and_outdir || return
  OUTFILE="$OUTDIR/noping_${TARGET}_${TIMESTAMP}.txt"
  read -p "Introduce puertos (por defecto top 100): " PORTS
  PORTS=${PORTS:---top-ports 100}
  echo "Ejecutando -Pn (no ping) a $TARGET..."
  nmap -Pn $PORTS -T4 "$TARGET" -oN "$OUTFILE"
  echo "Resultado: $OUTFILE"
}

# 11) Opción personalizada para nmap
custom_nmap() {
  read -p "Introduce las opciones para nmap (por ejemplo: -p 80 -sV --script=vuln): " custom_opts
  read -p "Introduce la IP, o el rango de IP para hacer el escaneo: " ip
  if [ -z "$ip" ]; then
    echo "IP no especificada. Abortando."
    return 1
  fi
  read -p "Directorio para resultados (por defecto ./nmap_results): " OUTDIR
  OUTDIR=${OUTDIR:-./nmap_results}
  mkdir -p "$OUTDIR"
  TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
  OUTFILE="$OUTDIR/custom_${TIMESTAMP}.txt"
  echo "Ejecutando: sudo nmap $custom_opts \"$ip\""
  # Usar eval con precaución para respetar cadenas del usuario
  sudo eval "nmap $custom_opts \"$ip\" -oN \"$OUTFILE\""
  echo "Resultado: $OUTFILE"
}

# 12) Salir se maneja en el menú principal

# Inicio
check_nmap
check_sudo

clear
usage_note
read -p "Presiona Enter para continuar..."

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
  echo "11) Crea tu propia opción para nmap"
  echo "12) Salir"
  echo "========================================"
  read -p "Elige opción [1-12]: " opt

  case $opt in
    1)
      ping_scan
      ;;
    2)
      tcp_syn_top
      ;;
    3)
      tcp_connect_ports
      ;;
    4)
      service_version
      ;;
    5)
      os_detection
      ;;
    6)
      udp_scan
      ;;
    7)
      aggressive_scan
      ;;
    8)
      nse_vuln_scan
      ;;
    9)
      example_output_formats
      ;;
    10)
      no_ping_scan
      ;;
    11)
      custom_nmap
      ;;
    12)
      usage_note
      echo "Saliendo del menú...."
      read -p "Presiona Enter para salir..."
      exit 0
      ;;
    *)
      echo "Opción inválida."
      ;;
  esac

  # Mostrar nota legal y esperar antes de volver al menú (se hace tras cada acción)
  echo
  usage_note
  read -p "Presiona Enter para continuar..."
done