<?php
/**
 * page_start.php
 *
 * Author: pixelcave
 *
 * The start section of each page used in every page of the template
 *
 */
?>
<?php if(isset($dm->page_loader) && $dm->page_loader) { ?>
<div id="page-loader" class="show"></div>

<?php } ?>

<?php
if (isset($_COOKIE['sidebar'])) {
  if ($_COOKIE['sidebar'] == 1) {
    $sidebar = "sidebar-dark";
  }
  else {
    $sidebar = "";
  }
}
?>
<div id="page-container" class="<?php if(isset($_COOKIE['sidebar'])) echo $sidebar;?> <?php $dm->page_classes(); ?>">
    <?php if(isset($dm->inc_side_overlay) && $dm->inc_side_overlay) { include ($dm->inc_side_overlay); } ?>
    <?php if(isset($dm->inc_sidebar) && $dm->inc_sidebar) { include ($dm->inc_sidebar); } ?>
    <?php if(isset($dm->inc_header) && $dm->inc_header) { include ($dm->inc_header); } ?>

    <!-- Main Container -->
    <main id="main-container">
