<?php

//PEAR�饤�֥���mimeDecode���ɤ߹���
require_once("/usr/local/lib/php/Mail/mimeDecode.php");
require_once("/usr/local/lib/php/Mail.php");

//mail��ʸ�������
$source = file_get_contents("test.txt");
if($source===false){
    echo "�ɤ߹��ߥ��顼";
}
/*
//mimeDecode�Υѥ�᡼����������
$params['include_bodies'] = true;   //ʬ�򤹤�ʸ�������ʸ��ޤफ�ɤ���
$params['decode_bodies'] = true;    //��ʸ��ǥ����ɤ��뤫�ɤ���
$params['decode_headers'] = true;   //�إå�����ǥ����ɤ��뤫�ɤ���
*/
//mimeDecode�Υ��󥹥�������
$decoder = new Mail_mimeDecode($source); // MIMEʬ��
$parts = $decoder->getSendArray();  // ���줾��Υѡ��Ĥ��Ǽ
list($recipients,$headers,$body) = $parts; // �ƥѡ��Ĥ�����˳�Ǽ
print_r($headers['From']);

/*
//���ꤷ���ͤ�mimeDecode�˥��å�
$structure = $decoder->decode($params);
*/