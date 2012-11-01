function ROver (obj,val) {
  obj.src = val;
}


function hydeAndSeek(id1,id2){
  var elem1 = document.getElementById(id1);
  var elem2 = document.getElementById(id2);
  elem1.style.display = elem1.style.display == "none"?"block":"none";
  elem2.style.display = elem2.style.display == "none"?"block":"none";
}
