<?php

namespace KFoobar\Fortnox\Resources\Inbox;

use KFoobar\Fortnox\Interfaces\ClientInterface;
use KFoobar\Fortnox\Interfaces\ResourceInterface;
use KFoobar\Fortnox\Traits\HasDelete;
use KFoobar\Fortnox\Traits\HasRetrieve;


class Inbox implements ResourceInterface
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
     * @param string $fileContent
     * @param string $folderId
     * @param string $inboxFolderPath
     * @return mixed
     */
    public function upload(string $filename, string $fileContent, string $folderId, string $inboxFolderPath) : mixed
    {
        $httpclient = $this->client->getHttpClient();


        //Attach file to larvel http client
        $response = $httpclient->attach(
            'file',
            $fileContent,
            $filename
        )->post($this->endpoint.'?folderid='.urldecode($folderId).'&path='.urldecode($inboxFolderPath));

        return $response->json();

    }
}
