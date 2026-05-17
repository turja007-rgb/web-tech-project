document.getElementById('comment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let taskId = document.getElementById('task_id').value;
    let body = document.getElementById('comment_body').value;
    
    let formData = new FormData();
    formData.append('task_id', taskId);
    formData.append('body', body);

    fetch('../controllers/CommentController.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.id) {
            
            let html = `
                <div class="comment" id="comment-${data.id}">
                    <strong>${data.author_name}</strong>: ${data.body} 
                    <small class="time-text">${data.created_at}</small>
                    <a href="#" onclick="deleteComment(${data.id}); return false;" class="delete-btn">Delete</a>
                </div>
            `;
            document.getElementById('comment-thread').insertAdjacentHTML('beforeend', html);
            document.getElementById('comment_body').value = ''; 
        }
    });
});

function deleteComment(commentId) {
    fetch(`../controllers/CommentController.php?id=${commentId}`, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(data => {
        if(data.ok) {
            let el = document.getElementById(`comment-${commentId}`);
            el.classList.add('fade-out');
            setTimeout(() => el.remove(), 500); 
        }
    });
}