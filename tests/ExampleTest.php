<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */

    protected $baseUrl = 'http://localhost:150';

    //use WithoutMiddleware;

    /*public function testBasicExample()
    {
        $this->visit('/')->see('Laravel 5');
    }*/

    /*public function testPagoTransferencia() {
        //$this->visit('http://10.0.10.13/faaszoom/public/pagoTransferencia/login');
        $this->type('100000788', 'login');
        $this->type('123456', 'claveenc');
        $this->type('pdhhz', 'captcha');
        $this->press('Aceptar');
        $this->seePageIs('/faaszoom/public/pagoTransferencia');
        $this->visit('/faaszoom/public/pagoTransferencia/3763');
        $this->visit('/faaszoom/public/pagoTransferencia/653/edit');
        $this->type('10000.05', 'montototal');
        $this->press('Guardar');
        $this->press('Close');
        $this->press('Regresar');
        $this->seePageIs('/faaszoom/public/pagoTransferencia/3763');
        $this->visit('/faaszoom/public/pagoTransferencia/648/detail');
        $this->press('Descargar pdf');
        $this->press('Regresar');
        $this->seePageIs('/faaszoom/public/pagoTransferencia/3763');
        $this->visit('/faaszoom/public/pagoTransferencia/login');
        
        $this->visit('/consultaDesarrollo3');
        $this->type('victor poeta', 'nombre');
        $this->press('buscar');
        $this->press('limpiar');

        //$this->visit('http://www.google.co.ve');
        //$this->press('btnK');
    }*/

    public function testPruebaHash() {
       /* $this->withSession(['login' => 'test']);
        $this->visit('/pruebaHash');
        //$this->press('buscar');
        $this->assertTrue(true);*/

        $this->visit('/home');
        $this->type('user_999', 'txtLogin');
        $this->type('secret', 'txtClave');
        $this->press('txtEnviar');

        $this->visit('/pruebaHash');
        $this->type('0123456789', 'txtCadena');
        $this->type('0123456789', 'txtKey');
        $this->press('btnEncriptar');
        //$this->see('error');
        $this->seePageIs('/pruebaHash');

    }

    public function testPagoTransferencia(Request $request) {
        //$this->withSession(['login' => 'unknown001', 'user_id' => '001']);
        print_r( \Session::get('login') );
        print_r( \Session::get('user_id') );

        //$this->visit('http://desarrollo3.grupozoom.com/faaszoom/public/pagoTransferencia/login');
        //$this->call('post', '/arrays');

        // $this->seePageIs('http://10.0.10.13/faaszoom/public/pagoTransferencia/login');
        // $this->visit('/')->see('');

    }

}
