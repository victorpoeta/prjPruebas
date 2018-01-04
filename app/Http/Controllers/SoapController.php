<?php

namespace App\Http\Controllers;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

class SoapController extends Controller {

    public function demo()
    {
        // Add a new service to the wrapper
        SoapWrapper::add(function ($service) {
            $service
                ->name('currency')
                ->wsdl('http://currencyconverter.kowabunga.net/converter.asmx?WSDL')
                ->trace(true)                                                   // Optional: (parameter: true/false)
                //->header()                                                      // Optional: (parameters: $namespace,$name,$data,$mustunderstand,$actor)
                //->customHeader($customHeader)                                   // Optional: (parameters: $customerHeader) Use this to add a custom SoapHeader or extended class                
                //->cookie()                                                      // Optional: (parameters: $name,$value)
                //->location()                                                    // Optional: (parameter: $location)
                //->certificate()                                                 // Optional: (parameter: $certLocation)
                //->cache(WSDL_CACHE_NONE)                                        // Optional: Set the WSDL cache
                /*->options(['login' => 'username', 'password' => 'password'])*/ ;   // Optional: Set some extra options
        });

        $data = [
            'CurrencyFrom' => 'USD',
            'CurrencyTo'   => 'EUR',
            'RateDate'     => '2016-11-01',
            'Amount'       => '500'
        ];

        // Using the added service
        SoapWrapper::service('currency', function ($service) use ($data) {
            var_dump($service->getFunctions());
            var_dump($service->call('GetConversionAmount', [$data])->GetConversionAmountResult);
        });
    }

}