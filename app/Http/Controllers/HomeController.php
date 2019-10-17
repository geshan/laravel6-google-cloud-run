<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Log\LogManager;

class HomeController extends Controller
{
    private $logger;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogManager $logger)
    {
        $this->logger = $logger;
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->logger->info('test', ['var' => 'val']);
        $this->logger->channel('logentries')->info('testing', ['type' => 1]);

        try {
            throw new \Exception('this in an Exception');
        } catch (\Exception $e) {
            $this->logger->channel('logentries')->error(
                sprintf('This is an error - %s', $e->getMessage()),
                [
                    'file' => $e->getFile(),
                    'lineNo' => $e->getLine()
                ]
            );
        }


        return view('home');
    }
}
