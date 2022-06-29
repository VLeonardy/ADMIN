<?php include("a_header.php") ?>
<?php
$sukses = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
date("j F Y")
// proses menghapus data
// if (isset($_GET['op'])) {
//     $op = $_GET['op'];
// } else {
//     $op = "";
// }
// if ($op == 'delete') {
//     $STT = $_GET['STT'];
//     $sql = "DELETE FROM datapengiriman WHERE STT = '$STT'";
//     $q1 = mysqli_query($koneksi, $sql);
//     if ($q1) {
//         $sukses = "Sukses Menghapus Data";
//     }
// }

?>

<h1>Halaman Admin</h1>

<!-- Untuk pergi ke halaman baru -->


<p>
    <a href="halaman_input.php">
        <input type="button" class="btn btn-primary" value="Buat Halaman Baru" />
    </a>
</p>

<!-- Alert Delete Data -->
<?php
if ($sukses) {
}
?>

<form action="" method="post">
<form>
            <div class="row form-group">
                <label for="date" class="col-sm-1 col-form-label">Select Date</label>
                <div class="col-sm-2">
                    <div class="input-group date" id="table_name" name="table_name">
                        <input type="text" class="form-control" name="table_name">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>    
                        
                    </div><input type="submit" name=create_table value="Submit" id="create_table">
                </div>
            </div>
        </form>


</form>
<script type="text/javascript">
    $(function(){
        $('#table_name').datepicker({
            format : 'dd MM yyyy'
        });
 
    });
</script>

<?php
if (isset($_POST['create_table'])) {

    $table_name = mysqli_real_escape_string($koneksi, $_POST['table_name']);
    $result = mysqli_query($koneksi, "show tables like '" . $table_name . "'");
    if ($result->num_rows == 1) {
        echo '<script language="javascript">';
        echo 'alert("Table exist, Please Try Again")';
        echo '</script>';
    } else {
        $table5 = "CREATE TABLE $table_name 
        (STT INT(250) PRIMARY KEY NOT NULL, 
        Agent VARCHAR(255) NOT NULL, 
        NamaPengirim VARCHAR(255), 
        NoHpPengirim INT(255),
        NamaPenerima VARCHAR(255), 
        NoHpPenerima INT(15), 
        Alamat VARCHAR(255), 
        Kilo INT(250), 
        Koli INT(250), 
        JenisBarang VARCHAR(255))";
        $res5 = mysqli_query($koneksi, $table5);
        echo '<script languange="javascript">';
        echo 'alert("Table Successfully Created")';
        echo '</script>';
    }
}
?>

<!-- <div class="alert alert-primary" role="alert">
    <?php echo $sukses; ?>
</div> -->

<div>

    <p>
        <!-- <a href="halaman_input.php">
        <input type="button" class="btn btn-primary" value="Input" />
    </a> -->

        <a href="export.php">
            <a href="export.php" target='_blank' type='button' class='btn btn-secondary' style="background-color:green; border-color:green;">
                <span class='glyphicon glypicon-export'>
                    <i class="fa-solid fa-file-export"></i>
                    Export
                </span>
            </a>
    </p>
</div>

<!-- table name -->



<!-- Alert Delete Data -->
<?php
if ($sukses) {
}
?>

<div class="alert alert-primary" role="alert">
    <?php echo $sukses; ?>
</div>

<!-- serach textfield and button -->
<form class="" method="get">
    <table></table>
    <tr>
        <td>
            <input type="text" class="" placeholder="Masukkan kata kunci" name="katakunci" value="<?php echo $katakunci ?>" />
        </td>
        <td>
            <label for="searchdate"></label>
        </td>

        <!-- filter tanggal -->
        <td>
            <!-- <input type="date" class="" id="searchdate" name="katakunci" value="<?php echo $katakunci ?>"> -->
        </td>
        <td>
            <input type="submit" name="cari" value="Cari Tulisan" class="btn btn-secondary" />
        </td>
    </tr>
    <br>
</form>


