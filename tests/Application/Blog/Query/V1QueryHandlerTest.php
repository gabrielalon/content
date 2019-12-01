<?php

namespace N3ttech\Content\Test\Application\Blog\Query;

use N3ttech\Content\Application\Blog\Query;
use N3ttech\Content\Application\Blog\Service;
use N3ttech\Content\Infrastructure\Query\Blog\InMemoryCategoryQuery;
use N3ttech\Content\Infrastructure\Query\Blog\InMemoryEntryQuery;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Entry */
    private $entry;

    /** @var Service\EntryQueryManager */
    private $entryQuery;

    /** @var Query\ReadModel\Category */
    private $category;

    /** @var Service\CategoryQueryManager */
    private $categoryQuery;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->entry = Query\ReadModel\Entry::fromUuid(Uuid::uuid4()->toString())
            ->setReleaseDate(VO\Date\Time::fromTimestamp(time()))
        ;

        $collection = new Query\ReadModel\EntryCollection();
        $collection->add($this->entry);

        $entryQuery = new InMemoryEntryQuery($collection);
        $this->register(Query\V1\FindOneEntryByUuidHandler::class, new Query\V1\FindOneEntryByUuidHandler($entryQuery));
        $this->register(Query\V1\FindAllActiveEntriesHandler::class, new Query\V1\FindAllActiveEntriesHandler($entryQuery));

        $this->entryQuery = new Service\EntryQueryManager($this->getQueryBus());

        $this->category = Query\ReadModel\Category::fromUuid(Uuid::uuid4()->toString());

        $collection = new Query\ReadModel\CategoryCollection();
        $collection->add($this->category);

        $entryQuery = new InMemoryCategoryQuery($collection);
        $this->register(Query\V1\FindOneCategoryByUuidHandler::class, new Query\V1\FindOneCategoryByUuidHandler($entryQuery));
        $this->register(Query\V1\FindAllSitedCategoriesHandler::class, new Query\V1\FindAllSitedCategoriesHandler($entryQuery));

        $this->categoryQuery = new Service\CategoryQueryManager($this->getQueryBus());
    }

    /**
     * @test
     */
    public function isFindsEntryByUuid()
    {
        $entry = $this->entryQuery->findOneEntryByUuid($this->entry->identifier());

        $this->assertTrue($entry->getUuid()->equals($this->entry->getUuid()));
    }

    /**
     * @test
     */
    public function isFindsAllActiveEntries()
    {
        $entries = $this->entryQuery->findAllActiveEntries();

        $this->assertTrue(1 == $entries->count());
    }

    /**
     * @test
     */
    public function isFindsCategoryByUuid()
    {
        $category = $this->categoryQuery->findOneCategoryByUuid($this->category->identifier());

        $this->assertTrue($category->getUuid()->equals($this->category->getUuid()));
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function isFindsAllSitedCategories()
    {
        $categories = $this->categoryQuery->findAllSitedCategories(Uuid::uuid4()->toString());

        $this->assertTrue(1 == $categories->count());
    }
}
