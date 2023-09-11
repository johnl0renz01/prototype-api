<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

ob_start();
session_start();

$requestLink = $_SERVER['REQUEST_URI'];


for ($i = strlen($requestLink) - 1; $i > 0; $i--) {
    if ($requestLink[$i] == "/") {
        $requestLink = substr($requestLink, 0, $i);
        break;
    }
}

//echo $requestLink;
$_SESSION['method'] = $_SERVER['REQUEST_METHOD'];
//echo $_SESSION['method'];

switch($requestLink) {
    //FOR LOGIN
     case "/Prototype-Vite/my-project/api/loginAdmin":
        include('loginAdmin.php');
    break;
    case "/Prototype-Vite/my-project/api/loginStudent":
        include('loginStudent.php');
    break;

    case "/Prototype-Vite/my-project/api/loginSession":
        include('loginSession.php');
    break;

    case "/Prototype-Vite/my-project/api/getSessionEmail":
        include('getSessionEmail.php');
    break;

    case "/Prototype-Vite/my-project/api/getSessionLogged":
        include('getSessionLogged.php');
    break;

    //LOGOUT
    case "/Prototype-Vite/my-project/api/logout":
        include('logout.php');
    break;

    //===========STUDENT=============
     //FOR SELECT DIFFICULTY
     case "/Prototype-Vite/my-project/api/selectDifficulty":
        include('selectDifficulty.php');
    break;
    case "/Prototype-Vite/my-project/api/getEquation":
        include('getEquation.php');
    break;

    //FOR WHITEBOARD
    case "/Prototype-Vite/my-project/api/whiteboardLog":
        include('whiteboardLog.php');
        break;
    case "/Prototype-Vite/my-project/api/whiteboardClick":
        include('whiteboardClick.php');
    break;
    case "/Prototype-Vite/my-project/api/endSession":
        include('endSession.php');
    break;
    case "/Prototype-Vite/my-project/api/getTimeSpent":
        include('getTimeSpent.php');
    break;

    //===========ADMIN=============
    //FOR REGISTRATION
    case "/Prototype-Vite/my-project/api/registerAccount":
    include('registerAccount.php');
    case "/Prototype-Vite/my-project/api/verifyEmail":
        include('verifyEmail.php');
    break;
    case "/Prototype-Vite/my-project/api/registerBulk":
        include('registerBulk.php');
    case "/Prototype-Vite/my-project/api/verifyEmailBulk":
        include('verifyEmailBulk.php');
    break;


    //FOR MANAGE SECTION
    case "/Prototype-Vite/my-project/api/sectionTotal":
        include('sectionTotal.php');
        break;
    case "/Prototype-Vite/my-project/api/sectionName":
        include('sectionName.php');
        break;
    case "/Prototype-Vite/my-project/api/sectionList":
        include('sectionList.php');
        break;
    case "/Prototype-Vite/my-project/api/sectionTotalStudents":
        include('sectionTotalStudents.php');
        break;
    case "/Prototype-Vite/my-project/api/sectionAdviser":
        include('sectionAdviser.php');
        break;

    case "/Prototype-Vite/my-project/api/adviserList":
        include('adviserList.php');
        break;
        

    case "/Prototype-Vite/my-project/api/addSection":
        include('addSection.php');
    break;
    case "/Prototype-Vite/my-project/api/editSection":
        include('editSection.php');
        break;

    case "/Prototype-Vite/my-project/api/verifySection":
        include('verifySection.php');
    break;

    case "/Prototype-Vite/my-project/api/sectionHandled":
        include('sectionHandled.php');
        break;

    case "/Prototype-Vite/my-project/api/sectionTotalv2":
        include('sectionTotalv2.php');
        break;
    case "/Prototype-Vite/my-project/api/sectionNamev2":
        include('sectionNamev2.php');
        break;

    case "/Prototype-Vite/my-project/api/getAssignedStudent":
        include('getAssignedStudent.php');
        break;

    case "/Prototype-Vite/my-project/api/getAssignedTeacher":
        include('getAssignedTeacher.php');
        break;

    case "/Prototype-Vite/my-project/api/removeSection":
        include('removeSection.php');
        break;

    case "/Prototype-Vite/my-project/api/removeSectionAccounts":
        include('removeSectionAccounts.php');
        break;



    //FOR CLASS LIST
    case "/Prototype-Vite/my-project/api/classList":
        include('classList.php');
        break;

    //FOR STUDENT DETAIL
    case "/Prototype-Vite/my-project/api/studentDetail":
        include('studentDetail.php');
        break;
    case "/Prototype-Vite/my-project/api/studentHistory":
        include('studentHistory.php');
    break;
   
    //FOR CUSTOMIZATION
    case "/Prototype-Vite/my-project/api/editAccount":
        include('editAccount.php');
    break;
    case "/Prototype-Vite/my-project/api/editAccountPassword":
        include('editAccountPassword.php');
    break;

    //EQUATIONS
    case "/Prototype-Vite/my-project/api/removeEquation":
        include('removeEquation.php');
    break;
    case "/Prototype-Vite/my-project/api/verifyEquation":
        include('verifyEquation.php');
    break;
    case "/Prototype-Vite/my-project/api/addEquation":
        include('addEquation.php');
    break;
    case "/Prototype-Vite/my-project/api/getEquationList":
        include('getEquationList.php');
    break;
    case "/Prototype-Vite/my-project/api/equationsEasy":
        include('equationsEasy.php');
    break;
    case "/Prototype-Vite/my-project/api/equationsAverage":
        include('equationsAverage.php');
    break;
    case "/Prototype-Vite/my-project/api/equationsDifficult":
        include('equationsDifficult.php');
    break;

    case "/Prototype-Vite/my-project/api/editEquationType":
        include('editEquationType.php');
    break;


    //// 


    case "/Prototype-Vite/my-project/api/getAccountSection":
        include('getAccountSection.php');
        break;
    case "/Prototype-Vite/my-project/api/sectionDetails":
        include('sectionDetails.php');
        break;
    
    
   

    case "/Prototype-Vite/my-project/api/upload":
        include('upload.php');
    break;

    //FOR LOGIN
    case "/Prototype-Vite/my-project/api/validateLogin":
        include('validateLogin.php');
    break;

    case "/Prototype-Vite/my-project/api/teacherLoginSection":
        include('teacherLoginSection.php');
    break;

    //FOR MANAGE ACCOUNTS
    case "/Prototype-Vite/my-project/api/accountList":
        include('accountList.php');
    break;

    case "/Prototype-Vite/my-project/api/accountDetails":
        include('accountDetails.php');
    break;

    case "/Prototype-Vite/my-project/api/accountType":
        include('accountType.php');
    break;

    case "/Prototype-Vite/my-project/api/getSectionAssigned":
        include('getSectionAssigned.php');
    break;

    case "/Prototype-Vite/my-project/api/removeAccount":
        include('removeAccount.php');
    break;

    //RESET REQUESTS
    case "/Prototype-Vite/my-project/api/resetPasswordList":
        include('resetPasswordList.php');
    break;
    case "/Prototype-Vite/my-project/api/resetPassword":
        include('resetPassword.php');
    break;
    case "/Prototype-Vite/my-project/api/removeResetRequest":
        include('removeResetRequest.php');
    break;


    //CONTACT ADMIN
    case "/Prototype-Vite/my-project/api/requestSend":
        include('requestSend.php');
    break;

    //USER REQUESTS
    case "/Prototype-Vite/my-project/api/requestList":
        include('requestList.php');
    break;

    case "/Prototype-Vite/my-project/api/requestDetails":
        include('requestDetails.php');
    break;

    case "/Prototype-Vite/my-project/api/requestSolved":
        include('requestSolved.php');
    break;

    case "/Prototype-Vite/my-project/api/requestTotal":
        include('requestTotal.php');
    break;

    case "/Prototype-Vite/my-project/api/requestStatus":
        include('requestStatus.php');
    break;

    // SET NEW PASSWORD
    case "/Prototype-Vite/my-project/api/setNewPassword":
        include('setNewPassword.php');
    break;

    // FORGOT PASSWORD
    case "/Prototype-Vite/my-project/api/forgotPassEmail":
        include('forgotPassEmail.php');
    break;

    case "/Prototype-Vite/my-project/api/forgotPassCode":
        include('forgotPassCode.php');
    break;
}

