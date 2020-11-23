<?php

namespace App\Http\Controllers;

use App\Cnae;
use App\NotaNfse;
use App\NotaTelecom;

class GerarNotaController extends Controller
{

    public static function downloadNota($cdRcd)
    {

        if (GerarNotaController::verificaSeExisteNotaTelecom($cdRcd)) {
            return GerarNotaController::gerarNotaTelecom($cdRcd);
        } else {
            GerarNotaController::gerarNotaNfse($cdRcd);
            return GerarNotaController::downloadFile($cdRcd);
        }
    }

    public static function gerarNotaTelecom($cdRcd)
    {
        $nota =  NotaTelecom::getNota($cdRcd);
        return $file = \PDF::loadView('notaTelecom', compact('nota'))
            ->save(storage_path("app/notas/Nota-$cdRcd.pdf"))
            ->download('Nota-' . $cdRcd . '.pdf');
    }

    public static function gerarNotaNfse($cdRcd)
    {
        $dados = '';
        $notaXml =  NotaNfse::getXmlNota($cdRcd);   
        $xmlFormatado = GerarNotaController::limparaXml($notaXml);
    
        foreach ($xmlFormatado as $registros)
            $dados =  $registros;


        $codMunipioCliente = GerarNotaController::getMunicipio(
            $dados->TomadorServico->Endereco->CodigoMunicipio
        );

        $codMunipioPrestSrv = GerarNotaController::getMunicipio(
            $dados->PrestadorServico->Endereco->CodigoMunicipio
        );

        $descCnae = Cnae::getDescricaoCnae($dados->Servico->CodigoCnae);
        //Remoção do acentos do prestador
        $dados->PrestadorServico->Endereco->Bairro = GerarNotaController::Utf8_ansi($dados->PrestadorServico->Endereco->Bairro);

        //Remoção do acentos dos dados do cliente
        $dados->TomadorServico->Endereco->Bairro = GerarNotaController::Utf8_ansi($dados->TomadorServico->Endereco->Bairro);
        $dados->TomadorServico->Endereco->Endereco = GerarNotaController::Utf8_ansi($dados->TomadorServico->Endereco->Endereco);
        $dados->TomadorServico->RazaoSocial = GerarNotaController::Utf8_ansi($dados->TomadorServico->RazaoSocial);

        $pdf = \PDF::loadView('newNfse', compact(
            'dados',
            'codMunipioCliente',
            'codMunipioPrestSrv',
            'descCnae'
        ));
        return $pdf->save(storage_path("app/notas/Nota-$cdRcd.pdf"));
    }

    public static function verificaSeExisteNotaTelecom($cdRcd)
    {
        $notaTelecom = NotaTelecom::verificaSeExisteNotaTelecom($cdRcd);
        return $notaTelecom;
    }

    public static function downloadFile($fileName)
    {
        $file_path = storage_path('app/notas/Nota-' . $fileName . '.pdf');
        return response()->download($file_path);
    }

