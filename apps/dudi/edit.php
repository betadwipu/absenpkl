<?php
session_start();
    if (isset($_POST['edit_dudi'])) {
        
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Memulai transaksi
            mysqli_query($kon,"START TRANSACTION");
            $id_dudi=input($_POST["id_dudi"]);
            $nama=input($_POST["nama"]);
            $nip=input($_POST["nip"]);
            $email=input($_POST["email"]);

            //Query unutk update tbl_admin
            $sql="UPDATE tbl_dudi SET 
            nama='$nama', 
            nip='$nip', 
            email='$email'
            WHERE id_dudi=$id_dudi";
                
            //Mengeksekusi query 
            $edit_dudi=mysqli_query($kon,$sql);

            //validasi jika data admin berhasil di update
            if ($edit_dudi) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../index.php?page=dudi&edit=berhasil");
            }
            else {
            //validasi jika data admin berhasil di update
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../index.php?page=dudi&edit=gagal");
            }
        }
    }
?>

<?php 
    include '../../config/database.php';
    $id_dudi=$_POST["id_dudi"];
    $sql="select * from tbl_dudi where id_dudi=$id_dudi limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>

<form action="apps/dudi/edit.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-7">
                <input type="hidden" name="id_dudi" class="form-control" value="<?php echo $data['id_dudi'];?>">
            <div class="form-group">
                <label>Nama Lengkap :</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'];?>" placeholder="Masukan Nama Lengkap" required>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label>Nomor Induk Pegawai (NIP) :</label>
                <input type="text" name="nip" class="form-control"  value="<?php echo $data['nip']; ?>" placeholder="Masukan Nomor Induk Pegawai" required>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" class="form-control" value="<?php echo $data['email'];?>" placeholder="Masukan Email" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <br>
                <button type="submit" name="edit_dudi" id="Submit" class="btn btn-warning" ><i class="fa fa-edit"></i> Update</button>
            </div>
        </div>
    </div>
</form>

<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>