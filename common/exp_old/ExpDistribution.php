<?PHP
/*

  �ɲá���ĥ : ����ʬ��


*/
  class ExpDistribution{

    var $exe = 'first';

    Function ExpDistribution($postS=False, $getS=False){

      $this->set($postS,$getS);

      return ;
    }

    // * ����ʬ��
    Function set( $postS=False, $getS=False ){

      // POST
      if( isset($postS['post']) ){
        $this->exe = @key($postS['post']);

      // GET
      }else if( isset($getS['get']) ){
        $this->exe = $getS['get'];

      // HIDDEN
      }else if( isset($postS['hidden']) ){
        $this->exe = $postS['hidden'];
      }

      return ;
    }

  }

?>
