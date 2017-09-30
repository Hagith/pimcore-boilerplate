<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php if (\Pimcore\Config::getEnvironment() !== 'development'): ?>
    <link rel="stylesheet" href="/website/var/static/bundle.css">
  <?php endif; ?>

  <title>Example</title>
</head>
<body>

<div id="site">
  <header>
    <a href="http://www.pimcore.org/" id="logo">pimcore</a>
    <hr/>
    <div class="claim">
      THE OPEN-SOURCE ENTERPRISE PLATFORM FOR PIM, CMS, DAM & COMMERCE
    </div>
  </header>

  <?php if ($this->editmode): ?>
    <div class="buttons">
      <a target="_blank" href="https://www.pimcore.org/wiki/pages/viewpage.action?pageId=16854186">Install
        Sample Data / Boilerplate</a>
      <a target="_blank" href="http://www.pimcore.org/wiki/display/PIMCORE4/Develop+with+pimcore">Getting
        Started</a>
    </div>

    <div class="info">
      <h2>Where can I edit some pages?</h2>
      <p>
        Well, it seems that you're using the professional distribution of pimcore which doesn't
        include any
        templates / themes or contents, it's designed to start a project from scratch. If you need a
        jump start
        please consider using our sample data / boilerplate package which includes everything you
        need to get started.
      </p>
    </div>
  <?php endif; ?>
</div>

<script src="/website/var/static/bundle.js"></script>

</body>
</html>
