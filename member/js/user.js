
    function rollOver (obj,val) {

      obj.src = val;

    }




    function messageLink($msg,$url) {

        if (confirm($msg)) {

            window.location=$url;

        }

    }


    function messageSubmit($msg,$url) {

        if (confirm($msg)) {

            return true;

        } else {

           return false;

        }

    }


    function allCheck(buttonID,checkID,num){


        var isCheck = document.getElementById(buttonID).checked;

        for(var i=0;i<num;i++) {

          document.getElementById(checkID+i).checked=isCheck;

        }

    }


    function groupCheck(formName,checkID,isEID,mode){

        var modeSelect    = document.getElementById(mode);

        var modeSelected  = modeSelect.value;

        if (modeSelected == 'all') {

            var isCheck = document.getElementById(isEID).checked;

            var ElementsCount = document.email_form.elements.length; // チェックボックスの数

            for( i=0 ; i<ElementsCount ; i++ ) {

               var isID = document.email_form.elements[i].id ;

               var searchCount = isID.search(isEID);

               if (isID != isEID  &&  searchCount >= 0) {

                   if (isCheck == true) {

                       document.getElementById(isID).disabled=true;
                       document.getElementById(isID).checked=false;

                   } else {

                       document.getElementById(isID).disabled=false;
                       document.getElementById(isID).checked=false;
                   }

               }
            }

        }

    }


    function groupCheckSelect(formName,mode){

        var modeSelect    = document.getElementById(mode);

        var modeSelected  = modeSelect.value;

        var ElementsCount = document.email_form.elements.length; // チェックボックスの数

//        var hoge = '';

        for( i=0 ; i<ElementsCount ; i++ ) {

            var isID = document.email_form.elements[i].id ;

            var isType = document.email_form.elements[i].type ;


            if (modeSelected == 'one'  &&  isType == 'checkbox') {

//var hoge = hoge+document.email_form.elements[i].name+'<br>\n';
                document.getElementById(isID).disabled=false;
//                document.getElementById(isID).checked=false;

            }
        }
//document.write(hoge);

    }



    function showOpenClose(checkID,showID,isDefault)
    {

        var isCheck = document.getElementById(checkID).checked;

        var isShow  = document.getElementById(showID);

        var isNow = isShow.style.display;


        if (isDefault != ''  &&  isDefault != isNow) {

            isShow.style.display = isDefault;

        } else if (isCheck == true) {

            if (isNow == 'none') {

                isShow.style.display = 'block';

            }

        } else {

            if (isNow == 'block') {

                isShow.style.display = 'none';

            }

        }

    }








    function checkSelectAlert(selectID,alertVal,msg) {


        var select    = document.getElementById(selectID);

        var selected  = select.value;

        if (selected == alertVal) {

            if (confirm(msg)) {

                return true;

            } else {

               return false;

            }

        }

    }

    function entryTab() {


    }

