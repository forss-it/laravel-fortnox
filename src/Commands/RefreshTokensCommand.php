<?php

namespace Warbio\Fortnox\Commands;

use Illuminate\Console\Command;
use Warbio\Fortnox\Services\Client;

class RefreshTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fortnox:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh tokens to keep the refresh token alive';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Client $client)
    {
        try {
            $client->refresh();
        } catch (\Exception $e) {
            $this->components->error('Failed to refresh tokens!');
            $this->components->error('Message: ' . $e->getMessage());

            return Command::FAILURE;
        }

        $this->components->info('Successfully refreshed tokens!');

        return Command::SUCCESS;
    }
}
