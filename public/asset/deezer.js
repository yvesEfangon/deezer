/**
 * Created by yves on 01/10/17.
 */

var callback = function(){

   document.getElementById("add-user").addEventListener('click', function () {
        addUser();
   })

};

var baseURL = '/deezer.php';

function addUser() {
    var xhr = new XMLHttpRequest();
    var data = getData("form-create-user");

    if(countProperties(data)<=0 || data['name']=='' || data['']){
        alert('Please supply data to create a user');
        return;
    }

    data['controller']  = 'user';

    xhr.open('PUT', baseURL);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var userInfo = JSON.parse(xhr.responseText);
            console.log(userInfo);
        }else{
            console.log(xhr.status);
            console.log(xhr.message);
        }
    };

    xhr.send(JSON.stringify(data));
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

            if(tagType == 'text' || tagType == 'number' || tagType == 'date' || tagType == 'radio'){
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
