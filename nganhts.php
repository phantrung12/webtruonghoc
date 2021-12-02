<?php
require_once "include/header.php";
require_once "include/navbar.php";
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quản lý <strong>Ngành học</strong></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">
                  DataTables Example
                </h6> -->
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addNHModal">
                Thêm Ngành học
            </button>
            <button type="button" class="btn btn-secondary btn-md" data-toggle="modal" data-target="#excelModal">
                Nhập từ file Excel
            </button>
            <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modelId">
                Xóa
            </button>
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
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>ID</th>
                            <th>Mã Ngành học</th>
                            <th>Tên ngành học</th>
                            <th>Chỉ tiêu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include file config.php
                        require_once "config.php";
                        
                        // Cố gắng thực thi truy vấn
                        $sql = "SELECT * FROM nganhts";
                        $i=1;
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                        ?>
                        <tr id="<?php echo $row["id"]; ?>">
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" class="user_checkbox" data-ad-id="<?php echo $row["id"]; ?>">
                                    <label for="checkbox2"></label>
                                </span>
                            </td>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row["manganh"]; ?></td>
                            <td><?php echo $row["tennganh"]; ?></td>
                            <td><?php echo $row["chitieu"]; ?></td>
                            <td>
                                <input hidden type="text" value="<?php echo $row["id"]?>">
                                <button type="button" class="btn btn-success viewNH" id="view_nh_btn"
                                    data-nh-id="<?php echo $row["id"]?>"><i class="fa fa-eye"
                                        aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-primary editNH" id="edit_nh_btn"
                                    data-nh-id="<?php echo $row["id"]?>" data-nh-ma="<?php echo $row["manganh"]; ?>"
                                    data-nh-ten="<?php echo $row["tennganh"]; ?>"
                                    data-nh-ct="<?php echo $row["chitieu"]; ?>"><i class="fa fa-edit"
                                        aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger deleteNH" id="delete_nh_btn"
                                    data-nh-id="<?php echo $row["id"]?>"><i class="fa fa-trash"
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
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->


<!--Add Modal -->
<div class="modal fade" id="addNHModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Ngành học</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="savenganh.php" method="POST" id="ng_form">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Mã ngành</label>
                        <input type="text" class="form-control" id="manganh" name="manganh" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Tên ngành học</label>
                        <input type="text" class="form-control" id="tennganh" name="tennganh" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Chỉ tiêu</label>
                        <input type="text" class="form-control" id="chitieu" name="chitieu" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_nh_btn">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->

<div class="modal fade" id="editNHModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa thông tin ngành học</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_form_nh" action="savenganh.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="u_id" id="u_id">
                    <div class="form-group">
                        <label class="col-form-label">Mã ngành</label>
                        <input type="text" class="form-control" id="u_manganh" name="u_manganh" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Tên ngành</label>
                        <input type="text" class="form-control" id="u_tennganh" name="u_tennganh" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Chỉ tiêu</label>
                        <input type="text" class="form-control" id="u_chitieu" name="u_chitieu" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="update_nh_btn">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewNHModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thông tin ngành học</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Mã ngành</label>
                        <input type="text" class="form-control" id="v_manganh">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Tên ngành</label>
                        <input type="text" class="form-control" id="v_tennganh">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Chỉ tiêu</label>
                        <input type="text" class="form-control" id="v_chitieu">
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
<div class="modal fade" id="deleteNHModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa Ngành học</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_form_ad" action="savenganh.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="d_id" id="d_id">
                    <p>Bạn có chắc chắn muốn xóa ngành học này này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="delete_nh_btn">Xóa</button>
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
            <form id="delete_form_ad" action="savenganh.php" method="POST">
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
    $(document).on('click', '.editNH', function() {
        $('#editNHModal').modal('show');
        // $tr = $(this).closest('tr');
        // var data = $tr.children("td").map(function() {
        //     return $(this).text();
        // }).get();
        // console.log(data);
        var id = $(this).attr("data-nh-id");
        var ma = $(this).attr("data-nh-ma");
        var ten = $(this).attr("data-nh-ten");
        var ct = $(this).attr("data-nh-ct");
        $('#u_id').val(id);
        $('#u_manganh').val(ma);
        $('#u_tennganh').val(ten);
        $('#u_chitieu').val(ct);
    });
    $(document).on('click', '.viewNH', function() {
        $('#viewNHModal').modal('show');
        var id = $(this).attr("data-nh-id");
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(id);
        console.log(data);
        $('#v_id').val(id);
        $('#v_manganh').val(data[2]);
        $('#v_tennganh').val(data[3]);
        $('#v_chitieu').val(data[4]);
    });
    $(document).on('click', '.deleteNH', function() {
        $('#deleteNHModal').modal('show');
        var id = $(this).attr("data-nh-id");
        console.log(id);
        $('#d_id').val(id);
    })
})
</script>
<script src="/admin.js"></script>
<?php
require_once "include/scripts.php";
require_once "include/footer.php";
?>