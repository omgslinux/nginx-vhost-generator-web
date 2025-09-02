<?php

return array (
  'static' => 
  array (
    'parameters' => 
    array (
      0 => 
      array (
        'name' => 'index',
        'description' => 'Index parameters after for "index ....;" directive',
        'dataType' => 'text',
        'defaultValue' => 'index.html',
      ),
    ),
    'description' => 'A basic Nginx vhost for static HTML websites',
    'copy' => 
    array (
    ),
  ),
  'proxy' => 
  array (
    'parameters' => 
    array (
      0 => 
      array (
        'name' => 'proxy_pass',
        'description' => 'Url completa de proxy_pass',
        'dataType' => 'text',
        'defaultValue' => 'http://',
      ),
      1 => 
      array (
        'name' => 'useWebsocket',
        'description' => NULL,
        'dataType' => 'boolean',
        'defaultValue' => NULL,
      ),
    ),
    'description' => 'Proxy',
    'copy' => 
    array (
      0 => 'snippets/proxy_ssl_client-upstream.conf',
    ),
  ),
  'php' => 
  array (
    'parameters' => 
    array (
      0 => 
      array (
        'name' => 'index',
        'description' => 'Index parameters after for "index ....;" directive',
        'dataType' => 'text',
        'defaultValue' => 'index.php',
      ),
      1 => 
      array (
        'name' => 'extraIndexLocationBlock',
        'description' => 'Full extra index block (optional)',
        'dataType' => 'text',
        'defaultValue' => NULL,
      ),
    ),
    'description' => 'Generic PHP template',
    'copy' => 
    array (
      0 => 'conf.d/php.conf',
    ),
  ),
  'symfony' => 
  array (
    'parameters' => 
    array (
      0 => 
      array (
        'name' => 'APP_ENV',
        'description' => 'APP_ENV environment',
        'dataType' => 'text',
        'defaultValue' => 'prod',
      ),
    ),
    'description' => 'Symfony',
    'copy' => 
    array (
      0 => 'conf.d/symfony.conf',
      1 => 'conf.d/php.conf',
    ),
  ),
  'mediawiki' => 
  array (
    'parameters' => 
    array (
    ),
    'description' => 'Mediawiki template',
    'copy' => 
    array (
      0 => 'conf.d/php.conf',
    ),
  ),
  'dokuwiki' => 
  array (
    'parameters' => 
    array (
      0 => 
      array (
        'name' => 'useRewrite',
        'description' => 'Use rewrite (0, 1 o 2)',
        'dataType' => 'text',
        'defaultValue' => '0',
      ),
      1 => 
      array (
        'name' => 'DokuwikiInstalled',
        'description' => 'Si está instalado (por seguridad)',
        'dataType' => 'boolean',
        'defaultValue' => NULL,
      ),
    ),
    'description' => 'Dokuwiki template',
    'copy' => 
    array (
      0 => 'conf.d/php.conf',
    ),
  ),
  'nextcloud' => 
  array (
    'parameters' => 
    array (
      0 => 
      array (
        'name' => 'nextcloudDir',
        'description' => 'Relative url for nextcloud (default is empty)',
        'dataType' => 'text',
        'defaultValue' => NULL,
      ),
    ),
    'description' => 'Nextcloud template',
    'copy' => 
    array (
      0 => 'conf.d/nextcloud.conf',
      1 => 'conf.d/php.conf',
    ),
  ),
  'wordpress' => 
  array (
    'parameters' => 
    array (
      0 => 
      array (
        'name' => 'multisiteSubdir',
        'description' => 'Path for multisite when using subir',
        'dataType' => 'text',
        'defaultValue' => NULL,
      ),
      1 => 
      array (
        'name' => 'multisiteSubdomain',
        'description' => 'Subdomain for multisite',
        'dataType' => 'boolean',
        'defaultValue' => NULL,
      ),
      2 => 
      array (
        'name' => 'subdir',
        'description' => 'Subdir for single site',
        'dataType' => 'text',
        'defaultValue' => NULL,
      ),
    ),
    'description' => 'Wordpress template',
    'copy' => 
    array (
      0 => 'conf.d/wordpress.conf',
      1 => 'conf.d/php.conf',
    ),
  ),
);
