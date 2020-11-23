<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <div>
        <table style="width:100%">
            <tr>
                <th style="height:100px">
                    <img src="{{ public_path('img/logopmf.png') }}" style="height:70px;width:80px">
                </th>
                <th style="width:70%">
                    <p style="font-size:12px">PREFEITURA MUNICIPAL DE FORTALEZA</p>
                    <p style="font-size:12px">SECRETARIA MUNICIPAL DAS FINANÇAS</p>
                    <p style="font-size:14px"> NOTA FISCAL ELETRÔNICA DE SERVIÇO - NFS-e</p>
                </th>
                <th style="width:13%">
                    <p>Número da
                        NFS-e</p>
                    <p>{{ $dados->Numero }}</p>
                </th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%">Data e Hora da Emissão</td>
                <td style="width:10%">
                    {{ date('d/m/Y H:i:s', strtotime($dados->Competencia)) }}

                </td>
                <td style="width:10%">Competência</td>
                <td style="width:10%">
                    {{ date('m/Y', strtotime($dados->Competencia)) }}
                </td>
                <td style="width:10%">Código de Verificação</td>
                <td style="width:10%">{{ $dados->CodigoVerificacao }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%">Número do RPS</td>
                <td style="width:10%">{{ $dados->IdentificacaoRps->Numero }}</td>
                <td style="width:10%">No. da NFS-e substituída</td>
                <td style="width:10%"></td>
                <td style="width:10%">Local da Prestação</td>
                <td style="width:10%">{{ $codMunipioCliente }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%;text-align: center;font-size: 12px;">Dados do Prestador de Serviços</th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;border: 0px"></td>
                <td style="width:10%">Razão Social/Nome</td>
                <td style="width:40%">{{ $dados->PrestadorServico->RazaoSocial }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;border: 0px"></td>
                <td style="width:10%">Nome Fantasia</td>
                <td style="width:40%">{{ $dados->PrestadorServico->NomeFantasia }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;border: 0px"></td>
                <td style="width:5%">CNPJ/CPF</td>
                <td style="width:10%">{{ $dados->PrestadorServico->IdentificacaoPrestador->Cnpj }}</td>
                <td style="width:10%">Inscrição Municipal</td>
                <td style="width:5%">{{ $dados->PrestadorServico->IdentificacaoPrestador->InscricaoMunicipal }}</td>
                <td style="width:10%">Município</td>
                <td style="width:10%">{{ $codMunipioPrestSrv }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;border: 0px"></td>
                <td style="width:7%">Endereço e Cep</td>
                <td style="width:43%">
                    {{ $dados->PrestadorServico->Endereco->Endereco 
                    . ', ' . $dados->PrestadorServico->Endereco->Numero 
                    . ', ' . $dados->PrestadorServico->Endereco->Bairro 
                    . ' CEP : ' . $dados->PrestadorServico->Endereco->Cep }}
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;border: 0px"></td>
                <td style="width:5%">Complemento</td>
                <td style="width:10%">{{ $dados->PrestadorServico->Endereco->Complemento }}</td>
                <td style="width:10%">Telefone</td>
                <td style="width:5%">{{ $dados->PrestadorServico->Contato->Telefone }}</td>
                <td style="width:10%">Email</td>
                <td style="width:10%">{{ $dados->PrestadorServico->Contato->Email }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%;text-align: center;font-size: 12px;">Dados do Tomador de Serviços</th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%">Razão Social/Nome</td>
                <td style="width:50%">{{ $dados->TomadorServico->RazaoSocial }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:5%">CNPJ/CPF</td>
                <td style="width:10%">{{ $dados->TomadorServico->IdentificacaoTomador->CpfCnpj->Cnpj }}</td>
                <td style="width:10%">Inscrição Municipal</td>
                <td style="width:10%">{{ $dados->TomadorServico->Endereco->CodigoMunicipio }}</td>
                <td style="width:10%">Município</td>
                <td style="width:10%">{{ $codMunipioCliente }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%">Endereço e Cep</td>
                <td style="width:50%">
                    {{ $dados->TomadorServico->Endereco->Endereco 
                    . ', ' . $dados->TomadorServico->Endereco->Numero 
                    . ', ' . $dados->TomadorServico->Endereco->Bairro 
                    . ' CEP : ' . $dados->TomadorServico->Endereco->Cep }}
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%">Complemento</td>
                <td style="width:10%">{{ $dados->PrestadorServico->Endereco->Complemento }}</td>
                <td style="width:10%">Telefone</td>
                <td style="width:10%"> {{ $dados->TomadorServico->Contato->Telefone }}</td>
                <td style="width:10%">Email</td>
                <td style="width:10%">{{ $dados->TomadorServico->Contato->Email }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%;text-align: center;font-size: 12px;">Discriminação dos Serviços</th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%;height:200px; ">
                    <p style="float: left;">{{ $dados->Servico->Discriminacao }}</p>
                </th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%;text-align: center;font-size: 12px; font-size: 12px;">Código de Atividade CNAE
                </th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:100%;">
                    {{ $dados->Servico->ItemListaServico }} / {{ $dados->Servico->CodigoCnae }} -
                    {{ $descCnae }}
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%;text-align: center;font-size: 12px;">Detalhamento Específico da Construção Civil
                </th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:8%">Código da Obra</td>
                <td style="width:15%"></td>
                <td style="width:8%">Código ART</td>
                <td style="width:15%"></td>


            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%;text-align: center;font-size: 12px;">Tributos Federais</th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:8%">PIS</td>
                <td style="width:8%"></td>
                <td style="width:8%">COFINS</td>
                <td style="width:8%"></td>
                <td style="width:8%">IR(R$)</td>
                <td style="width:8%"></td>
                <td style="width:8%">INSS(R$)</td>
                <td style="width:8%"></td>
                <td style="width:8%">CSLL(R$)</td>
                <td style="width:8%"></td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <th style="width:100%; font-size: 12px;">
                    <b>Detalhamento de Valores - Prestador dos Serviços</b>
                    &#160;&#160; &#160;&#160; &#160;&#160;
                    &#160;&#160; &#160;&#160; &#160;&#160;
                    &#160;&#160; &#160;&#160; &#160;&#160;
                    <b>Cálculo do ISSQN devido no Município</b>

                </th>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%">Valor dos Serviços R$</td>
                <td style="width:10%">{{ $dados->Servico->Valores->ValorServicos }}</td>
                <td style="width:10%">Natureza Operação</td>
                <td style="width:10%">Valor dos Serviços R$</td>
                <td style="width:10%">{{ $dados->Servico->Valores->ValorServicos }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%; height:40px">(-) Desconto Incondicionado</td>
                <td style="width:10%; height:40px"></td>
                <td style="width:10%; height:40px">1 - Tributação no Município</td>
                <td style="width:10%; height:40px">(-) Deduções permitidas em lei</td>
                <td style="width:10%; height:40px"></td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;">(-) Desconto Condicionado</td>
                <td style="width:10%;"></td>
                <td style="width:10%;">Regime especial Tributação</td>
                <td style="width:10%;">(-) Desconto Incondicionado</td>
                <td style="width:10%;"></td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;">(-) Retenções Federais</td>
                <td style="width:10%;">0,00</td>
                <td style="width:10%;">0 - Nenhum</td>
                <td style="width:10%;">Base de Cálculo</td>
                <td style="width:10%;">{{ $dados->Servico->Valores->ValorServicos }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;">Outras Retenções</td>
                <td style="width:10%;"></td>
                <td style="width:10%;">Opção Simples Nacional</td>
                <td style="width:10%;">(x) Alíquota %</td>
                <td style="width:10%;"> {{ $dados->Servico->Valores->Aliquota }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;">(-) ISS Retido</td>
                <td style="width:10%;">{{ $dados->Servico->Valores->ValorIssRetido }}</td>
                <td style="width:10%;">{{ $dados->OptanteSimplesNacional }} - Não</td>
                <td style="width:10%;">ISS a reter</td>
                <td style="width:10%;">( ) Sim (X) Não</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%;">(=) Valor Líquido R$</td>
                <td style="width:10%;">{{ $dados->Servico->Valores->ValorLiquidoNfse }}</td>
                <td style="width:10%;">
                    <p>Incentivador Cultural</p>
                    <hr>
                    <p>{{ $dados->IncentivadorCultural }} - Não</p>
                </td>
                <td style="width:10%;">(=) Valor do ISS: R$</td>
                <td style="width:10%;">{{ $dados->Servico->Valores->ValorIss }}</td>

            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td style="width:10%; height:100px;">Avisos</td>
                <td style="width:40%;">
                    <p>1- Uma via desta Nota Fiscal será enviada através do e-mail fornecido pelo Tomador dos Serviços,
                        no
                        sítio http://iss.fortaleza.ce.gov.br</p>
                    <p>2- A autenticidade desta Nota Fiscal poderá ser validada no site http://iss.fortaleza.ce.gov.br/,
                        com
                        a utilização do Código de Verificação.</p>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>
<style scope>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 9px;

    }
</style>