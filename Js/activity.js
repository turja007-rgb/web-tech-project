function loadActivity() {
    let projectId = document.getElementById('project_id').value;
    let userId = document.getElementById('member-filter').value;
    
    fetch(`../controllers/ActivityController.php?project_id=${projectId}&user_id=${userId}`)
    .then(res => res.json())
    .then(data => {
        let html = '';
        data.forEach(log => {
            html += `
                <div class="activity-item">
                    <div class="avatar">${log.initials}</div>
                    <div class="action">${log.action_text}</div>
                    <div class="time">${log.time_ago}</div>
                </div>
            `;
        });
        document.getElementById('activity-list').innerHTML = html || '<p>No activity found.</p>';
    });
}

document.getElementById('member-filter').addEventListener('change', loadActivity);
loadActivity();