<?php
require_once('config.php');

$id = $_POST['id'];
if($id == 1){
    $sql = "SELECT * FROM donts";
}else{
    $sql = "SELECT * FROM donts WHERE nganhts = '{$id}'";
}

$result = mysqli_query($conn, $sql);
$i=1;
while($row = mysqli_fetch_array($result)){
    
?>
<tr>
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
        <button type="button" class="btn btn-sm btn-success viewD" id="view_dts_btn" data-id="<?php echo $row["id"]?>"
            data-ht="<?php echo $row["hoten"]?>" data-email="<?php echo $row["email"]?>"
            data-ns="<?php echo $row["ngaysinh"]?>" data-sdt="<?php echo $row["sdt"]?>"
            data-dc="<?php echo $row["diachi"]?>" data-gt="<?php echo $row["gioitinh"]?>"
            data-nts="<?php echo $row["nganhts"]?>" data-tt="<?php echo $row["trangthai"]?>"><i class="fa fa-eye"
                aria-hidden="true"></i></button>
        <button type="button" class="btn btn-sm btn-primary editD" id="edit_dts_btn" data-id="<?php echo $row["id"]?>"
            data-ht="<?php echo $row["hoten"]?>" data-email="<?php echo $row["email"]?>"
            data-ns="<?php echo $row["ngaysinh"]?>" data-sdt="<?php echo $row["sdt"]?>"
            data-dc="<?php echo $row["diachi"]?>" data-gt="<?php echo $row["gioitinh"]?>"
            data-nts="<?php echo $row["nganhts"]?>" data-tt="<?php echo $row["trangthai"]?>"><i class="fa fa-edit"
                aria-hidden="true"></i></button>
        <button type="button" class="btn btn-sm btn-danger deleteD" id="delete_dts_btn"
            data-id="<?php echo $row["id"]?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
    </td>
</tr>
<?php
$i++;
}
?>