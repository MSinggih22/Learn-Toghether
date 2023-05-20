<?php
                require_once '../database-connect.php';
                function getTopicsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM topics";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Title: " . $row["title"] . "<br>";
                            echo "Description: " . $row["description"] . "<br>";
                            echo "Views: " . $row["views"] . "<br>";
                            echo "Comments: " . $row["comments"] . "<br>";
                            echo "Followers: " . $row["followers"] . "<br>";
                            echo "Image: <img src=''><br>";
                            echo "Created At: " . $row["created_at"] . "<br><br>";
                            echo "<a href='delete-topic.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No topics found.";
                    }
                }

                function getUsersSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM users";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "Username: " . $row["username"] . "<br>";
                            echo "Email: " . $row["email"] . "<br>";
                            echo "Password: " . $row["password"] . "<br>";
                            echo "User Image: <img src='' '><br>";
                            echo "Post Created Count: " . $row["post_created_count"] . "<br>";
                            echo "Registration Date: " . $row["reg_date"] . "<br><br>";
                            echo "<a href='delete_user.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No users found.";
                    }
                }

                // Fungsi untuk mendapatkan semua pengaturan dari tabel topics_comments
                function getTopicsCommentsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM topics_comments";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Topic ID: " . $row["topic_id"] . "<br>";
                            echo "Comment: " . $row["comment"] . "<br>";
                            echo "Created At: " . $row["created_at"] . "<br><br>";
                            echo "<a href='delete_comment.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No comments found.";
                    }
                }

                // Fungsi untuk mendapatkan semua pengaturan dari tabel topic_views
                function getTopicViewsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM topic_views";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Topic ID: " . $row["topic_id"] . "<br>";
                            echo "Viewed At: " . $row["viewed_at"] . "<br><br>";
                            echo "<a href='delete_view.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No views found.";
                    }
                }

                // Fungsi untuk mendapatkan semua pengaturan dari tabel sessions
                function getSessionsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM sessions";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Token: " . $row["token"] . "<br><br>";
                            echo "<a href='delete_session.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No sessions found.";
                    }
                }

                // Fungsi untuk menampilkan semua pengaturan
                function displayAllSettings()
                {
                    echo "<h2>Topics Settings</h2>";
                    getTopicsSettings();

                    echo "<h2>Users Settings</h2>";
                    getUsersSettings();

                    echo "<h2>Topics Comments Settings</h2>";
                    getTopicsCommentsSettings();

                    echo "<h2>Topic Views Settings</h2>";
                    getTopicViewsSettings();

                    echo "<h2>Sessions Settings</h2>";
                    getSessionsSettings();
                }

                // Memeriksa apakah pengguna telah login sebagai admin
                function isAdminLoggedIn()
                {
                    // Implementasi login admin di sini, misalnya menggunakan session
                    // Kembalikan true jika admin sudah login, false jika tidak
                    // Contoh sederhana:
                    session_start();
                    if (isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true) {
                        return true;
                    } else {
                        return false;
                    }
                }

                // Memeriksa status login admin sebelum menampilkan menu admin
                if (isAdminLoggedIn()) {
                    // Tampilkan menu admin dan pengaturan
                    displayAllSettings();
                } else {
                    // Redirect ke halaman login admin jika belum login
                    header("Location: admin_login.php");
                    exit();
                }

                // Tutup koneksi ke database
                mysqli_close($conn);
