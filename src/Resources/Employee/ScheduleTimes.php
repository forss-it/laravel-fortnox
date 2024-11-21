<?php

namespace Warbio\Fortnox\Resources\Employee;

use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Traits\HasCreate;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;
use Warbio\Fortnox\Traits\HasUpdate;

class ScheduleTimes implements ResourceInterface
{

    protected $client;
    protected $endpoint = 'scheduletimes';

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
    * Sends an get request for a single item.
    * @param mixed $employeeId
    * @param mixed $date
    */
    public function get(mixed $employeeId, mixed $date): mixed
    {
        $endpoint = sprintf('%s/%s/$s', $this->endpoint, $employeeId, $date);

        $response = $this->client->get($endpoint, []);

        return $response->json();
    }
}
