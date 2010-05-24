<?php use_helper('I18n', 'gnAdmin') ?>

<h1><?php echo __('Listing Site Pages') ?></h1>

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
    <?php foreach ($gn_site_pages as $gn_site_page): ?>
    <tr class="gn-admin-tree gn-admin-tree-level-<?php echo $gn_site_page->level ?>">
      <td class="gn-admin-title"><a href="<?php echo url_for('gnSitePageAdmin/edit?id='.$gn_site_page->getId()) ?>"><?php echo $gn_site_page->getTitle() ?></a></td>
      <td><?php echo gn_nice_boolean($gn_site_page->getPublished()) ?></td>
      <td><?php echo link_to_if($gn_site_page->version > 1, $gn_site_page->version, 'gnSitePageAdmin/versions?id='.$gn_site_page->getId()) ?></td>
      <td><?php echo $gn_site_page->getCreatedAt() ?></td>
      <td>
        <ul class="gn-admin-tools">
          <li><?php echo gn_button_show(url_for('gn_site_page_show', $gn_site_page)) ?></li>
          <li><?php echo gn_button_edit(url_for('gnSitePageAdmin/edit?id='.$gn_site_page->getId())) ?></li>
          <li><?php echo gn_button_delete(url_for('gnSitePageAdmin/delete?id='.$gn_site_page->getId())) ?></li>
          <?php if($gn_site_page->getNode()->isRoot()): ?>
          <li><?php echo gn_ui_button(__('tree'), 'gnSitePageAdmin/tree' . '?root=' . $gn_site_page->getRootId(), 'arrow-1-e') ?></li>
          <?php endif; ?>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php slot('gn-side') ?>
<p>
  <?php echo button_to(__('Create new site page'), 'gnSitePageAdmin/new', array('class' => 'button positive')) ?>
</p>
<?php end_slot(); ?>