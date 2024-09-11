// let draftid = null;
let isEditing = false;

document.addEventListener("DOMContentLoaded", function () {
  if (id) {
    document.getElementById("btnSaveDraftForm").style.display = "block";
    document.getElementById("btnDraftForm").style.display = "none";
    // jQuery.agent
    //   .getDraftDataWithId(id)
    //   .then((response) => {
    //     console.log("response", response)
    //     if (response?.result == "success") {
    //       setDefaultValueForm(response?.data);
    //     }
    //   })
    //   .catch((error) => {
    //     console.error("Error occurred:", error);
    //   });


  }


})
const handleClickDraftButton = async () => {
  console.log("handleClickDraft")
  const requestBody = handleForm();
  await jQuery.agent.insertQuotationData(requestBody, null, campaignDetails);
  window.location.href = "/application.php";
}
const handleClickSaveDraftButton = () => {
  console.log("handleClickSaveDraft")
  const requestBody = handleForm();
  jQuery.agent.updateQuoteData(requestBody, null, id);
}
const handleEditQuote = () => {
  const btnEditForm = document.getElementById('btnEditForm');
  console.log("Edit")
  if (!isEditing) {
    const formElements = document.querySelectorAll("input, select, button:not(#btnSaveForm)");
    unhideFormData(formElements);
    btnEditForm.textContent = "Save"
    isEditing = true;
  } else {
    window.alert("Fetch Recalculate Quote")
    window.location.reload();
  }
}