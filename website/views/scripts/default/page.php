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
    <div data-component="snippet">
        <p v-text="msg" v-style="background-color: background"></p>
    </div>
    <?= $this->wysiwyg('content') ?>
</div>
