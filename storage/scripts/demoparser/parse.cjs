const { parseEvent, parseTicks } = require('@laihoe/demoparser2');

const pathToDemo = process.argv[2]; 

if (!pathToDemo) {
    process.exit(1);
}

try {
    const roundEnds = parseEvent(pathToDemo, "round_end");
    
    // Si la demo está vacía o corrupta, evitamos el error de Math.max
    if (!roundEnds || roundEnds.length === 0) {
        process.exit(1);
    }

    const gameEndTick = Math.max(...roundEnds.map(x => x.tick));

    // Añadimos 'user_name' para que la tabla no salga vacía
    const fields = [
        "name", 
        "kills_total", 
        "deaths_total", 
        "mvps", 
        "headshot_kills_total", 
        "ace_rounds_total", 
        "score"
    ];

    const scoreboard = parseTicks(pathToDemo, fields, [gameEndTick]);

    // IMPORTANTE: Imprimimos SOLO el JSON. 
    // No pongas console.log de "Cargando..." ni nada parecido.
    process.stdout.write(JSON.stringify(scoreboard)); 

} catch (e) {
    // Los errores van al canal de error, no al de salida (stdout)
    process.stderr.write(e.message);
    process.exit(1);
}