<?php
    require('./config/db_config.php');

    $sql = "SELECT * FROM subject_row ORDER BY coef DESC";
    $data = mysqli_query($conn, $sql);
    $results = mysqli_fetch_all($data);

    if (isset($_POST['submitNewGrade'])) {
        $grade = $_POST['grade'];
        $coef = $_POST['coef'];
        $maxPoints = $_POST['maxPoints'];
        $subjectRef = $_POST['subject'];
        
        $sql = "INSERT INTO grades_$subjectRef(grade, grade_coef, maxPoints) VALUES ('$grade', '$coef', '$maxPoints')";
        if (!mysqli_query($conn, $sql)) {
            echo "Error during insertion. Please refresh.";
        } else {
            header("Location: ./");
        }

    } else if (isset($_POST['submitNewSubject'])) {
        $subjectName = $_POST['subjectName'];
        $subjectCoef = $_POST['subjectCoef'];

        $sql = "INSERT INTO subject_row(subjectName, coef) VALUES('$subjectName', '$subjectCoef')";
        if (!mysqli_query($conn, $sql)) {
            echo "Error during creation of new Subject. Please refresh.";
        } else {
            $sql = "SELECT gradesRef FROM subject_row WHERE subjectName='$subjectName'";
            $data = mysqli_query($conn, $sql);
            $results = mysqli_fetch_all($data);
            
            $gradeRef = $results[0][0];
            $sql = "CREATE TABLE grades_$gradeRef (
                GradeID int(11) PRIMARY KEY AUTO_INCREMENT,
                grade float,
                grade_coef float,
                maxPoints int(11)
            )";
            if (!mysqli_query($conn, $sql)) {
                echo "Error while creating new table. Please contact support";
            } else {
                header("Location: ./?subjectOverview");
            }
        }
    }

    if (isset($_POST['gradeEdit'])) {
        $newGrade = $_POST['gradeEdit'];
        $newCoef = $_POST['gradeCoefEdit'];
        $newMaxPoints = $_POST['maxPointsEdit'];

        $subjectRef = $_POST['subjectRef'];
        $GradeID = $_POST['GradeID'];

        $sql = "UPDATE grades_$subjectRef SET grade=$newGrade, grade_coef=$newCoef, maxPoints=$newMaxPoints WHERE GradeID=$GradeID";
        if (!mysqli_query($conn, $sql)) {
            echo "There was en error processing the modification. Please try again.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="./app.js" defer></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" defer></script>

    <title>Grade Estimator</title>
</head>
<body>

    <?php require_once("./components/gradeEdition.php") ?>

    <main class="container">
        <h4 class="center-align">Grade Estimator</h4>
        <table>
            <thead class="light-blue darken-1 white-text">
                <tr>
                    <th style="width: 12rem">Subject</th>
                    <th style="width: 4rem">Coef.</th>
                    <th style="width: 6rem">Average</th>
                    <th>Grades</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalAverage = 0;
                    $totalCoef = 0; 
                    foreach ($results as $row): 
                ?>
                    <tr>
                        <?php
                            $gradesRef = $row[0];
                            $subject = $row[1];
                            $subjectCoef = $row[2];

                            // fetch grades of the subject
                            $sql = "SELECT * FROM grades_$gradesRef";
                            $gradesData = mysqli_query($conn, $sql);
                            $gradesRes = mysqli_fetch_all($gradesData);


                            // calculate the average
                            $gradesSum = 0;
                            $coefsSum = 0;
                            for ($i=0; $i<count($gradesRes); $i++) {
                                $grade = $gradesRes[$i][1];
                                $gradeCoef = $gradesRes[$i][2];
                                $base = $gradesRes[$i][3];

                                $gradesSum += (($grade / $base) * 20) * $gradeCoef;
                                $coefsSum += $gradeCoef;
                            }
                            if ($coefsSum != 0) {
                                $subjectAverage = round($gradesSum / $coefsSum, 2);
                                $totalAverage += $subjectAverage * $subjectCoef;
                                $totalCoef += $subjectCoef;
                            } else {
                                $subjectAverage = "NaN";
                            }
                        ?>

                        <td><?php echo $subject ?></td>
                        <td><?php echo $subjectCoef ?></td>
                        <td id="average"><?php echo $subjectAverage ?></td>
                        <td id="grades">
                            <div class="grades-container">
                                <?php foreach ($gradesRes as $grade): ?>
                                    <a class="grade-wrapper black-text" href="./?subjectRef=<?php echo $gradesRef ?>&gradeRef=<?php echo $grade[0] ?>">

                                        <span class="grade-value">
                                            <?php echo $grade[1] ?>
                                        </span>

                                        <?php if ($grade[3] != 20): ?>
                                            <span class="grade-maxpoints">
                                                <?php echo "/" . $grade[3]; ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($grade[2] != 1): ?>
                                            <span class="grade-coef">
                                                <?php echo "(" . $grade[2] . ")" ?>
                                            </span>
                                        <?php endif; ?>

                                    </a>
                                <?php endforeach; ?>
                            </div>                             
                        </td>
                    
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" class="right-align light-blue-text darken-1" style="font-weight: bold;">Moyenne générale</td>
                    <td colspan="2" id="average" class="light-blue-text darken-1" style="font-weight: bold;"><?php if ($totalCoef != 0) { echo round($totalAverage / $totalCoef, 2); } ?></td>
                </tr>
                
            </tbody>
        </table>

        <div class="right newFieldsForm">
            <button class="btn blue darken-1" id="newGradeFormOpen">New Grade</button>
            <button class="btn blue darken-1" id="editSubjectsFormOpen">Edit Subjects</button>
        </div>
    </main>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <?php
        require_once("./components/newGradeForm.php");
        require_once("./components/editSubjectsForm.php");   
    ?>

</body>
</html>