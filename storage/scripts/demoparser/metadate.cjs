/**
 * Este archivo tiene todo el código necesario para sacar la información,
 * el metadata de la partida jugada como por ejemplo el nombre del mapa 
 * o el nombre del servidor donde se jugo.
 * 
 * @return Archivo JSON con la infromación.
 * 
 * @author Alejandro De la Huerga
 * @version 1.0.0
 * @since 06/05/2026
 */

// Importamos la función de la libreria.
const { parseHeader } = require('@laihoe/demoparser2');

const pathToDemo = process.argv[2]; 

if (!pathToDemo) {
    process.exit(1);
}

try{
    // Extraemos el nombre del mapa desde el header.
    const header = parseHeader(pathToDemo);
    const map_name = header.map_name ?? "Desconocido";

    const result = {
        map: header.map_name ?? 'unknown'
    };
    
    process.stdout.write(JSON.stringify(result));

}catch (e){
    // Los errores van al canal de error, no al de salida (stdout)
    process.stderr.write(e.message);
    process.exit(1);
}