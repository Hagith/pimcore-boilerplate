<?php
$mainNavStartNode = $this->document->getProperty('mainNavStartNode');
if(!$mainNavStartNode) {
    $mainNavStartNode = \Pimcore\Model\Document::getById(1);
}
$mainNavigation = $this->pimcoreNavigation()
    ->getNavigation($this->document, $mainNavStartNode);
$this->navigation($mainNavigation);
?>

<div class="container">
    <nav class="main navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed"
                        data-toggle="collapse" data-target=".navbar-collapse"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $mainNavStartNode; ?>">
                    pimcore
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <?= $this->navigation()->menu()
                    ->setMaxDepth(0)
                    ->setUlClass('nav navbar-nav')
                ?>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
</div>
