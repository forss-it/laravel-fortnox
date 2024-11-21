<?php

namespace Warbio\Fortnox\Resources\Invoice;

use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Traits\HasCreate;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;
use Warbio\Fortnox\Traits\HasUpdate;

class InvoiceAccruals implements ResourceInterface
{
    use HasCreate;
    use HasDelete;
    use HasRetrieve;
    use HasUpdate;

    protected $client;
    protected $endpoint = 'invoiceaccruals';

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
