<?php
require_once "include/header.php";
require_once "include/navbar.php";
require_once("security.php");
require_once "config.php";

$sql = "SELECT * FROM nganhts";
$result = mysqli_query($conn, $sql);

?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quản lý <strong>Đơn tuyển sinh</strong></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addDtsModal">
                Thêm Đơn
            </button>
            <button type="button" class="btn btn-secondary btn-md" data-toggle="modal" data-target="#excelModal">
                Nhập từ file Excel
            </button>
            <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modelId">
                Xóa
            </button>
            <select name="nganh" id="nganh" class="mx-3" onchange="chonNganh()">
                <option value="1">Tất cả</option>
                <?php while($row =  mysqli_fetch_array($result)){
                ?>
                <option value="<?php echo $row["manganh"] ?>"><?php echo $row["tennganh"] ?></option>
                <?php }
                ?>
            </select>
        </div>
        <?php
            if(isset($_SESSION['status_code']) && $_SESSION['status_code'] === "success"){
                echo '<p>' .$_SESSION['status']. '</p>';
                unset($_SESSION['status']);
            }else if(isset($_SESSION['status_code']) && $_SESSION['status_code'] === "error"){
                echo '<p>' .$_SESSION['status']. '</p>';
                unset($_SESSION['status']);
            } else if(isset($_SESSION['status_code']) && $_SESSION['status_code'] === "warning"){
                echo '<p>' .$_SESSION['status']. '</p>';
                unset($_SESSION['status']);
            }
        ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Ngày sinh</th>
                            <th>Địa chỉ</th>
                            <th>Giới tính</th>
                            <!-- <th>Ngành đăng kí</th> -->
                            <th>Trạng thái</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ans">
                        <?php
                        require_once "config.php";
                        
                        $sql = "SELECT * FROM donts";
                        $i=1;
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                        ?>
                        <tr id="<?php echo $row["id"]; ?>">

                            <td><?php echo $i; ?></td>
                            <td><?php echo $row["hoten"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["ngaysinh"]; ?></td>
                            <td><?php echo $row["diachi"]; ?></td>
                            <td><?php if($row["gioitinh"] == 0){echo "Nữ";} else echo "Nam" ;?></td>
                            <!-- <td><?php echo $row["nganhts"]; ?></td> -->
                            <td><?php if($row["trangthai"] == 0){echo "Chưa duyệt";} else echo "Đã duyệt" ; ?></td>
                            <td>
                                <input hidden type="text" value="<?php echo $row['id']?>">
                                <button type="button" class="btn btn-sm btn-success viewD" id="view_dts_btn"
                                    data-id="<?php echo $row["id"]?>" data-ht="<?php echo $row["hoten"]?>"
                                    data-email="<?php echo $row["email"]?>" data-ns="<?php echo $row["ngaysinh"]?>"
                                    data-sdt="<?php echo $row["sdt"]?>" data-dc="<?php echo $row["diachi"]?>"
                                    data-gt="<?php echo $row["gioitinh"]?>" data-nts="<?php echo $row["nganhts"]?>"
                                    data-tt="<?php echo $row["trangthai"]?>"><i class="fa fa-eye"
                                        aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-sm btn-primary editD" id="edit_dts_btn"
                                    data-id="<?php echo $row["id"]?>" data-ht="<?php echo $row["hoten"]?>"
                                    data-email="<?php echo $row["email"]?>" data-ns="<?php echo $row["ngaysinh"]?>"
                                    data-sdt="<?php echo $row["sdt"]?>" data-dc="<?php echo $row["diachi"]?>"
                                    data-gt="<?php echo $row["gioitinh"]?>" data-nts="<?php echo $row["nganhts"]?>"
                                    data-tt="<?php echo $row["trangthai"]?>"><i class="fa fa-edit"
                                        aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-sm btn-danger deleteD" id="delete_dts_btn"
                                    data-id="<?php echo $row["id"]?>"><i class="fa fa-trash"
                                        aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <?php
                                $i++;
                                }
                                mysqli_free_result($result);
                            }else{
                                echo "<p class='lead'><em>Không tìm thấy bản ghi.</em></p>";
                            } 
                        }else{
                            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
                        }
                        // Đóng kết nối
                        //mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->


<!--Add Modal -->
<div class="modal fade" id="addDtsModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="savedon.php" method="POST" id="ad_form">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="hoten" name="hoten" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="sdt" name="sdt" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="message-text" class="col-form-label">Giới tính </label>
                            <select name="gioitinh" id="gioitinh" class="form-control" required>
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="message-text" class="col-form-label">Ngành đăng kí</label>
                            <select name="nganhts" id="nganhts" class="form-control">
                                <?php
                            require_once "config.php";
                            
                            $sql2 = "SELECT * FROM nganhts";
                            if($result = mysqli_query($conn, $sql2)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                            ?>
                                <option value="<?php echo $row["manganh"];?>"><?php echo $row["tennganh"]; ?></option>
                                <?php
                                    }
                                }else echo "Không tìm thấy ngành nào";
                            } else echo "ERROR: Không thể thực thi $sql2. " . mysqli_error($conn);
                            //mysqli_close($conn);
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="diachi" name="diachi" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Trường THPT</label>
                        <input type="text" class="form-control" id="truong" name="truong" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn-add-dts">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->

