<?php

    if (isset($_GET['subjectAction'])) {
        if ($_GET['subjectAction'] == 'deleteRow') {
            $subjectRef = $_GET['subjectRef'];
            $sql = "DELETE FROM subject_row WHERE GradesRef=$subjectRef";
            if (!mysqli_query($conn, $sql)) {
                echo "There was an issue processing your delete request. Please try again.";
            }
            $sql = "DROP TABLE grades_subjectRef";
            if (!mysqli_query($conn, $sql)) {
                echo "There was an issue processing your delete request. Please try again";
            } else {
                header('Location: ./?subjectOverview');
            }
        }
    }

?>

<dialog id="editSubjectsFormModal" style="width: 40%; min-width: 300px">
    <a class="btn-floating btn-small red right bold" href="./">
        <span class="material-symbols-outlined">
            close
        </span>
    </a>
    <form action="./" method="POST">
        <?php
            // do stuff back end
        ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 35%;">Subject</th>
                    <th style="width: 15%;">Coef</th>
                    <th style="width: 50%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $subject): ?>
                    <tr>
                        <td><?php echo $subject[1] ?></td>
                        <td><?php echo $subject[2] ?></td>
                        <td class="right-align">

                            <?php if (!isset($_GET["subjectAction"])): ?>
                            
                                <a 
                                    href="./?subjectRef=<?php echo $subject[0] ?>&subjectAction=editRow" 
                                    class="material-icon-wrapper btn btn-floating light-blue darken-1"
                                >
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </a>

                                <a 
                                    href="./?subjectRef=<?php echo $subject[0] ?>&subjectAction=deleteRow"
                                    class="material-icon-wrapper btn btn-floating red darken-1"
                                >
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>

                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (isset($_GET['subjectAction'])): ?>
                    <tr>
                        <td><input type="text" name="subjectName" placeholder="Subject Name..." class="validate" required></td>
                        <td><input type="number" name="subjectCoef" placeholder="Coef" class="validate" required></td>
                        <td class="center-align"><input type="submit" name="submitNewSubject" value="confirm" class="btn"></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <?php if (!isset($_GET['subjectAction'])): ?>
            <div class="right-align">
                <a href="./?subjectAction=newSubjectRow" class="btn">Add</a>
            </div>
        <?php else: ?>
            <div class="right-align">
                <a href="./?subjectOverview" class="btn grey darken-1">Cancel</a>
            </div>
        <?php endif; ?>
    </form>
</dialog>

<script>
    const editSubjectsFormDialog = document.getElementById('editSubjectsFormModal');
    const editSubjectsFormOpen = document.getElementById('editSubjectsFormOpen');
    
    editSubjectsFormOpen.addEventListener('click', () => {
        editSubjectsFormDialog.showModal();
    })

    <?php if (isset($_GET['subjectAction']) || isset($_GET['subjectOverview'])): ?>
        editSubjectsFormDialog.showModal();
    <?php endif; ?>
</script>