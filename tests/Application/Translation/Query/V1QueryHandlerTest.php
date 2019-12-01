<?php

namespace N3ttech\Content\Test\Application\Translation\Query;

use N3ttech\Content\Application\Translation\Query;
use N3ttech\Content\Application\Translation\Service;
use N3ttech\Content\Domain\Model\Translation\Translation\Key;
use N3ttech\Content\Infrastructure\Query\Translation\InMemoryTranslationQuery;
use N3ttech\Content\Test\Application\HandlerTestCase;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Translation */
    private $translation;

    /** @var Service\TranslationQueryManager */
    private $translationQuery;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->translation = Query\ReadModel\Translation::fromKey(Key::fromString('Some translation'));

        $collection = new Query\ReadModel\TranslationCollection();
        $collection->add($this->translation);

        $translationQuery = new InMemoryTranslationQuery($collection);
        $this->register(Query\V1\FindOneByKeyHandler::class, new Query\V1\FindOneByKeyHandler($translationQuery));

        $this->translationQuery = new Service\TranslationQueryManager($this->getQueryBus());
    }

    /**
     * @test
     */
    public function isFindsTranslationByUuid(): void
    {
        $translation = $this->translationQuery->findOneTranslationByUuid($this->translation->identifier());

        $this->assertTrue($translation->getKey()->equals($this->translation->getKey()));
    }
}
