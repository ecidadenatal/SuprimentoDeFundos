<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

class cl_tomadorsuprimento extends DAOBasica {

  public function __construct() {
    parent::__construct("plugins.tomadorsuprimento");
  }

  public function sql_tomador_depto($sCampos = "*", $coddepto, $sWhere = null) {

    $sSql  = " select {$sCampos} ";
    $sSql .= "  from plugins.tomadorsuprimento ";
    $sSql .= "      inner join cgm on z01_numcgm = numcgm";
    $sSql .= "      inner join (select db01_orgao as orgao, db01_unidade as unidade 
    							from db_departorg 
    							where db01_coddepto = {$coddepto} 
    							  and db01_anousu   = ".db_getsession('DB_anousu').") departorg";
    $sSql .= "   	  		on departorg.orgao = tomadorsuprimento.orgao and departorg.unidade = tomadorsuprimento.unidade";
    $sSql .= "  where ativo is true";

    $sWhere = trim($sWhere);
    if (!empty($sWhere)) {
      $sSql .= " and {$sWhere} ";
    }
    $sSql .= " order by tomadorsuprimento.sequencial";
    return $sSql;
  }

  public function sql_empenhos_pendentes($iTomador) {

    $sSql  = " select count(*) as pendente";
    $sSql .= "  from plugins.tomadorsuprimento ts";
    $sSql .= "      inner join plugins.empauttomador et on et.tomadorsuprimento = ts.sequencial";
    $sSql .= "      inner join empautoriza              on e54_autori           = et.autorizacaoempenho";
    $sSql .= "      inner join empempaut                on e61_autori           = e54_autori";
    $sSql .= "      inner join empempenho               on e60_numemp           = e61_numemp";
    $sSql .= "  where ts.sequencial = {$iTomador} and e60_numemp in (select e45_numemp from emppresta where e45_conferido is null)";

    $rsEmpenhosPendentes = db_query($sSql);
    $iEmpenhosPendentes  = db_utils::fieldsMemory($rsEmpenhosPendentes, 0)->pendente;

    return $iEmpenhosPendentes;
  }
}
