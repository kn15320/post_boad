
let mail = document.getElementById("mail");
let pass = document.getElementById("pass");
let comment = document.getElementById("comment");
let comment_pass = document.getElementById("comment_pass");

mail.addEventListener("blur", () =>  {
    if(mail.value === ""){
        comment.innerHTML = "メールアドレスを入力してください。";
    }else{
        comment.innerHTML = "";
        var match = mail.value.match(/^[a-z0-9-._+-]+(\.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/);
        if(match === null){
            comment.innerHTML = "メールアドレスの形式が正しくありません。";
        }
    }

});

pass.addEventListener("blur", () =>  {
    console.log('JIKO');
    if(pass.value === ""){
        comment_pass.innerHTML = "パスワードを入力してください。";
    }else{
        if(pass.value.length >= 1){
            comment_pass.innerHTML = "";
        }
    }
});