    public static function limparaXml($xmlNota)
    {

        $versionErro = 'version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?';
        $version = " version='1.0' encoding='UTF-8' ?";


        $link = '<ns3:ConsultarLoteRpsResposta xsi:schemaLocation=\"https:\/\/iss.fortaleza.ce.gov.br\/grpfor\/schema\/V2\/tipos_v02.xsd\" xmlns=\"http:\/\/www.ginfes.com.br\/tipos_v03.xsd\" xmlns:ns2=\"http:\/\/www.w3.org\/2000\/09\/xmldsig#\" xmlns:ns3=\"http:\/\/www.ginfes.com.br\/servico_consultar_lote_rps_resposta_v03.xsd\" xmlns:xsi=\"http:\/\/www.w3.org\/2001\/XMLSchema-instance\">\n';
        $NotaNfseXml = str_replace($link, '', $xmlNota);

        $NotaNfseXml = str_replace($versionErro, $version, $NotaNfseXml);
        $NotaNfseXml = str_replace('<\/ns3:ConsultarLoteRpsResposta>', '', $NotaNfseXml);
        $NotaNfseXml = str_replace('<ns3:ListaNfse>', '', $NotaNfseXml);
        $NotaNfseXml = str_replace('<ns3:CompNfse>', '', $NotaNfseXml);
        $NotaNfseXml = str_replace('<\/ns3:CompNfse>', '', $NotaNfseXml);
        $NotaNfseXml = str_replace('<\/ns3:ListaNfse>', '', $NotaNfseXml);
        $NotaNfseXml = str_replace('<\/ns3:ListaNfse>', '', $NotaNfseXml);
        $NotaNfseXml = str_replace('<\/Nfse>\n"', '<\/Nfse>"', $NotaNfseXml);
        $NotaNfseXml = str_replace('\n', '', $NotaNfseXml);
        $NotaNfseXml = str_replace('   ', '', $NotaNfseXml);

        $barra_invertida = ".\.";
        $barra_invertida = str_replace('.', '', $barra_invertida);
        $NotaNfseXml = str_replace($barra_invertida, '', $NotaNfseXml);

        $XmlObj = json_decode($NotaNfseXml);
        $nsfeXml = simplexml_load_string($XmlObj->XMLNFSe);
        return $nsfeXml;
    }

    public static function getMunicipio($id)
    {
        $cURLConnection = curl_init();
        $urlsApi = "https://servicodados.ibge.gov.br/api/v1/localidades/municipios/$id";
        curl_setopt($cURLConnection, CURLOPT_URL, $urlsApi);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $phoneList = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $resp = json_decode($phoneList);

        $municipio = $resp->nome . '-' . $resp->microrregiao->mesorregiao->UF->sigla;

        return $municipio;
    }
    public static function Utf8_ansi($valor = '')
    {

        $utf8_ansi2 = array(
            "u00c0" => "À",
            "u00c1" => "Á",
            "u00c2" => "Â",
            "u00c3" => "Ã",
            "u00c4" => "Ä",
            "u00c5" => "Å",
            "u00c6" => "Æ",
            "u00c7" => "Ç",
            "u00c8" => "È",
            "u00c9" => "É",
            "u00ca" => "Ê",
            "u00cb" => "Ë",
            "u00cc" => "Ì",
            "u00cd" => "Í",
            "u00ce" => "Î",
            "u00cf" => "Ï",
            "u00d1" => "Ñ",
            "u00d2" => "Ò",
            "u00d3" => "Ó",
            "u00d4" => "Ô",
            "u00d5" => "Õ",
            "u00d6" => "Ö",
            "u00d8" => "Ø",
            "u00d9" => "Ù",
            "u00da" => "Ú",
            "u00db" => "Û",
            "u00dc" => "Ü",
            "u00dd" => "Ý",
            "u00df" => "ß",
            "u00e0" => "à",
            "u00e1" => "á",
            "u00e2" => "â",
            "u00e3" => "ã",
            "u00e4" => "ä",
            "u00e5" => "å",
            "u00e6" => "æ",
            "u00e7" => "ç",
            "u00e8" => "è",
            "u00e9" => "é",
            "u00ea" => "ê",
            "u00eb" => "ë",
            "u00ec" => "ì",
            "u00ed" => "í",
            "u00ee" => "î",
            "u00ef" => "ï",
            "u00f0" => "ð",
            "u00f1" => "ñ",
            "u00f2" => "ò",
            "u00f3" => "ó",
            "u00f4" => "ô",
            "u00f5" => "õ",
            "u00f6" => "ö",
            "u00f8" => "ø",
            "u00f9" => "ù",
            "u00fa" => "ú",
            "u00fb" => "û",
            "u00fc" => "ü",
            "u00fd" => "ý",
            "u00ff" => "ÿ"
        );

        return strtr($valor, $utf8_ansi2);
    }
}
