<?php

/**
 * Node preprocessing - overrides some of nitobe_preprocess_node
 * in order to change the label for the list of taxonomy terms
 *
 * @param &$vars The template variables array. After invoking this function,
 *        these keys will be added to $vars:
 *        - 'nitobe_term_links' - The taxonomy links with a separator placed
 *          between each.
 */
function nitobe_vivian_preprocess_node(&$vars) {
  $prefix = t('Keywords: ');
  $vars['nitobe_term_links']  = nitobe_separate_terms($vars['terms'], $prefix);
}
