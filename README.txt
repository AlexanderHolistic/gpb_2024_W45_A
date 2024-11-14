# Team Error 404

Übungsprojekt GPB 125-129 Blau

---------------------------------------------------------

script.js und index wurden nochmal gepusht.

---------------------------------------------------------

!!NICHT VERGESSEN!! - db.php zu ändern - KEIN LOCALHOST! 

#############################################################################
Alles funktioniert, keine Bugs etc. Session, Button Bearbeiten i.O.         #
                                                                            # 
Kein Modal - popup Window, session wurde repariert, kein Alert beim Löschen.#
#############################################################################

****************************************************************************
TODO:

TESTEN,

danach:

SCHRIFTGRÖßE

****************************************************************************






-----------------------------------


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
