function goToDashboard() {
    window.location.href = 'user_dashboard.html'; // Ensure you have a dashboard.html file
}

function goToGallery() {
    window.location.href = "gallery.html";
}

function goToProfile() {
    window.location.href = "profile_page.php";
}

function viewPhoto(photoSrc) {
    var modal = document.getElementById('myModal');
    var modalImg = document.getElementById('img01');
    modal.style.display = "flex"; // Use flex to center the image
    modalImg.src = photoSrc;
}

function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
}
