<?php
require_once "include/header.php";
require_once "include/navbar.php";
require_once("security.php");

?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Manage <strong>Admin</strong></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">
                  DataTables Example
                </h6> -->
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addAdModal">
                Thêm Admin
            </button>
            <button type="button" class="btn btn-secondary btn-md" data-toggle="modal" data-target="#excelModal">
                Nhập từ file Excel
            </button>
            <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modelId">
                Xóa
            </button>
        </div>
        <?php
            if(isset($_SESSION['status']) && $_SESSION['status'] != ""){
                echo '<p>' .$_SESSION['status']. '</p>';
                unset($_SESSION['status']);
            }else if(isset($_SESSION['status']) && $_SESSION['status'] != ""){
                echo '<p>' .$_SESSION['status']. '</p>';
                unset($_SESSION['status']);
            } else if(isset($_SESSION['status']) && $_SESSION['status'] != ""){
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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include file config.php
                        require_once "config.php";
                        
                        // Cố gắng thực thi truy vấn
                        $sql = "SELECT * FROM admin";
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
                            <td><?php echo $row["username"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["password"]; ?></td>
                            <td>
                                <input hidden type="text" value="<?php echo $row["id"]?>">
                                <button type="button" class="btn btn-success viewAd" id="view_ad_btn"
                                    data-ad-id="<?php echo $row["id"]?>"><i class="fa fa-eye"
                                        aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-primary editAd" id="edit_ad_btn"><i
                                        class="fa fa-edit" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger deleteAd" id="delete_ad_btn"><i
                                        class="fa fa-trash" aria-hidden="true"></i></button>
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
<div class="modal fade" id="addAdModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="saveadmin.php" method="POST" id="ad_form">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="ad-username" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="ad-email" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="ad-password" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password" name="ad-cpassword" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btn-add-ad">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->

<div class="modal fade" id="editAdModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa thông tin Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_form_ad" action="saveadmin.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="u_id" id="u_id">
                    <div class="form-group">
                        <label class="col-form-label">Username</label>
                        <input type="text" class="form-control" id="u_username" name="u-username" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="u_email" name="u-email" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input type="password" class="form-control" id="u_password" name="u-password" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="message-text" class="col-form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password" name="ad-cpassword" required>
                    </div> -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="update_ad_btn">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewAdModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thông tin Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Username</label>
                        <input type="text" class="form-control" id="v_username">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="v_email">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Password</label>
                        <input type="password" class="form-control" id="v_password">
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
<div class="modal fade" id="deleteAdModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_form_ad" action="saveadmin.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="d_id" id="d_id">
                    <p>Bạn có chắc chắn muốn xóa thông tin Admin này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="delete_ad_btn">Xóa</button>
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
            <form id="delete_form_ad" action="saveadmin.php" method="POST">
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
    $(document).on('click', '.editAd', function() {
        $('#editAdModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#u_id').val(data[1]);
        $('#u_username').val(data[2]);
        $('#u_email').val(data[3]);
        $('#u_password').val(data[4]);
    });
    $(document).on('click', '.viewAd', function() {
        $('#viewAdModal').modal('show');
        var id = $(this).attr("data-ad-id");
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(id);
        console.log(data);
        $('#v_id').val(id);
        $('#v_username').val(data[2]);
        $('#v_email').val(data[3]);
        $('#v_password').val(data[4]);
    });
    $(document).on('click', '.deleteAd', function() {
        $('#deleteAdModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#d_id').val(data[1]);
        // $('#v_username').val(data[2]);
        // $('#v_email').val(data[3]);
        // $('#v_password').val(data[4]);
    })
})
</script>
<script src="/admin.js"></script>
<?php
require_once "include/scripts.php";
require_once "include/footer.php";
?>