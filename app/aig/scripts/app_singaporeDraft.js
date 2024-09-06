let draftid = null;
document.addEventListener("DOMContentLoaded", function () {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  draftid = urlParams.get("draftid");
  console.log("draftid:", draftid);

  if (draftid) {
    document.getElementById("btnSaveDraftForm").style.display = "block";
    document.getElementById("btnDraftForm").style.display = "none";
    jQuery.agent
      .getDraftDataWithId(draftid)
      .then((response) => {
        console.log("response", response)
        if (response?.result == "success") {
          setDefaultValueForm(response?.data);
        }
      })
      .catch((error) => {
        console.error("Error occurred:", error);
      });


  }


})
const handleClickDraftButton = () => {
  console.log("handleClickDraft")
  const requestBody = handleForm();
  jQuery.agent.insertDraftQuoteData(requestBody);
}
const handleClickSaveDraftButton = () => {
  console.log("handleClickSaveDraft")
  const requestBody = handleForm();
  jQuery.agent.updateDraftQuoteData(requestBody, draftid);
}