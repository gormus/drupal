<?php

// @codingStandardsIgnoreFile

$databases['default']['default'] = [
  'database' => getenv('DRUPAL_DB_DATABASE'),
  'username' => getenv('DRUPAL_DB_USERNAME'),
  'password' => getenv('DRUPAL_DB_PASSWORD'),
  'host' => getenv('DRUPAL_DB_HOST'),
  'port' => getenv('DRUPAL_DB_PORT'),
  'driver' => getenv('DRUPAL_DB_DRIVER'),
  'prefix' => getenv('DRUPAL_DB_PREFIX'),
  'collation' => getenv('DRUPAL_DB_COLLATION'),
];
$settings['config_sync_directory'] = '../config/sync';
$settings['hash_salt'] = getenv('DRUPAL_SALT');
$settings['deployment_identifier'] = \Drupal::VERSION;
$settings['update_free_access'] = FALSE;
# $settings['file_public_base_url'] = 'http://downloads.example.com/files';
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = '';
$settings['file_temp_path'] = '/tmp';
$config['system.performance']['fast_404']['exclude_paths'] = '/\/(?:styles)|(?:system\/files)\//';
$config['system.performance']['fast_404']['paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
$config['system.performance']['fast_404']['html'] = '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

$settings['trusted_host_patterns'] = [
  '^www\.example\.com$',
];
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];
$settings['entity_update_batch_size'] = 50;
$settings['entity_update_backup'] = TRUE;
$settings['migrate_node_migrate_type_classic'] = FALSE;

if (file_exists($app_root . '/' . $site_path . '/settings.production.php')) {
  include $app_root . '/' . $site_path . '/settings.production.php';
}

/**
 * Load local development override configuration, if available.
 *
 * Use settings.local.php to override variables on secondary (staging,
 * development, etc) installations of this site. Typically used to disable
 * caching, JavaScript/CSS compression, re-routing of outgoing emails, and
 * other things that should not happen on development and testing sites.
 *
 * Keep this code block at the end of this file to take full effect.
 */
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
