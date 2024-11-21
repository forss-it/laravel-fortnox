<?php

namespace Warbio\Fortnox\Resources\Inbox;

use Warbio\Fortnox\Interfaces\ClientInterface;
use Warbio\Fortnox\Interfaces\ResourceInterface;
use Warbio\Fortnox\Traits\HasDelete;
use Warbio\Fortnox\Traits\HasRetrieve;


class Inbox implements ResourceInterface
{
    use HasDelete;
    use HasRetrieve;

    protected $client;
    protected $endpoint = 'inbox';

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
     * Uploads a file to the inbox.
     * @param string $filename
     * @param string $fileContents
     * @param string $inboxPath
     * @return mixed
     */
    public function upload(string $filename, string $fileContents, string $inboxPath) : mixed
    {
        return $this->client->upload(sprintf('%s?path=%s', $this->endpoint, $inboxPath), $filename, $fileContents);
    }
}
