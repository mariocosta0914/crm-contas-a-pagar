<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodosBoletos extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'TodosOsBoletos';

    public static function getQtdTitulos($id_cliente)
    {
        return TodosBoletos::selectRaw("COUNT(*) as quantidade, 
        Format(SUM(ValorPrincipal),'N','pt-BR') as valor_total,  Format(SUM(ValorPago),'N','pt-BR') as valor_pago,
        Format(SUM(Valor),'N','pt-BR') as valor_devido")
            ->where('ClienteId', '=', $id_cliente)
            ->first();
    }

    public static function getInformacoesTitulos($id_cliente)
    {
        return TodosBoletos::selectRAW("CdRcd as id, Format(ValorPrincipal,'N','pt-BR') as Valor, 
                Format(ValorPago,'N','pt-BR') as valor_pago,
                Format(Valor,'N','pt-BR') as valor_devido,
                convert(varchar, DtRctVen ,103) as data_vencimento,
                convert(varchar, DtRctVenPro ,103) as data_vencimento_prorrogado,
                Situacao, SituacaoBoleto, NmBco as banco, TipoDeDocumento")
            ->where('ClienteId', '=', $id_cliente)
            ->orderBy('CdRcd', 'DESC')
            ->get();
    }

    public static function getInformacaoBoleto($id_boleto)
    {
        return TodosBoletos::selectRaw('CdRcd,Cedente,CNPJCPF_Cedente,CNPJCPF_Sacado,Sacado,Endereco,
        NrPesEdr as numero, Bairro, NrPesCep as cep, Cidade, UF, ValorPrincipal as Valor, NrFfm as nosso_numero,
        NrBco, Carteira,AgCodCed as agencia_conta, DtRctVen as vencimento, NFSE, 
        EspecieDoc as especie, Aceite, DataEHoraDoProcessamento as processamento,
        DtRcdEmi as emissao, LinhaDigitavel as codigo_barras,ClienteId,Email,Email2,
        convert(varchar, DtRctVenPro ,103) as data_vencimento_prorrogado,NmBco,TipoDeDocumento')
            ->where('CdRcd', '=', $id_boleto)
            ->first();
    }

    public static function getInformacoesFila($segmento)
    {
        $sem_segmentacao = null;
        $com_segmentacao = null;
        if ($segmento === 'Sem Segmentação') {
            $sem_segmentacao = $segmento;
        } else {
            $com_segmentacao = $segmento;
        }
        return TodosBoletos::selectRaw("Format(SUM(TodosOsBoletos.Valor),'N','pt-BR') as valor, 
        COUNT(*) as quantidade")
            ->join('Pessoas', 'Pessoas.CodigoCliente', '=', 'TodosOsBoletos.ClienteId')
            ->whereRaw('TodosOsBoletos.DtRctVen < GETDATE()-3')
            ->when($sem_segmentacao, function ($query) {
                return $query->whereRaw('Pessoas.TipoCliente is null');
            })
            ->when($com_segmentacao, function ($query, $com_segmentacao) {
                return $query->where('Pessoas.TipoCliente', '=', $com_segmentacao);
            })
            ->first();
    }

    public static function configuracaoFila($where, $segmento, $intervalo)
    {
        $sem_segmentacao = null;
        $com_segmentacao = null;
        $where_valor = null;
        $where_data = null;
        if (isset($intervalo["valor_inicial"]) && isset($intervalo["valor_final"])) {
            $where_valor = 'SUM(TodosOsBoletos.Valor)>=' . $intervalo["valor_inicial"] . ' and SUM(TodosOsBoletos.Valor)<=' . $intervalo["valor_final"];
        }
        if (isset($intervalo["data_inicial"]) && isset($intervalo["data_final"])) {
            $data_inicio = $intervalo["data_inicial"];
            $data_final = $intervalo["data_final"];
            $where_data = "TodosOsBoletos.DtRctVen >='$data_inicio' and TodosOsBoletos.DtRctVen<='$data_final'";
        }
        if ($segmento === 'Sem Segmentação') {
            $sem_segmentacao = $segmento;
        } else {
            $com_segmentacao = $segmento;
        }
        return TodosBoletos::selectRaw('TodosOsBoletos.ClienteId, COUNT(*) as quantidade, 
        SUM(TodosOsBoletos.Valor) as divida,
        MAX(DATEDIFF(day, TodosOsBoletos.DtRctVen,GETDATE()-3)) as dias_atraso')
            ->from('TodosOsBoletos')
            ->join('Pessoas', 'Pessoas.CodigoCliente', '=', 'TodosOsBoletos.ClienteId')
            ->when($sem_segmentacao, function ($query) {
                return $query->whereRaw('Pessoas.TipoCliente is null');
            })
            ->when($com_segmentacao, function ($query, $com_segmentacao) {
                return $query->where('Pessoas.TipoCliente', $com_segmentacao);
            })
            ->whereRaw('TodosOsBoletos.DtRctVen<GETDATE()-3')
            ->when($where_data, function ($query, $where_data) {
                return $query->whereRaw($where_data);
            })
            ->when($where_valor, function ($query, $where_valor) {
                return $query->havingRaw($where_valor);
            })
            ->groupBy('TodosOsBoletos.ClienteId')
            ->orderByRaw($where)
            ->get()->toArray();
    }

    public static function getBoletosVencHoje()
    {
        $dataAtual = date('Y-m-d');
        $dados = TodosBoletos::selectRaw('CdRcd,Cedente,CNPJCPF_Cedente,CNPJCPF_Sacado,Sacado,Endereco,
        NrPesEdr as numero, Bairro, NrPesCep as cep, Cidade, UF, ValorPrincipal as Valor, NrFfm as nosso_numero,
        NrBco, Carteira,AgCodCed as agencia_conta, DtRctVen as vencimento, NFSE, 
        EspecieDoc as especie, Aceite, DataEHoraDoProcessamento as processamento,
        DtRcdEmi as emissao, LinhaDigitavel as codigo_barras,ClienteId,Email,Email2,
        convert(varchar, DtRctVenPro ,103) as data_vencimento_prorrogado,NmBco,TipoDeDocumento')
            ->where("DtRctVen", '=', $dataAtual)
            ->get();
        return $dados;
    }

    /**
     * Retorna os boletos para lembrete(Venc. + 3)
     *
     */
    public static function getBoletosLembrete()
    {
        $dados = TodosBoletos::selectRaw('CdRcd,Cedente,CNPJCPF_Cedente,CNPJCPF_Sacado,Sacado,Endereco,
        NrPesEdr as numero, Bairro, NrPesCep as cep, Cidade, UF, ValorPrincipal as Valor, NrFfm as nosso_numero,
        NrBco, Carteira,AgCodCed as agencia_conta, DtRctVen as vencimento, NFSE, 
        EspecieDoc as especie, Aceite, DataEHoraDoProcessamento as processamento,
        DtRcdEmi as emissao, LinhaDigitavel as codigo_barras,ClienteId,Email,Email2,
        convert(varchar, DtRctVenPro ,103) as data_vencimento_prorrogado,NmBco,TipoDeDocumento')
            ->whereRaw(
                'cast(DtRctVen as DATE) = cast(DATEADD(dd,
            + 3,GETDATE()) as Date)
            AND NrFfm IS NOT NULL
            '
            )->get();
        return $dados;
    }

    /**
     * Retorna os boletos para lembrete(Venc. =- 3)
     *
     */
    public static function getBoletosCobranca()
    {
        return TodosBoletos::selectRaw('CdRcd,Cedente,CNPJCPF_Cedente,CNPJCPF_Sacado,Sacado,Endereco,
        NrPesEdr as numero, Bairro, NrPesCep as cep, Cidade, UF, ValorPrincipal as Valor, NrFfm as nosso_numero,
        NrBco, Carteira,AgCodCed as agencia_conta, DtRctVen as vencimento, NFSE, 
        EspecieDoc as especie, Aceite, DataEHoraDoProcessamento as processamento,
        DtRcdEmi as emissao, LinhaDigitavel as codigo_barras,ClienteId,Email,Email2,
        convert(varchar, DtRctVenPro ,103) as data_vencimento_prorrogado,NmBco,TipoDeDocumento')
            ->whereRaw(
                'cast(DtRctVen as DATE) = cast(DATEADD(dd,
           - 3,GETDATE()) as Date)
            AND NrFfm IS NOT NULL
            '
            )->get();
    }

    /**
     * Retorna os boletos em atraso antigos(ven. = - 7 dias atras)
     *
     */
    public static function getBoletosCobrancaAntigos()
    {

        return TodosBoletos::selectRaw('CdRcd,Cedente,CNPJCPF_Cedente,CNPJCPF_Sacado,Sacado,Endereco,
        NrPesEdr as numero, Bairro, NrPesCep as cep, Cidade, UF, ValorPrincipal as Valor, NrFfm as nosso_numero,
        NrBco, Carteira,AgCodCed as agencia_conta, DtRctVen as vencimento, NFSE, 
        EspecieDoc as especie, Aceite, DataEHoraDoProcessamento as processamento,
        DtRcdEmi as emissao, LinhaDigitavel as codigo_barras,ClienteId,Email,Email2,
        convert(varchar, DtRctVenPro ,103) as data_vencimento_prorrogado,NmBco,TipoDeDocumento')
            ->whereRaw('
                    YEAR(cast(DtRctVen as DATE)) = YEAR(GETDATE()) 
					AND cast(DtRctVen as DATE) <= cast(DATEADD(dd,- 7, GETDATE()) as Date)
					AND DtRctVen > DATEADD(month, - 6, GETDATE())
					AND NrFfm IS NOT NULL
        ')->get();
    }

    /**
     * Retorna os boletos vencidos no fim de semana
     *
     *
     */
    public static function getBoletosVencimentoFimDeSemana()
    {
        return TodosBoletos::whereRaw('(cast(DtRctVen as date) = cast (DATEADD(dd, - 1, GETDATE()) as Date)) OR
	(cast(DtRctVen as date) = cast (DATEADD(dd, - 2, GETDATE()) as Date))
	   AND NrFfm IS NOT NULL
	   ')->get();
    }

 
    public static function getPessoa(){
        return TodosBoletos::selectRaw('NomeFantasia,CNPJCPF ,Email')
        ->from('Pessoas')
        ->whereRaw("Segmentacao='Clientes Recife DATASAFEIT'")
        ->get();
    }
   
}