<div class="modal fade" id="editDtsModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa thông tin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="savedon.php" method="POST" id="ad_form">
                <div class="modal-body">

                    <input type="hidden" name="u_id" id="u_id">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="u_hoten" name="u_hoten" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="u_email" name="u_email" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="u_ngaysinh" name="u_ngaysinh" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="u_sdt" name="u_sdt" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="message-text" class="col-form-label">Giới tính </label>
                            <select name="u_gioitinh" id="u_gioitinh" class="form-control" required>
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="message-text" class="col-form-label">Ngành đăng kí</label>
                            <select name="u_nganhts" id="u_nganhts" class="form-control">
                                <?php
                            require_once "config.php";
                            
                            $sql3 = "SELECT * FROM nganhts";
                            if($result = mysqli_query($conn, $sql3)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                            ?>
                                <option value="<?php echo $row["manganh"];?>"><?php echo $row["tennganh"]; ?></option>
                                <?php
                                    }
                                }else echo "Không tìm thấy ngành nào";
                            } else echo "ERROR: Không thể thực thi $sql3. " . mysqli_error($conn);
                            //mysqli_close($conn);
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="u_diachi" name="u_diachi" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Trạng thái</label>
                        <select name="u_trangthai" id="u_trangthai" class="form-control" required>
                            <option value="1">Phê duyệt</option>
                            <option value="0">Chưa duyệt</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn-edit-dts">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewDtsModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thông tin đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="savedon.php" method="POST" id="ad_form">
                <div class="modal-body">

                    <input type="hidden" name="v_id" id="v_id">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="v_hoten" name="v_hoten" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="v_email" name="v_email" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="v_ngaysinh" name="v_ngaysinh" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="v_sdt" name="v_sdt" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="message-text" class="col-form-label">Giới tính </label>
                            <select name="v_gioitinh" id="v_gioitinh" class="form-control" required>
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="message-text" class="col-form-label">Ngành đăng kí</label>
                            <select name="v_nganhts" id="v_nganhts" class="form-control">
                                <?php
                            require_once "config.php";
                            
                            $sql3 = "SELECT * FROM nganhts";
                            if($result = mysqli_query($conn, $sql3)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                            ?>
                                <option value="<?php echo $row["manganh"];?>"><?php echo $row["tennganh"]; ?></option>
                                <?php
                                    }
                                }else echo "Không tìm thấy ngành nào";
                            } else echo "ERROR: Không thể thực thi $sql3. " . mysqli_error($conn);
                            //mysqli_close($conn);
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="v_diachi" name="v_diachi" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Trạng thái</label>
                        <select name="v_trangthai" id="v_trangthai" class="form-control" required>
                            <option value="1">Phê duyệt</option>
                            <option value="0">Chưa duyệt</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteDtsModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_form_ad" action="savedon.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="d_id" id="d_id">
                    <p>Bạn có chắc chắn muốn xóa thông tin Admin này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn-delete-dts">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- IMPORT EXCEL MODAL -->
<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import từ file Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_form_ad" action="savedon.php" method="POST">
                <div class="modal-body">
                    <input type="file" name="file" id="file" class="">
                    <button type="submit" name="btnImport" class="btn btn-success btn-md">Import</button>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ------------------------------------------------------ -->


<script>
$('#exampleModal').on('show.bs.modal', event => {
    var button = $(event.relatedTarget);
    var modal = $(this);
    // Use above variables to manipulate the DOM

});
</script>
<script>
$(document).ready(function() {
    $(document).on('click', '.editD', function() {
        $('#editDtsModal').modal('show');
        var id = $(this).attr("data-id");
        $('#u_id').val(id);
        $('#u_hoten').val($(this).attr("data-ht"));
        $('#u_email').val($(this).attr("data-email"));
        $('#u_ngaysinh').val($(this).attr("data-ns"));
        $('#u_sdt').val($(this).attr("data-sdt"));
        $('#u_diachi').val($(this).attr("data-dc"));
        $('#u_gioitinh').val($(this).attr("data-gt"));
        $('#u_nganhts').val($(this).attr("data-nts"));
        $('#u_trangthai').val($(this).attr("data-tt"));
    });
    $(document).on('click', '.viewD', function() {
        $('#viewDtsModal').modal('show');
        var id = $(this).attr("data-id");
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#v_id').val(id);
        $('#v_hoten').val($(this).attr("data-ht"));
        $('#v_email').val($(this).attr("data-email"));
        $('#v_ngaysinh').val($(this).attr("data-ns"));
        $('#u_sdt').val($(this).attr("data-sdt"));
        $('#v_diachi').val($(this).attr("data-dc"));
        $('#v_gioitinh').val($(this).attr("data-gt"));
        $('#v_nganhts').val($(this).attr("data-nts"));
        $('#v_trangthai').val($(this).attr("data-tt"));
    });
    $(document).on('click', '.deleteD', function() {
        $('#deleteDtsModal').modal('show');
        var id = $(this).attr("data-id");
        console.log(id);
        $('#d_id').val(id);
    })
})
</script>
<!-- <script src="/admin.js"></script> -->
<?php
require_once "include/scripts.php";
require_once "include/footer.php";
?>