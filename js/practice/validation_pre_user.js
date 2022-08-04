
let email = document.getElementById("mail");

email.addEventListener("blur", function blur(){
    if(email.value.length >= 1 && email.value.length <= 50){
    console.log(email[0].value.length);  
    var match = email[0].value.match(/[^a-z0-9-._]^[a-z]|\d[.]$/);//半角英小文字、数字、「-」(ハイフン)、「.」(ドット)、「_」(アンダースコア)以外のいずれか1文字にマッチ
    console.log(match);
    mail_address[0].innerHTML = "";
    if(match === null){
        console.log(match)
        var alpha = email.value.match(/^[a-z]|\d/)//行の先頭が半角英小文字または数字
        mail_address.innerHTML = "";
        if(alpha !== null){
            console.log(alpha);
            mail_address[0].innerHTML = "";
            var symbol = email[0].value.match(/[.]$/); 
            console.log(symbol) 
            if(symbol === null){
                console.log(symbol);
                mail_address[0].innerHTML = "";
                var symbol_1 = email[0].value.match(/[.]{2,}/)
                if(symbol_1 === null){
                    console.log(symbol_1);
                    mail_address[0].innerHTML = "";
                }else{
                    console.log("実行")
                    error();
                }
            }else{
                console.log("実行")
                error();       
            }
        }else{
            console.log("実行")
            error();        
        }
    }else{
        console.log("実行")
        error();
    };
  }else{
    console.log("実行")
    if(email[0].value.length > 30){
        error();
    }else{
        mail_address[0].innerHTML = "値を入力してください。";
        mail_address[0].style.color = "red";
    }
  };
});