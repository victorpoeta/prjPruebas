<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\consumirWSController;

class infoPagosPendientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'info_pagospendientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestra los pagos por transferencia pendientes (estatus 1) y se notifica por correo electrónico al usuario (si el parametro enviaremail es enviado con valor 1)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ws = new consumirWSController();
        //$Result = $ws->infoPagosPendientesWS();

        //dd($Result);
/*        $msg = "***************************************************** \n";
        $msg = $msg . "Comando: " . $this->signature . " \n \n";
        $msg = $msg . "*** Total Registros: " .  $Result['totalRegistros'] . 
                      ", Emails Enviados: " . $Result['emailsEnviados'] . " *** \n";
        $msg = $msg . "***************************************************** \n";*/
        
/*        $data = ['email'=>'vpoeta@grupozoom.com', 'pagador' => 'Victor Poeta', 
                 'asunto' => 'Mensaje de prueba', 'cuerpo'=> 'Este es un mensaje de prueba.' ];

        $EmailEnviado = \Mail::send([''=> 'view'], ['data'=>$data], function ($msg) use ($data) {
            $msg->from('mensajero@grupozoom.com', 'Pago por Transferencia - GRUPO ZOOM');
            $msg->to($data['email'], 'Victor G. Poeta')->subject($data['asunto']);
            $msg->setBody($data['cuerpo'], 'text/html');
        });

        $msg = "Prueba infoPagosPendientesWS";

        $this->info($msg);*/

        $msg = "Comando: " . $this->signature . " \n \n";

        // Se consume el WS infoPagosPendientesWs, con los parámetros: idcuentabanco: 213 (id del Banco Provincial),
        // idtipotransbanc: 24 (transferencia) y enviaremail: 1.
        $url = "http://10.0.10.13/baaszoom/public/";
        $Res = $ws->consumirPorPost('infoPagosPendientesWs', ['idcuentabanco' => '213', 'idtipotransbanc' => '24', 'enviaremail' => '1'], $url, 'canguroazul/');

        if (count($Res) > 0) {
            if ($Res['codrespuesta']=='COD_000') {
                $msg = $msg . "OK";
            } else {
                $msg = $msg . "Mensaje CODE - No se pudo enviar correos electrónicos, ya que no existen registros de pagos pendientes.";
            }
        } else {
            $msg = $msg . "$res No se pudo enviar correos electrónicos, ya que no existen registros de pagos pendientes.";
        }

        $this->info($msg);

    }


}
