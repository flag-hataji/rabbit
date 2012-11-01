<?PHP
/*

  追加・拡張 : 振り分け


*/
  class ExpDistribution{

    var $exe = 'first';

    Function ExpDistribution($postS=False, $getS=False){

      $this->set($postS,$getS);

      return ;
    }

    // * 振り分け
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
