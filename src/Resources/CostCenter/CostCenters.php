<?php

namespace Warbio\Fortnox\Resources\CostCenter;

use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Traits\HasCreate;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;
use Warbio\Fortnox\Traits\HasUpdate;

class CostCenters implements ResourceInterface
{
    use HasCreate;
    use HasDelete;
    use HasRetrieve;
    use HasUpdate;

    protected $client;
    protected $endpoint = 'costcenters';

    /**
     * Constructs a new instance.
     *
     * @param \Warbio\Fortnox\Interfaces\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
}
