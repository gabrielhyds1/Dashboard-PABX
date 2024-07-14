<?php

// 2009/04/01
//   Initial release by Eder F. Miotto <eder@upf.br>
header('Content-Type: text/html; charset=utf-8');
$dayp[0] = "Domingo";
$dayp[1] = "Segunda";
$dayp[2] = "Terca";
$dayp[3] = "Quarta";
$dayp[4] = "Quinta";
$dayp[5] = "Sexta";
$dayp[6] = "Sabado";
$lang['pt_BR']['option'] = "Op��es";

$yearp[0] = "Janeiro";
$yearp[1] = "Fevereiro";
$yearp[2] = "Marco";
$yearp[3] = "Abril";
$yearp[4] = "Maio";
$yearp[5] = "Junho";
$yearp[6] = "Julho";
$yearp[7] = "Agosto";
$yearp[8] = "Setembro";
$yearp[9] = "Outubro";
$yearp[10]= "Novembro";
$yearp[11]= "Dezembro";

// Menu options
$lang['pt_BR']['menu_home']         = "Inicio";
$lang['pt_BR']['menu_answered']     = "Atendidas";
$lang['pt_BR']['menu_unanswered']   = "Perdidas";
$lang['pt_BR']['menu_distribution'] = "Distribuição";

// tooltips
$lang['pt_BR']['pdfhelp'] = "Exportar os dados para PDF";
$lang['pt_BR']['csvhelp'] = "Exportar os dados em CSV";
$lang['pt_BR']['gotop']   = "Ir para to topo da página";

// Index page
$lang['pt_BR']['ALL']               = "Todos";
$lang['pt_BR']['lower']             = "Menor  ...";
$lang['pt_BR']['higher']            = "Maior ...";
$lang['pt_BR']['select_queue']      = "Selecionar Fila";
$lang['pt_BR']['select_agent']      = "Selecionar Agente";
$lang['pt_BR']['select_timeframe']  = "Selecionar Fatia de Tempo";
$lang['pt_BR']['queue']   	         = "Fila";
$lang['pt_BR']['start']   	         = "Data Inicial";
$lang['pt_BR']['end']   	         = "Data Final";
$lang['pt_BR']['display_report']    = "Mostrar Relat&oacute;rio";
$lang['pt_BR']['shortcuts']         = "Filtros";
$lang['pt_BR']['today']             = "Hoje";
$lang['pt_BR']['this_week']         = "Esta semana";
$lang['pt_BR']['this_month']        = "Este m&ecirc;s";
$lang['pt_BR']['last_three_months'] = "&Uacute;ltimos 3 meses";
$lang['pt_BR']['available']         = "Dispon&iacute;vel";
$lang['pt_BR']['selected']          = "Selecionado";
$lang['pt_BR']['invaliddate']       = "Intervalo de data inv&aacute;lido";

// Answered page
$lang['pt_BR']['answered_calls_by_agent'] = "Chamadas atendidas por agentes";
$lang['pt_BR']['answered_calls_by_queue'] = "Chamadas atendidas por fila";
$lang['pt_BR']['anws_unanws_by_hour']     = "Atendidas/Perdidas por Hora";
$lang['pt_BR']['report_info']       = "Informa&ccedil;&otilde;es do Relat&oacute;rio";
$lang['pt_BR']['period']            = "Periodo";
$lang['pt_BR']['answered_calls']    = "Chamadas Atendidas";
$lang['pt_BR']['transferred_calls'] = "Chamadas Transferidas";
$lang['pt_BR']['secs']              = "segs";
$lang['pt_BR']['minutes']           = "min";
$lang['pt_BR']['hours']             = "hs";
$lang['pt_BR']['calls']             = "chamadas";
$lang['pt_BR']['Calls']             = "Chamadas";
$lang['pt_BR']['agent']             = "Agente";
$lang['pt_BR']['avg']               = "Média";
$lang['pt_BR']['avg_calltime']      = "Dura&ccedil;&atilde;o M&eacute;dia";
$lang['pt_BR']['avg_holdtime']      = "Tempo de espera m&eacute;dio";
$lang['pt_BR']['percent']           = "%";
$lang['pt_BR']['total']             = "Total";
$lang['pt_BR']['calltime']          = "Tempo das chamadas";
$lang['pt_BR']['holdtime']          = "Tempo de espera";
$lang['pt_BR']['total_time_agent']  = "Tempo total por agente (segs)";
$lang['pt_BR']['no_calls_agent']    = "Número de chamadas por agente";
$lang['pt_BR']['call_response']     = "Nível de Servico";
$lang['pt_BR']['within']            = "Com ";
$lang['pt_BR']['answer']            = "Atendidas";
$lang['pt_BR']['count']             = "Quantidade";
$lang['pt_BR']['delta']             = "Delta";
$lang['pt_BR']['disconnect_cause']  = "Causa da desconecx&atilde;o";
$lang['pt_BR']['cause']             = "Causa";
$lang['pt_BR']['agent_hungup']      = "Agente desligou";
$lang['pt_BR']['caller_hungup']     = "Cliente desligou";
$lang['pt_BR']['caller']            = "Caller";
$lang['pt_BR']['transfers']         = "Transfers";
$lang['pt_BR']['to']                = "Para";

