function getName(params) {

    return params.split('').join(' ')
}
console.log(getName("Hornel"));

function getName2(name){
    var data="";
    for (var index = 0; index < name.length; index++) {
        data+=name[index]+" ";
    }
    return data.trim();
}
console.log("Name:",getName2("LAMA"));