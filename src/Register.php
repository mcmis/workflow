<?php

namespace MCMIS\Workflow;

use Illuminate\Contracts\Foundation\Application;

class Register
{

    /**
     * Bootstrap script
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app){
        $app->bind('MCMIS\Contracts\Workflow', 'MCMIS\Workflow\Container');
    }

}