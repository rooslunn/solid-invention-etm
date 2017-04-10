<?php

namespace Libs;

use Libs\Soap\EtmAbstract;

class GetAirFareResult extends EtmAbstract
{
    public $request_id;
    
    public function getRequest()
    {
        $main_container = [
            $this->getSecurityData(),
            'RequestId' => new \SoapVar($this->request_id, XSD_INT)
        ];
        return new \SoapVar($main_container, SOAP_ENC_OBJECT, 'GetAirFareRQ', null, 'AirFareRQ');
    }
    
    protected function getMethodName()
    {
        return 'ETM_GetAirFareResult';
    }
}
