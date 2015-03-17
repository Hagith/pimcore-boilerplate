<!DOCTYPE html>
<html lang="<?=$this->language?>">
<?= $this->template('partial/html-head.php') ?>
<body>

<div id="wrapper">
    <?= $this->template('partial/header.php') ?>

    <?= $this->layout()->content; ?>

    <?= $this->template('partial/footer.php') ?>
</div>

<script src="/website/assets/build/site.js"></script>
</body>
</html>
