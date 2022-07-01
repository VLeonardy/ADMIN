<?php include "a_header.php";
$sukses = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
?>

<!-- select date -->
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
                </div>
                <input type="submit" name=table value="Submit" id="table">
            </div>
        </div>
    </form>
</form>
<script type="text/javascript">
    $(function() {
        $('#table_name').datepicker({
            format: 'ddMMyyyy'
        });

    });
</script>


<!-- EXPORT DATA -->
<!-- <div>
    <p>
        <a href="export.php">
            <a href="export.php" target='_blank' type='button' class='btn btn-secondary' style="background-color:green; border-color:green;">
                <span class='glyphicon glypicon-export'>
                    <i class="fa-solid fa-file-export"></i>
                    Export
                </span>
            </a>
    </p>
</div> -->


<!-- Alert Delete Data -->
<?php
if ($sukses) {
}
?>

<!-- Search -->
<div class="alert alert-primary" role="alert">
    <?php echo $sukses; ?>
</div>

<form class="" method="get">
    <tr>
        <td>
            <input type="text" class="" placeholder="Masukkan kata kunci" name="katakunci" value="<?php echo $katakunci ?>" />
        </td>
        <td>
            <input type="submit" name="cari" value="Cari Tulisan" class="btn btn-secondary" />
        </td>
    </tr>
    <br>
</form>

<!-- edit table and delete -->
<style>
    .table,
    thead,
    tr,
    th,
    td {
        border: 1px solid black;
    }
</style>
<style>
    .edit,
    .delete {
        width: 30px;
        height: 30px;
    }
</style>



<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        DataTable
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="Table" width="100%" cellspacing="0">
                <tr>
                    <th width="50">STT</th>
                    <th width="100">NamaPengirim</th>
                    <th width="100">NoHpPengirim</th>
                    <th width="100">NamaPenerima</th>
                    <th width="100">NoHpPenerima</th>
                    <th width="400">Alamat</th>
                    <th width="50">Koli</th>
                    <th width="50">Kilo</th>
                    <th width="200">JenisBarang</th>
                    <th>#</th>
                </tr>


                <tbody border='1'>
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
                            JenisBarang like '%" . $array_katakunci[$x] . "%' 
                            or Koli like '%" . $array_katakunci[$x] . "%' or 
                            Kilo like '%" . $array_katakunci[$x] . "%'or 
                            Agent like '%" . $array_katakunci[$x] . "%' or
                            STT like '%" . $array_katakunci[$x] . "%')";
                        }
                        $sqltambahan    = " where " . implode(" or ", $sqlcari);
                    }

                    // untuk menampilkan data dan page  

                    if (isset($_POST['table'])) {
                        $table_name = mysqli_real_escape_string($koneksi, $_POST['table_name']);
                        $table5 = "SELECT * FROM $table_name";

                        $res5 = mysqli_query($koneksi, $table5);
                        echo '<script languange="javascript">';
                        echo '</script>';
                    }


                    // while($table = mysqli_fetch_array($showtables)) { // go through each row that was returned in $result
                    //     echo($table[0] . "<br>");    // print the table that was returned on that row.
                    // }

                    $q1     = mysqli_query($koneksi, $table5);

                    while ($r1 = mysqli_fetch_array($q1)) { {
                            echo "
        <tr>
            <td align='center'>$r1[STT]</td>
            <td>$r1[NamaPengirim]</td>
            <td>$r1[NoHpPengirim]</td>
            <td>$r1[NamaPenerima]</td>
            <td>$r1[NoHpPenerima]</td>
            <td>$r1[Alamat]</td>
            <td>$r1[Koli]</td>
            <td>$r1[Kilo]</td>
            <td>$r1[JenisBarang]</td>
            <td>
            <button class='edit'>
            <a href='halaman_update.php?update=$r1[STT]'>
            <input type='button' value='Edit' class='fa-solid fa-pen-to-square' class='edit'>
            </button>
            </td>

            <td>
            </a>
            <button class='delete'>
                <a href='?hapus=$r1[STT]' onClick=\"return confirm('Yakin akan menghapus data?');\"> 
                <input type='button' value='Hapus' class='fa-solid fa-trash-can'>
                </a>            
            </button>

             </td>
        <tr>";
                        }
                    }
                    ?>


                    <!-- hapus data -->
                    <div class="alert alert-primary" role="alert">
                        <?php
                        if (isset($_GET['hapus'])) {

                            mysqli_query($koneksi, "delete from $table_name where STT='$_GET[hapus]'")
                                or die(mysqli_error($koneksi));

                            echo "<p><b> Data berhasil dihapus</b> </p>";
                            echo "<meta http-equiv=refresh content=2;URL='pilihtable.php'>";
                        }
                        ?>
                    </div>

                </tbody>
            </table>
        </div>
    </div>
</div>
