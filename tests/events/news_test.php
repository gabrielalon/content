<?php

use N3ttech\Content\Application\News;

return [
    News\Event\ExistingNewsRemoved::class => [\N3ttech\Content\Domain\Model\News\Projection\NewsProjection::class],
    News\Event\ExistingNewsReleased::class => [\N3ttech\Content\Domain\Model\News\Projection\NewsProjection::class],
    News\Event\ExistingNewsTranslated::class => [\N3ttech\Content\Domain\Model\News\Projection\NewsProjection::class],
    News\Event\ExistingNewsSited::class => [\N3ttech\Content\Domain\Model\News\Projection\NewsProjection::class],
    News\Event\NewNewsCreated::class => [\N3ttech\Content\Domain\Model\News\Projection\NewsProjection::class],
];
