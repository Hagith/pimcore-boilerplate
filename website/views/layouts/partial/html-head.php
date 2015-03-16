<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if (!empty($_COOKIE['desktop-mode'])): ?>
    <meta name="viewport" content="width=1024">
    <?php else: ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1.0, user-scalable=no">
    <?php endif; ?>

    <?php
    $this->headMeta()->setSeparator(PHP_EOL . '    ');
    if ('' != ($description = $this->document->getDescription(false))) {
        $this->headMeta()->appendName('description', $description);
    }
    if ('' != ($keywords = $this->document->getKeywords(false))) {
        $this->headMeta()->appendName('keywords', $keywords);
    }

    // page title
    $this->headTitle()->setSeparator(' - ');
    foreach ($this->document->getTitle(false) as $title) {
        $this->headTitle($title);
    }
    ?>
    <?= $this->headTitle() . "\n" ?>
    <?= $this->headMeta() . "\n" ?>

    <link href="/website/assets/build/website.css" rel="stylesheet" type="text/css">

    <?php if ($this->editmode): ?>
        <link href="/website/assets/build/editmode.css" rel="stylesheet" type="text/css">
    <?php endif; ?>

    <?= $this->headScript() ?>

    <link rel="shortcut icon" href="/website/assets/images/favicon.ico" type="image/x-icon">
    <?php /* @todo icons
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/website/static/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/website/static/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/website/static/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/website/static/images/ico/apple-touch-icon-57-precomposed.png">
    */ ?>

</head>
