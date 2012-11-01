<?PHP
/*
もじこーどいーゆーしー
*/
  new itmKakugen();
  class itmKakugen {
    var $path = "/www/html/cls/kakugen/kakugen.txt";
    var $link = "";
    function itmKakugen(){
      $wordS = file($this->path);
      $count = count($wordS)-1;
      srand((double)date('Ymd'));
      $key=round(rand(0,$count));
      echo "{$wordS[$key]}　{$this->link}";
    }
  }
?>
