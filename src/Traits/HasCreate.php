<?php

namespace KFoobar\Fortnox\Traits;

trait HasCreate
{
    /**
     * Sends an create request.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->client->post($endpoint);
    }
}
