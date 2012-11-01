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

      if( !$this->test ){

      }else{

      }

      $this->defaultS['pictmail_id']      = '';
      $this->defaultS['user_id']      = '';
      $this->defaultS['plan_pictmail_id'] = 1;
      $this->defaultS['price_month']      = 1000;
      $this->defaultS['price_month6']      = 6000;
      $this->defaultS['price_year']      = 10000;
      $this->defaultS['account']          = 1;
      $this->defaultS['send_max']         = 20;
      $this->defaultS['send_now']         = 20;
      $this->defaultS['month_max']        = 5;
      $this->defaultS['month_now']        = 5;
      $this->defaultS['flag_permission']  = 1;
      $this->defaultS['flag_dm']          = 1;

     return ;
    }

    /*
     * ̾��
     * $nameS['�ե������̾'] = '̾��';
     */
    Function name(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | name() <br>\n";

      $this->nameS['pictmail_id']      = '�ԥ��ȥ᡼��ID';
      $this->nameS['user_id']          = '�桼����ID';
      $this->nameS['plan_pictmail_id'] = '�ԥ��ȥ᡼�� �ץ��';
      $this->nameS['price_month']          = '�������ȴ����1�����';
      $this->nameS['price_month6']          = '�������ȴ����6�����';
      $this->nameS['price_year']          = '�������ȴ����12�����';
      $this->nameS['account']          = '��ͭ��������ȿ�';
      $this->nameS['send_max']         = '����᡼��������';
      $this->nameS['send_now']         = '���ߤλĤ�᡼��������';
      $this->nameS['month_max']        = '����������������';
      $this->nameS['month_now']        = '����������������';
      $this->nameS['flag_permission']  = '���ѵ���';
      $this->nameS['flag_dm']          = '���Τ餻�᡼��μ������';

      return ;
    }


    /*
     * ����DB��Ͽ�ե������
     * dbS['�ơ��֥�̾']['Ϣ��'] = array('name'=>'�����','key'=>'��','default'=>'INSERT�ǥե����');
     */
    Function db(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | db() <br>\n";

      $this->dbS['td_pictmail'][] = array( 'name'=>'pictmail_id',     'key'=>'primary','default'=>'' );
      $this->dbS['td_pictmail'][] = array( 'name'=>'user_id',         'key'=>'int',    'default'=>1 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'plan_pictmail_id','key'=>'int',    'default'=>1 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'price_month',         'key'=>'int',    'default'=>1000 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'price_month6',         'key'=>'int',    'default'=>6000 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'price_year',         'key'=>'int',    'default'=>10000 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'account',         'key'=>'int',    'default'=>1 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'send_max',        'key'=>'int',    'default'=>20 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'send_now',        'key'=>'int',    'default'=>20 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'month_max',       'key'=>'int',    'default'=>5 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'month_now',       'key'=>'int',    'default'=>5 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'flag_permission', 'key'=>'int',    'default'=>1);
      $this->dbS['td_pictmail'][] = array( 'name'=>'flag_dm',         'key'=>'int',    'default'=>1);

      return ;
    }


    /*
     * �����Ѵ�
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     */
    Function convert(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | convert() <br>\n";

      // ʸ��������
      $this->convertS['code'][] = array( 'key'=>'pictmail_id', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'plan_pictmail_id', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'user_id', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'price_month',          'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'price_month6',          'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'price_year',          'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'account',          'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'send_max',         'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'send_now',         'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'month_max',        'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'month_now',        'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'flag_permission',  'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'flag_dm',          'code'=>'EUC-JP' );


      // �������
      $this->convertS['s39'][] = array( 'key'=>'send_max' );
      $this->convertS['s39'][] = array( 'key'=>'send_now' );

      // Ⱦ�ѱѿ� <- ���ѱѿ�
      $this->convertS['a'][] = array( 'key'=>'send_max' );
      $this->convertS['a'][] = array( 'key'=>'send_now' );

      return ;
    }

    /*
     * �����Ѵ������ϻ�
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     */
    Function write(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | write() <br>\n";

      $this->writeS['text'][] = array( 'key'=>'plan_pictmail_id' );
      $this->writeS['text'][] = array( 'key'=>'user_id' );
      $this->writeS['text'][] = array( 'key'=>'price_month' );
      $this->writeS['text'][] = array( 'key'=>'price_month6' );
      $this->writeS['text'][] = array( 'key'=>'price_year' );
      $this->writeS['text'][] = array( 'key'=>'account' );
      $this->writeS['text'][] = array( 'key'=>'send_max' );
      $this->writeS['text'][] = array( 'key'=>'send_now' );
      $this->writeS['text'][] = array( 'key'=>'month_max');
      $this->writeS['text'][] = array( 'key'=>'month_now');
      $this->writeS['text'][] = array( 'key'=>'flag_permission');
      $this->writeS['text'][] = array( 'key'=>'flag_dm' );

      return ;
    }


    /*
     * �����Ѵ���ɽ����
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     */
    Function view(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | view() <br>\n";

      $this->viewS['html'][] = array( 'key'=>'plan_pictmail_id' );
      $this->viewS['html'][] = array( 'key'=>'user_id' );
      $this->viewS['html'][] = array( 'key'=>'price_month' );
      $this->viewS['html'][] = array( 'key'=>'price_month6' );
      $this->viewS['html'][] = array( 'key'=>'price_year' );
      $this->viewS['html'][] = array( 'key'=>'account' );
      $this->viewS['html'][] = array( 'key'=>'send_max' );
      $this->viewS['html'][] = array( 'key'=>'send_now' );
      $this->viewS['html'][] = array( 'key'=>'month_max');
      $this->viewS['html'][] = array( 'key'=>'month_now');
      $this->viewS['html'][] = array( 'key'=>'flag_permission');
      $this->viewS['html'][] = array( 'key'=>'flag_dm' );

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
      $this->checkS['Input'][] = array( 'key'=>'price_month' );
      $this->checkS['Input'][] = array( 'key'=>'price_month6' );
      $this->checkS['Input'][] = array( 'key'=>'price_year' );
      $this->checkS['Input'][] = array( 'key'=>'account' );
      $this->checkS['Input'][] = array( 'key'=>'send_max' );
      $this->checkS['Input'][] = array( 'key'=>'send_now' );
      $this->checkS['Input'][] = array( 'key'=>'month_max' );
      $this->checkS['Input'][] = array( 'key'=>'month_now' );
      $this->checkS['Input'][] = array( 'key'=>'flag_permission' );
      $this->checkS['Input'][] = array( 'key'=>'flag_dm' );

      // [ ʸ���� ]
      $this->checkS['Len'][] = array( 'key'=>'price_month',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'price_month6',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'price_year',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'account',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'send_max',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'send_now',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'month_max',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'month_now',    'limit'=>8);



      // [ Ⱦ�ѿ� ]
      $this->checkS['Number'][] = array( 'key'=>'price_month',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'price_month6',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'price_year',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'account',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'send_max',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'send_now',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'month_max',   'limit'=>0 );

      // [ Ⱦ�ѱѿ� ]
      //$this->checkS['Eisu'][] = array( 'key'=>'campaign_code' );

      return ;
    }


    /*
     * Hidden
     */
    Function hidden(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | hidden() <br>\n";

      $this->hiddenS[] = array('key'=>'inputS[user_id]',     'str'=>'', 'mode'=>'input');
      $this->hiddenS[] = array('key'=>'inputS[pictmail_id]', 'str'=>'', 'mode'=>'input');

      return ;
    }

  }

?>
