document.addEventListener('DOMContentLoaded', function() {
    // Toggle Edit for About Me Section
    const toggleButton = document.getElementById('togglebutton');
    const form = document.getElementById('abtme');
    const inputs = form.querySelectorAll('input:not([type="date"]), textarea'); // Exclude date input
    const dateInput = form.querySelector('input[type="date"]');

    toggleButton.addEventListener('click', function() {
        // Toggle readonly attribute for inputs and textarea
        for (let input of inputs) {
            input.readOnly = !input.readOnly;
        }
        dateInput.disabled = !dateInput.disabled;

        // Toggle edit button text based on readonly state
        if (toggleButton.textContent === 'Edit') {
            toggleButton.textContent = 'Save Profile';
        } else {
            form.submit(); // Submit form if Save Profile button is clicked
            toggleButton.textContent = 'Edit';
        }
    });

    // Toggle Edit for Top Picks Section
    const toggleTopPicksButton = document.getElementById('toggleTopPicks');
    const topPicksForm = document.getElementById('toppicks');
    const topPicksInputs = topPicksForm.querySelectorAll('input');

    toggleTopPicksButton.addEventListener('click', function() {
        // Toggle readonly attribute for top picks inputs
        for (let input of topPicksInputs) {
            input.readOnly = !input.readOnly;
        }

        // Toggle edit button text based on readonly state
        if (toggleTopPicksButton.textContent === 'Edit Top Picks') {
            toggleTopPicksButton.textContent = 'Save Top Picks';
        } else {
            topPicksForm.submit(); // Submit form if Save Top Picks button is clicked
            toggleTopPicksButton.textContent = 'Edit Top Picks';
        }
    });
});
