<?php

namespace KFoobar\Fortnox\Traits;

trait HasUpdate
{
    /**
     * Sends an update request for given item.
     *
     * @param mixed $id
     * @param array $data
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $endpoint = sprintf('%s/%s', $this->endpoint, $id);

        return $this->client->put($endpoint, $data);
    }
}
