<?php

namespace N3ttech\Content\Test\Application\News\Query;

use N3ttech\Content\Application\News\Query;
use N3ttech\Content\Application\News\Service;
use N3ttech\Content\Infrastructure\Query\News\InMemoryNewsQuery;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\News */
    private $news;

    /** @var Service\NewsQueryManager */
    private $newsQuery;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->news = Query\ReadModel\News::fromUuid(Uuid::uuid4()->toString())
            ->setReleaseDate(VO\Date\Time::fromTimestamp(time()))
        ;

        $collection = new Query\ReadModel\NewsCollection();
        $collection->add($this->news);

        $newsQuery = new InMemoryNewsQuery($collection);
        $this->register(Query\V1\FindOneNewsByUuidHandler::class, new Query\V1\FindOneNewsByUuidHandler($newsQuery));
        $this->register(Query\V1\FindAllActiveNewsHandler::class, new Query\V1\FindAllActiveNewsHandler($newsQuery));
        $this->register(Query\V1\FindAllSitedNewsHandler::class, new Query\V1\FindAllSitedNewsHandler($newsQuery));

        $this->newsQuery = new Service\NewsQueryManager($this->getQueryBus());
    }

    /**
     * @test
     */
    public function isFindsNewsByUuid(): void
    {
        $news = $this->newsQuery->findOneNewsByUuid($this->news->identifier());

        $this->assertTrue($news->getUuid()->equals($this->news->getUuid()));
    }

    /**
     * @test
     */
    public function isFindsAllActiveNews(): void
    {
        $news = $this->newsQuery->findAllActiveNews();

        $this->assertTrue(1 == $news->count());
    }

    /**
     * @test
     */
    public function itFindAllSitedNews(): void
    {
        $news = $this->newsQuery->findAllSitedNews($this->news->identifier());

        $this->assertTrue(1 == $news->count());
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function isFindsAllSitedNews(): void
    {
        $news = $this->newsQuery->findAllSitedNews(Uuid::uuid4()->toString());

        $this->assertTrue(1 == $news->count());
    }
}
