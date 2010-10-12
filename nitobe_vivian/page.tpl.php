<?php
/**
 * @file page.tpl.php
 * The variable-layout page structure for Nitobe.
 *
 * In addition to the standard variables Drupal makes available to page.tpl.php,
 * these variables are made available by the theme:
 *
 * - $nitobe_classes - The CSS classes to apply to the content and sidebar
 *   regions. This array will have 'content', 'left', and 'right' as keys. The
 *   values will include the grid size for the region and any push/pull
 *   classes needed for the region in that context.
 *
 * - $nitobe_content_width - The CSS class providing the full width of the
 *   content region without any push/pull classes.
 *
 * - $nitobe_logo - The HTML for the linked logo image.
 *
 * - $nitobe_page_title - The pre rendered page title element with the
 *   appropriate CSS classes assigned.
 *
 * - $nitobe_placement - The theme setting for how the sidebars should be
 *   rendered relative to the content region. Will be one of:
 *           left   - Both sidebars rendered left of the content region.
 *           center - A sidebar is rendered on either side of the content
 *                    region.
 *           right  - Both sidebars rendered right of the content region.
 *
 * - $nitobe_primary_links - The HTML for the rendered primary links.
 *
 * - $nitobe_render_date - whether or not to render the date for this type if
 *   the page is a node page.
 *
 * - $nitobe_secondary_links - The HTML for the rendered secondary links.
 *
 * - $nitobe_slogan - The HTML for the site slogan.
 *
 * - $nitobe_title - The HTML for the linked title.
 *
 * - $tabs2 - The HTML for the menu secondary local tasks.
 *
 * $Id: page.tpl.php,v 1.1.2.1 2009/08/01 17:58:31 shannonlucas Exp $
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	<head>
		<title><?php print $head_title; ?></title>
		<?php print $head; ?>
		<?php print $styles; ?>
		<?php print $scripts; ?>
		<!--[if lt IE 8]>
			<?php print phptemplate_get_ie_styles() . "\n"; ?>
		<![endif]-->
	</head>
	<body class="nitobe <?php print $body_classes; ?>">
		<div id="page-wrapper" class="clear-block">
			<div id="header-area" class="container-16">
					<div id="title-group" class="<?php print nitobe_ns('grid-16', $header, 6, $search_box, 4); ?>">
			            <?php if (isset($nitobe_logo)) { print $nitobe_logo; } ?>
			            <?php if (isset($nitobe_title)) { print $nitobe_title; } ?>
			            <?php if (isset($nitobe_slogan)) { print $nitobe_slogan; } ?>
			        </div><!-- /title-group -->
			        <?php if (!empty($header)): ?>
    			        <div id="header-region" class="grid-6">
    			        	<?php if (isset($header)) { print $header; } ?>
    			        </div><!-- /header-region -->
			        <?php endif; ?>
			        <?php if (!empty($search_box)): ?>
			        	<div id="search-top" class="grid-4"><?php print $search_box; ?></div>
			        <?php endif; ?>
          		<hr class="break"/>
          		<?php if (isset($nitobe_primary_links)): ?>
            		<div id="header-links" class="grid-16">
            		    <?php if (isset($nitobe_primary_links)) { print $nitobe_primary_links; } ?>
            		    <?php if (isset($nitobe_secondary_links)) : ?>
              			<hr class="break"/>
            		    <?php print $nitobe_secondary_links; ?>
            		    <?php endif; ?>
          			</div><!-- #header-links -->
          		<?php else: ?>
          			<hr id="no-menu-rule" class="rule-bottom grid-16"/>
          		<?php endif; ?>
				<!-- Masthead was here, has been removed -->
          		<hr class="rule-top grid-16" />
			</div><!-- /header-area -->
			<hr class="break"/>
			<div id="content-area" class="container-16">
				<div id="content" class="<?php print $nitobe_classes['content']; ?>">
					<?php if (!empty($breadcrumb)) { print $breadcrumb; } ?>
					<?php if ($show_messages && !empty($messages)) { print $messages; } ?>
					<?php print $help; ?>
					<?php if (!empty($mission)): ?>
						<div id="mission" class="clear-block"><?php print $mission; ?></div>
					<?php endif;?>
					<?php if (!empty($title)): ?>
          				<div id="page-headline" class="clear-block">
    					    <?php print $nitobe_page_title; ?>
    					    <?php if (isset($nitobe_node_timestamp)): ?>
                  				<span class="timestamp"><?php print $nitobe_node_timestamp; ?></span>
    					    <?php endif; ?>
          				</div><!-- #page-headline -->
					<?php endif; ?>
					<?php if (!empty($tabs)):?>
                    	<div id="tabs-wrapper" class="<?php print $nitobe_content_width; ?> alpha omega clear-block">
                        	<ul class="tabs primary clear-block<?php if ($tabs2) { print ' has-secondary'; } ?>"><?php print $tabs; ?></ul>
                              <?php if ($tabs2): ?>
                              	  <ul class="tabs secondary"><?php print $tabs2; ?></ul>
                              <?php endif; ?>
                    	</div>
                    	<br class="break"/>
                    <?php endif; ?>
					<?php print $content; ?>
				</div><!-- /content -->
				<?php if (!empty($left)): ?>
					<div id="left-sidebar" class="<?php print $nitobe_classes['left']; ?>">
					  <?php print $left; ?>
					</div><!-- /left-sidebar -->
				<?php endif; ?>
				<?php if (!empty($right)): ?>
					<div id="right-sidebar" class="<?php print $nitobe_classes['right']; ?>">
						<?php print $right; ?>
					</div> <!-- /right-sidebar -->
				<?php endif; ?>
			</div><!-- /content-area -->
			<hr class="break"/>
			<div id="bottom-blocks" class="container-16">
				<hr class="rule-bottom grid-16"/>
				<div id="bottom-left" class="grid-4">
					<?php if (isset($bottom_left)) { print $bottom_left; } ?>
				</div><!-- /bottom-left -->
				<div id="bottom-center-left" class="grid-4">
					<?php if (isset($bottom_center_left)) { print $bottom_center_left; } ?>
				</div><!-- /bottom-center-left -->
				<div id="bottom-center-right" class="grid-4">
					<?php if (isset($bottom_center_right)) { print $bottom_center_right; } ?>
				</div><!-- /bottom-center-right -->
				<div id="bottom-right" class="grid-4">
					<?php if (isset($bottom_right)) { print $bottom_right; } ?>
				</div><!-- /bottom-right -->
			</div><!-- /bottom-blocks -->
			<hr class="break"/>
			<div id="footer-area" class="container-16">
				<hr class="rule-top grid-16"/>
				<div id="footer" class="grid-16">
					<?php print $footer_message . $footer; ?>
				</div><!-- /footer -->
			</div><!-- /footer-area -->
			<hr class="break"/>
		</div><!-- /page-wrapper -->
		<?php print $closure; ?>
	</body>
</html>