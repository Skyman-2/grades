<dialog id="newSubjectFormModal">
    <form action="index.php" method="POST">
        <div class="inputs">
            <div class="input-field">
                <input id="subjectName" type="text" name="subjectName" class="validate" required>
                <label for="subjectName">Subject</label>
            </div>
            <div class="input-field">
                <input id="subjectCoef" type="number" name="subjectCoef" class="validate" required>
                <label for="subjectCoef">Coefficient</label>
            </div>
        </div>
        <div style="margin-top: 16px; display: flex; justify-content: space-between;">
            <a href="./" class="btn btn-flat">Cancel</a>
            <input type="submit" name="submitNewSubject" value="Add" class="btn">
        </div>
    </form>
</dialog>