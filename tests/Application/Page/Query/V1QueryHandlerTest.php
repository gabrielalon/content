<?php

namespace N3ttech\Content\Test\Application\Page\Query;

use N3ttech\Content\Application\Page\Query;
use N3ttech\Content\Application\Page\Service;
use N3ttech\Content\Domain\Model\Page\Page\Key;
use N3ttech\Content\Infrastructure\Query\Page\InMemoryPageQuery;
use N3ttech\Content\Test\Application\HandlerTestCase;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Page */
    private $page;

    /** @var Service\PageQueryManager */
    private $pageQuery;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->page = Query\ReadModel\Page::fromKey(Key::fromString('Some page'));

        $collection = new Query\ReadModel\PageCollection();
        $collection->add($this->page);

        $pageQuery = new InMemoryPageQuery($collection);
        $this->register(Query\V1\FindOneByKeyHandler::class, new Query\V1\FindOneByKeyHandler($pageQuery));

        $this->pageQuery = new Service\PageQueryManager($this->getQueryBus());
    }

    /**
     * @test
     */
    public function isFindsPageByUuid(): void
    {
        $page = $this->pageQuery->findOnePageByUuid($this->page->identifier());

        $this->assertTrue($page->getKey()->equals($this->page->getKey()));
    }
}
