<?php
use Illuminate\Auth\Events\Login;
use App\Listeners\MergeCartListener;

protected $listen = [
    Login::class => [
        MergeCartListener::class,
    ],
];