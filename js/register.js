function register() {
    if(!checkName()){
        alert("该用户名不可用");
        return false;
    }

    if(!checkMail()){
        alert("邮箱格式错误！");
        return false;
    }

    if(!checkPassword()){
        alert("两次密码不一致，请检查后重试");
        return false;
    }
    return true;
}


function checkName() {
    let nameRe = /^[A-Za-z_]+[\w]*/;
    let name = document.getElementById("name").value;
    return nameRe.test(name) && (!JudgeUsername(name));
}

function checkPassword() {
    let pass1 = document.getElementById("password1").value;
    let pass2 = document.getElementById("password2").value;
    return pass1===pass2;
}

function checkMail() {
    let mailRe = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
    let mail = document.getElementById("email").value;
    return mailRe.test(mail);
}


function JudgeUsername(name) {
    let result;
    let xml=$.ajax({
        type: "POST",
        url:'../php/ifUserExist.php',
        dataType:'json',
        async:false,
        data:{'name':name},
        success:function (ans) {
            result = ans;
            return result;
        }
    } );
    return result;
}
