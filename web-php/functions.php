<?php
// koneksi ke database
$db_conn = mysqli_connect("localhost", "root", "", "raihanweb");

function query($query)
{
    global $db_conn;
    $result = mysqli_query($db_conn, $query);
    if (!$result) {
        echo "Query Error" . mysqli_error($db_conn);
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getUserData($userdata)
{
    return query("SELECT * FROM users WHERE username = '$userdata'");
}

function insertProject($data)
{
    global $db_conn;

    $name = htmlspecialchars($data["name"]);
    $short_desc = htmlspecialchars($data["short_desc"]);
    $long_desc = htmlspecialchars($data["long_desc"]);
    $url = htmlspecialchars($data["url"]);
    $username = htmlspecialchars($data["username"]);


    // upload gambar
    $image = upload();
    if (!$image) {
        return false;
    }
    // query insert data
    $query = "INSERT INTO project 
    VALUES ('', '$name', '$short_desc', '$long_desc','$url','$username', '$image')";

    mysqli_query($db_conn, $query);

    return mysqli_affected_rows($db_conn);
}

function upload()
{
    $namaFile = $_FILES['image']['name'];
    $ukuranFile = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script> alert('pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    // cek yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script> alert('yang anda upload bukan gambar!');</script>";
        return false;
    }

    // cek jika ukuran gambar terlalu besar
    if ($ukuranFile > 10000000) {
        echo "<script> alert('ukuran gambar terlalu besar!');</script>";
        return false;
    }

    // lolo pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function delete($id)
{
    global $db_conn;

    // query deid
    mysqli_query($db_conn, "DELETE FROM project WHERE id=$id");

    return mysqli_affected_rows($db_conn);
}
function getTotalData($keyword = '')
{
    if ($keyword) {
        return count(search($keyword));
    }
    return count(query("SELECT * FROM project"));
}

function getProjectData($keyword = '', $awalData, $jumlahDataPerHalaman)
{
    if ($keyword) {
        return paginationForSearch($keyword, $awalData, $jumlahDataPerHalaman);
    }
    return query("SELECT * FROM project LIMIT $awalData, $jumlahDataPerHalaman");
}

function update($data)
{
    global $db_conn;

    $id = $data["id"];
    $name = htmlspecialchars($data["name"]);
    $short_desc = htmlspecialchars($data["short_desc"]);
    $long_desc = htmlspecialchars($data["long_desc"]);
    $url = htmlspecialchars($data["url"]);
    $oldImage = htmlspecialchars($data["oldImage"]);

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['image']['error'] === 4) {
        $image = $oldImage;
    } else {
        $image = upload();
    }

    // query insert data
    $query = "UPDATE project SET name = '$name',short_desc = '$short_desc' ,long_desc = '$long_desc', url = '$url',
    image = '$image' WHERE id = $id ";

    mysqli_query($db_conn, $query);

    return mysqli_affected_rows($db_conn);
}

function search($keyword)
{
    $query = "SELECT * FROM project WHERE name LIKE '%$keyword%'OR 
    short_desc LIKE '%$keyword%' OR username LIKE '%$keyword%' ";

    return query($query);
}
function paginationForSearch($keyword, $awalData, $jumlahDataPerHalaman)
{
    $query = "SELECT * FROM project WHERE name LIKE '%$keyword%'OR 
    short_desc LIKE '%$keyword%' OR username LIKE '%$keyword%'
    LIMIT $awalData,$jumlahDataPerHalaman ";

    return query($query);
}
function register($data)
{
    global $db_conn;

    $username = strtolower(stripslashes($data["reg_username"]));
    $password = mysqli_real_escape_string($db_conn, $data["reg_password"]);
    $password2 = mysqli_real_escape_string($db_conn, $data["reg_password2"]);
    $email = strtolower($data["email"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($db_conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        return 50; // value for username exist
    }
    // cek konfirmasi password
    if ($password !== $password2) {
        return 55; // value for password doesnt match
    }

    // enkripsi password pake algoritma default yang terus di update oleh php
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan data user ke database
    mysqli_query($db_conn, "INSERT INTO users VALUES ('', '$username', '$password','$email')");

    return mysqli_affected_rows($db_conn);
}

function live_validate_register($username, $password1, $password2)
{
    global $db_conn;

    $usernameToCheck = strtolower(stripslashes($username));
    $password = mysqli_real_escape_string($db_conn, $password1);
    $passwordConfirm = mysqli_real_escape_string($db_conn, $password2);

    //cek username sudah ada atau belum
    if ($usernameToCheck !== "") {
        $result = mysqli_query($db_conn, "SELECT username FROM users WHERE username = '$username'");
        if (mysqli_fetch_assoc($result)) {
            return 50; // value for username exist
        }
    }
    // cek konfirmasi password
    if ($password !== "" && $passwordConfirm !== "") {
        if ($password !== $password2) {
            return 55; // value for password doesnt match
        }
    }
    return 1;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>