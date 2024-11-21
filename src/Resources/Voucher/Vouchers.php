<?php

namespace Warbio\Fortnox\Resources\Voucher;

use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Services\QueryObject;
use Warbio\Fortnox\Traits\HasCreate;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;
use Warbio\Fortnox\Traits\HasUpdate;

class Vouchers implements ResourceInterface
{
    use HasCreate;
    use HasRetrieve;

    protected $client;
    protected $endpoint = 'vouchers';

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
     * Retrieve a specific voucher.
     *
     * @param mixed                                 $series
     * @param mixed                                 $number
     * @param \Warbio\Fortnox\Services\QueryObject $query
     *
     * @return mixed
     */
    public function get(mixed $series, mixed $number, QueryObject $query = null): mixed
    {
        $endpoint = sprintf('%s/%s/%s', $this->endpoint, $series, $number);

        return $this->client->get($endpoint, $query->toArray() ?? []);
    }

    /**
     * Retrieve a list of vouchers for a specific series.
     *
     * @param mixed                                 $series
     * @param \Warbio\Fortnox\Services\QueryObject $query
     *
     * @return mixed
     */
    public function sublist(mixed $series, QueryObject $query = null): mixed
    {
        $endpoint = sprintf('%s/%s', $this->endpoint, $series);

        return $this->client->get($endpoint, $query->toArray() ?? []);
    }
}
