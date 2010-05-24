<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('gn-side') ?>
<p>
  <button type="submit" class="button positive" onclick="$('#gnAdminForm').submit()"><?php echo $form->getObject()->isNew() ? __('Create this site page') : __('Save and close') ?></button>
  <?php $back_location = $form->getObject()->isNew() ? 'history.go(-1);' : 'document.location.href=\'' . url_for('gn_site_page_show', $form->getObject()) . '\';'; ?>
  <?php echo button_to(__('Cancel'),'gnSitePageAdmin/index', array('class' => 'button cancel')) ?>
<?php if (!$form->getObject()->isNew()): ?>
  <br/>
  <?php echo __('Or') ?>,
  <?php echo link_to('delete this site page', 'gnSitePageAdmin/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
<?php endif; ?>
</p>
<?php include_component('gnAsset', 'form', array('object' => $form->getObject())) ?>
<?php end_slot(); ?>

<form id ="gnAdminForm" action="<?php echo url_for('gnSitePageAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields(false) ?>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['title']->renderLabel() ?></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['content']->renderLabel() ?></th>
        <td>
          <?php echo $form['content']->renderError() ?>
          <?php echo $form['content'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['published']->renderLabel() ?></th>
        <td>
          <?php echo $form['published']->renderError() ?>
          <?php echo $form['published'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['published_from']->renderLabel() ?></th>
        <td>
          <?php echo $form['published_from']->renderError() ?>
          <?php echo $form['published_from'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['published_to']->renderLabel() ?></th>
        <td>
          <?php echo $form['published_to']->renderError() ?>
          <?php echo $form['published_to'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['comment_status']->renderLabel() ?></th>
        <td>
          <?php echo $form['comment_status']->renderError() ?>
          <?php echo $form['comment_status'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['searchable']->renderLabel() ?></th>
        <td>
          <?php echo $form['searchable']->renderError() ?>
          <?php echo $form['searchable'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['slug']->renderLabel() ?></th>
        <td>
          <?php echo $form['slug']->renderError() ?>
          <?php echo $form['slug'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['menu_title']->renderLabel() ?></th>
        <td>
          <?php echo $form['menu_title']->renderError() ?>
          <?php echo $form['menu_title'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['display_in_menu']->renderLabel() ?></th>
        <td>
          <?php echo $form['display_in_menu']->renderError() ?>
          <?php echo $form['display_in_menu'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['tags']->renderLabel() ?></th>
        <td>
          <?php echo $form['tags']->renderError() ?>
          <?php echo $form['tags'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
