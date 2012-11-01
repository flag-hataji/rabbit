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
        $this->defaultS['user_id']      = '';
        $this->defaultS['job_id']       = '';
        $this->defaultS['id']           = '';
        $this->defaultS['password']     = '';
        $this->defaultS['name_company']  = '';
        $this->defaultS['kana_company']  = '';
        $this->defaultS['name_family']  = '';
        $this->defaultS['name_first']   = '';
        $this->defaultS['kana_family']  = '';
        $this->defaultS['kana_first']   = '';
        $this->defaultS['birthday_y']   = date('Y')-1;
        $this->defaultS['birthday_m']   = date('m');
        $this->defaultS['birthday_d']   = date('d');
        $this->defaultS['mail']         = '';
        $this->defaultS['tel_1']        = '';
        $this->defaultS['tel_2']        = '';
        $this->defaultS['tel_3']        = '';
        $this->defaultS['mobile_1']     = '';
        $this->defaultS['mobile_2']     = '';
        $this->defaultS['mobile_3']     = '';
        $this->defaultS['fax_1']        =  '';
        $this->defaultS['fax_2']        = '';
        $this->defaultS['fax_3']        = '';
        $this->defaultS['zip_1']        = '';
        $this->defaultS['zip_2']        = '';
        $this->defaultS['area']         = '';
        $this->defaultS['address1']     = '';
        $this->defaultS['address2']     = '';
        $this->defaultS['comment']      = '';
        $this->defaultS['flag_gender']  = 1;
        $this->defaultS['flag_pictmail']= 't';
      }else{
        $this->defaultS['user_id']      = '';
        $this->defaultS['job_id']       = '';
        $this->defaultS['id']           = 'q';
        $this->defaultS['password']     = 'a';
        $this->defaultS['name_company']  = 'ITM';
        $this->defaultS['kana_company']  = '�����ƥ�����';
        $this->defaultS['name_family']  = '����';
        $this->defaultS['name_first']   = '���';
        $this->defaultS['kana_family']  = '�ޤ���';
        $this->defaultS['kana_first']   = '���ĤΤ�';
        $this->defaultS['birthday_y']   = 1978;
        $this->defaultS['birthday_m']   = 9;
        $this->defaultS['birthday_d']   = 8;
        $this->defaultS['mail']         = 'masaki@pictnotes.jp';
        $this->defaultS['tel_1']        = '092';
        $this->defaultS['tel_2']        = '525';
        $this->defaultS['tel_3']        = '0081';
        $this->defaultS['mobile_1']     = '090';
        $this->defaultS['mobile_2']     = '8624';
        $this->defaultS['mobile_3']     = '5560';
        $this->defaultS['fax_1']        = '092';
        $this->defaultS['fax_2']        = '525';
        $this->defaultS['fax_3']        = '0081';
        $this->defaultS['zip_1']        = '810';
        $this->defaultS['zip_2']        = '0022';
        $this->defaultS['area']         = 'ʡ����';
        $this->defaultS['address1']     = 'ʡ�������������3-13-11';
        $this->defaultS['address2']     = '���ʥ��ꥢ���Σ���';
        $this->defaultS['comment']      = date('Yǯm��d��H��iʬs��')."\n����Ͽ�Ǥ�";
        $this->defaultS['flag_gender']  = 1;
        $this->defaultS['flag_pictmail']= 't';

      }
      $this->defaultS['pictmail_id']      = '';
      $this->defaultS['plan_pictmail_id'] = 1;
      $this->defaultS['account']          = 1;
      $this->defaultS['send_max']         = 60;
      $this->defaultS['month_max']        = 3;
      $this->defaultS['month_now']        = 3;
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

      $this->nameS['user_id']      = '�桼����ID';
      $this->nameS['job_id']       = '����';
      $this->nameS['id']           = 'ID';
      $this->nameS['password']     = '�ѥ����';
      $this->nameS['name_company']         = '��ҡ����Ρ��ع�̾';
      $this->nameS['kana_company']         = '��ҡ����Ρ��ع�̾�ʥեꥬ�ʡ�';
      $this->nameS['name']         = '��̾��';
      $this->nameS['name_family']  = '��̾��������';
      $this->nameS['name_first']   = '��̾����̾��';
      $this->nameS['kana']         = '�եꥬ��';
      $this->nameS['kana_family']  = '�եꥬ�ʡ�����';
      $this->nameS['kana_first']   = '�եꥬ�ʡ�̾��';
      $this->nameS['birthday']     = '��ǯ����';
      $this->nameS['birthday_y']   = '��ǯ���� ��ǯ��';
      $this->nameS['birthday_m']   = '��ǯ���� �ʷ��';
      $this->nameS['birthday_d']   = '��ǯ���� ������';
      $this->nameS['mail']         = '�᡼�륢�ɥ쥹';
      $this->nameS['tel']           = '�����ֹ�';
      $this->nameS['tel_1']         = '�����ֹ� ����';
      $this->nameS['tel_2']         = '�����ֹ� ����';
      $this->nameS['tel_3']         = '�����ֹ� ����';
      $this->nameS['mobile']        = '�����ֹ�';
      $this->nameS['mobile_1']      = '�����ֹ� ����';
      $this->nameS['mobile_2']      = '�����ֹ� ����';
      $this->nameS['mobile_3']      = '�����ֹ� ����';
      $this->nameS['fax']           = 'FAX';
      $this->nameS['fax_1']         = 'FAX ����';
      $this->nameS['fax_2']         = 'FAX ����';
      $this->nameS['fax_3']         = 'FAX ����';
      $this->nameS['zip']           = '͹���ֹ�';
      $this->nameS['zip_1']         = '͹���ֹ� ��3��';
      $this->nameS['zip_2']         = '͹���ֹ� ��4��';
      $this->nameS['area']          = '�������ƻ�ܸ���';
      $this->nameS['address1']      = '����ʻԶ�Į¼��';
      $this->nameS['address2']      = '������������ϡ���ʪ̾��';
      $this->nameS['comment']       = '����';
      $this->nameS['flag_gender']   = '����';
      $this->nameS['flag_pictmail'] = 'PICTMAIL���Ѹ���';

      $this->nameS['pictmail_id']      = '�ԥ��ȥ᡼��ID';
      $this->nameS['plan_pictmail_id'] = '�ԥ��ȥ᡼�� �ץ��ID';
      $this->nameS['account']          = '��ͭ��������ȿ�';
      $this->nameS['send_max']         = '����᡼��������';
      $this->nameS['month_max']        = '��ֺ����������';
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

      $this->dbS['td_user'][] = array( 'name'=>'user_id',         'key'=>'primary','default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'id',              'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'password',        'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'name_company',     'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'kana_company',     'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'name_family',     'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'name_first',      'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'kana_family',     'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'kana_first',      'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'birthday',        'key'=>'date',   'default'=>'now');
      $this->dbS['td_user'][] = array( 'name'=>'mail',            'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'tel',             'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'mobile',          'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'fax',             'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'zip',             'key'=>'int',    'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'area',            'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'address1',        'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'address2',        'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'comment',         'key'=>'text',   'default'=>'');
      $this->dbS['td_user'][] = array( 'name'=>'flag_gender',     'key'=>'int',    'default'=>3);
      $this->dbS['td_user'][] = array( 'name'=>'flag_pictmail',   'key'=>'text',   'default'=>'t');

      $this->dbS['td_pictmail'][] = array( 'name'=>'pictmail_id',     'key'=>'primary','default'=>'' );
      $this->dbS['td_pictmail'][] = array( 'name'=>'user_id',         'key'=>'int',    'default'=>1 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'plan_pictmail_id','key'=>'int',    'default'=>1 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'account',         'key'=>'int',    'default'=>1 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'send_max',        'key'=>'int',    'default'=>60 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'send_now',        'key'=>'int',    'default'=>60 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'month_max',       'key'=>'int',    'default'=>3 );
      $this->dbS['td_pictmail'][] = array( 'name'=>'month_now',       'key'=>'int',    'default'=>3 );
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
      $this->convertS['code'][] = array( 'key'=>'user_id',     'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'id',          'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'password',    'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'name_company', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'kana_company', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'name_family', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'name_first',  'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'kana_family', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'kana_first',  'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'birthday_y',  'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'birthday_m',  'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'birthday_d',  'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'mail',        'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'tel_1',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'tel_2',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'tel_3',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'mobile_1',    'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'mobile_2',    'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'mobile_3',    'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'fax_1',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'fax_2',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'fax_3',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'zip_1',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'zip_2',       'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'area',        'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'address1',    'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'address2',    'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'comment',     'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'plan_id',   'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'flag_gender', 'code'=>'EUC-JP' );

      $this->convertS['code'][] = array( 'key'=>'plan_pictmail_id', 'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'account',          'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'send_max',         'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'month_max',        'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'flag_permission',  'code'=>'EUC-JP' );
      $this->convertS['code'][] = array( 'key'=>'flag_dm',          'code'=>'EUC-JP' );


      // �������
      $this->convertS['s39'][] = array( 'key'=>'id' );
      $this->convertS['s39'][] = array( 'key'=>'password' );
      $this->convertS['s39'][] = array( 'key'=>'name_company' );
      $this->convertS['s39'][] = array( 'key'=>'kana_company' );
      $this->convertS['s39'][] = array( 'key'=>'name_family' );
      $this->convertS['s39'][] = array( 'key'=>'name_first' );
      $this->convertS['s39'][] = array( 'key'=>'kana_family' );
      $this->convertS['s39'][] = array( 'key'=>'kana_first' );
      $this->convertS['s39'][] = array( 'key'=>'mail' );
      $this->convertS['s39'][] = array( 'key'=>'tel_1' );
      $this->convertS['s39'][] = array( 'key'=>'tel_2' );
      $this->convertS['s39'][] = array( 'key'=>'tel_3' );
      $this->convertS['s39'][] = array( 'key'=>'mobile_1' );
      $this->convertS['s39'][] = array( 'key'=>'mobile_2' );
      $this->convertS['s39'][] = array( 'key'=>'mobile_3' );
      $this->convertS['s39'][] = array( 'key'=>'fax_1' );
      $this->convertS['s39'][] = array( 'key'=>'fax_2' );
      $this->convertS['s39'][] = array( 'key'=>'fax_3' );
      $this->convertS['s39'][] = array( 'key'=>'zip_1' );
      $this->convertS['s39'][] = array( 'key'=>'zip_2' );
      $this->convertS['s39'][] = array( 'key'=>'address1' );
      $this->convertS['s39'][] = array( 'key'=>'address2' );
      $this->convertS['s39'][] = array( 'key'=>'comment' );


      // Ⱦ�ѱѿ� <- ���ѱѿ�
      $this->convertS['a'][] = array( 'key'=>'send_max' );
      $this->convertS['a'][] = array( 'key'=>'name_company' );
      $this->convertS['a'][] = array( 'key'=>'kana_company' );
      $this->convertS['a'][] = array( 'key'=>'name_family' );
      $this->convertS['a'][] = array( 'key'=>'name_family' );
      $this->convertS['a'][] = array( 'key'=>'name_first' );
      $this->convertS['a'][] = array( 'key'=>'kana_family' );
      $this->convertS['a'][] = array( 'key'=>'kana_first' );
      $this->convertS['a'][] = array( 'key'=>'mail' );
      $this->convertS['a'][] = array( 'key'=>'tel_1' );
      $this->convertS['a'][] = array( 'key'=>'tel_2' );
      $this->convertS['a'][] = array( 'key'=>'tel_3' );
      $this->convertS['a'][] = array( 'key'=>'mobile_1' );
      $this->convertS['a'][] = array( 'key'=>'mobile_2' );
      $this->convertS['a'][] = array( 'key'=>'mobile_3' );
      $this->convertS['a'][] = array( 'key'=>'fax_1' );
      $this->convertS['a'][] = array( 'key'=>'fax_2' );
      $this->convertS['a'][] = array( 'key'=>'fax_3' );
      $this->convertS['a'][] = array( 'key'=>'zip_1' );
      $this->convertS['a'][] = array( 'key'=>'zip_2' );
      $this->convertS['a'][] = array( 'key'=>'address1' );
      $this->convertS['a'][] = array( 'key'=>'address2' );
      $this->convertS['a'][] = array( 'key'=>'comment' );


      // ���ѥ��� <- Ⱦ�ѥ���
      $this->convertS['KV'][] = array( 'key'=>'kana_company' );
      $this->convertS['KV'][] = array( 'key'=>'name_family' );
      $this->convertS['KV'][] = array( 'key'=>'name_first' );
      $this->convertS['KV'][] = array( 'key'=>'address1' );
      $this->convertS['KV'][] = array( 'key'=>'address2' );
      $this->convertS['KV'][] = array( 'key'=>'comment' );

      // ���ѥ��� <- Ⱦ�ѥ��ʡ��Ҥ餬��
      $this->convertS['KVC'][] = array( 'key'=>'kana_company' );
      $this->convertS['KVC'][] = array( 'key'=>'kana_family' );
      $this->convertS['KVC'][] = array( 'key'=>'kana_first' );

      return ;
    }

    /*
     * �����Ѵ������ϻ�
     *   $convertS['�Ѵ�����']['Ϣ��'] = array('key'=>'�ե������̾');
     */
    Function write(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | write() <br>\n";

      $this->writeS['input'][]    = array( 'key'=>'user_id');
      $this->writeS['text'][]     = array( 'key'=>'id');
      $this->writeS['text'][]     = array( 'key'=>'password');
      $this->writeS['text'][]     = array( 'key'=>'name_company');
      $this->writeS['text'][]     = array( 'key'=>'kana_company');
      $this->writeS['text'][]     = array( 'key'=>'name_family');
      $this->writeS['text'][]     = array( 'key'=>'name_first');
      $this->writeS['text'][]     = array( 'key'=>'kana_family');
      $this->writeS['text'][]     = array( 'key'=>'kana_first');
      $this->writeS['text'][]     = array( 'key'=>'birthday_y');
      $this->writeS['text'][]     = array( 'key'=>'birthday_m');
      $this->writeS['text'][]     = array( 'key'=>'birthday_d');
      $this->writeS['text'][]     = array( 'key'=>'mail');
      $this->writeS['text'][]     = array( 'key'=>'tel_1');
      $this->writeS['text'][]     = array( 'key'=>'tel_2');
      $this->writeS['text'][]     = array( 'key'=>'tel_3');
      $this->writeS['text'][]     = array( 'key'=>'mobile_1');
      $this->writeS['text'][]     = array( 'key'=>'mobile_2');
      $this->writeS['text'][]     = array( 'key'=>'mobile_3');
      $this->writeS['text'][]     = array( 'key'=>'fax_1');
      $this->writeS['text'][]     = array( 'key'=>'fax_2');
      $this->writeS['text'][]     = array( 'key'=>'fax_3');
      $this->writeS['text'][]     = array( 'key'=>'zip_1');
      $this->writeS['text'][]     = array( 'key'=>'zip_2');
      $this->writeS['text'][]     = array( 'key'=>'area');
      $this->writeS['text'][]     = array( 'key'=>'address1');
      $this->writeS['text'][]     = array( 'key'=>'address2');
      $this->writeS['textarea'][] = array( 'key'=>'comment');
      $this->writeS['text'][]     = array( 'key'=>'flag_gender');

      $this->writeS['text'][] = array( 'key'=>'plan_pictmail_id' );
      $this->writeS['text'][] = array( 'key'=>'account' );
      $this->writeS['text'][] = array( 'key'=>'send_max' );
      $this->writeS['text'][] = array( 'key'=>'month_max');
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

      $this->viewS['html'][]     = array( 'key'=>'user_id');
      $this->viewS['html'][]     = array( 'key'=>'id');
      $this->viewS['html'][]     = array( 'key'=>'password');
      $this->viewS['html'][]     = array( 'key'=>'name_company');
      $this->viewS['html'][]     = array( 'key'=>'kana_company');
      $this->viewS['html'][]     = array( 'key'=>'name_family');
      $this->viewS['html'][]     = array( 'key'=>'name_first');
      $this->viewS['html'][]     = array( 'key'=>'kana_family');
      $this->viewS['html'][]     = array( 'key'=>'kana_first');
      $this->viewS['html'][]     = array( 'key'=>'birthday_y');
      $this->viewS['html'][]     = array( 'key'=>'birthday_m');
      $this->viewS['html'][]     = array( 'key'=>'birthday_d');
      $this->viewS['html'][]     = array( 'key'=>'mail');
      $this->viewS['html'][]     = array( 'key'=>'tel_1');
      $this->viewS['html'][]     = array( 'key'=>'tel_2');
      $this->viewS['html'][]     = array( 'key'=>'tel_3');
      $this->viewS['html'][]     = array( 'key'=>'mobile_1');
      $this->viewS['html'][]     = array( 'key'=>'mobile_2');
      $this->viewS['html'][]     = array( 'key'=>'mobile_3');
      $this->viewS['html'][]     = array( 'key'=>'fax_1');
      $this->viewS['html'][]     = array( 'key'=>'fax_2');
      $this->viewS['html'][]     = array( 'key'=>'fax_3');
      $this->viewS['html'][]     = array( 'key'=>'zip_1');
      $this->viewS['html'][]     = array( 'key'=>'zip_2');
      $this->viewS['html'][]     = array( 'key'=>'area');
      $this->viewS['html'][]     = array( 'key'=>'address1');
      $this->viewS['html'][]     = array( 'key'=>'address2');
      $this->viewS['html'][]     = array( 'key'=>'comment');
      $this->viewS['html'][]     = array( 'key'=>'plan_id');
      $this->viewS['html'][]     = array( 'key'=>'flag_gender');
      $this->viewS['html'][]     = array( 'key'=>'flag_permission');


      $this->viewS['html'][] = array( 'key'=>'plan_pictmail_id' );
      $this->viewS['html'][] = array( 'key'=>'account' );
      $this->viewS['html'][] = array( 'key'=>'send_max' );
      $this->viewS['html'][] = array( 'key'=>'month_max');
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
      $this->checkS['Input'][] = array( 'key'=>'id' );
      $this->checkS['Input'][] = array( 'key'=>'password' );
      $this->checkS['Input'][] = array( 'key'=>'name_family' );
      $this->checkS['Input'][] = array( 'key'=>'name_first' );
      $this->checkS['Input'][] = array( 'key'=>'kana_family' );
      $this->checkS['Input'][] = array( 'key'=>'kana_first' );
      $this->checkS['Input'][] = array( 'key'=>'mail' );
      $this->checkS['Input'][] = array( 'key'=>'zip_1' );
      $this->checkS['Input'][] = array( 'key'=>'zip_2' );
      $this->checkS['Input'][] = array( 'key'=>'area' );
      $this->checkS['Input'][] = array( 'key'=>'address1' );
      $this->checkS['Input'][] = array( 'key'=>'address1' );

      // [ ʸ���� ]
      //$this->checkS['Len'][] = array( 'key'=>'id',         'limit'=>8);
      //$this->checkS['Len'][] = array( 'key'=>'password',   'limit'=>8);

      $this->checkS['Len'][] = array( 'key'=>'name_company','limit'=>100);
      $this->checkS['Len'][] = array( 'key'=>'kana_company','limit'=>100);
      $this->checkS['Len'][] = array( 'key'=>'name_family','limit'=>50);
      $this->checkS['Len'][] = array( 'key'=>'name_first', 'limit'=>50);
      $this->checkS['Len'][] = array( 'key'=>'kana_family','limit'=>50);
      $this->checkS['Len'][] = array( 'key'=>'kana_first', 'limit'=>50);

      $this->checkS['Len'][] = array( 'key'=>'send_max',   'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'month_max',  'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'account',    'limit'=>8);


      // [ �᡼�� ]
      $this->checkS['Mail'][] = array( 'key'=>'mail' );

      // [ ͹���ֹ� ]
      //$this->checkS['Zip'][] = array( 'key'=>'zip' );

      // [ ���� ]
      $this->checkS['Date'][] = array( 'key'=>'birthday' );

      // [ �����ֹ� ]
      $this->checkS['Tel'][] = array( 'key'=>'tel' );
      $this->checkS['Tel'][] = array( 'key'=>'fax' );
      $this->checkS['Tel'][] = array( 'key'=>'mobile' );

      // [ Ⱦ�ѿ� ]
      $this->checkS['Number'][] = array( 'key'=>'zip_1', 'limit'=>3 );
      $this->checkS['Number'][] = array( 'key'=>'zip_2', 'limit'=>4 );
      $this->checkS['Number'][] = array( 'key'=>'send_max',  'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'month_max', 'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'account',   'limit'=>0 );

      // [ Ⱦ�ѱѿ� ]
      //$this->checkS['Eisu'][] = array( 'key'=>'campaign_code' );

      // [ �������� ]
      $this->checkS['KataKana'][] = array( 'key'=>'kana_family' );
      $this->checkS['KataKana'][] = array( 'key'=>'kana_first' );

 
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
