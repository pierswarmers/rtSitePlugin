<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Site Pages') ?></h1>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('object' => new rtSitePage(), 'mode' => 'create'))?>
<?php end_slot(); ?>

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
      <td><?php echo rt_nice_boolean($rt_site_page->getPublished()) ?></td>
      <td><?php echo link_to_if($rt_site_page->version > 1, $rt_site_page->version, 'rtSitePageAdmin/versions?id='.$rt_site_page->getId()) ?></td>
      <td><?php echo $rt_site_page->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_show(url_for('rt_site_page_show', $rt_site_page)) ?></li>
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
