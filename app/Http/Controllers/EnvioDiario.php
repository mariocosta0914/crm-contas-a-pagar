<?php

namespace App\Http\Controllers;

use App\BloqueioEnvioDiario;
use App\Clientes;
use App\Helpers\Helper;
use App\Helpers\ServiceEnvioDiario;
use App\Mail\SendeEnvioDiario;
use App\TodosBoletos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class EnvioDiario extends Controller
{


    public static function index()
    {
        return view('envio_diario.listagemUsuarios');
    }


    public static function getClientes()
    {
        $clientes = Clientes::getTodosCliente();
        return $clientes;
    }

    public static function bloquearCliente(Request $request)
    {
        $verClienteBloque = BloqueioEnvioDiario::getClientesBloqueadosById($request->id_cliente);
        if ($verClienteBloque == 0) {
            $dados = array(
                'id_cliente' => $request->id_cliente,
                'nome' => $request->nome,
                'cnpj' => $request->cnpj
            );
            BloqueioEnvioDiario::bloquearCliente($dados);
        } else {
            throw new Exception("Erro, cliente já bloqueado..");
        }
    }

    public static function desbloquearCliente($id_cliente)
    {
        BloqueioEnvioDiario::desbloquearCliente($id_cliente);
    }


    public static function EnvioBoletosVencHj()
    {

        $titulos = TodosBoletos::getBoletosVencHoje();
        $assuntos = ServiceEnvioDiario::assuntoEnvioDiario();
        $tipos_envio = ServiceEnvioDiario::tipoEnvio();

        try {
            if ($titulos) {
                foreach ($titulos as $titulo) {
                    $cnpj = EnvioDiario::limpaCPF_CNPJ($titulo->CNPJCPF_Sacado);
                    if (BloqueioEnvioDiario::getClientesBloqueadosByCnpj($cnpj) == 0) {
                        $nota = 'Nota-' . $titulo['CdRcd'] . '.pdf';
                        $anexo = 'Boleto-' . $titulo['CdRcd'] . '.pdf';

                        EnvioDiario::getNota($titulo);
                        $titulo = (object) $titulo;
                        Helper::gerarBoleto($titulo, true);

                        $array_email = array();
                        if ($titulo->Email != null) {
                            $email1 = explode(";", $titulo->Email);
                            for ($j = 0; $j < count($email1); $j++) {
                                array_push($array_email, trim($email1[$j]));
                            }
                        }

                        if ($titulo->Email2 != null) {
                            $email2 = explode(";", $titulo->Email2);
                            for ($k = 0; $k < count($email2); $k++) {
                                array_push($array_email, trim($email2[$k]));
                            }
                        }

                        Mail::to($array_email)
                            ->bcc('boletos@wirelink.com.br')
                            ->send(new SendeEnvioDiario(
                                $anexo,
                                $titulo,
                                $nota,
                                $assuntos['vencHoje'],
                                $tipos_envio['LEMBRETE_DIA']
                            ));
                    }
                }
            }
        } catch (Exception $e) {
            Log::info('Erro no Envio CDRCD:');
            Log::info($e);
        }
    }


    public static function EnvioBoletosVencEmTresD()
    {

        $titulos = TodosBoletos::getBoletosLembrete();
        $assuntos = ServiceEnvioDiario::assuntoEnvioDiario();
        $tipos_envio = ServiceEnvioDiario::tipoEnvio();

        try {
            if ($titulos) {
                foreach ($titulos as $titulo) {
                    $cnpj = EnvioDiario::limpaCPF_CNPJ($titulo->CNPJCPF_Sacado);

                    if (BloqueioEnvioDiario::getClientesBloqueadosByCnpj($cnpj) == 0) {
                        $titulo = (object) $titulo;
                        $array_email = array();
                        if ($titulo->Email != null) {
                            $email1 = explode(";", $titulo->Email);
                            for ($j = 0; $j < count($email1); $j++) {
                                array_push($array_email, trim($email1[$j]));
                            }
                        }

                        if ($titulo->Email2 != null) {
                            $email2 = explode(";", $titulo->Email2);
                            for ($k = 0; $k < count($email2); $k++) {
                                array_push($array_email, trim($email2[$k]));
                            }
                        }

                        Mail::to($array_email)
                            ->bcc('boletos@wirelink.com.br')
                            ->send(new SendeEnvioDiario(
                                $anexo = null,
                                $titulo,
                                $nota = null,
                                $assuntos['vencLembrete'],
                                $tipos_envio['LEMBRETE_3_DIAS']
                            ));
                    }
                }
            }
        } catch (Exception $e) {
            Log::info('Erro no Envio CDRCD:');
            Log::info($e);
        }
    }


    public static function EnvioBoletosAtrasoTresD()
    {

        $titulos = TodosBoletos::getBoletosCobranca();
        $assuntos = ServiceEnvioDiario::assuntoEnvioDiario();
        $tipos_envio = ServiceEnvioDiario::tipoEnvio();

        try {
            if ($titulos) {
                foreach ($titulos as $titulo) {
                    $cnpj = EnvioDiario::limpaCPF_CNPJ($titulo->CNPJCPF_Sacado);

                    if (BloqueioEnvioDiario::getClientesBloqueadosByCnpj($cnpj) == 0) {

                        $titulo = (object) $titulo;
                        $array_email = array();
                        if ($titulo->Email != null) {
                            $email1 = explode(";", $titulo->Email);
                            for ($j = 0; $j < count($email1); $j++) {
                                array_push($array_email, trim($email1[$j]));
                            }
                        }

                        if ($titulo->Email2 != null) {
                            $email2 = explode(";", $titulo->Email2);
                            for ($k = 0; $k < count($email2); $k++) {
                                array_push($array_email, trim($email2[$k]));
                            }
                        }

                        Mail::to($array_email)
                            ->bcc('boletos@wirelink.com.br')
                            ->send(new SendeEnvioDiario(
                                $anexo = null,
                                $titulo,
                                $nota = null,
                                $assuntos['vencCobranca'],
                                $tipos_envio['COBRANCA']
                            ));
                    }
                }
            }
        } catch (Exception $e) {
            Log::info('Erro no Envio CDRCD:');
            Log::info($e);
        }
    }


    public static function EnvioBoletosAtrasoSeteD()
    {

        $titulos = TodosBoletos::getBoletosCobrancaAntigos();
        $assuntos = ServiceEnvioDiario::assuntoEnvioDiario();
        $tipos_envio = ServiceEnvioDiario::tipoEnvio();

        try {
            if ($titulos) {

                foreach ($titulos as $titulo) {

                    $cnpj = EnvioDiario::limpaCPF_CNPJ($titulo->CNPJCPF_Sacado);

                    if (BloqueioEnvioDiario::getClientesBloqueadosByCnpj($cnpj) == 0) {
                        $titulo = (object) $titulo;
                        $array_email = array();
                        if ($titulo->Email != null) {
                            $email1 = explode(";", $titulo->Email);
                            for ($j = 0; $j < count($email1); $j++) {
                                array_push($array_email, trim($email1[$j]));
                            }
                        }

                        if ($titulo->Email2 != null) {
                            $email2 = explode(";", $titulo->Email2);
                            for ($k = 0; $k < count($email2); $k++) {
                                array_push($array_email, trim($email2[$k]));
                            }
                        }

                        Mail::to($array_email)
                            ->bcc('boletos@wirelink.com.br')
                            ->send(new SendeEnvioDiario(
                                $anexo = null,
                                $titulo,
                                $nota = null,
                                $assuntos['vencCobranca'],
                                $tipos_envio['COBRANCA']
                            ));
                    }
                }
            }
        } catch (Exception $e) {
            Log::info('Erro no Envio CDRCD:');
            Log::info($e);
        }
    }



    public static function getNota($titulo)
    {
        if (
            $titulo['TipoDeDocumento'] == 'Nota Fiscal de Serviço Eletrônica'
            || $titulo['TipoDeDocumento'] == 'Nota de Telecomunicação - Fortel'
        ) {
            GerarNotaController::downloadNota($titulo['CdRcd']);
        }
    }

    public static function getClientesBloqueados()
    {
        return BloqueioEnvioDiario::getClientesBloqueados();
    }



    public static function getClientesBloqueadosById($id)
    {
        BloqueioEnvioDiario::getClientesBloqueadosById($id);
    }

    public static function limpaCPF_CNPJ($cnpj)
    {
        return str_replace(".", "", str_replace("/", "", str_replace("-", "", $cnpj)));
    }

    // Caso seja presciso enviar menssagens em massa 
    // public static function envio()
    // {
    //     $titulos = TodosBoletos::getPessoa();
    //     foreach ($titulos as $titulo) {
    //         try {

    //             $array_email = array();
    //             $array_email =  str_replace(' ', ';', $array_email);

    //             if ($titulo->Email != null) {
    //                 $email1 = explode(";", $titulo->Email);

    //                 for ($j = 0; $j < count($email1); $j++) {
    //                     array_push($array_email, trim($email1[$j]));
    //                 }

    //                 Mail::to($array_email)
    //                     ->cc('boletos@wirelink.com.br')
    //                     ->send(new SendeEnvioDiario());
    //                 Log::info(' Envio :');
    //             }
    //         } catch (\Throwable $th) {
    //             Log::info('Erro no Envio :');
    //             Log::info($th);
    //         }
    //     }
    // }
}
