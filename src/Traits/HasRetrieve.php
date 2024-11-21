<?php

namespace Warbio\Fortnox\Traits;

use Warbio\Fortnox\Objects\QueryObject;

trait HasRetrieve
{
    /**
     * Sends an get request for a single item.
     *
     * @param mixed                                 $id
     * @param \Warbio\Fortnox\Services\QueryObject $query
     *
     * @return mixed
     */
    public function get(mixed $id, QueryObject $query = null): mixed
    {
        $endpoint = sprintf('%s/%s', $this->endpoint, $id);

        $response = $this->client->get($endpoint, $query?->toArray() ?? []);

        return $response->json();
    }

    /**
     * Sends an get request for all items.
     *
     * @param \Warbio\Fortnox\Services\QueryObject $query
     *
     * @return mixed
     */
    public function all(QueryObject $query = null): mixed
    {
        $response = $this->client->get($this->endpoint, $query?->toArray() ?? []);

        return $response->json();
    }
}
