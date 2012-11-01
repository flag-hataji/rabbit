<?PHP
/*

  # フィールド設定

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
     * 初期値
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
     * 名称
     * $nameS['フィールド名'] = '名称';
     */
    Function name(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | name() <br>\n";

      $this->nameS['pictmail_id']      = 'ピクトメールID';
      $this->nameS['user_id']          = 'ユーザーID';
      $this->nameS['plan_pictmail_id'] = 'ピクトメール プラン';
      $this->nameS['price_month']          = '料金（税抜き：1か月）';
      $this->nameS['price_month6']          = '料金（税抜き：6か月）';
      $this->nameS['price_year']          = '料金（税抜き：12か月）';
      $this->nameS['account']          = '所有アカウント数';
      $this->nameS['send_max']         = '最大メール送信数';
      $this->nameS['send_now']         = '現在の残りメール送信数';
      $this->nameS['month_max']        = '月間送信回数：最大';
      $this->nameS['month_now']        = '月間送信回数：現在';
      $this->nameS['flag_permission']  = '使用許可';
      $this->nameS['flag_dm']          = 'お知らせメールの受け取り';

      return ;
    }


    /*
     * 使用DB登録フィールド
     * dbS['テーブル名']['連番'] = array('name'=>'カラム','key'=>'型','default'=>'INSERTデフォルト');
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
     * 強制変換
     *   $convertS['変換形式']['連番'] = array('key'=>'フィールド名');
     */
    Function convert(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | convert() <br>\n";

      // 文字コード
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


      // 空白除去
      $this->convertS['s39'][] = array( 'key'=>'send_max' );
      $this->convertS['s39'][] = array( 'key'=>'send_now' );

      // 半角英数 <- 全角英数
      $this->convertS['a'][] = array( 'key'=>'send_max' );
      $this->convertS['a'][] = array( 'key'=>'send_now' );

      return ;
    }

    /*
     * 強制変換：入力時
     *   $convertS['変換形式']['連番'] = array('key'=>'フィールド名');
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
     * 強制変換：表示時
     *   $convertS['変換形式']['連番'] = array('key'=>'フィールド名');
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
     * チェック
     * $checkS['チェック型']['連番'] = array('key'=>'フィールド名');
     * 又は
     * $checkS['チェック型']['連番'] = array('key'=>'フィールド名','limit'=>数値);
     * 又は
     * $checkS['チェック型']['連番'] = array('key'=>'フィールド名','ex'=>拡張チェック);
     */
    Function check(){

      if( $this->debug ) echo" - "._ROOT_PG_."Field.php | check() <br>\n";

      // [ 入力 ]
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

      // [ 文字数 ]
      $this->checkS['Len'][] = array( 'key'=>'price_month',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'price_month6',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'price_year',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'account',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'send_max',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'send_now',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'month_max',    'limit'=>8);
      $this->checkS['Len'][] = array( 'key'=>'month_now',    'limit'=>8);



      // [ 半角数 ]
      $this->checkS['Number'][] = array( 'key'=>'price_month',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'price_month6',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'price_year',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'account',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'send_max',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'send_now',   'limit'=>0 );
      $this->checkS['Number'][] = array( 'key'=>'month_max',   'limit'=>0 );

      // [ 半角英数 ]
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
