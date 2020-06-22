//退出登录
function clearUser() {
    let user = {};
    user.loginState = false;
    user.name = null;
    user.userID =-1;
    localStorage.setItem('user',JSON.stringify(user));

}
//用户登录信息
function setUser(userName,userID) {
    let user = {};
    user.userID = userID;
    user.name = userName;
    user.loginState =true;
    localStorage.setItem('user',JSON.stringify(user));
}
//是否登录
function isUserLogin() {
    let user = JSON.parse(localStorage.getItem('user'));
    if(!user){
        clearUser();
        return false;
    }else {
        return user.loginState;
    }
}

/**
 * 获得用户ID，若失败则返回-1
 * @returns {number}
 */
//-1表示出错
function getUserID() {
    let user = JSON.parse(localStorage.getItem('user'));
    if(user===undefined){
        return -1;
    }
    if(user.loginState===false){
        return -1;
    }
    return user.userID;
}
function setClickImgId(imgId) {
    console.log("设置当前点击图片的ID="+imgId);//
    localStorage.setItem('imgId',imgId);
}

function getClickImgId() {
    return localStorage.getItem('imgId');
}
function setEditImg(imgID) {
    console.log("设置当前修改图片的ID="+imgID);//
    localStorage.setItem('isEditing',true);
    localStorage.setItem('editImgId',imgID);
}
//修改图片id的
function getEditImg() {
    let isEditing = localStorage.getItem('isEditing');
    console.log("isEditing="+isEditing);//
    let imgID;
    if(isEditing=='true'){
        console.log("isEditing===true");//
        imgID =localStorage.getItem('editImgId');
    }else {
        console.log("not isEditing===true");//
        imgID=-1;
    }
    return imgID;
}
//取消编辑
function cancelEdit() {
    console.log("cancelEdit");//
    localStorage.setItem('isEditing',false);
}