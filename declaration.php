<?php 
  session_start();
  // include 'db.php';
  if(isset($_GET['r'])){
  $r = $_GET['r'];}

  if (isset($_POST['submit'])) {
    $con = new mysqli("localhost", "root", "", "alumni");


    $filename = $_FILES['passport']['name'];
    $filetmpname = $_FILES['passport']['tmp_name'];
    // Folder to Move the Image
    $folder = 'img/';
    // Function for saving the uploaded images in a specific folder
    move_uploaded_file($filetmpname, $folder.$filename);

    // The Details to be captured
    $fullname = $con->real_escape_string($_POST['name']);
    $matric = $con->real_escape_string($_POST['mat-num']);
    $phone = $con->real_escape_string($_POST['phone']);
    $mail = $con->real_escape_string($_POST['email']);
    $sets = $con->real_escape_string($_POST['set']);
    $school = $con->real_escape_string($_POST['school']);
    $department = $con->real_escape_string($_POST['department']);
    $lga = $con->real_escape_string($_POST['lga']);
    $position = $con->real_escape_string($_POST['portfolio']);
    $vision = $con->real_escape_string($_POST['vision']);

    if(empty($fullname) || empty($matric) || empty($mail) || empty($phone)) {
    header("Location: declaration?r=All fields are required, please try again.'");
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("Location: declaration?r=The email you entered is invalid, please try again.'");
    exit();
  }else{
        //validate the uniqueness of email
        $checkemail = $con->query("SELECT email FROM aspirant WHERE email = '$mail'");
        $numrows = mysqli_num_rows($checkemail);
        if($numrows > 0){
        header("Location: declaration?r=The Email is already in use!");
        exit();
      }
      // prepare and bind and execute for user table
      $stmt = $con->prepare("INSERT INTO aspirant (fullname, matric, phone, mail, sets, school, department, lga, position, vision, passport) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
      $stmt->bind_param("ssssssssssss", $fullname, $matric, $phone, $mail, $sets, $school, $department, $lga, $position, $vision, $passport);


      if($stmt->execute()){
        $msg = "Form Submission Successful!";
        header("Location: congratulation");
        }else{
        header("Location: declaration?r=Registration Failed, Please Try Again or Contact Support!");
        exit();
        }
      }
      $stmt->close();
      $con->close();


  }

 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Declaration of interest</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fupre Declaration Form</title>
    <link rel="stylesheet" href="css/style.css" />

    <link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div class="container">
      <div class="overlay"></div>
      <div class="form-container declaration-form-container">
        <h1 class="form-title">DECLARATION OF INTEREST FORM</h1>
        <form action="declaration" method="post" enctype="multipart/form-data">
          <div class="input-container">
            <div class="input-content-container">
              <input type="text" placeholder="Enter Full Name..." name="name" />
            </div>
            <div class="input-content-container">
              <input type="text" placeholder="Matriculation No..." name="mat-num" />
            </div>
          </div>
          <div class="input-container">
              <div class="input-content-container">
                  <input type="tel" placeholder="Phone..." name="phone" />
                </div>
                <div class="input-content-container">
                  <input type="email" placeholder="Enter Email..." name="email" />
                </div>
          </div>
          <div class="select-container">
              <label for="">What set of Fupre did you graduate with?</label><br>
                      <select class="select" name="set" id="set">
                          <option value="2012/2013">Select the your set</option>
                          <option value="2012/2013">2012/2013</option>
                          <option value="2013/2014">2013/2014</option>
                          <option value="2014/2015">2014/2015</option>
                          <option value="2015/2016">2015/2016</option>
                          <option value="2016/2017">2016/2017</option>
                          <option value="2017/2018">2017/2018</option>
                          <option value="2018/2019">2018/2019</option>
                          <option value="2019/2020">2019/2020</option>
                          <option value="2020/2021">2020/2021</option>
                      </select>
                 </div>
          <div class="select-container">
              <label for="">What school did you graduate from?</label><br>
                      <select class="select" name="school" id="school">
                          <option value="">Select school</option>
                          <option value="school of undergraduate">School Of Undergraduate Studies</option>
                          <option value="school of post graduate">School Of Post Graduate Studies</option>
                          <option value="both">Both</option>
                      </select>
                 </div>

          <div class="select-container">
              <label for="">What school did you graduate from?</label><br>
                      <select class="select" name="department" id="department">
                          <option value="">Select Department</option>
                          <option value="chemical engineering">Chemical Engineering</option>
                          <option value="petroleum engineering">Petroleum Engineering</option>
                          <option value="mechanical engineering">Mechanical Engineering</option>
                          <option value="electrical electronic engineering">Electrical Electronic Engineering</option>
                          <option value="marine engineering">Marine Engineering</option>
                          <option value="Enviromental management & toxicology">Enviromental Management & Toxicology</option>
                          <option value="physics">Physics</option>
                          <option value="chemistry/industrial chemistry">Chemistry/ Industrial Chemistry</option>
                          <option value="earth science">Earth Science</option>
                          <option value="mathematics & computer science">Mathematics & Computer Science</option>
                      </select>
                 </div>

          <div class="select-container">
            <label for="">What local government are you from?</label><br>
                    <select class="select" name="lga" id="department">
                        <option>Select your local government area</option>
                        <option>Ajeromi Ifelodun</option>
                        <option>Alimosho</option>
                        <option>Amuwo Odofin</option>
                        <option>Apapa</option>
                        <option>Badagary</option>
                        <option>Kosofe</option>
                        <option>Mushin</option>
                        <option>Oshodi</option>
                        <option>Ojo</option>
                        <option>Ikorodu</option>
                        <option>Surulere</option>
                        <option>Ifako Ajayi</option>
                        <option>Shomolu</option>
                        <option>Lagos Mainland</option>
                    </select>
               </div>
          <div class="select-container">
            <label for="">What position are you aspiring for?</label><br>
                    <select class="select" name="portfolio" id="department">
                        <option>Select position </option>
                        <option>Executive Chairman</option>
                        <option>Vice Chairman, Ikeja Division</option>
                        <option>Vice Chairman, Badagry Division</option>
                        <option>Vice Chairman, Ikorodu Division</option>
                        <option>Vice Chairman, Lagos Island Division</option>
                        <option>Vice Chairman, Epe Division</option>
                        <option>General Secretary</option>
                        <option>Director of Finance</option>
                        <!--option>Treasurer</option-->
                        <option>Director of Publicity</option>
                    </select>
               </div>

               <div class="select-container">
                <label for="vision">What are your visions for the organization in the office you intend to hold</label>
                <textarea name="vision" id="vision" cols="80" rows="10" placeholder="Tell us about your vision!"></textarea>
            </div>

               <div class="select-container">
                <label for="">Do you promise to effectively carry out your responsibility throughout your tenure?</label><br>
                    <input type="radio" name="radio" id="yes" >
                    <label for="yes"> Yes</label><br>

                    <input type="radio" name="radio" id="no" >
                    <label for="no">No</label><br>

                    <input type="radio" name="radio" id="can't" >
                    <label for="can't"> Can't Tell</label>
                   </div>


               <div class="select-container">
                <label for="">Upload a clear picture of yourself showing your face!</label><br>
                <div class="file-upload-container">
                  <input class="file" type="file" name="passport" id="file-upload" />
                </div>
              </div>

               <div class="select-container btn-submit-container">
                <button class="btn-submit btn">Submit</button>
              </div>
              
              
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
