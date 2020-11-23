
    <table style="height: 161px; margin-left: auto; margin-right: auto;" border="1px solid" width="100%">
        <caption>&nbsp;</caption>
        <tbody>
        <tr style="height: 25px;">
            <td style="width: 10%; height: 25px;" rowspan="5">
                <img src="{{ public_path('img/logoNotaTelecom.png')}}" alt="" height="25px"/>
            </td>
            <td style="width: 10%; height: 25px;">
                EMPRESA:
            </td>
            <td style="width: 50.3831%; height: 25px;">
                <strong><?php /** @var TYPE_NAME $nota */
                    if ($nota['RazaoSocial']) echo $nota['RazaoSocial']; ?></strong>
            </td>
            <td style="width: 17.6169%; height: 25px;" rowspan="5">
                <p style="text-align: center;"><strong>Nota Fiscal</strong></p>
                <p>N&ordm;.: <strong><?php if ($nota['Numero']) echo $nota['Numero']; ?></strong></p>
                <p>Data Emiss&atilde;o: <strong><?php if ($nota['DtEmissao']) echo $nota['DtEmissao']; ?></strong></p>
            </td>
        </tr>
        <tr style="height: 25px;">
            <td style="width: 10%; height: 25px;">
                CNPJ:
            </td>
            <td style="width: 45%; height: 25px;">
                <strong><?php if ($nota['CNPJCPF']) echo $nota['CNPJCPF']; ?></strong>
            </td>
        </tr>
        <tr style="height: 25px;">
            <td style="width: 10%; height: 25px;">
                ENDERE&Ccedil;O:
            </td>
            <td style="width: 45%; height: 25px;">
                <strong><?php if ($nota['Endereco']) echo $nota['Endereco']; ?></strong>
            </td>
        </tr>
        <tr>
            <td style="width: 10%;">BAIRRO:</td>
            <td style="width: 45%;"><strong><?php if ($nota['BairroUne']) echo $nota['BairroUne']; ?></strong></td>
        </tr>
        <tr style="height: 25px;">
            <td style="width: 10%; height: 25px;">
                CIDADE:
            </td>
            <td style="width: 45%; height: 25px;">
                <strong><?php if ($nota['CidadeUne']) echo $nota['CidadeUne']; ?></strong>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="height: 28px; margin-left: auto; margin-right: auto;" border="1 px solid" width="100%">
        <tbody>
        <tr>
            <td style="width: 181px; text-align: center;">
                <strong>Nota Fiscal de Telecomunica&ccedil;&atilde;o - Modelo: 22 -
                    Serie: <?php if ($nota['Serie'] && $nota['SubSerie']) echo $nota['Serie'] . $nota['SubSerie']; ?></strong>
            </td>
        </tr>
        </tbody>
    </table>
    <table style="height: 29px; margin-left: auto; margin-right: auto;" border="1 px solid" width="100%">
        <tbody>
        <tr>
            <td style="width: 18.5855%;">Cliente:</td>
            <td style="width: 78.7829%;">
                <strong><?php if ($nota['Cliente']) echo $nota['Cliente']; ?></strong>
            </td>
        </tr>
        <tr>
            <td style="width: 18.5855%;">
                CPNJ/CPF:
            </td>
            <td style="width: 78.7829%;">
                <strong><?php if ($nota['CNPJCPFCliente']) echo $nota['CNPJCPFCliente']; ?></strong>
            </td>
        </tr>
        <tr>
            <td style="width: 18.5855%;">
                Endere&ccedil;o:
            </td>
            <td style="width: 78.7829%;">
                <strong><?php if ($nota['EnderecoCli']) echo $nota['EnderecoCli']; ?></strong>
            </td>
        </tr>
        <tr>
            <td style="width: 18.5855%;">
                CEP:
            </td>
            <td style="width: 78.7829%;">
                <strong><?php if ($nota['EnderecoCli']) {
                        $CEP = substr($nota['EnderecoCli'], strpos($nota['EnderecoCli'], 'Cep:') + 4);
                        $CEP = explode(' ', $CEP);
                        echo $CEP[0];
                    } ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td style="width: 18.5855%;">
                CIDADE:
            </td>
            <td style="width: 78.7829%;">
                <strong><?php if ($nota['MunicipioCli']) echo $nota['MunicipioCli']; ?></strong>
            </td>
        </tr>
        <tr>
            <td style="width: 18.5855%;">
                Telefone:
            </td>
            <td style="width: 78.7829%;">
                <strong><?php if ($nota['TelefoneCli']) echo $nota['TelefoneCli']; ?></strong>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="height: 26px; margin-left: auto; margin-right: auto;" border="1 px solid" width="100%">
        <tbody>
        <tr>
            <td style="width: 31%; text-align: center;">
                Descri&ccedil;&atilde;o dos servi&ccedil;os
            </td>
            <td style="width: 10%; text-align: center;">
                CFOP
            </td>
            <td style="width: 11.7083%; text-align: center;">
                Aliq. ICMS
            </td>
            <td style="width: 13.2917%; text-align: center;">
                Base ICMS
            </td>
            <td style="width: 12%; text-align: center;">
                Valor ICMS
            </td>
            <td style="width: 13%; text-align: center;">
                Valor Bruto
            </td>
        </tr>
        <tr>
            <td style="width: 31%;">
                <strong><?php if ($nota['Objeto']) echo $nota['Objeto']; ?></strong>
            </td>
            <td style="width: 10%; text-align: right;">
                <strong><?php if ($nota['Cfop']) echo $nota['Cfop']; ?></strong>
            </td>
            <td style="width: 11.7083%; text-align: right;">
                <strong><?php if ($nota['AliqICMS']) echo number_format($nota['AliqICMS'], 2, ',', '.'); ?></strong>
            </td>
            <td style="width: 13.2917%; text-align: right;">
                <strong>
                    <?php

                    if ( $nota['Cfop'] == 5301
                        || $nota['Cfop'] == 5302
                        ||$nota['Cfop'] == 5303
                        ||$nota['Cfop'] == 5304
                        ||$nota['Cfop'] == 5305
                        ||$nota['Cfop'] == 5306
                        ||$nota['Cfop'] == 5307)

                    {
                        $baseIcms =  ($nota['VrBruto'] * 25)/100 ;
                        echo "R$ " . number_format($baseIcms, 2, ',', '.');
                    }else{
                        echo "R$ " . number_format($nota['VrBruto'], 2, ',', '.');
                    }

                    ?>
                </strong>
            </td>
            <td style="width: 12%; text-align: right;">
                <strong><?php if ($nota['VrTotICMS']) echo "R$ " . number_format($nota['VrTotICMS'], 2, ',', '.'); ?></strong>
            </td>
            <td style="width: 13%; text-align: right;">
                <strong><?php if ($nota['VrBruto']) echo "R$ " . number_format($nota['VrBruto'], 2, ',', '.'); ?></strong>
            </td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="height: 71px; margin-left: auto; margin-right: auto;" border="1 px solid" width="100%">
        <tbody>
        <tr style="height: 18px;">
            <td style="width: 164px; text-align: center; height: 18px;">
                <strong>Informa&ccedil;&otilde;es Adicionais</strong>
            </td>
        </tr>
        <tr style="height: 35.4px;">
            <td style="width: 164px; height: 35.4px;">
                <?php
                if ($nota['InfoAdi'] && $nota['Cfop'] == 5301
                        || $nota['Cfop'] == 5302
                        ||$nota['Cfop'] == 5303
                        ||$nota['Cfop'] == 5304
                        ||$nota['Cfop'] == 5305
                        ||$nota['Cfop'] == 5306
                        ||$nota['Cfop'] == 5307) {
                    echo $nota['InfoAdi'] . "<br/>" .
                        "A Empresa prestadora dos serviços constantes deste documento
                         fiscal é beneficiária de redução de base cálculo de ICMS,
                         conforme Convênio ICMS Nº 19 de 03/04/2018, art.: 67 a 69, da Lei nº 12.670/96
                         c/c art.: 54-B, do Dec. 24.569/97,
                         firmado e plasmado no Termo Especial 
                        de Tributação Nº 00945/2019, com efeitos a partir 1º de Outubro de 2019.";

                } else {
                    echo $nota['InfoAdi'];
                }

                ?>
            </td>
        </tr>
        <tr style="height: 18px;">
        
            <td style="width: 164px; height: 18px; text-align: center;">
                <strong>C&aacute;lculo do Imposto</strong>
            </td>
        </tr>
        </tbody>
    </table>
    <table style="height: 24px; margin-left: auto; margin-right: auto;" border="1 px solid" width="100%">
        <tbody>
        <tr>
            <td style="width: 28.1488%;">&nbsp;Base de C&aacute;lculo do ICMS</td>
            <td style="width: 21.8512%;">Al&iacute;quota do ICMS</td>
            <td style="width: 23%;">Valor do ICMS</td>
            <td style="width: 18%;">Outros</td>
        </tr>
        <tr>
            <td style="width: 28.1488%;">
                <strong>
                    <?php
                     if ( $nota['Cfop'] == 5301
                         || $nota['Cfop'] == 5302
                         ||$nota['Cfop'] == 5303
                         ||$nota['Cfop'] == 5304
                         ||$nota['Cfop'] == 5305
                         ||$nota['Cfop'] == 5306
                         ||$nota['Cfop'] == 5307){
                         $baseIcms =  ($nota['VrBruto'] * 25)/100 ;
                         echo "R$ " . number_format($baseIcms, 2, ',', '.');
                     }else{
                         echo "R$ " . number_format($nota['VrBruto'], 2, ',', '.');
                     }

                    ?>
                </strong>
            </td>
            <td style="width: 21.8512%;">
                <strong><?php if ($nota['AliqICMS']) echo number_format($nota['AliqICMS'], 2, ',', '.'); ?></strong>
            </td>
            <td style="width: 23%;">
                <strong><?php if ($nota['VrTotICMS']) echo "R$ " . number_format($nota['VrTotICMS'], 2, ',', '.'); ?></strong>
            </td>
            <td style="width: 18%;">
                <strong><?php if ($nota['Outros']) echo "R$ " . number_format($nota['Outros'], 2, ',', '.'); ?></strong>
            </td>
        </tr>
        </tbody>
    </table>
    <table style="height: 14px; margin-left: auto; margin-right: auto;" border="1 px solid" width="100%">
        <tbody>
        <tr>
            <td style="width: 164px;">
                Reservado ao fisco: <strong><?php if ($nota['MD5']) echo $nota['MD5']; ?></strong>
            </td>
        </tr>
        </tbody>

    </table>

