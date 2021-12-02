<?php
require_once("security.php");
require('Classes/PHPExcel.php');
require_once('Classes/PHPExcel/IOFactory.php');

$hoten = $email = $ngaysinh = $sdt = $gioitinh = $nganhdk = $diachi = $truong = "";
$hoten_err = $email_err = $ngaysinh_err = $sdt_err = $gioitinh_err = $nganhdk_err = $diachi_err = $truong_err = "";


if(isset($_POST['btn-add-dts'])){
    $hoten = $_POST['hoten'];
    $email = $_POST['email'];
    $ngaysinh = $_POST['ngaysinh'];
    $sdt = $_POST['sdt'];
    $gioitinh = $_POST['gioitinh'];
    $nganhdk = $_POST['nganhts'];
    $diachi = $_POST['diachi'];
    $truong = $_POST['truong'];
    
    $email_query = "SELECT * FROM donts WHERE email='$email' ";
    $email_query_run = mysqli_query($conn, $email_query);
    if(mysqli_num_rows($email_query_run) > 0)
    {
        $_SESSION['status'] = "Đơn đăng kí đã tồn tại.";
        $_SESSION['status_code'] = "error";
        header('Location: nganhts.php');  
        echo '<script>alert("Ngành học đã tồn tại")</script>';
    }else{
            $query = "INSERT INTO donts (hoten,email,ngaysinh,sdt,diachi,truong,gioitinh,trangthai,nganhts) VALUES ('$hoten','$email','$ngaysinh','$sdt','$diachi','$truong','$gioitinh',0,'$nganhdk')";
            $query_run = mysqli_query($conn, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thêm thành công";
                $_SESSION['status_code'] = "success";
                header('Location: dontuyensinh.php');
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

if(isset($_POST['btn-edit-dts'])){
    
    $id = $_POST['u_id'];
    $hoten = $_POST['u_hoten'];
    $email = $_POST['u_email'];
    $ngaysinh = $_POST['u_ngaysinh'];
    $sdt = $_POST['u_sdt'];
    $gioitinh = $_POST['u_gioitinh'];
    $nganhdk = $_POST['u_nganhts'];
    $diachi = $_POST['u_diachi'];
    $truong = $_POST['u_truong'];
    $trangthai = $_POST['u_trangthai'];

            $query = "UPDATE donts SET hoten='$hoten', email='$email', ngaysinh='$ngaysinh', sdt='$sdt',diachi='$diachi',truong='$truong',gioitinh='$gioitinh',trangthai='$trangthai',nganhts='$nganhdk' WHERE id='$id'";
            $query_run = mysqli_query($conn, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thông tin đã được cập nhật";
                $_SESSION['status_code'] = "success";
                header('Location: dontuyensinh.php');
            }
            else 
            {
                $_SESSION['status'] = "Lỗi";
                $_SESSION['status_code'] = "error";
                header('Location: dontuyensinh.php');  
            }
}

if(isset($_POST['btn-delete-dts'])){
    $id = $_POST['d_id'];
    $query = "DELETE FROM donts WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);
            
    if($query_run)
    {
        // echo "Saved";
        $_SESSION['status'] = "Xóa thành công";
        $_SESSION['status_code'] = "success";
        header('Location: dontuyensinh.php');
    }
    else 
    {
        $_SESSION['status'] = "Lỗi";
        $_SESSION['status_code'] = "error";
        header('Location: dontuyensinh.php');  
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
        $hoten=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
        $email=$worksheet->getCellByColumnAndRow(1,$row)->getValue();
        $ngaysinh=$worksheet->getCellByColumnAndRow(2,$row)->getValue();
        $sdt=$worksheet->getCellByColumnAndRow(3,$row)->getValue();
        $diachi=$worksheet->getCellByColumnAndRow(4,$row)->getValue();
        $truong=$worksheet->getCellByColumnAndRow(5,$row)->getValue();
        $gioitinh=$worksheet->getCellByColumnAndRow(6,$row)->getValue();
        $nganhdk=$worksheet->getCellByColumnAndRow(7,$row)->getValue();

		if($email!='')
		{
            $insertqry = "INSERT INTO donts (hoten,email,ngaysinh,sdt,diachi,truong,gioitinh,trangthai,nganhts) VALUES ('$hoten','$email','$ngaysinh','$sdt','$diachi','$truong','$gioitinh',0,'$nganhdk')";
			$insertres=mysqli_query($conn,$insertqry);
		}
        if($insertres)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thêm thành công";
                $_SESSION['status_code'] = "success";
                header('Location: dontuyensinh.php');
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