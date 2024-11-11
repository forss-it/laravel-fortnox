<?php

namespace KFoobar\Fortnox\Resources\Inbox;

use KFoobar\Fortnox\Interfaces\ClientInterface;
use KFoobar\Fortnox\Interfaces\ResourceInterface;
use KFoobar\Fortnox\Traits\HasDelete;
use KFoobar\Fortnox\Traits\HasRetrieve;


class Inboxes implements ResourceInterface
{
    use HasDelete;
    use HasRetrieve;

    protected $client;
    protected $endpoint = 'inbox';

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
