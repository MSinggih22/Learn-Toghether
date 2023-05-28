//arrow changed scripts
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

//sidebar script
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
  arrow[i].addEventListener("click", (e) => {
    let arrowParent = e.target.parentElement.parentElement;
    arrowParent.classList.toggle("showMenu");
    let mainContent = document.querySelector(".section");
    mainContent.classList.toggle("shifted");
  });
}
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-chevron-right");
console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {
  sidebar.classList.toggle("close");
  let mainContent = document.querySelector(".section");
  mainContent.classList.toggle("shifted");
});

//forum text script
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

//prev,next page buttons script 5 views
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

//search script
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

//togle timeline comment
function toggleComments(button) {
  var commentsDiv = button.nextElementSibling;
  if (commentsDiv.style.display === "none") {
    commentsDiv.style.display = "block";
    button.innerText = "Hide Comment";
  } else {
    commentsDiv.style.display = "none";
    button.innerText = "Show Comment";
  }
}

//follow unfollow change
function changeText() {
  var button = document.getElementById("follow-button");
  if (button.innerText === "+ Follow") {
    button.innerText = "Unfollow";
  } else {
    button.innerText = "+ Follow";
  }
}

//timiline comments script
function toggleCommentForm(button) {
  var commentForm = button.nextElementSibling;
  if (commentForm.style.display === "none") {
    commentForm.style.display = "block";
    button.textContent = "Close Comment";
  } else {
    commentForm.style.display = "none";
    button.textContent = "Add Coment :";
  }
}

function toggleComments(button) {
  var commentsDiv = button.nextElementSibling;
  if (commentsDiv.style.display === "none") {
    commentsDiv.style.display = "block";
    button.innerText = "Hide Comment";
  } else {
    commentsDiv.style.display = "none";
    button.innerText = "Show Comment";
  }
}

//link youtube dengan youtube API
//link youtube dengan youtube API
function playVideo(playerId, videoId) {
  // Load the YouTube IFrame API asynchronously
  var tag = document.createElement("script");
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName("script")[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // Function to create the YouTube player after the API is loaded
  window.onYouTubeIframeAPIReady = function () {
    new YT.Player(playerId, {
      videoId: extractVideoId(videoId),
      events: {
        onReady: onPlayerReady,
      },
    });
  };

  // Function to extract the YouTube video ID from the URL
  function extractVideoId(url) {
    var videoId = "";
    if (url.indexOf("youtube.com") !== -1) {
      videoId = url.split("v=")[1];
    } else if (url.indexOf("youtu.be") !== -1) {
      videoId = url.split("youtu.be/")[1];
    } else if (url.indexOf("embed") !== -1) {
      videoId = url.split("embed/")[1];
    }
    return videoId;
  }

  // Function to start playing the video
  function onPlayerReady(event) {
    event.target.playVideo();
  }
}
