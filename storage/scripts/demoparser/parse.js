const { DemoFile } = require('@markus-wa/demoparser');
const fs = require('fs');

const path = process.argv[2]; // Ruta que envía Laravel
if (!path) process.exit(1);

const fd = fs.readFileSync(path);
const demoFile = new DemoFile();

demoFile.on('end', e => {
    const players = demoFile.players.map(p => ({
        nombre: p.name,
        kills: p.kills,
        muertes: p.deaths,
        asistencias: p.assists,
        kd: p.deaths === 0 ? p.kills : (p.kills / p.deaths).toFixed(2)
    }));

    // Imprimimos el JSON final para que Laravel lo capture
    console.log(JSON.stringify(players));
});

demoFile.parse(fd);