<?php
// $Id$

/**
 * Return an array of the modules to be enabled when this profile is installed.
 *
 * @return
 *   An array of modules to enable.
 */
function aaedirp_profile_modules() {
  return array(
  // Enabling optional core modules
  'color', 'help', 'menu', 'taxonomy', 'dblog', 'path', 'filter', 'search', 'update', 
  // Enabling contributed modules
  // CCK
  'content', 'content_copy', 'filefield', 'imagefield', 'link', 'number', 'optionwidgets', 'text',
  // Views
  'views', 'views_export', 'views_ui', 
  // Rules
  'rules', 'rules_admin', 'rules_forms', 'rules_scheduler', 
  // SWF Tools
  'swftools', 'wijering4', 
  // Workflow
  'workflow', 'workflow_access', 
  // Miscellaneous
  'globalredirect', 'token', 'pathauto', 'googleanalytics', 'date_api', 'advanced_help', 'node_import', 'node_export', 'node_export_file', 'menu_breadcrumb'
  );
}

/**
 * Return a description of the profile for the initial installation screen.
 *
 * @return
 *   An array with keys 'name' and 'description' describing this profile,
 *   and optional 'language' to override the language selection for
 *   language-specific profiles.
 */
function aaedirp_profile_details() {
  return array(
    'name' => 'AAEDIRP',
    'description' => 'Select this profile to do a custom installation for the AAEDIRP site, including contributed modules.'
  );
}

/**
 * Return a list of tasks that this profile supports.
 *
 * @return
 *   A keyed array of tasks the profile will perform during
 *   the final stage. The keys of the array will be used internally,
 *   while the values will be displayed to the user in the installer
 *   task list.
 */
function aaedirp_profile_task_list() {
}

/**
 * Perform any final installation tasks for this profile.
 */
function aaedirp_profile_tasks(&$task, $url) {

  if ($task == 'profile') {
    // Set up all the things a default installation profile has.
    require_once 'profiles/default/default.profile';
    default_profile_tasks($task, $url);
    
    // Create a taxonomy for the web directory.
    $vocabulary = array(
      'name' => st('keywords'),
      'description' => st('Keywords for the web directory entries.'),
      'nodes' => array('dir_entry' => st('Directory Entry')),
      'hierarchy' => 0,
      'relations' => 0,
      'tags' => 1,
      'multiple' => 0,
      'required' => 0,
    );
    taxonomy_save_vocabulary($vocabulary);

    // Custom input filter allowed HTML tags.
    variable_set('allowed_html_1', '<a> <em> <strong> <cite> <blockquote> <code> <ul> <ol> <li> <dl> <dt> <dd> <ins> <del> <p> <br> <h3> <h4> <h5> <img>');
        
    // Import custom content types with CCK fields
    // Get CCK fields exported from site with content_copy
    foreach (glob(drupal_get_path('profile', 'aaedirp') . '/content_types/*.cck') as $input_file) {
      _add_content_types($input_file);
    }
    
    _add_roles_permissions();
    
    // Add blocks
    $blocks = array(
      0 => array(
        'body' => '<p>The ultimate objective of the Atlantic Aboriginal Economic Development Integrated Research Program (AAEDIRP) is to improve the lives of the Aboriginal people in the region.</p><p><a href="about">Read More</a>',
        'info' => 'about'
      ),
      1 => array(
        'body' => '<a href="http://www.apcfnc.ca/en/"><img src="sites/default/files/apcfnc_logo.png" /></a>The AAEDIRP knowledge base is an initiative of the <a href="http://www.apcfnc.ca/en/">Atlantic Policy Congress of First Nations Chiefs</a>.',
        'info' => 'APCFNC acknowledgement'
      )
    );
    foreach($blocks as $block) {
      drupal_write_record('boxes', $block);
    }
    
    // Enable our theme and subtheme, and set subtheme as default
    $themes = system_theme_data();
    $theme = 'nitobe';
    $subtheme = 'nitobe_vivian';
    if (isset($themes[$theme])) {
      system_initialize_theme_blocks($theme);
      db_query("UPDATE {system} SET status = 1 WHERE type = 'theme' AND name = '%s'", $theme);
      }
    if (isset($themes[$subtheme])) {
      system_initialize_theme_blocks($subtheme);
      db_query("UPDATE {system} SET status = 1 WHERE type = 'theme' AND name = '%s'", $subtheme);
      variable_set('theme_default', $subtheme);
    } else {
      variable_set('theme_default', $theme);
    }
    menu_rebuild();
    drupal_rebuild_theme_registry();
  }
}

function _add_content_types($file) {
  $form_state = array(
    'values' => array(
         'type_name' => '<create>',
         'macro' => file_get_contents($file),
    ),
  );

  // Pass form values to content_copy's import form
  drupal_execute("content_copy_import_form", $form_state);
  if ($errors = form_get_errors()) {
    watchdog('error', 'Error attempting to add CCK fields', $errors);
  }
  content_clear_type_cache();
}

function _add_roles_permissions() {
  // Create custom roles
  $roles = array(
    0 => array(
      'name' => 'directory editor',
      'perm' => 'access content, create dir_entry content, delete any dir_entry content, edit any dir_entry content',
    ),
    1 => array(
      'name' => 'page editor',
      'perm' => 'access content, edit any activity content, edit any page content, edit any story content, edit own activity content, edit own page content, edit own story content',
    ),
    2 => array(
      'name' => 'stakeholder editor',
      'perm' => 'access content, create stakeholder content, delete any stakeholder content, edit any stakeholder content, edit own stakeholder content',
    ),
    3 => array(
      'name' => 'video uploader',
      'perm' => 'access content, create video content, delete any video content, edit any video content',
    )
  );
  foreach ($roles as $role) {
    // Write to role table
    // drupal_write_record('role', $role['name']);
    db_query("INSERT INTO {role} (name) VALUES ('%s')", $role['name']);
    // Determine rid (role id)
    $result = db_fetch_array(db_query("SELECT rid FROM {role} WHERE role.name = '%s'", $role['name']));
    // Write to permission table
    db_query("INSERT INTO {permission} (rid, perm) VALUES ('%s', '%s')", $result['rid'], $role['perm']);
  }
}