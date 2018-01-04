<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//include "\phpseclib\phpseclib\phpseclib\Net\SFTP.php";
/*use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
use phpseclib\Net\SSH2;
use phpseclib\System\SSH\Agent;*/

class SFTPController extends Controller
{
    private $host;
    private $port;
    private $user;
    private $password;
    private $ssl;
    private $timeout;
    private $stream;
    private $passive;
    private $system_type;

    public function __construct() {
    	$this->ssl = true;
    	$this->timeout = 90;
    }

    public function conectar($ssl_ftp = true, $host, $port = 22, $user, $password) {
    	#$obj = new \Net_SFTP($host, $port, $this->timeout);
        #return $obj;

    	//$obj = conectar_SFTP($host, $port, $user, $password);
    	#return "Resultado:" . $obj;

    }

}
