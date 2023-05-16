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


// function createNewBox() {
//   const newBox = document.createElement("div");
//   newBox.classList.add("box");
//   newBox.style.top = mainBox.getBoundingClientRect().bottom + 200 + "px"; // position new box 200px below main box

//   const boxImage = document.createElement("div");
//   boxImage.classList.add("box-image");
//   const image = document.createElement("img");
//   image.src = "image/tes.png";
//   image.alt = "Image description";
//   image.classList.add("box-image");
//   boxImage.appendChild(image);
//   newBox.appendChild(boxImage);

//   const boxContent = document.createElement("div");
//   boxContent.classList.add("box-content");
//   const boxTitle = document.createElement("div");
//   boxTitle.classList.add("box-title");
//   const titleLink = document.createElement("a");
//   titleLink.href = "#";
//   const titleHeading = document.createElement("h2");
//   titleHeading.textContent = "New Box Title";
//   titleLink.appendChild(titleHeading);
//   boxTitle.appendChild(titleLink);
//   boxContent.appendChild(boxTitle);
//   const boxDescription = document.createElement("div");
//   boxDescription.classList.add("box-description");
//   const descriptionText = document.createElement("p");
//   descriptionText.textContent =
//     "This is a brief description of the new box content.";
//   boxDescription.appendChild(descriptionText);
//   boxContent.appendChild(boxDescription);
//   newBox.appendChild(boxContent);

//   const boxButtons = document.createElement("div");
//   boxButtons.classList.add("box-buttons");
//   const viewsButton = document.createElement("button");
//   viewsButton.classList.add("box-button", "bx", "bx-show");
//   viewsButton.textContent = "100 Views";
//   const commentsButton = document.createElement("button");
//   commentsButton.classList.add("box-button", "bx", "bx-comment");
//   commentsButton.textContent = "10 Comments";
//   const followersButton = document.createElement("button");
//   followersButton.classList.add("box-button", "bx", "bx-user-plus");
//   followersButton.textContent = "10 Followers";
//   boxButtons.appendChild(viewsButton);
//   boxButtons.appendChild(commentsButton);
//   boxButtons.appendChild(followersButton);
//   newBox.appendChild(boxButtons);

//   mainBox.insertAdjacentElement("afterend", newBox);
//   mainBox = newBox; // update mainBox to reference the newly created box
// }

// createBoxBtn.addEventListener("click", createNewBox);
