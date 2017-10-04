<?php
if (!$this->document) {
  // use "home" document as default if no document is present
  $this->document = \Pimcore\Model\Document::getById(1);
}

if ($this->document instanceof \Pimcore\Model\Document\Page) {
  $titleSeparator = $this->config->titleSeparator ?: ':';
  $this->headTitle()->setSeparator(" $titleSeparator ");

  $siteName = $this->config->siteName ?: 'Pimcore Boilerplate';
  $this->headTitle()->append($siteName);

  if ($this->document->getTitle()) {
    $this->headTitle()->prepend($this->document->getTitle());
  }

  if ($this->document->getDescription()) {
    $this->headMeta()->appendName('description', $this->document->getDescription());
  }
}
?>

<!DOCTYPE html>
<html lang="<?= $this->language; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?= $this->headMeta(); ?>
  <?= $this->headTitle(); ?>

  <?php if (\Pimcore\Config::getEnvironment() !== 'development'): ?>
    <link rel="stylesheet" href="/website/var/static/website.css">
    <?php if ($this->editmode): ?>
      <link rel="stylesheet" href="/website/var/static/editmode.css">
    <?php endif; ?>
  <?php endif; ?>
</head>
<body>

<?= $this->layout()->content; ?>

<script src="/website/var/static/website.js"></script>
</body>
</html>
