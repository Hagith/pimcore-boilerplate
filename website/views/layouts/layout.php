<!DOCTYPE html>
<html lang="<?=$this->language?>">
<?= $this->template('partial/html-head.php') ?>
<body>

<div id="wrapper" class="page-<?= $this->getRequest()->getParam('action') ?>">
    <?= $this->template('partial/header.php') ?>

    <div class="container">
        <?= $this->layout()->content; ?>
    </div>

    <?= $this->template('partial/footer.php') ?>
</div>

<script src="/website/assets/build/site.js"></script>
</body>
</html>
