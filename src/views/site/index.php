<?php
/**
 * @var $this SiteController
 */

$this->pageTitle = $this->pageHeading = app()->name;

echo '<p>You may change the content of this page by modifying the file <code>' . __FILE__ . '</code>.</p>';
if (!Helper::tableExists('migration')) {
    echo '<p>To install the database run <code>yiic migrate</code>.</p>';
}


