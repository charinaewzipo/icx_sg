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
  console.log("handleClickDraft");
  const requestBody = handleForm();
  try {
    const responseId = await jQuery.agent.insertQuotationData(requestBody, null, campaignDetails);
    let currentUrl = window.location.href;
    const url = new URL(currentUrl); 
    
    if (url.searchParams.has('id')) {
    
      url.searchParams.set('id', responseId);
    } else {
    
      url.searchParams.append('id', responseId);
    }
    
    window.location.href = url.toString(); 
  } catch (error) {
    console.error("Error while inserting quotation:", error);
  }
};


const handleClickSaveDraftButton = () => {
  console.log("handleClickSaveDraft")
  const requestBody = handleForm();
  jQuery.agent.updateQuoteData(requestBody, null, id,planData);
}
const handleEditQuote = () => {
  const btnEditForm = document.getElementById('btnEditForm');
  console.log("Edit")
  if (!isEditing) {
    event.preventDefault();
    const formElements = document.querySelectorAll("input, select:not(#planPoiSelect1),textarea, button:not(#btnSaveForm)");

   
    unhideFormData(formElements);
    btnEditForm.textContent = "Save"
    isEditing = true;
  } else {
    // window.alert("Fetch Recalculate Quote")
    // window.location.reload();
    // handleValidateForm();
  }
}