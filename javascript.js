function O(el) {
  return typeof el === 'object' ? el : document.getElementById(el);
}

function S(el) {
  return O(el).style;
}

function C(name) {
  let elements = document.getElementsByTagName('*');
  let obj = [];

  for (var i = 0; i <= elements.length-1; ++i) {
    if (elements[i].className = name) 
      obj.push(elements[i]);
  }
  return obj;
}