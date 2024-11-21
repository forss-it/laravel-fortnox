<?php

namespace Warbio\Fortnox\Resources\Employee;

use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Traits\HasCreate;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;
use Warbio\Fortnox\Traits\HasUpdate;

class AttendanceTransactions implements ResourceInterface
{
    use HasCreate;
    use HasRetrieve;
    use HasUpdate;
    use HasDelete;

    protected $client;
    protected $endpoint = 'attendancetransactions';

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
