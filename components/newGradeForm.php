<dialog id="newGradeFormModal">
    <form action="index.php" method="POST">
        <div class="inputs">
            <div class="row">
                <div class="input-field col l4">
                    <input type="number" name="grade" placeholder="20" step=0.01 class="validate" required>
                    <label for="grade">Grade:</label>
                </div>
                <div class="input-field col l4">
                    <input type="number" name="maxPoints" value="20" step=0.01 class="validate" required>
                    <label for="grade">Max Points:</label>
                </div>
                <div class="input-field col l4">
                    <input type="number" name="coef" value="1" step=0.01 class="validate" required>
                    <label for="coef">Coefficient:</label>
                </div>
            </div>

            <div class="input-field">
                <?php foreach ($results as $row): ?>
                    <p>
                        <label>
                            <input name="subject" type="radio" value="<?php echo $row[0] ?>" required> <!-- echoes the subject reference -->
                            <span><?php echo $row[1] ?></span> <!-- echoes the subject name -->
                        </label>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
        <div style="margin-top: 16px; display: flex; justify-content: space-between;">
            <a href="./" class="btn btn-flat">Cancel</a>
            <input type="submit" name="submitNewGrade" value="Add" class="btn">
        </div>
    </form>
</dialog>

<script>
    const newGradeFormDialog = document.getElementById('newGradeFormModal');
    const newGradeFormOpen = document.getElementById('newGradeFormOpen');

    newGradeFormOpen.addEventListener('click', () => {
        newGradeFormDialog.showModal();
    })
</script>