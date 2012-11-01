<?PHP
/*

  # �ե����������

*/


  class Field{

    var $debug    = "";
    var $test    = "";
    var $defaultS = "";
    var $nameS    = "";
    var $dbS      = "";
    var $convertS = "";
    var $writeS   = "";
    var $viewS    = "";

    Function Field($debug=False,$test=False){

      if( $debug ) $this->debug = True;
      if( $test ) $this->test = True;
      $this->name();
      $this->defaults();
      $this->db();
      $this->check();
      $this->convert();
      $this->write();
      $this->view();
      $this->hidden();

      return ;
    }


    /*
     * �����
     */
    Function defaults(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | defaults() <br>\n";

      if( !_TEST_ ){
        $this->defaultS['log_id']     = '';
        $this->defaultS['user_id']    = '';
        $this->defaultS['subject']    = '';
        $this->defaultS['message']    = '';
        $this->defaultS['message_html']    = '';
        $this->defaultS['flag_html']    = '';
        $this->defaultS['file_mail']  = '';
        $this->defaultS['name_from']  = '';
        $this->defaultS['mail_from']  = '';
        $this->defaultS['mail_error'] = '';
        $this->defaultS['mail_test']  = '';
      }else{
        $this->defaultS['log_id']     = '';
        $this->defaultS['user_id']    = '';
        $this->defaultS['subject']    = '�����ƥ��� '.date('Ymd');
        $this->defaultS['message']    = '�����ƥ��ȥ�å����� '.date('Ymd')."\n%name%\n%param1%\n%param2%\n%param3%\n%param4%\n%param5%";
        $this->defaultS['message_html']    = "";
        $this->defaultS['flag_html']  = 1;
        $this->defaultS['file_mail']  = '';
        $this->defaultS['name_from']  = 'ITM�ƥ���������';
        $this->defaultS['mail_from']  = 'masaki@itm.ne.jp';
        $this->defaultS['mail_error'] = 'masaki@pictsys.com';
        $this->defaultS['mail_test']  = 'masaki@pictnotes.jp';
      }
      $this->defaultS['send_date_y']  = date('y');
      $this->defaultS['send_date_m']  = date('m');
      $this->defaultS['send_date_d']  = date('d');
      $this->defaultS['send_date_h']  = date('H');
      $this->defaultS['send_date_i']  = date('i');

     return ;
    }

    /*
     * ̾��
     * $nameS['�ե������̾'] = '̾��';
     */
    Function name(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | name() <br>\n";

      $this->nameS['log_id']     = '��������ID';
      $this->nameS['user_id']    = '�桼����ID';
      $this->nameS['subject']    = '������̾';
      $this->nameS['message']    = '������å��������ƥ����ȷ���';
      $this->nameS['message_html'] = '������å�������HTML����';
      $this->nameS['flag_html']  = 'HTML�����ե饰';
      $this->nameS['file_mail']  = '�᡼��ꥹ��';
      $this->nameS['name_from']  = '������̾';
      $this->nameS['mail_from']  = '�����ԥ᡼�륢�ɥ쥹';
      $this->nameS['mail_error'] = '���顼����᡼�륢�ɥ쥹';
      $this->nameS['mail_test']  = '�ƥ��ȥ᡼������᡼�륢�ɥ쥹';
      $this->nameS['flag_user']  = '�ץ��';
      $this->nameS['send_date']  = '����ͽ����';

      return ;
    }


    /*
     * DB��Ͽ�ե������
     * $nameS['�ơ��֥�̾']['�ե������̾'] = '��';
     */
    Function db(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | db() <br>\n";

      $this->dbS['td_log'][]  = array( 'name'=>'log_id',      'key'=>'primary', 'default'=>'' );
      $this->dbS['td_log'][]  = array( 'name'=>'user_id',     'key'=>'int',     'default'=>'' );
      $this->dbS['td_log'][]  = array( 'name'=>'name_from',   'key'=>'text',    'default'=>'' );
      $this->dbS['td_log'][]  = array( 'name'=>'mail_from',   'key'=>'text',    'default'=>'' );
      $this->dbS['td_log'][]  = array( 'name'=>'count',       'key'=>'int',     'default'=>'' );
      $this->dbS['td_log'][]  = array( 'name'=>'ip',          'key'=>'text',    'default'=>'' );
      $this->dbS['td_log'][]  = array( 'name'=>'host',        'key'=>'text',    'default'=>'' );
      $this->dbS['td_log'][]  = array( 'name'=>'date_start',  'key'=>'date',    'default'=>'now' );
      $this->dbS['td_log'][]  = array( 'name'=>'date_end',    'key'=>'date',    'default'=>'now' );
      $this->dbS['td_log'][]  = array( 'name'=>'flag_user',   'key'=>'int',     'default'=>'now' );
      $this->dbS['td_log'][]  = array( 'name'=>'date_insert', 'key'=>'date',    'default'=>'now' );

      return ;
    }


    /*
     * �����Ѵ�
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     */
    Function convert(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | convert() <br>\n";

      // ʸ��������
      $this->convertS['code'][] = array( 'key'=>'log_id',    'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'user_id',   'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'subject',   'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'message',   'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'message_html',   'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'flag_html', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'file_mail', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'name_from', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'mail_from', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'mail_error','code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'mail_test', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'flag_user', 'code'=>'EUC-JP' );

      // �������
      $this->convertS['s39'][] = array( 'key'=>'name_from' );
      $this->convertS['s39'][] = array( 'key'=>'mail_from' );
      $this->convertS['s39'][] = array( 'key'=>'mail_error' );
      $this->convertS['s39'][] = array( 'key'=>'mail_test' );

      // Ⱦ�ѱѿ� <- ���ѱѿ�
      $this->convertS['a'][] = array( 'key'=>'name_from' );
      $this->convertS['a'][] = array( 'key'=>'mail_from' );
      $this->convertS['a'][] = array( 'key'=>'mail_error' );
      $this->convertS['a'][] = array( 'key'=>'mail_test' );

      // ���ѥ��� <- Ⱦ�ѥ���
      $this->convertS['KV'][] = array( 'key'=>'subject' );
      $this->convertS['KV'][] = array( 'key'=>'message' );
      $this->convertS['KV'][] = array( 'key'=>'message_html' );
      $this->convertS['KV'][] = array( 'key'=>'name_from' );

      return ;
    }

    /*
     * �����Ѵ������ϻ�
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     */
    Function write(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | write() <br>\n";

      $this->writeS['input'][]    = array( 'key'=>'log_id');
      $this->writeS['input'][]    = array( 'key'=>'user_id');
      $this->writeS['text'][]     = array( 'key'=>'subject');
      $this->writeS['textarea'][] = array( 'key'=>'message');
      $this->writeS['textarea'][] = array( 'key'=>'message_html');
      $this->writeS['text'][]     = array( 'key'=>'flag_html');
      $this->writeS['text'][]     = array( 'key'=>'file_mail');
      $this->writeS['text'][]     = array( 'key'=>'name_from');
      $this->writeS['text'][]     = array( 'key'=>'mail_from');
      $this->writeS['text'][]     = array( 'key'=>'mail_error');
      $this->writeS['text'][]     = array( 'key'=>'mail_test');
      $this->writeS['text'][]     = array( 'key'=>'flag_user');

      return ;
    }


    /*
     * �����Ѵ���ɽ����
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     */
    Function view(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | view() <br>\n";

      $this->viewS['html'][]  = array( 'key'=>'log_id');
      $this->viewS['html'][]  = array( 'key'=>'user_id');
      $this->viewS['html'][]  = array( 'key'=>'subject');
      $this->viewS['html'][]  = array( 'key'=>'message');
//      $this->viewS['html'][]  = array( 'key'=>'message_html');
      $this->viewS['html'][]  = array( 'key'=>'flag_html');
      $this->viewS['html'][]  = array( 'key'=>'file_mail');
      $this->viewS['html'][]  = array( 'key'=>'name_from');
      $this->viewS['html'][]  = array( 'key'=>'mail_from');
      $this->viewS['html'][]  = array( 'key'=>'mail_error');
      $this->viewS['html'][]  = array( 'key'=>'mail_test');
      $this->viewS['html'][]  = array( 'key'=>'flag_user');

      return ;
    }


    /*
     * �����å�
     * $checkS['�����å���']['Ϣ��'] = array('key'=>'�ե������̾');
     * ����
     * $checkS['�����å���']['Ϣ��'] = array('key'=>'�ե������̾','limit'=>����);
     * ����
     * $checkS['�����å���']['Ϣ��'] = array('key'=>'�ե������̾','ex'=>��ĥ�����å�);
     */
    Function check(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | check() <br>\n";

      // [ ���� ]
      $this->checkS['Input'][] = array( 'key'=>'user_id' );
      $this->checkS['Input'][] = array( 'key'=>'subject' );
      $this->checkS['Input'][] = array( 'key'=>'message' );
      //$this->checkS['Input'][] = array( 'key'=>'file_mail' );
      $this->checkS['Input'][] = array( 'key'=>'name_from' );
      $this->checkS['Input'][] = array( 'key'=>'mail_from' );
      $this->checkS['Input'][] = array( 'key'=>'mail_error' );
      $this->checkS['Input'][] = array( 'key'=>'mail_test' );

      // [ ʸ���� ]
      $this->checkS['Len'][] = array( 'key'=>'name_from',  'limit'=>50);
      $this->checkS['Len'][] = array( 'key'=>'mail_from',  'limit'=>50);
      $this->checkS['Len'][] = array( 'key'=>'mail_error', 'limit'=>50);
      $this->checkS['Len'][] = array( 'key'=>'mail_test',  'limit'=>50);
      $this->checkS['Len'][] = array( 'key'=>'subject',    'limit'=>500);
      $this->checkS['Len'][] = array( 'key'=>'message',    'limit'=>50000);

      // [ �᡼�� ]
      $this->checkS['Mail'][] = array( 'key'=>'mail_from' );
      $this->checkS['Mail'][] = array( 'key'=>'mail_error' );
      $this->checkS['Mail'][] = array( 'key'=>'mail_test' );

      // [ ͹���ֹ� ]
      //$this->checkS['Zip'][] = array( 'key'=>'zip' );

      // [ ���� ]
      //$this->checkS['Date'][] = array( 'key'=>'ins_date_start' );
      //$this->checkS['Date'][] = array( 'key'=>'ins_date_end' );

      // [ �����ֹ� ]
      //$this->checkS['Tel'][] = array( 'key'=>'tel' );

      // [ Ⱦ�ѿ� ]
      //$this->checkS['Number'][] = array( 'key'=>'money', 'limit'=>0 );

      // [ Ⱦ�ѱѿ� ]
      //$this->checkS['Eisu'][] = array( 'key'=>'campaign_code' );

      // [ �������� ]
      //$this->checkS['KataKana'][] = array( 'key'=>'kana_family' );

 
      return ;
    }


    /*
     * Hidden
     */
    Function hidden(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | hidden() <br>\n";

      $this->hiddenS[] = array('key'=>'inputS[user_id]', 'str'=>'', 'mode'=>'input');

      return ;
    }

  }

?>
