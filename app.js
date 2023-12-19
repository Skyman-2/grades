// grade details modal
const gradeDetails = document.getElementById('grade-details');



if (gradeDetails != null) {
    gradeDetails.showModal();
}


document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var options = {
        classes: "",
        dropdownOptions: {}
    }
    var instances = M.FormSelect.init(elems, options);
    console.log('it is done.');
});