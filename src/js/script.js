document.addEventListener("DOMContentLoaded", function () {
  const mainForm = document.getElementById("mainNoteForm");
  const formHeader = document.getElementById("formHeader");
  const formAction = document.getElementById("formAction");
  const formNoteId = document.getElementById("formNoteId");
  const formSubmitButton = document.getElementById("formSubmitButton");

  window.editNote = function (noteId, title, content) {
    formHeader.textContent = "Notiz bearbeiten";
    formAction.value = "update";
    formNoteId.value = noteId;
    document.getElementById("title").value = title;
    document.getElementById("content").value = content;
    formSubmitButton.textContent = "Änderungen speichern";
  };
});

mainForm.addEventListener("submit", function () {
  formHeader.textContent = "Neue Notiz hinzufügen";
  formAction.value = "add";
  formNoteId.value = "";
  formSubmitButton.textContent = "Notiz hinzufügen";
});
