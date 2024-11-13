// Funktion zum Hinzufügen einer Notiz
document.getElementById('saveNoteButton').addEventListener('click', function() {
    const title = document.getElementById('noteTitle').value;
    const content = document.getElementById('noteContent').value;

    fetch('add_note.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}`
    })
    .then(response => response.text())
    .then(data => alert(data));
});

// Funktion zum Bearbeiten einer Notiz
function editNote(noteId) {
    const title = prompt("Neuer Titel:");
    const content = prompt("Neuer Inhalt:");

    fetch('edit_note.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `noteId=${noteId}&title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}`
    })
    .then(response => response.text())
    .then(data => alert(data));
}

// Funktion zum Löschen einer Notiz
function deleteNote(noteId) {
    if (confirm("Möchten Sie diese Notiz wirklich löschen?")) {
        fetch('delete_note.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `noteId=${noteId}`
        })
        .then(response => response.text())
        .then(data => alert(data));
    }
}
