document.addEventListener('DOMContentLoaded', function() {
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
            toggleTopPicksButton.textContent = 'Edit Top Picks';
            topPicksForm.submit(); // Submit form if Save Top Picks button is clicked
        }
    });
});
