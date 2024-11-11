<?php

namespace KFoobar\Fortnox\Resources\Supplier;

use KFoobar\Fortnox\Interfaces\ClientInterface;
use KFoobar\Fortnox\Interfaces\ResourceInterface;
use KFoobar\Fortnox\Traits\HasCreate;
use KFoobar\Fortnox\Traits\HasDelete;
use KFoobar\Fortnox\Traits\HasRetrieve;
use KFoobar\Fortnox\Traits\HasUpdate;

class SupplierInvoiceFileConnections implements ResourceInterface
{
    use HasCreate;
    use HasRetrieve;
    use HasUpdate;
    use HasDelete;

    protected $client;
    protected $endpoint = 'supplierinvoicefileconnections';

    /**
     * Constructs a new instance.
     *
     * @param \KFoobar\Fortnox\Interfaces\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
}
