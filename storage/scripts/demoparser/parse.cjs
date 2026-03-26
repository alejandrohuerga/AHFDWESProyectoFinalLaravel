// parser.js
const { parseEvent, parseTicks } = require('@laihoe/demoparser2');

// Capturamos la ruta que nos mande PHP
const pathToDemo = process.argv[2]; 

if (!pathToDemo) {
    process.exit(1);
}

try {
    let roundEnds = parseEvent(pathToDemo, "round_end");
    let gameEndTick = Math.max(...roundEnds.map(x => x.tick));

    let fields = ["kills_total", "deaths_total", "mvps", "headshot_kills_total", "ace_rounds_total", "score"];
    let scoreboard = parseTicks(pathToDemo, fields, [gameEndTick]);

    // IMPORTANTE: Solo imprimir el JSON y nada más
    console.log(JSON.stringify(scoreboard));
} catch (e) {
    process.stderr.write(e.message);
    process.exit(1);
}