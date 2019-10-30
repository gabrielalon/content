<?php

use N3ttech\Content\Application\Blog;

return [
    Blog\Event\ExistingEntryRemoved::class => [\N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection::class],
    Blog\Event\ExistingEntryUpdated::class => [\N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection::class],
    Blog\Event\ExistingEntryTranslated::class => [\N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection::class],
    Blog\Event\ExistingEntryShown::class => [\N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection::class],
    Blog\Event\ExistingEntryHidden::class => [\N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection::class],
    Blog\Event\ExistingEntryCategorized::class => [\N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection::class],
    Blog\Event\NewEntryCreated::class => [\N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection::class],

    Blog\Event\NewCategoryCreated::class => [\N3ttech\Content\Domain\Model\Blog\Projection\CategoryProjection::class],
    Blog\Event\ExistingCategoryMoved::class => [\N3ttech\Content\Domain\Model\Blog\Projection\CategoryProjection::class],
    Blog\Event\ExistingCategorySited::class => [\N3ttech\Content\Domain\Model\Blog\Projection\CategoryProjection::class],
    Blog\Event\ExistingCategoryTranslated::class => [\N3ttech\Content\Domain\Model\Blog\Projection\CategoryProjection::class],
    Blog\Event\ExistingCategoryRemoved::class => [\N3ttech\Content\Domain\Model\Blog\Projection\CategoryProjection::class],
];
