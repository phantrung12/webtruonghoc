<?php
require_once("security.php");
require('Classes/PHPExcel.php');
require_once('Classes/PHPExcel/IOFactory.php');

$username = $email = $password = $cpassword = "";
$username_err = $email_err = $password_err = "";

if(isset($_POST['btn-add-ad'])){
    $username = $_POST['ad-username'];
    $email = $_POST['ad-email'];
    $password = md5($_POST['ad-password']);
    $cpassword = md5($_POST['ad-cpassword']);
    
    $email_query = "SELECT * FROM admin WHERE email='$email' ";
    $email_query_run = mysqli_query($conn, $email_query);
    if(mysqli_num_rows($email_query_run) > 0)
    {
        $_SESSION['status'] = "Email Already Taken. Please Try Another one.";
        $_SESSION['status_code'] = "error";
        header('Location: register.php');  
    }else{
        if($password === $cpassword){
            $query = "INSERT INTO admin (username,email,password) VALUES ('$username','$email','$password')";
            $query_run = mysqli_query($conn, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "Admin Profile Added";
                $_SESSION['status_code'] = "success";
                header('Location: index.php');
            }
            else 
            {
                $_SESSION['status'] = "Admin Profile Not Added";
                $_SESSION['status_code'] = "error";
                header('Location: index.php');  
            }
        }
        else 
        {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: index.php');  
        }
    }
}

if(isset($_POST['update_ad_btn'])){
    
    $id = $_POST['u_id'];
    $username = $_POST['u-username'];
    $email = $_POST['u-email'];
    $password = md5($_POST['u-password']);
    //$cpassword = md5($_POST['u-cpassword']);
    
        //if($password === $cpassword){
            $query = "UPDATE admin SET username='$username', email='$email', password='$password' WHERE id='$id'";
            $query_run = mysqli_query($conn, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thông tin đã được cập nhật";
                $_SESSION['status_code'] = "success";
                header('Location: index.php');
            }
            else 
            {
                $_SESSION['status'] = "Lỗi";
                $_SESSION['status_code'] = "error";
                header('Location: index.php');  
            }
        // }
        // else 
        // {
        //     $_SESSION['status'] = "Mật khẩu không giống nhau";
        //     $_SESSION['status_code'] = "warning";
        //     header('Location: index.php');  
        // }
}

if(isset($_POST['delete_ad_btn'])){
    $id = $_POST['d_id'];
    $query = "DELETE FROM admin WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);
            
    if($query_run)
    {
        // echo "Saved";
        $_SESSION['status'] = "Xóa thành công";
        $_SESSION['status_code'] = "success";
        header('Location: index.php');
    }
    else 
    {
        $_SESSION['status'] = "Lỗi";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');  
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
        $username=$worksheet->getCellByColumnAndRow(0,$row)->getValue();
        $email=$worksheet->getCellByColumnAndRow(1,$row)->getValue();
        $password=$worksheet->getCellByColumnAndRow(2,$row)->getValue();
        $password = md5($password);

		if($email!='')
		{
            $insertqry = "INSERT INTO admin (username,email,password) VALUES ('$username','$email','$password')";
			$insertres=mysqli_query($conn,$insertqry);
		}
        if($insertres)
            {
                // echo "Saved";
                $_SESSION['status'] = "Thêm thành công";
                $_SESSION['status_code'] = "success";
                header('Location: index.php');
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