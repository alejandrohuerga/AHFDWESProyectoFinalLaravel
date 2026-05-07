# EXPLOTADOR DE ARCHIVOS .DEM

Este repositorio guarda todo un proyecto completo realizado con el framework de PHP Laravel el cual consiste en una aplicación web capaz de extraer la información de las estadísticas de las partidas de *Counter Strike profesionales de E-sports* de cada uno de los jugadores que participen en dicha partida.

Este tipo de aplicaciones web tienen una *gran vista a futuro* debido a que cada vez más deportes tanto tradicionales como modernos estan implementando el análisis de datos para el estudio o preparación de los encuentros en los cuales participen en un futuro.

La obtención de los archivos .dem de las partidas disputadas de manera profesional se pueden obtener de la web de **HLTV** (gratis e ilimitadas sus descargas).

Para la extracción de información de dichos archivos se ha utilizado una **libreria de JavaScript** la cual nos permitira mediante sus métodos y funciones de manera mas liviana y con menos tiempo de carga extraer dicha información y transferirla en formato **JSON** para su posterior presentación en forma de tabla.

## Pila de tecnologías

**A continuación tenemos la pila de tecnologías utilizadas para la elaboración de esta aplicación web:**

*El proyecto utiliza una arquitectura híbrida que combina la robusta herramienta web de Laravel con las capacidades especializadas de procesamiento de datos de Node.js.*

![Tabla con pila de tecnologías](/public/doc/PilaTecnologias.PNG)

## Primeros pasos y instalación

*Esta página proporciona una guía técnica completa para la configuración del proyecto CS2 Demo Analyzer en un entorno de desarrollo local. La aplicación aprovecha una pila híbrida que involucra un backend de Laravel 12 y un analizador binario basado en Node.js para procesar archivos .dem*

### Requisitos previos

Antes de comenzar la instalación, asegúrese de que su sistema cumple con los siguientes requisitos:

![Tabla requerimientos](/public/doc/TablaRequerimientos.PNG)

### Pasos de instalación

**1. Configuración de clones y entornos**

*Clone el repositorio y prepare la configuración del entorno. El proyecto incluye una setupGuión en composer.jsonEsto automatiza varios de estos pasos.*

```bash
git clone https://github.com/alejandrohuerga/AHFDWESProyectoFinalLaravel.git
cd AHFDWESProyectoFinalLaravel
cp .env.example .env
```

**2. Instalación de dependencia**

*El proyecto requiere paquetes de PHP y JavaScript.*

- **Dependencias de PHP:** Administrado a través de Compositor. Los paquetes clave incluyen laravel/framework y laravel/breeze **(composer.json 10-16)**.

- **Dependencias de JavaScript:** Administrado a través de NPM. Incluye alpinejs, axios, y tailwindcss **(package.json 12-18)**.

```bash
composer install
npm install
```

**3. Clave de la aplicación y base de datos**

Genere la clave de cifrado de la aplicación y prepare la base de datos. De forma predeterminada, el entorno está configurado para usar SQLite **(env.example)**.

```bash
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
```

**4. Compilación de archivos**

El frontend utiliza Vite Para compilar CSS y JS. Los puntos de entrada están definidos en **(resources/js/app.js 1-3) (resources/css/app.css 1-3)**.

```bash
npm run build
```

**5. Mapeo de configuración**

Esta tabla asigna los componentes del sistema a sus respectivas entidades de código para facilitar la navegación durante la configuración.

![Tabla mapeo configuración](/public/doc/TablaMapeoConfiguración.PNG)



