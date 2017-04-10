<?php

namespace Libs;

use Libs\Soap\EtmAbstract;

class Ping extends EtmAbstract
{
    public $echo_data = 'ping';

    public function getRequest()
    {
        return $this->echo_data;
    }

    protected function getMethodName()
    {
        return 'ETM_Ping';
    }
}
