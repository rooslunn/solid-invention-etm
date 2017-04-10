<?php

namespace Libs;

use Libs\Soap\EtmAbstract;

class DoAirFareRequest extends EtmAbstract
{
    public $departure_datetime;
    public $original_location;
    public $destination_location;
    public $passangers_quantity;
    
    public function getRequest()
    {
        $date = date('Y-m-d\TH:i:s', strtotime($this->departure_datetime . ' 00:00:00'));
        
        $destination = new \stdClass();
        $destination->DepartureDateTime   = new \SoapVar($date, XSD_DATETIME);
        $destination->OriginLocation      = new \SoapVar($this->original_location, XSD_STRING);
        $destination->DestinationLocation = new \SoapVar($this->destination_location, XSD_STRING);
        
        $destination_soap = new \SoapVar($destination, SOAP_ENC_OBJECT, 'OriginDestinationInformationType', null, 'OriginDestinationInformation');
                
        $passanger = new \stdClass();
        
        $passanger->Type = new \SoapVar('ADT', XSD_STRING);
        $passanger->Quantity = new \SoapVar($this->passangers_quantity, XSD_INT);
        
        $passanger_soap = new \SoapVar($passanger, SOAP_ENC_OBJECT, 'PassengerQuantityType', null, 'Passenger');
        
        $travaller = [$passanger_soap];
        
        $travaller_soap = new \SoapVar($travaller, SOAP_ENC_OBJECT, 'TravelerInfoSummaryType', null, 'TravelerInfoSummary');
        
        $main_container = [
            $this->getSecurityData(),
            $destination_soap,
            $travaller_soap
        ];
        
        return new \SoapVar($main_container, SOAP_ENC_OBJECT, 'DoAirFareRQ', null, 'AirFareRQ');
    }
    
    protected function getMethodName()
    {
        return 'ETM_DoAirFareRequest';
    }
}