// Unanswered page
$lang['pt_BR']['unanswered_calls']    = "Chamadas Perdidas";
$lang['pt_BR']['number_unanswered']   = "Chamadas perdidas";
$lang['pt_BR']['avg_wait_before_dis'] = "M&eacute;dia de tempo de espera antes de desconectar";
$lang['pt_BR']['avg_queue_pos_at_dis']= "M&eacute;dia de posi&ccedil;&atilde;o na fila antes de desconectar";
$lang['pt_BR']['avg_queue_start']     = "Posição média na fila de espera";
$lang['pt_BR']['user_abandon']        = "Abandono do usuário";
$lang['pt_BR']['abandon']             = "Abandono";
$lang['pt_BR']['timeout']             = "Timpo limite da chamada";
$lang['pt_BR']['unanswered_calls_qu'] = "Não respondidas por filas";

// Distribution
$lang['pt_BR']['totals']              = "Totais";
$lang['pt_BR']['number_answered']     = "Número de Chamadas Atendidas";
$lang['pt_BR']['number_unanswered']   = "Chamadas Perdidas";
$lang['pt_BR']['agent_login']         = "Login de Agente";
$lang['pt_BR']['agent_logoff']        = "Logoff de Agente";
$lang['pt_BR']['call_distrib_day']    = "Distribuição de Chamadas por dia";
$lang['pt_BR']['call_distrib_hour']   = "Distribuição de Chamadas por hora";
$lang['pt_BR']['call_distrib_week']   = "Distribuição de Chamadas por dia da semana";
$lang['pt_BR']['date']                = "Data";
$lang['pt_BR']['day']                 = "Dia";
$lang['pt_BR']['days']                = "dias";
$lang['pt_BR']['hour']                = "Hora";
$lang['pt_BR']['answered']            = "Atendidas";
$lang['pt_BR']['unanswered']          = "Perdidas";
$lang['pt_BR']['percent_answered']    = "% Atend";
$lang['pt_BR']['percent_unanswered']  = "% Perd";
$lang['pt_BR']['login']               = "Login";
$lang['pt_BR']['logoff']              = "Logoff";
$lang['pt_BR']['answ_by_day']         = "Chamadas Atendidas por dia da semana";
$lang['pt_BR']['unansw_by_day']       = "Chamadas Perdidas por dia da semana";
$lang['pt_BR']['avg_call_time_by_day']= "Duração média de chamadas por dia da semana";
$lang['pt_BR']['avg_hold_time_by_day']= "Duração médio de espera por dia da semana";
$lang['pt_BR']['answ_by_hour']        = "Chamadas atendidas por hora";
$lang['pt_BR']['unansw_by_hour']      = "Chamadas perdidas por hora";
$lang['pt_BR']['avg_call_time_by_hr'] = "Tempo médio de chamada por hora";
$lang['pt_BR']['avg_hold_time_by_hr'] = "Tempo médio de espera por hora";
$lang['pt_BR']['page']                = "Página";
$lang['pt_BR']['export']              = "Exportar tabela:";

// Realtime
$lang['pt_BR']['server_time']         = "Hor�rio do servidor:";
$lang['pt_BR']['php_parsed']          = "PHP parsed this page in ";
$lang['pt_BR']['seconds']             = "segundos";
$lang['pt_BR']['current_agent_status'] = "Filtrar por ramais Offline";
$lang['pt_BR']['hide_loggedoff']       = "Ocultar Offline";
$lang['pt_BR']['agent_status']         = "Status do agente";
$lang['pt_BR']['state']                = "Status";
$lang['pt_BR']['durat']                = "Durat.";
$lang['pt_BR']['clid']                 = "CLID";
$lang['pt_BR']['last_in_call']         = "�ltima chamada";
$lang['pt_BR']['not_in_use']           = "Online";
$lang['pt_BR']['paused']               = "pausado(a)";
$lang['pt_BR']['busy']                 = "Em chamada";
$lang['pt_BR']['unavailable']          = "Ramal Desligado";
$lang['pt_BR']['unknown']              = "desconhecido(a)";
$lang['pt_BR']['dialout']              = "discar";
$lang['pt_BR']['no_info']              = "nenhuma informa��o dispon�vel";
$lang['pt_BR']['min_ago']              = "min. atr�s";
$lang['pt_BR']['queue_summary']        = "Resumo da fila";
$lang['pt_BR']['staffed']              = "Pessoal";
$lang['pt_BR']['talking']              = "Conversando";
$lang['pt_BR']['paused']               = "Pausado(a)";
$lang['pt_BR']['calls_waiting']        = "Chamadas em espera";
$lang['pt_BR']['oldest_call_waiting']  = "Chamada em espera mais antiga";
$lang['pt_BR']['calls_waiting_detail'] = "chamadas em espera";
$lang['pt_BR']['position']             = "Posi��o";
$lang['pt_BR']['callerid']             = "ID de chamada";
$lang['pt_BR']['wait_time']            = "Tempo de espera";
$lang['pt_BR']['report']            = "Relat�rio";

?>
