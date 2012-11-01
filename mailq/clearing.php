<?php
/**
 * ���ߥǡ����κ���ȥХ��塼��
 *
 * @author fujita
 * @package defaultPackage
 */

// �������
include_once "setup.php";

// ���饹
include _ROOT_LIB_."Postgres.php";
include _ROOT_LIB_."Debuglib.php";

$Psql = new Postgres();

pg_exec("begin");

// ���ߥǡ����κ�� td_message
$sql  = "DELETE FROM td_message WHERE message_id in ( ";
$sql .= " SELECT tdm.message_id FROM td_message as tdm left join td_mailq as tdq on tdm.message_id=tdq.message_id ";
$sql .= " WHERE tdq.message_id is null ";
$sql .= " )";
$Psql->executeUpdate($sql);

// td_mailq �Τߤ˥ǡ�����¸�ߤ�����
$sql  = "DELETE FROM td_mailq WHERE message_id in ";
$sql .= " ( SELECT tdq.message_id ";
$sql .= "   FROM td_mailq as tdq left join td_message as tdm on tdq.message_id=tdm.message_id ";
$sql .= "   WHERE tdm.message_id IS NULL ";
$sql .= "   GROUP BY tdq.message_id ";
$sql .= " )";
$Psql->executeUpdate($sql);

pg_exec("commit");

// �Х��塼��
if ( _TEST_ ) {
	// TEST
`/usr/local/bin/vacuumdb -d itm-asp_test &`;	

} else {
	// ����
`/usr/local/bin/vacuumdb -d itm-asp &`;

}



?>