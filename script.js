function showCommentForm(contentId) {
    var form = document.getElementById('comment-form-' + contentId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
function openNav() {
    document.getElementById("myNavbar").style.display = "block";
    document.getElementById("main-content").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("myNavbar").style.display = "none";
    document.getElementById("main-content").style.marginLeft = "0";
}
