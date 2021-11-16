<?php

// phpcs:ignoreFile

/**
 * @file
 * Drupal site-specific configuration file.
 */

// Database settings:
$databases = [];
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

// Location of the site configuration files.
$settings['config_sync_directory'] = '../config/sync';

// Salt for one-time login links, cancel links, form tokens, etc.
$settings['hash_salt'] = getenv('DRUPAL_SALT');

// Deployment identifier.
$settings['deployment_identifier'] = \Drupal::VERSION;

// Access control for update.php script.
$settings['update_free_access'] = FALSE;

// Public file base URL:
# $settings['file_public_base_url'] = 'http://downloads.example.com/files';

// Public file path:
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = '../.private_files';
$settings['file_temp_path'] = '/tmp';

// A custom theme for the offline page:
# $settings['maintenance_theme'] = 'bartik';

// Configuration overrides.
# $config['system.site']['name'] = 'My Drupal site';
$config['user.settings']['anonymous'] = 'Visitor';

// Fast 404 pages:
$config['system.performance']['fast_404']['exclude_paths'] = '/\/(?:styles)|(?:system\/files)\//';
$config['system.performance']['fast_404']['paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
$config['system.performance']['fast_404']['html'] = '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

// Trusted host configuration.
# $settings['trusted_host_patterns'] = [
#   '^example\.com$',
#   '^.+\.example\.com$',
#   '^example\.org$',
#   '^.+\.example\.org$',
# ];

// The default list of directories that will be ignored by Drupal's file API.
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

// The default number of entities to update in a batch process.
$settings['entity_update_batch_size'] = 50;

// Entity update backup.
$settings['entity_update_backup'] = TRUE;

// Node migration type.
$settings['migrate_node_migrate_type_classic'] = FALSE;

/**
 * Load local development override configuration, if available.
 *
 * Typical uses of settings.local.php include:
 * - Disabling caching.
 * - Disabling JavaScript/CSS compression.
 * - Rerouting outgoing emails.
 *
 * Keep this code block at the end of this file to take full effect.
 */
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
