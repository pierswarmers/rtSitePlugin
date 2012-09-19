<?php

/** @var rtSitePage $rt_site_page */

use_helper('I18N','Date');

slot('rt-title', 'Page not found');

?>

<div class="rt-section-content">
    <p>The requested site page doesn't exist yet. Since you're an administrator of site pages - perhaps you meant for it to be here. Should we go ahead and create it now?</p>
    <form action="<?php echo url_for($sf_request->getUri()) ?>" method="post">
        <input type="hidden" name="slug" value="<?php echo $sf_request->getParameter('slug') ?>" />
        <p>
            <button type="submit"><?php echo __('Create page', null, 'sf_guard') ?></button>
        </p>
    </form>
</div>

