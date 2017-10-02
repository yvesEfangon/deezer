/**
 * Created by yves on 01/10/17.
 */

var callback = function(){

   document.getElementById("add-user").addEventListener('click', function () {
        addUser();
   });
    document.getElementById("search-users").addEventListener('click', function () {
        getUsers();
   })

};

var baseURL = '/application.php';

function addUser() {
    var xhr = new XMLHttpRequest();
    var data = getData("form-create-user");

    if(countProperties(data)<=0 || data['username']=='' || data['email']==''){
        alert('Please supply data to create a user');
        return;
    }

    data['controller']  = 'user';

    xhr.open('PUT', baseURL);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var result = JSON.parse(xhr.responseText);
            var classResult;

            if(result.status == false) classResult = 'error';
            else classResult ='success';

            document.getElementById("results-add").innerHTML = '<span class="'+classResult+'">'+result.message+'</span>';
        }else{
            document.getElementById("results-add").innerHTML = '<span class="error">'+xhr.message+'</span>';
        }

        getUsers();
    };

    xhr.send(JSON.stringify(data));
}

/**
 *
 */
function getUsers(){
    var xhr = new XMLHttpRequest();
    var data = getData("form-search-user");

    data['controller']  = 'user';

    xhr.open('POST', baseURL);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var users = JSON.parse(xhr.responseText);
            displayUsersTable(users.data);
        }else{
            document.getElementById("display-users").innerHTML = '<span class="error">'+xhr.message+'</span>';
        }
    };

    xhr.send(JSON.stringify(data));
}

function displayUsersTable(users) {
    var html    = [];
    html.push("<table><tr><th>Name</th><th>Username</th><th>Email</th><th></th></tr>");

    for(var i=0; i<users.length;i++){

        html.push("<tr><td>"+users[i].name+"</td><td>"+users[i].username+"</td><td>"+users[i].email+"</td></tr>");
    }

    html.push('</table>');

    document.getElementById("display-users").innerHTML  = html.join('');
}

function getData(divID){
    var data = {};
    var elts    = document.getElementById(divID).children;

    for(var i=0; i<elts.length; i++){
        var elt = elts[i];
        var tagName = elt.tagName;
        tagName = tagName.toUpperCase();

        if(tagName == 'INPUT'){
            var tagType     = elt.type;
            var eltName     = elt.name;
            var eltValue    = elt.value;

            if(tagType == 'text' || tagType == 'number' || tagType == 'date' || tagType == 'radio'|| tagType == 'email'){
                data[eltName]  = eltValue;
            }

            if(tagType == 'checkbox'){
                var chk = [];
                if(data.hasOwnProperty(eltName)) chk = data[eltName];

                chk.push(eltValue);
                data[eltName]   = chk;
            }
        }

        if(tagName == 'SELECT'){
            data[elt.name]  = elt.options[elt.selectedIndex].value;
        }

    }

    return data;
}

function countProperties(obj) {
    var count = 0;

    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            ++count;
    }

    return count;
}
