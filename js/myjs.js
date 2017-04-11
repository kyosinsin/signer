// 验证用户名和密码不为空
function check(){
    var x=document.forms["form-horizontal"]["inputUsername3"].value;
    if(x==null || x==""){
        alert("用户名不能为空！");
        return false;
    }
    var z=document.forms["form-horizontal"]["inputPassword3"].value;
    if(z==null || z==""){
        alert("密码不能为空！");
        return false;
    }
}

