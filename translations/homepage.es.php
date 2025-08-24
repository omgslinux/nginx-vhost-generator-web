<?php

return [
    'congratulations_title' => '¡¡Enhorabuena!!',
    'defined_defaults' => 'Has definido la configuración por defecto para tu servidor. Ahora, tienes que definir tus vhosts.',
    'missing_defaults_title' => 'Faltan valores por defecto',
    'missing_defaults_text' => 'Parece que no has definido la <a href="%url%">configuración por defecto</a> para tu servidor. Cuando termines, tendrás que definir tus vhosts.',
    'step_1' => 'Ve a <a href="%url%">la Lista de Vhosts</a> y crea nuevos vhosts o edita los existentes',
    'step_2' => 'En el formulario del vhost, establece primero un nombre descriptivo para el vhost',
    'step_3' => 'Elige un tipo de Vhost: el sistema utiliza un conjunto de tipos de Vhost con plantillas y parámetros preconfigurados para propósitos de aplicación específicos (por ejemplo, una aplicación PHP simple, un proxy inverso, un sitio estático).',
    'step_4' => 'Hay una primera sección, Parámetros Comunes, donde se establecen parámetros como el nombre del servidor, sufijo de dominio, rutas de certificados SSL, formatos de log, etc.',
    'step_5' => 'Luego, está la sección de parámetros relacionados con el tipo de Vhost, donde se establecen los parámetros necesarios relacionados con el tipo de vhost.',
    'step_6' => 'Hay una sección opcional para un bloque extra, donde se pueden introducir directivas o bloques de Nginx arbitrarios, que se adjuntarán al final de la configuración.',
    'step_7' => 'Mientras escribes los parámetros, puedes ver a la derecha una vista previa en tiempo real del archivo de configuración de Nginx.',
    'step_8' => 'Cuando termines, guarda el Vhost y repite el proceso para todos tus vhosts.',
    'publish_title' => 'Publicar Vhosts (Comando de consola)',
    'publish_text' => 'Una vez que todos los Vhosts están configurados y guardados en la base de datos, hay que usar el comando de consola para generar los archivos y enlaces simbólicos. Si se ejecuta con permisos de superusuario (<code>sudo</code> o como <code>root</code>), los archivos se crearán en el directorio base, <code>/etc/nginx</code>. De lo contrario, se usará un directorio de prueba en <code>var/nginx-test/</code> (solo para comprobar los resultados). Puedes forzar un directorio diferente usando el parámetro <code>--base-dir</code>, en cuyo caso debes asegurarte de tener permisos de escritura para ese directorio.',
    'generate_all_vhosts_title' => 'Generar todos los Vhosts',
    'generate_all_vhosts_text' => 'Este comando generará o actualizará todos los Vhosts definidos en la base de datos.',
    'generate_specific_vhost_title' => 'Generar un Vhost específico',
    'generate_specific_vhost_text' => 'Siendo <code>mi-vhost</code> el nombre de un vhost creado en la base de datos, puedes usar',
    'simulate_generation_title' => 'Simular generación',
    'simulate_generation_text' => 'Usa la opción <code>--dry-run</code> para comprobar la lógica de generación sin afectar a tu sistema.',
];
