<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Site Pages') ?></h1>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('object' => new rtSitePage()))?>
<h2><?php echo __('Site Pages Summary') ?></h2>
<dl class="rt-admin-summary-panel clearfix">
  <dt class="rt-admin-primary"><?php echo __('Total') ?></dt>
  <dd class="rt-admin-primary"><?php echo $stats['total']['count'] ?></dd>
  <dt><?php echo __('Published') ?></dt>
  <dd><?php echo $stats['total_published']['count'] ?></dd>
</dl>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<script type="text/javascript">
  $(function() {
    enablePublishToggle('<?php echo url_for('rtSitePageAdmin/toggle') ?>');
  });
</script>

<table>
  <thead>
    <tr>
      <th><?php echo __('Title') ?></th>
      <th><?php echo __('Published') ?></th>
      <th><?php echo __('Version') ?></th>
      <th><?php echo __('Created at') ?></th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rt_site_pages as $rt_site_page): ?>
    <tr class="rt-admin-tree rt-admin-tree-level-<?php echo $rt_site_page->level ?>">
      <td class="rt-admin-title"><a href="<?php echo url_for('rtSitePageAdmin/edit?id='.$rt_site_page->getId()) ?>"><?php echo $rt_site_page->getTitle() ?></a></td>
      <td class="rt-admin-publish-toggle">
        <?php echo rt_nice_boolean($rt_site_page->getPublished()) ?>
        <div style="display:none;"><?php echo $rt_site_page->getId() ?></div>
      </td>
      <td><?php echo link_to_if($rt_site_page->version > 1, $rt_site_page->version, 'rtSitePageAdmin/versions?id='.$rt_site_page->getId()) ?></td>
      <td><?php echo $rt_site_page->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_show(url_for('rtSitePageAdmin/show?id='.$rt_site_page->getId())) ?></li>
          <li><?php echo rt_button_edit(url_for('rtSitePageAdmin/edit?id='.$rt_site_page->getId())) ?></li>
          <li><?php echo rt_button_delete(url_for('rtSitePageAdmin/delete?id='.$rt_site_page->getId())) ?></li>
          <?php if($rt_site_page->getNode()->isRoot()): ?>
          <li><?php echo rt_ui_button(__('tree'), 'rtSitePageAdmin/tree' . '?root=' . $rt_site_page->getRootId(), 'arrow-1-e') ?></li>
          <?php endif; ?>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
