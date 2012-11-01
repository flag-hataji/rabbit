<?PHP
/*
 * クレジット決済
 * plan_change@itm-asp.com にて起動
 *
 */
class mailData extends mailRead
{


    function mailData()
    {

        require_once("/var/www/html/program/cls/define/Db.php");

        pg_connect("host="._DB_HOST_." port="._DB_PORT_." dbname="._DB_NAME_." user="._DB_USER_." ");

        $this->setMailData();
        $this->setConvertMailData();
        $this->setSepalateMailData();
        $this->setMailHeader();
        $this->setMailSubject();

        $isMailDataBody = $this->_mailDataBody;

        $isExplodeS = explode("\n",$isMailDataBody);

        $isId = $isExplodeS[0];
        $isId = trim($isId);
        $isIdS = explode("_",$isId,3);

        $isUserID = $isIdS[0];
        $isPlanID = $isIdS[1];

        if ($isUserID!="" && $isPlanID!="") {

            $isPlanDataS = $this->getPlanData($isPlanID);

            $isQuery = "";
            $isQuery .= "UPDATE td_pictmail SET ";
            $isQuery .= "plan_pictmail_id=".$isPlanID.", ";
            $isQuery .= "price_month  = ".$isPlanDataS['price_month'].", ";
            $isQuery .= "price_month6 = ".$isPlanDataS['price_month6'].", ";
            $isQuery .= "price_year   = ".$isPlanDataS['price_year'].", ";
            $isQuery .= "month_max    = ".$isPlanDataS['month_max'].", ";
            if ($isPlanID==7 || $isPlanID==10 || $isPlanID==11) {
                $isQuery .= "send_now=send_now+".$isPlanDataS['send_max'].",";
                $isQuery .= "send_max=send_max+".$isPlanDataS['send_max'].", ";
            } else {
                $isQuery .= "send_now     = ".$isPlanDataS['send_max'].",";
                $isQuery .= "send_max     = ".$isPlanDataS['send_max'].", ";
            }
            $isQuery .= "month_now    = 0 ";
            $isQuery .= "WHERE user_id=".$isUserID." ";
            $result = pg_query($isQuery);
        }

        pg_close();

        mail ("masaki@itm.ne.jp", "[itm-asp]PlanChange",$isQuery);

    }

    function getPlanData($isPlanID="")
    {

          $isQuery = "";
          $isDataS = "";

          $isQuery .= "SELECT * FROM tm_plan WHERE plan_id=".$isPlanID." ";
          $result = pg_query($isQuery);
          $isResult = pg_query($isQuery);
          $isCount = pg_num_rows($isResult);
          if ($isCount!=0){
              $isDataS = pg_fetch_assoc($isResult,0);
          }
          pg_free_result($isResult);


        return $isDataS;
    }

}


?>
