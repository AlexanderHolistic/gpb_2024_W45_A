document.addEventListener('DOMContentLoaded', function() {
  // Elemente auswählen
  const addNoteBtn = document.getElementById('add-note-btn');
  const noteInput = document.getElementById('note-input');
  const notesContainer = document.getElementById('notes-container');
  const editBtn = document.getElementById('edit-btn');

  let isEditing = false;

  // Event-Listener für die Schaltfläche "Notiz hinzufügen"
  addNoteBtn.addEventListener('click', addNote);

  // Event-Listener für den Bearbeiten-Schaltfläche
  editBtn.addEventListener('click', toggleEditingMode);

  // Funktion zum Hinzufügen einer Notiz
  function addNote() {
    const noteText = noteInput.value.trim();

    if (noteText === "") {
      alert("Bitte eine Notiz eingeben!");
      return;
    }

    // Notiz-Element erstellen
    const note = document.createElement('div');
    note.classList.add('note');

    // Notiz-Text hinzufügen
    const noteContent = document.createElement('p');
    noteContent.textContent = noteText;

    // Löschen-Schaltfläche hinzufügen
    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Löschen';
    deleteBtn.classList.add('delete-btn');
    deleteBtn.addEventListener('click', () => {
      notesContainer.removeChild(note);
    });

    // Elemente zur Notiz hinzufügen
    note.appendChild(noteContent);
    note.appendChild(deleteBtn);

    // Notiz in den Container hinzufügen
    notesContainer.appendChild(note);

    // Eingabefeld leeren
    noteInput.value = "";
  }

  // Funktion zum Umschalten des Bearbeitungsmodus
  function toggleEditingMode() {
    isEditing = !isEditing;
    const allNotes = document.querySelectorAll('.note p');

    if (isEditing) {
      editBtn.textContent = "Speichern";
      allNotes.forEach(note => {
        note.contentEditable = 'true';
        note.style.backgroundColor = '#fffacd'; // Hintergrund ändern zur Kennzeichnung
      });
    } else {
      editBtn.textContent = "Bearbeiten";
      allNotes.forEach(note => {
        note.contentEditable = 'false';
        note.style.backgroundColor = ''; // Hintergrund zurücksetzen
      });
    }
  }
});