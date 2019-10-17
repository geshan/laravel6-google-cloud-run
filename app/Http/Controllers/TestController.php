<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Log\LogManager;
use Symfony\Component\Stopwatch\Stopwatch;

class TestController extends Controller
{
    private $logger;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogManager $logger, Stopwatch $stopwatch)
    {
        $this->logger = $logger;
        $this->stopwatch = $stopwatch;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->logger->info('test', ['var' => 'val']);
        $this->logger->critical('testing err', ['var' => 'val']);
        $this->logger->info('This is a test info line', ['type' => 2]);
        $this->logger->warning('This is a test warning line', ['type' => 3]);

        try {
            throw new \Exception('Could not connect the the database, check credentials');
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf('This is an error - %s', $e->getMessage()),
                [
                    'file' => $e->getFile(),
                    'lineNo' => $e->getLine()
                ]
            );
        }

        $this->stopwatch->start('renderWelcome', 'render');
        $view = view('welcome-edited');
        $event = $this->stopwatch->stop('renderWelcome');
        $this->logger->info(
            sprintf('Welcome took %s', $event->__toString()),
            ['view' => 'welcome']
        );
        $this->logger->channel('logentries')->info(
            'Goes to logentries only',
            ['renderMemory' => $event->getMemory()]
        );

        return $view;
    }

}
