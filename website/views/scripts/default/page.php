<?php
// Example of javascript page routing through document property
$route = trim($this->document->getProperty('route'));
if ($route) {
    $route = 'data-route="' . $route . '""';
}
?>
<div class="container" <?= $route ?>>
    <div class="page-header">
        <h1><?= $this->input('page-headline') ?></h1>
    </div>
    <?= $this->wysiwyg('content') ?>
</div>
