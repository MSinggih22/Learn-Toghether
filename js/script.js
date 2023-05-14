// function chonclick(x) {
//   x.classList.toggle("bx bx-chevron-left");
// }
function chonclick(element) {
  let currentClass = element.getAttribute("class");
  if (currentClass.includes("bx-chevron-right")) {
      element.setAttribute("class", "bx bx-chevron-left");
  } else {
      element.setAttribute("class", "bx bx-chevron-right");
  }
}
