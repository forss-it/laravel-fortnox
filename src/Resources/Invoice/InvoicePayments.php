<?php

namespace Warbio\Fortnox\Resources\Invoice;

use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Traits\HasCreate;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;
use Warbio\Fortnox\Traits\HasUpdate;

class InvoicePayments implements ResourceInterface
{
    use HasCreate;
    use HasDelete;
    use HasRetrieve;
    use HasUpdate;

    protected $client;
    protected $endpoint = 'invoicepayments';

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
     * Bookkeep given invoice payment.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function bookkeep(mixed $id): mixed
    {
        $endpoint = sprintf('%s/%s/bookkeep', $this->endpoint, $id);

        return $this->client->put($endpoint);
    }
}