<!-- Buat Table -->

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        DataTable
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="Table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tanggal</th>
                        <th>Agent</th>
                        <th>NamaPengirim</th>
                        <th>NoHpPengirim</th>
                        <th>NamaPenerima</th>
                        <th>NoHpPenerima</th>
                        <th>Alamat</th>
                        <th>Koli</th>
                        <th>Kilo</th>
                        <th>JenisBarang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // untuk mencari data
                    $sqltambahan    = "";
                    $per_halaman    = 10;
                    if ($katakunci != '') {
                        $array_katakunci = explode(" ", $katakunci);
                        for ($x = 0; $x < count($array_katakunci); $x++) {
                            $sqlcari[] = "(NamaPengirim like'%" . $array_katakunci[$x] . "%' or 
                            NoHpPengirim like '%" . $array_katakunci[$x] . "%' or 
                            NamaPenerima like '%" . $array_katakunci[$x] . "%' or
                            NoHpPenerima like '%" . $array_katakunci[$x] . "%' or 
                            Alamat like '%" . $array_katakunci[$x] . "%' or 
                            JenisBarang like '%" . $array_katakunci[$x] . "%' or 
                            Koli like '%" . $array_katakunci[$x] . "%' or 
                            Kilo like '%" . $array_katakunci[$x] . "%'or 
                            Agent like '%" . $array_katakunci[$x] . "%' or
                            STT like '%" . $array_katakunci[$x] . "%' or 
                            Tanggal like '%" . $array_katakunci[$x] . "%')";
                        }
                        $sqltambahan    = " where " . implode(" or ", $sqlcari);
                    }


                    // untuk menampilkan data dan page
                    $sql1   = "select * from datapengiriman $sqltambahan";

                    $page   = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
                    $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
                    $q1     = mysqli_query($koneksi, $sql1);
                    $total  = mysqli_num_rows($q1);
                    $pages  = ceil($total / $per_halaman);
                    $nomor  = $mulai + 1;
                    $sql1   = $sql1 . "order by Tanggal desc limit $mulai, $per_halaman";


                    $q1     = mysqli_query($koneksi, $sql1);

                    while ($r1 = mysqli_fetch_array($q1)) {
                    ?>




                        <tr>
                            <td><?php echo $r1['STT'] ?></td>
                            <td><?php echo $r1['Tanggal'] ?></td>
                            <td><?php echo $r1['Agent'] ?></td>
                            <td><?php echo $r1['NamaPengirim'] ?></td>
                            <td><?php echo $r1['NoHpPengirim'] ?></td>
                            <td><?php echo $r1['NamaPenerima'] ?></td>
                            <td><?php echo $r1['NoHpPenerima'] ?></td>
                            <td><?php echo $r1['Alamat'] ?></td>
                            <td><?php echo $r1['Koli'] ?></td>
                            <td><?php echo $r1['Kilo'] ?></td>
                            <td><?php echo $r1['JenisBarang'] ?></td>

                            <!-- FUNGSI EDIT -->
                            <!-- <td> -->
                            <!-- <a href="halaman_input.php?STT=<?php echo $r1['STT'] ?>">
                                    <span class="badge text-bg-warning">Edit</span>
                                </a> -->

                            <!-- menghapus data dengan konfirmasi
                                <a href="halaman.php?op=delete&STT=<?php echo $r1['STT'] ?>" onClick="return confirm('Hapus Data Ini?');">

                                    <span class="badge text-bg-danger">Delete</span>
                                    <input type='button' class="badge text-bg-danger" value='Hapus' </a> -->

                            <!-- </td> -->
                        </tr>
                    <?php
                    }
                    ?>

                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Tanggal</th>
                        <th>Agent</th>
                        <th>NamaPengirim</th>
                        <th>NoHpPengirim</th>
                        <th>NamaPenerima</th>
                        <th>NoHpPenerima</th>
                        <th class=col-4>Alamat</th>
                        <th>Koli</th>
                        <th>Kilo</th>
                        <th>JenisBarang</th>
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</main>

</div>
</div>
<tbody>


</tbody>

<!-- Navigation -->
<nav aria-label="Page navigation example">
    <ul class="Pagination">
        <?php
        $cari = (isset($_GET['cari'])) ? $_GET['cari'] : "";
        for ($i = 1; $i <= $pages; $i++) {
        ?>
            <li class="page-item">
                <a class="page-link" href="halaman.php?katakunci=<?php echo $katakunci ?>&cari=<?php echo $cari ?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>

</table>

<?php
// Perintah delete
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "delete from halaman where Id = '$_GET[hapus]'")
        or die(mysqli_error($koneksi));

    echo "<p><b> Data berhasil dihapus </b></p>";
    echo "<meta http-equiv=refresh content=2;URL=halaman.php>";
}
?>



<?php include("a_footer.php") ?>