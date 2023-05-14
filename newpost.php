<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<body style="background-image: url('background-image.jpg');">
  <div class="form-container">
    <form action="#" method="post" enctype="multipart/form-data">
      <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
      </div>
      <div>
        <label for="topics">Topics:</label>
        <select id="topics" name="topics">
          <option value="technology">Technology</option>
          <option value="health">Health</option>
          <option value="business">Business</option>
          <option value="entertainment">Entertainment</option>
        </select>
      </div>
      <div>
        <label for="image">Image Upload:</label>
        <input type="file" id="image" name="image">
      </div>
      <div>
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>
</body>

<style>
  body {
    background-size: cover;
    background-position: center center;
    background-attachment: fixed;
    filter: blur(5px);
  }

  .form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.8);
  }

  form {
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
  }
</style>

</body>
</html>