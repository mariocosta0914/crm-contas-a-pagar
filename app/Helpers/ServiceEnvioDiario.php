<?php

namespace App\Helpers;

class ServiceEnvioDiario
{
    public static function layoutEnvioDiario()
    {
        $views = array(
            "vencHoje" => "templates.viewDoDia",
            "vencLembrete" => "templates.viewLembrete",
            "vencCobranca" => "templates.viewCobranca",
        );
        return $views;
    }

    public static function assuntoEnvioDiario()
    {
        $assuntos = array(
            "vencHoje" => "É HOJE: O vencimento da sua fatura Wirelink é hoje!",
            "vencLembrete" => "NÃO ESQUEÇA: O vencimento da sua fatura Wirelink está chegando!",
            "vencCobranca" => "ATRASOU: A sua fatura Wirelink está atrasada, pague agora mesmo!",
        );

        return $assuntos;
    }

    public static function tipoEnvio()
    {
        $tipos_envio = array(
            "LEMBRETE_3_DIAS" => "LEMBRETE 3 DIAS",
            "LEMBRETE_7_DIAS" => "LEMBRETE 7 DIAS",
            "LEMBRETE_DIA" => "LEMBRETE DIA",
            "COBRANCA" => "COBRANCA"
        );
        return $tipos_envio;
    }
}
