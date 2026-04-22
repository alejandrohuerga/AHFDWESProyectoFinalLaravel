# EXPLOTADOR DE ARCHIVOS .DEM

Este repositorio guarda todo un proyecto completo realizado con el framework de PHP Laravel el cual consiste en una aplicación web capaz de extraer la información de las estadísticas de las partidas de *Counter Strike profesionales de E-sports* de cada uno de los jugadores que participen en dicha partida.

Este tipo de aplicaciones web tienen una *gran vista a futuro* debido a que cada vez más deportes tanto tradicionales como modernos estan implementando el análisis de datos para el estudio o preparación de los encuentros en los cuales participen en un futuro.

La obtención de los archivos .dem de las partidas disputadas de manera profesional se pueden obtener de la web de **HLTV** (gratis e ilimitadas sus descargas).

Para la extracción de información de dichos archivos se ha utilizado una **libreria de JavaScript** la cual nos permitira mediante sus métodos y funciones de manera mas liviana y con menos tiempo de carga extraer dicha información y transferirla en formato **JSON** para su posterior presentación en forma de tabla.

## Guía instalación y requerimientos

Como desarrollador web el cual quiera **implementar dicho proyecto de manera local** sin la necesidad de tener acceso a la red y acceder asi desde la aplicación web principal del proyecto , debes de seguir los siguientes pasos y comprobar el *cumplimiento de todos los requisitos:* 

- Realizar la descarga de la última release publicada en este mismo repositorio.
- Sera necesario el uso de un servidor web (Ubuntu Server , Apache Server).
- Si o queremos ejecutar de manera local podremos utilizar **Laragon** *(Programa el cual nos permite la iniciación de un servidor web para php de manera local)*.
- Comprobar la instalación de dependencias en nuestro proyecto.
- Si es la primera vez, debemos ejecutar **"npm install"** en la terminal dentro del   directorio de nuestro proyecto, instalando asi todas las dependencias de nuestro proyecto.
- Una vez instaladas todas las dependencias ya podremos abrir nuestra aplicación web de manera local desde Laragon.

Si como desarrollador web lo que quieres es realizar avances en el código o implementar nuevas funcionalidades a la aplicación web debes de tener en cuenta los siguientes requisitos:

- Debes de tener instalado node js en tu ordenador.
- Debes de saber que necesitaras varios paquetes de Laravel descargados.
- Debes saber que se utiliza Vite para desplegar la aplicación web en local, debes de tenerlo instalado.
- A continuación te dejo una lista con todas las **dependencias necesarias para su desarrollo:**
    
        "@tailwindcss/forms": "^0.5.2",
        "@tailwindcss/vite": "^4.0.0",
        "alpinejs": "^3.4.2",
        "autoprefixer": "^10.4.2",
        "axios": "^1.11.0",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^2.0.0",
        "postcss": "^8.4.31",
        "tailwindcss": "^3.1.0",
        "vite": "^7.0.7"


*Esta información ha sido proporcionada a traves del archivo **package.json** de nuestro proyecto*