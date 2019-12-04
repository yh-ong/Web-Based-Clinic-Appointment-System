<?php
include("../config/autoload.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient = escape_input($_POST['inputPatient']);
    $clinic = escape_input($_POST['inputClinic']);
    $doctor = escape_input($_POST['inputDoctor']);
    $treatment = escape_input($_POST['inputTreatment']);

    $stmt = $conn->prepare("INSERT INTO appointment (app_date, app_time, treatment_type, patient_id, doctor_id, clinic_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiii", $current_date, $current_time, $treatment, $patient, $doctor, $clinic);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div><p>Current Date: <?=$current_date?></p></div>
    <div><p>Current Time: <?=$current_time?></p></div>
    <form action="" method="POST">
        <label for="">Patient Name</label>
        <select name="inputPatient" id="">
            <option value="" selected disabled>Choose</option>
            <?php 
            $list = $conn->query("SELECT * FROM patients");
            while($trow = $list->fetch_assoc()):
                echo '<option value="'.$trow['patient_id'].'">'.$trow['patient_lastname']." ".$trow['patient_firstname'].'</option>';
            endwhile;
            ?>
        </select>

        <label for="">Clinic Name</label>
        <select name="inputClinic" id="">
            <option value="" selected disabled>Choose</option>
            <?php 
            $list1 = $conn->query("SELECT * FROM clinics");
            while($trow = $list1->fetch_assoc()):
                echo '<option value="'.$trow['clinic_id'].'">'.$trow['clinic_name'].'</option>';
            endwhile;
            ?>
        </select>

        <label for="">Doctor Name</label>
        <select name="inputDoctor" id="">
            <option value="" selected disabled>Choose</option>
            <?php
            $list2 = $conn->query("SELECT * FROM doctors");
            while($trow = $list2->fetch_assoc()):
                echo '<option value="'.$trow['doctor_id'].'">'.$trow['doctor_lastname']." ".$trow['doctor_firstname'].'</option>';
            endwhile;
            ?>
        </select>

        <label for="">Treatment Type</label>
        <input type="text" name="inputTreatment">

        <button type="submit" name="registerbtn">Submit</button>
    </form>


    <div style="margin-top:50px;">
        <table border="1" cellpadding="10">
            <tr>
                <th>Patient</th>
                <th>App Date</th>
                <th>App Time</th>
                <th>Clinic</th>
                <th>Doctor</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
                $result = $conn->query("SELECT * FROM appointment A JOIN patients P ON A.patient_id = P.patient_id JOIN clinics C ON A.clinic_id = C.clinic_id JOIN doctors D ON A.doctor_id = D.doctor_id");
                while ($row = $result->fetch_assoc()) :
                    ?>
                    <tr>
                        <td><?= $row['patient_lastname'].' '.$row['patient_firstname'] ?></td>
                        <td><?= $row['app_date'] ?></td>
                        <td><?= $row['app_time'] ?></td>
                        <td><?= $row['clinic_name'] ?></td>
                        <td><?= $row['doctor_lastname'].' '.$row['doctor_firstname'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td>
                            <?php
                            if ($row['status'] == 1) {
                                echo 'Once Confirm Cannot be Cancel';
                            } else {
                                echo '<button >Confirm</button>';
                                echo '<button >Cancel Appointment</button>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                endwhile;
            ?>
        </table>
    </div>
</body>

</html>