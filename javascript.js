canvas = O('logo')
context = canvas.getContext('2d')
context.font = 'bold italic 97px Georgia'
context.textBaseline = 'top'
image = new Image()
image.src = 'robin.gif'
image.onload = function()
{
 gradient = context.createLinearGradient(0, 0, 0, 89)
 gradient.addColorStop(0.00, '#faa')
 gradient.addColorStop(0.66, '#f00')
 context.fillStyle = gradient
 context.fillText( "R bin's Nest", 0, 0)
 context.strokeText("R bin's Nest", 0, 0)
 context.drawImage(image, 64, 32)
}

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