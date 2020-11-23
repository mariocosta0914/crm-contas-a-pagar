<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<div style="">

    <table class="" style="width: 100%;" width="100%">
        <tbody style="">
            <tr style="">
                <td class="m_-1111144186164006899center" style="" valign="top" align="center">
                    <center style="">

                        <table style="display: inline-block; margin: 0px auto; border-collapse: collapse; background-color: rgb(245, 243, 244);" width="600" cellspacing="0" cellpadding="0" align="center">

                            <tbody style="">
                                <tr style="">
                                    <td style="" align="center">
                                        <img alt="" style="display: block; height: 80px; width: 600px;" src="{{asset('img/bannerTopHoje.png')}}" border="0">
                                    </td>
                                </tr>


                                <tr style="">
                                    <td style="" align="center">
                                        <img alt="" style="display: block; height: 292px; width: 600px;" src="{{asset('img/bannerBottomCobranca.png')}}" border="0">
                                    </td>
                                </tr>


                                <tr style="">
                                    <td style="" valign="top" align="center">

                                        <table style="margin: 0px auto; border-collapse: collapse;" width="500" cellspacing="0" cellpadding="0" align="center">
                                            <tbody style="">
                                                <tr style="">
                                                    <td style="" height="30" align="center">&nbsp;</td>
                                                </tr>

                                                <tr style="">
                                                    <td style="" width="100%" valign="top" align="left">
                                                        <p style="color: rgb(65, 64, 66); font-family: arial, helvetica, sans-serif; font-size: 15px; margin: 0px;  margin-bottom: 20px !important; line-height: 20px;">
                                                            <strong style="">{{$boleto->Sacado}}</strong><br style=""><br style="">
                                                            <img src="https://wireadmin.wirelink.com.br/api/registro-leitura/{{$boleto->CdRcd}}/5" alt="" width="1" height="1" style="display: none;">
                                                            Até o momento não identificamos em nossos sistemas o pagamento da
                                                            fatura vencida em
                                                            <b>{{ date( 'd/m/Y' , strtotime($boleto->vencimento))}}</b>
                                                            no valor de <b>R$
                                                                {{ number_format($boleto->Valor, 2, ',', '.') }}.</b>

                                                        </p>
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>

                                    </td>
                                </tr>

                                <tr style="background: #53a6d5;">
                                    <td style="" align="center">

                                        <table style="margin: 0px auto; border-collapse: collapse;" width="500" cellspacing="0" cellpadding="0" align="center">

                                            <tbody style="">
                                                <tr style="">
                                                    <td style="" height="20" align="center">&nbsp;</td>
                                                </tr>
                                                <div style="display: none">
                                                </div>

                                                <tr style="">
                                                    <td style="" width="100%" valign="top" align="left">
                                                        <p style="color: rgb(0, 0, 0); font-family: arial, helvetica, sans-serif; font-size: 13px; margin: 0px; line-height: 20px;">
                                                            Evite a suspensão de seus serviços efetuando o pagamento ainda hoje.
                                                            <br>
                                                            <a href="https://portal.wirelink.com.br/">Clique
                                                                aqui</a> e utilize o código de barras abaixo para atualizar o
                                                            seu boleto vencido. <br>
                                                            <br>
                                                            Endereço: <strong style="">{{$boleto->Endereco}},
                                                            </strong> Nº <b>{{$boleto->NrPesEdr}}</b>,
                                                            Bairro:<b>{{$boleto->Bairro}}</b><br style="">

                                                            Código de barras: <strong style="">{{$boleto->codigo_barras}}</strong><br style="">
                                                            <br>
                                                            Para ter acesso as suas notas e boletos, solicite seu acesso ao nosso portal agora mesmo, clique no link a seguir: <a href="https://portal.wirelink.com.br">https://portal.wirelink.com.br</a>
                                                        </p>
                                                    </td>

                                                </tr>

                                                <tr style="">
                                                    <td style="" height="20" align="center">&nbsp;</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr style="" bgcolor="#888C8D">
                                    <td style="" height="80" align="center">


                                        <table style="margin: 0px auto; border-collapse: collapse;" width="500" cellspacing="0" cellpadding="0" align="center">
                                            <tbody style="">
                                                <tr style="">
                                                    <td style="" width="100" valign="middle" align="center">
                                                        <a href="https://www.wirelink.com.br" target="_blank" style="">
                                                            <img alt="" style="display: block; height: 50px;" src="{{asset('img/logoCompleta.png')}}" border="0">
                                                        </a>
                                                    </td>
                                                    <td style="" width="300" valign="middle" align="center">
                                                        &nbsp;
                                                    </td>
                                                    <td style="" width="100" valign="middle" align="center">
                                                        <table style="margin: 0px auto; border-collapse: collapse;" width="95" cellspacing="0" cellpadding="0" align="center">
                                                            <tbody style="">
                                                                <tr style="">
                                                                    <td colspan="3" style="" width="100%" valign="middle" height="25" align="center">
                                                                        <span style="color:white; font-size: 15px;">Siga-nos </span>
                                                                    </td>

                                                                </tr>
                                                                <tr style="">
                                                                    <td style="height: 20px;width: 20px; padding-right: 8px;" align="right" ;><a href="https://www.linkedin.com/company/wirelink-telecom/" target="_blank" style=""><img alt="" style="display: block; height: 20px; width: 20px;" src="{{asset('img/iconLinkedin.png')}}" border="0"></a></td>
                                                                    <td style="height: 20px;width: 20px;"><a href="https://www.linkedin.com/company/wirelink-telecom/" target="_blank" style=""><img alt="" style="display: block; height: 20px; width: 20px;" src="{{asset('img/iconFacebook.png')}}" border="0"></a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td style="" width="100" valign="middle" align="right">
                                                        <br>
                                                        <img alt="" style="display: block; height: 12px;" src="{{asset('img/icon-fone.png')}}" border="0">

                                                        <a href="https://api.whatsapp.com/send?phone=5585991163602">
                                                            <img alt="" style="display: block; height: 12px;" src="{{asset('img/icon-whatsapp.png')}}" border="0">
                                                        </a>
                                                    </td>
                                                    <td style="padding-left: 6px;" width="200" valign="middle" align="left">
                                                        <span style="color:white; font-size: 15px;">Contato </span><br>
                                                        <span style="color:white;     font-size: 10px; "> (85) 2181-6299 </span><br>
                                                        <span style="color:white;     font-size: 10px; "> (85) 99116-3602 </span>
                                                    </td>


                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr style="" bgcolor="#FFFFFF">
                                    <td style="">
                                        <br style="">
                                        <p style="color: rgb(51, 51, 51); font-family: arial, helvetica, sans-serif; font-size: 11px; margin: 0px; text-align: justify;">
                                            Não responda a este e-mail. Esta é uma mensagem gerada automaticamente. Para
                                            enviar seus comentários, <a href="https://www.wirelink.com.br/" style="text-decoration: none; color: rgb(51, 51, 51);" target="_blank">clique aqui e fale conosco</a>. Se
                                            você já pagou sua fatura referente á este vencimento, desconsidere este
                                            lembrete.

                                        </p>
                                        <br style="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </center>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>

</html>