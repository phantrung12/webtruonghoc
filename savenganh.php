<?php
require_once("security.php");
require('Classes/PHPExcel.php');
require_once('Classes/PHPExcel/IOFactory.php');

$manganh = $tennganh = $chitieu = "";
$manganh_err = $tennganh_err = $chitieu_err = "";

if(isset($_POST['add_nh_btn'])){
    $manganh = $_POST['manganh'];
    $tennganh = $_POST['tennganh'];
    $chitieu = $_POST['chitieu'];
    
    $mn_query = "SELECT * FROM nganhts WHERE manganh='$manganh' ";
    $mn_query_run = mysqli_query($conn, $mn_query);
    if(mysqli_num_rows($mn_query_run) > 0)
    {
        $_SESSION['status'] = "Ngành học đã tồn tại.";
        $_SESSION['status_code'] = "error";
        header('Location: nganhts.php');  
        echo '<script>alert("Ngành học đã tồn tại")</script>';
    }else{
            $query = "INSERT INTO nganhts (manganh,tennganh,chitieu) VALUES ('$manganh','$tennganh','$chitieu')";
            $query_run = mysqli_query($conn, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thêm thành công";
                $_SESSION['status_code'] = "success";
                header('Location: nganhts.php');
            }
            else 
            {
                $_SESSION['status'] = "Không thể thêm";
                $_SESSION['status_code'] = "error";
                echo "ERROR: Không thể thực thi $query. " . mysqli_error($conn);
                //header('Location: nganhts.php');  
            }
    }
}

if(isset($_POST['update_nh_btn'])){
    
    $id = $_POST['u_id'];
    $manganh = $_POST['u_manganh'];
    $tennganh = $_POST['u_tennganh'];
    $chitieu = md5($_POST['u_chitieu']);

            $query = "UPDATE nganhts SET manganh='$manganh', tennganh='$tennganh', chitieu='$chitieu' WHERE id='$id'";
            $query_run = mysqli_query($conn, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thông tin đã được cập nhật";
                $_SESSION['status_code'] = "success";
                header('Location: nganhts.php');
            }
            else 
            {
                $_SESSION['status'] = "Lỗi";
                $_SESSION['status_code'] = "error";
                header('Location: nganhts.php');  
            }
}

if(isset($_POST['delete_nh_btn'])){
    $id = $_POST['d_id'];
    $query = "DELETE FROM nganhts WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);
            
    if($query_run)
    {
        // echo "Saved";
        $_SESSION['status'] = "Xóa thành công";
        $_SESSION['status_code'] = "success";
        header('Location: nganhts.php');
    }
    else 
    {
        $_SESSION['status'] = "Lỗi";
        $_SESSION['status_code'] = "error";
        header('Location: nganhts.php');  
    }
}

if(isset($_POST['btnImport'])){
    $file = $_FILES['file']['tmp_name'];
    
    $objReader = PHPExcel_IOFactory::load($file);
    foreach($objReader->getWorksheetIterator() as $worksheet)
    {
        $highestrow = $worksheet->getHighestRow();
        
        for($row=0;$row<=$highestrow;$row++)
        {
            $manganh=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
            $tennganh=$worksheet->getCellByColumnAndRow(1,$row)->getValue();
            $chitieu=$worksheet->getCellByColumnAndRow(2,$row)->getValue();

            $insertqry = "INSERT INTO nganhts (manganh,tennganh,chitieu) VALUES ('$manganh','$tennganh','$chitieu')";
            $insertres=mysqli_query($conn,$insertqry);
            if($insertres)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thêm thành công";
                $_SESSION['status_code'] = "success";
                header('Location: nganhts.php');
            }
            else 
            {
                $_SESSION['status'] = "Không thể thêm";
                $_SESSION['status_code'] = "error";
                echo "ERROR: Không thể thực thi $query. " . mysqli_error($conn);
                //header('Location: nganhts.php');  
            }
        }
    }
}

?>