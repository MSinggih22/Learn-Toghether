function chonclick(element) {
  let currentClass = element.getAttribute("class");
  if (currentClass.includes("bx-chevron-right")) {
    element.setAttribute("class", "bx bx-chevron-left");
  } else {
    element.setAttribute("class", "bx bx-chevron-right");
  }
}
function openSidebar() {
  document.body.classList.add("sidebar-open");
}
function closeSidebar() {
  document.body.classList.remove("sidebar-open");
}

function truncateText() {
  const descriptions = document.querySelectorAll(".box-description p");
  const limit = 70;

  descriptions.forEach((description) => {
    const text = description.textContent.trim();
    const words = text.split(" ");
    const truncatedText = words.slice(0, limit).join(" ") + "...";
    description.textContent = truncatedText;
  });
}
truncateText();

function toggleMenu() {
  let arrowParent = this.parentElement.parentElement;
  arrowParent.classList.toggle("showMenu");
  let mainContent = document.querySelector(".section");
  mainContent.classList.toggle("shifted");
}

function toggleSidebar() {
  let sidebar = document.querySelector(".sidebar");
  sidebar.classList.toggle("close");
  let mainContent = document.querySelector(".section");
  mainContent.classList.toggle("shifted");
}

let arrows = document.querySelectorAll(".arrow");
arrows.forEach((arrow) => {
  arrow.addEventListener("click", toggleMenu);
});

// Attach event listener to sidebar button
let sidebarBtn = document.querySelector(".bx-chevron-right");
sidebarBtn.addEventListener("click", toggleSidebar);

var boxesContainer = document.getElementById("boxes");
var paginationContainer = document.getElementById("pagination");
var prevBtn = document.getElementById("prevBtn");
var nextBtn = document.getElementById("nextBtn");

var boxes = boxesContainer.getElementsByClassName("box");
var totalPages = Math.ceil(boxes.length / 5);

var currentPage = 1;
var boxesPerPage = 5;

function showPage(pageNumber) {
  var startIndex = (pageNumber - 1) * boxesPerPage;
  var endIndex = startIndex + boxesPerPage;

  for (var i = 0; i < boxes.length; i++) {
    boxes[i].classList.add("hidden");
  }
  for (var j = startIndex; j < endIndex; j++) {
    if (j >= boxes.length) {
      break;
    }
    boxes[j].classList.remove("hidden");
  }

  prevBtn.disabled = pageNumber === 1;
  nextBtn.disabled = pageNumber === totalPages;
}

function goToNextPage() {
  if (currentPage < totalPages) {
    currentPage++;
    showPage(currentPage);
  }
}

function goToPrevPage() {
  if (currentPage > 1) {
    currentPage--;
    showPage(currentPage);
  }
}

showPage(currentPage);
prevBtn.addEventListener("click", goToPrevPage);
nextBtn.addEventListener("click", goToNextPage);

const loginBtn = document.querySelector(".btn-login");
const registerBtn = document.querySelector(".btn-register");
loginBtn.addEventListener("click", () => {
  console.log("Login button clicked");
});
registerBtn.addEventListener("click", () => {
  console.log("Register button clicked");
});
const searchBar = document.querySelector('input[type="text"]');
searchBar.addEventListener("keyup", function (e) {
  const term = e.target.value.toLowerCase();
  const items = document.querySelectorAll("div.item");
  Array.from(items).forEach(function (item) {
    const title = item.textContent;
    if (title.toLowerCase().indexOf(term) != -1) {
      item.style.display = "block";
    } else {
      item.style.display = "none";
    }
  });
});

function confirmDelete() {
  return confirm("Are you sure you want to delete this topic?");
}

