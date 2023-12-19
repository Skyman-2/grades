<?php if (isset($_GET['subjectRef']) && isset($_GET['gradeRef'])): ?>
    <?php
        $subjectRef = $_GET['subjectRef'];
        $gradeRef = $_GET['gradeRef'];

        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'delete') {
                $sql =  "DELETE FROM grades_$subjectRef WHERE GradeID=$gradeRef";
                if (!mysqli_query($conn, $sql)) {
                    echo "There was an error processing your delete request.";
                } else {
                    header('Location: ./');
                }
            }
        }
        $sql = "SELECT * FROM grades_$subjectRef WHERE GradeID='$gradeRef'";
        $res = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($res);
    ?>
    <dialog id="grade-details" style="width: 500px;">
        <a class="btn-floating btn-small red right bold" href="./">
            <span class="material-symbols-outlined">
                close
            </span>
        </a>
        <?php if (!isset($_GET['action'])): ?>
            <h5 class="light-blue-text darken-1 bold">Grade details:</h5>
            <div class="details-wrapper">
                <p>
                    <b>Grade:</b> <?php echo $data["grade"] ?>
                    <?php if ($data["maxPoints"] != 20) {
                        echo "/ " . $data["maxPoints"];
                    } ?>
                </p>
                <p><b>Coefficient:</b> <?php echo $data["grade_coef"] ?></p>
            </div>
            <div class="right-align">

                <a 
                    href="./?subjectRef=<?php echo $subjectRef ?>&gradeRef=<?php echo $gradeRef ?>&action=edit" 
                    class="material-icon-wrapper btn light-blue darken-1"
                >
                    <span class="material-symbols-outlined">
                        edit
                    </span>
                    Edit
                </a>

                <a 
                    href="./?subjectRef=<?php echo $subjectRef ?>&gradeRef=<?php echo $gradeRef ?>&action=delete"
                    class="material-icon-wrapper btn red darken-1"
                >
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                    Delete
                </a>
            </div>
        <?php else: ?>
            <h5 class="light-blue-text darken-1 bold">Grade details:</h5>
            <div class="details-wrapper">
                <form action="./" method="POST">
                    <input type="hidden" name="subjectRef" value="<?php echo $subjectRef ?>">
                    <input type="hidden" name="GradeID" value="<?php echo $data['GradeID'] ?>">
                    <p>
                        <b>Grade:</b> <br>
                        <input type="number" name="gradeEdit" value="<?php echo $data["grade"] ?>" style="width: 45%;" class="align-center">
                        <span style="width: auto;">/</span>
                        <input type="number" name="maxPointsEdit" value="<?php echo $data["maxPoints"] ?>" style="width: 45%;" class="align-center">
                    </p>
                    <p>
                        <b>Coefficient:</b>
                        <input type="number" name="gradeCoefEdit" value="<?php echo $data["grade_coef"] ?>">
                    </p>                    
                    <div class="right-align">
                        <a 
                            href="./?subjectRef=<?php echo $subjectRef ?>&gradeRef=<?php echo $gradeRef ?>" 
                            class="material-icon-wrapper btn grey darken-1"
                        >
                            <span class="material-symbols-outlined">
                                cancel
                            </span>
                            Cancel
                        </a>

                        <a 
                            href="#"
                            onclick="this.closest('form').submit();return false;"
                            class="material-icon-wrapper btn light-blue darken-1"
                        >
                            <span class="material-symbols-outlined">
                                save
                            </span>
                            Save
                        </a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </dialog>
<?php endif; ?>