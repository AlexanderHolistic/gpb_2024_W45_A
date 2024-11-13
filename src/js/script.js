export function openEditModal(noteId, title, content) {
  const modalOverlay = document.getElementById("editModalOverlay");
  modalOverlay.style.display = "flex";
  document.getElementById("editNoteId").value = noteId;
  document.getElementById("editTitle").value = title;
  document.getElementById("editContent").value = content;
}

export function closeEditModal() {
  document.getElementById("editModalOverlay").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
  const editNoteForm = document.getElementById("editNoteForm");

  if (editNoteForm) {
    editNoteForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const noteId = document.getElementById("editNoteId").value;
      const title = document.getElementById("editTitle").value;
      const content = document.getElementById("editContent").value;

      fetch("index.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=update&noteId=${encodeURIComponent(
          noteId
        )}&title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}`,
      })
        .then((response) => response.text())
        .then(() => {
          closeEditModal();
          location.reload();
        });
      
    });
  }
});

export function deleteNote(noteId) {
  if (confirm("Möchten Sie diese Notiz wirklich löschen?")) {
    fetch("index.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `action=delete&noteId=${noteId}`,
    })
      .then((response) => response.text())
      .then((data) => {
        alert(data);
        location.reload();
      });
  }
}
