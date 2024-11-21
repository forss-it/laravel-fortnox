<?php

namespace Warbio\Fortnox\Resources\Template;

use Warbio\Fortnox\Exceptions\FortnoxException;
use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Traits\HasCreate;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;
use Warbio\Fortnox\Traits\HasUpdate;

class PrintTemplates implements ResourceInterface
{
    use HasRetrieve;

    protected $client;
    protected $endpoint = 'printtemplates';

    /**
     * Constructs a new instance.
     *
     * @param \Warbio\Fortnox\Interfaces\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve a single print template.
     *
     * @param  mixed                                        $id
     * @throws \Warbio\Fortnox\Exceptions\FortnoxException
     *
     * @return mixed
     */
    public function get(mixed $id): mixed
    {
        throw new FortnoxException('Print templates do not support this method.');
    }
}
