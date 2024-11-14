<?php

namespace KFoobar\Fortnox\Resources\Employee;

use KFoobar\Fortnox\Interfaces\ClientInterface;
use KFoobar\Fortnox\Interfaces\ResourceInterface;
use KFoobar\Fortnox\Traits\HasCreate;
use KFoobar\Fortnox\Traits\HasDelete;
use KFoobar\Fortnox\Traits\HasRetrieve;
use KFoobar\Fortnox\Traits\HasUpdate;

class ScheduleTimes implements ResourceInterface
{

    protected $client;
    protected $endpoint = 'scheduletimes';

    /**
     * Constructs a new instance.
     *
     * @param \KFoobar\Fortnox\Interfaces\ClientInterface $client
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
