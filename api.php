<?php
if (isset($_GET['Bank']) && isset($_GET['Acc'])) {
    //檢查銀行代碼
    $BankCode = substr($_GET['Bank'], 0, 3);
    if (!is_nan($BankCode) && $BankCode >= 1 && strlen($BankCode)==3) {

        //檢查帳號
        $AccNo = str_pad($_GET['Acc'], 16, "0", STR_PAD_LEFT);
        if (!is_nan($AccNo) && $AccNo >= 1 && strlen($AccNo) == 16) {
            
            //產生QRCode編碼字串
            $QString = "TWQRP%3A%2F%2F".$BankCode."NTTransfer%2F158%2F02%2FV1%3FD6%3D".$AccNo."%26D5%3D".$BankCode."%26D10%3D901%26D97%3D99991231235959";
            
            //檢查金額
            if (isset($_GET['Amount'])) {
                //TWPay金額格式包含兩位小數，所以此處數字要乘上100
                $Amount = $_GET['Amount']*100;
                //TWPay金額限制最低1.00元，最高9,999,999.00元
                if (!is_nan($Amount) && $Amount <= 999999900 && $Amount >= 100) {
                    //於編碼字串上加上金額
                    $QString .= "%26D1%3D".$Amount;
                }
            }
            
            //檢查備註
            if (isset($_GET['Memo'])) {
                //備註上限為19字元，超過者省略。
                $Memo = substr($_GET['Memo'], 0, 19);
                //於編碼字串上加上備註
                $QString .= "%26D9%3D".$Memo;
            }

            //資料檢核完成，顯示QRCode
            if(isset($_GET['Redir'])) {
                $Pixel = $_GET['Redir'];
                //Google API產生的QR Code像素大小須介於99~547之間
                if (!is_nan($Pixel) && $Pixel >= 99 && $Pixel <= 547) {
                    echo "<center><img src='https://chart.googleapis.com/chart?cht=qr&chs=".$Pixel."x".$Pixel."&chl=".$QString."' /></center>";
                } else {
                    //預設像素為400x400
                    echo "<center><img src='https://chart.googleapis.com/chart?cht=qr&chs=400x400&chl=".$QString."' /></center>";
                }
            } else {
            //資料檢核完成，回傳JSON String
                echo '{"Success":"1", "String":"';
                echo urldecode($QString);
                echo '", "QR":"https://chart.googleapis.com/chart?cht=qr&chs=400x400&chl=';
                echo $QString;
                echo '"}';
            }
        } else {
            //回傳帳號不合法訊息
            echo '{"Success":"0", "Msg":"Parameters `Acc` not legal"}';
        }       
    } else {
        //回傳銀行代碼不合法訊息
        echo '{"Success":"0", "Msg":"Parameters `Bank` not legal"}';
    }
} else {
    //銀行代碼或帳號值為空，回傳錯誤訊息
    echo '{"Success":"0", "Msg":"Parameters `Bank` or `Acc` not set"}';
}
?>
