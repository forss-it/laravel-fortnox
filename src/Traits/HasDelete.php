<?php

namespace KFoobar\Fortnox\Traits;

trait HasDelete
{
    /**
     * Sends an delete request.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        $endpoint = sprintf('%s/%s', $this->endpoint, $id);

        return $this->client->delete($endpoint);
    }
}
