<?php

return [
    'congratulations_title' => 'Congratulations!!',
    'defined_defaults' => 'You have defined the default settings for your server. Now, you have to define your vhosts.',
    'missing_defaults_title' => 'Missing defaults',
    'missing_defaults_text' => 'It looks like you haven\'t defined the <a href="%url%">default settings</a> for your server. Once, you\'re finished, you have to define your vhosts.',
    'step_1' => 'Go to <a href="%url%">Vhost List</a> and create new vhosts or edit existing',
    'step_2' => 'In the vhost form, set first a descriptive name for the vhost',
    'step_3' => 'Choose a Vhost Type: The system uses a set of Vhost Types with pre-configured templates and parameters tailored for specific application purposes (e.g., a simple PHP app, a reverse proxy, a static site).',
    'step_4' => 'There is a first section, Common Parameters, where you set parameters like the name server, domain suffix, SSL certificate paths, log formats, etc, which are then used as a baseline for new Vhosts.',
    'step_5' => 'Then there is the Vhost Type related parameters section, where you set the necessary parameters related to the vhost type.',
    'step_6' => 'There is an option section for an Extra block, where you can enter arbitrary nginx directives or blocks, which will be appended at the bottom of the configuration.',
    'step_7' => 'As you type the parameters, you can see at the right side, a live, real-time preview of the Nginx configuration file.',
    'step_8' => 'When finished, save the Vhost and repeat the process for all your vhosts.',
    'publish_title' => 'Publish Vhosts (Console Command)',
    'publish_text' => 'Once all Vhosts are configured and saved in the database, use the console command to generate the actual files and symbolic links. If run with superuser permissions (<code>sudo</code> or as <code>root</code>), files will be created in the base dir, <code>/etc/nginx</code>. Otherwise, a test directory in <code>var/nginx-test/</code> will be used instead (just to check the results). You can force a different directory by using the <code>--base-dir</code> parameter, in whose case you have to make sure you have write permissions for that directory.',
    'generate_all_vhosts_title' => 'Generate all Vhosts',
    'generate_all_vhosts_text' => 'This command will generate or update all Vhosts defined in the database.',
    'generate_specific_vhost_title' => 'Generate a specific Vhost',
    'generate_specific_vhost_text' => 'Being <code>my-vhost</code> the name given to a self-created vhost in the database, you can use',
    'simulate_generation_title' => 'Simulate generation',
    'simulate_generation_text' => 'Use the <code>--dry-run</code> option to check the generation logic without affecting your system.',
];
