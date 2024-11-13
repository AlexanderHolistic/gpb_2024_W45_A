<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Notizverwaltung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #f4f4f9;
        }
        h1, h2 {
            color: #4a90e2;
        }
        .note {
            background-color: #fff;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .note button {
            background-color: #4a90e2;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h1>Willkommen, Benutzer</h1>
    <p><a href="#" onclick="logout()">Abmelden</a></p>

    <h2>Neue Notiz hinzufügen</h2>
    <form id="noteForm">
        Titel: <input type="text" id="title" required><br><br>
        Inhalt: <textarea id="content" required></textarea><br><br>
        <button type="button" onclick="addNote()">Notiz hinzufügen</button>
    </form>

    <h2>Deine Notizen</h2>
    <div id="notesContainer">
        <p>Keine Notizen vorhanden.</p>
    </div>

    <script>
        const notesContainer = document.getElementById('notesContainer');

        function addNote() {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;

            if (title && content) {
                const noteDiv = document.createElement('div');
                noteDiv.classList.add('note');

                noteDiv.innerHTML = `
                    <h3>${title}</h3>
                    <p>${content.replace(/\n/g, "<br>")}</p>
                    <button onclick="editNote(this)">Notiz aktualisieren</button>
                    <button onclick="deleteNote(this)">Notiz löschen</button>
                `;

                notesContainer.appendChild(noteDiv);
                document.getElementById('noteForm').reset();

                if (notesContainer.querySelector('p')) {
                    notesContainer.querySelector('p').remove();
                }
            }
        }

        function deleteNote(button) {
            if (confirm('Möchten Sie diese Notiz wirklich löschen?')) {
                button.parentElement.remove();
                if (notesContainer.childElementCount === 0) {
                    notesContainer.innerHTML = "<p>Keine Notizen vorhanden.</p>";
                }
            }
        }

        function editNote(button) {
            const noteDiv = button.parentElement;
            const title = prompt("Aktualisiere den Titel", noteDiv.querySelector('h3').innerText);
            const content = prompt("Aktualisiere den Inhalt", noteDiv.querySelector('p').innerText);

            if (title && content) {
                noteDiv.querySelector('h3').innerText = title;
                noteDiv.querySelector('p').innerText = content;
            }
        }

        function logout() {
            alert("Sie haben sich erfolgreich abgemeldet.");
            // Tutaj możesz dodać akcję na wylogowanie, np. przekierowanie na stronę logowania
        }
    </script>

</body>

</html>
