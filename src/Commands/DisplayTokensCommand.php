<?php

namespace Warbio\Fortnox\Commands;

use Illuminate\Console\Command;
use Warbio\Fortnox\Services\Token;

class DisplayTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fortnox:tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display information about Fortnox tokens';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->components->info(
            'Access token: ' . Token::get('fortnox-access-token') ?? 'Missing'
        );

        $this->components->info(
            'Refresh token: ' . Token::get('fortnox-refresh-token') ?? 'Missing'
        );

        return Command::SUCCESS;
    }
}
