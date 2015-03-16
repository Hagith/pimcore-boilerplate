<?php if ($this->pageCount > 1): ?>
<div class="text-center">
    <ul class="pagination">

        <?php if (isset($this->previous)):
            $href = (isset($this->previous))
                ? $this->url(array('page' => $this->previous), null, false, false)
                : '' ?>
            <li class="previous">
                <a href="<?= $href ?>" rel="prev">
                    &laquo; <?= $this->translate('Previous') ?>
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($this->pagesInRange as $page): ?>
            <?php $class = ($page == $this->current) ? 'active' : 'hidden-xs' ?>
            <?php $href = ($page == $this->current)
                ? ''
                : $this->url(['page' => $page]) ?>
            <li class="<?= $class ?>">
                <?= ($href) ? "<a href=\"$href\">" : '<span>' ?>
                <?= $page ?> <span class="visible-xs-inline"> / <?= $this->pageCount ?></span>
                <?= ($href) ? '</a>' : '</span>' ?>
            </li>
        <?php endforeach; ?>

        <?php if (isset($this->next)):
            $href = (isset($this->next))
                ? $this->url(array('page' => $this->next), null, false, false)
                : '' ?>
            <li class="next">
                <a href="<?= $href ?>" rel="next">
                    <?= $this->translate('Next') ?> &raquo;
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?>
