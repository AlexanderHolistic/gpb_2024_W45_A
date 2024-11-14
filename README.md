# Team Error 404

Übungsprojekt GPB 125-129 Blau


////js
export function openEdit(noteId, title, content) {
  document.getElementById("formAction").value = "update";
  document.getElementById("noteId").value = noteId;
  document.getElementById("title").value = title;
  document.getElementById("content").value = content;
  document.getElementById("submitButton").textContent = "Notiz aktualisieren";
  window.scrollTo(0, 0); 
}

document.addEventListener("DOMContentLoaded", function () {

  document.getElementById("noteForm").addEventListener("reset", function () {
    document.getElementById("formAction").value = "add";
    document.getElementById("noteId").value = "";
    document.getElementById("submitButton").textContent = "Notiz hinzufügen";
  });
});



//new form index.php

<form method="post" action="index.php" id="noteForm">
    <input type="hidden" name="action" id="formAction" value="add">
    <input type="hidden" name="noteId" id="noteId">
    <label for="title">Titel:</label><br>
    <input type="text" name="title" id="title" required>
    <label for="content">Inhalt:</label><br>
    <textarea name="content" id="content" required></textarea>
    <button type="submit" id="submitButton">Notiz hinzufügen</button>
</form>


//button
<button type="button" onclick="openEdit('<?php echo $note['ID']; ?>', '<?php echo htmlspecialchars($note['Titel'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($note['Inhalt'], ENT_QUOTES); ?>')">Bearbeiten</button>
