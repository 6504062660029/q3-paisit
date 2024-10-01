function toggle_visibility(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'block')
    e.style.display = 'none';
  else
    e.style.display = 'block';
}
window.onresize = function(event) {
  var e = document.getElementById("menu");
  var w = window.innerWidth;
  if(w > 599)
    e.style.display = 'block';
  else
    e.style.display = 'none';
};
