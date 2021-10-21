# twpay
台灣Pay產生器API<BR>
API 呼叫網址： https://i-tw.org/twpay/api<BR>
資料傳送方式： GET<BR>
資料反送方式： JSON String

適用場景：<BR>
* 網路賣家可透過平台API介接功能，將虛擬帳號及訂單金額製作成QR Code供買家掃碼。<BR>
* 攤販商家可產生包含購物金額的條碼，避免客入於主掃交易時輸錯金額造成的爭議。<BR>

<pre>
需求參數：
Bank   必填     3 位數字 銀行代碼
Acc    必填  1-16 位數字 帳號/銷帳編號
Amount 選填  1- 7 位數字 金額(若未設定此欄位，則掃碼者可自行調整金額)
Memo   選填  1-19 位字串 備註
Redir  選填 NULL或99~547 有設定此參數時，自動導引至QR圖片(數字為圖片像素)
                         未設定此參數時，將回傳JSON String

回傳參數
Success (產製結果)： 0表示條碼產生失敗，1表示條碼產生成功
Msg     (錯誤資訊)： 條碼產生失敗的原因說明
String  (編碼內容)： QR Code的編碼內容，可以此字串自行產生QR Code
QR      (條碼連結)： 使用Google API產生的QR Code圖片網址
</pre>

API使用範例<BR>
假設要產生「臺灣銀行(004)」，帳號「12345678」且金額為「100元」的台灣Pay條碼<BR>
API呼叫連結為： https://i-tw.org/twpay/api?Bank=004&Acc=12345678&Amount=100<BR>

如果不想要字串，想要直接導引至QR Code圖片位置，則在後方加上 &Redir 即可<BR>
即： https://i-tw.org/twpay/api?Bank=004&Acc=12345678&Amount=100&Redir<BR>
「Redir」可指定數字，用來調整條碼的大小，如「Redir=400」，產出400x400px的條碼。
